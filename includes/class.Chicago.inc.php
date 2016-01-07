<?php

/**
 * San Francisco parser for State Decoded.
 * Extends AmericanLegal base classes.
 *
 * PHP version 5
 *
 * @license		http://www.gnu.org/licenses/gpl.html GPL 3
 * @version		0.8
 * @link		http://www.statedecoded.com/
 * @since		0.3
*/

/**
 * This class may be populated with custom functions.
 */

require 'class.AmericanLegal.inc.php';

class State extends AmericanLegalState {}

class Parser extends AmericanLegalParser
{
	public $structure_regex = '/^(?P<type>ARTICLES?|TITLE|CHAPTER|DIVISION|PART|SECTION)\s+(?P<number>[A-Za-z0-9\-\.]+( THROUGH [A-Za-z0-9\-\.])?):?(\s+(?P<name>.*?))?$/i';
	public $default_section_regex = '/^((?:§ )?(?P<number>(X?[0-9]+-[0-9]+-[0-9]+(\.[0-9]+)?)|APPENDIX [A-Z]+))\s*(?P<catch_line>.*?)\.?\]?$/i';
	public $preface_section_regex = '/^(?P<name>.*)$/';

	/*
	 * Files to ignore.
	 */
	public $ignore_files = array(
		'0-0-0-1.xml',
		'0-0-0-5.xml'
	);

	/*
	 * We end up with a duplicate of the Adopting Ordinance section.
	 * Use a static variable to check this and skip it.
	 */

	public static $adopting_done;

	public function pre_parse_chapter(&$chapter)
	{
		// Get all of the titles before the current one.
		// Cast into an array for easier manipulation;
		$titles = array();
		foreach($chapter->REFERENCE->TITLE as $title) {
			$titles[] = $title;
		};
		array_pop($titles);

		$this->logger->message('Got titles: ' . print_r($titles, true), 1);

		foreach ($titles as $title) {
			if (preg_match($this->structure_regex, $title, $matches)) {
				// We've got a structure, see if it exists.
				$sql = 'SELECT * FROM structure
					WHERE identifier = :identifier
					AND name = :name
					AND edition_id = :edition_id ';
				$sql_args = array();
				$sql_args[':identifier'] = $this->clean_identifier($matches['number']);
				$sql_args[':name'] = $this->clean_title($matches['name']);
				$sql_args[':edition_id'] = $this->edition_id;

				if ($last_structure = end($this->structures)) {
					$sql .= 'AND parent_id = :parent_id ';
					$sql_args[':parent_id'] = $last_structure->id;
				} else {
					$sql .= 'AND parent_id IS NULL ';
				}

				$statement = $this->db->prepare($sql);
				$result = $statement->execute($sql_args);

				if ($result && $statement->rowCount() > 0) {
					$this->logger->message('Structure exists ' .
						$matches['number'] . ' : ' . $matches['name'], 2);
					$structure = $statement->fetch(PDO::FETCH_OBJ);
					$this->structures[] = $structure;
				} else {
					$this->logger->message('Creating structure ' .
						$matches['number'] . ' : ' . $matches['name'], 2);

					$structure = new stdClass();
					$structure->name = $this->clean_title($matches['name']);
					$structure->label = $this->clean_title($matches['type']);
					$structure->identifier = $this->clean_identifier($matches['number']);
					$structure->order_by = $this->get_structure_order_by($structure);

					if ($last_structure = end($this->structures)) {
						$structure->parent_id = $last_structure->id;
					}

					$structure->level = count($this->structures) + 1;

					$structure->id = $this->create_structure($structure);

					$this->structures[] = $structure;
				}
				$this->logger->message('Structure: ' . print_r($structure, true), 1);
			}
		}

		$title = trim($chapter->REFERENCE->TITLE[0]);

		/*
		 * Get the part of the building code from the title.
		 */
		$this->logger->message('Generating top sections.', 2);

		$this->section_regex = $this->default_section_regex;

		// The Tables page still needs some work.
		if($title == 'TABLES')
		{
			$this->logger->message('Skipping TABLES section.', 3);
			unset($chapter->LEVEL);
			return;
		}

		if(in_array($title, array(
			'MUNICIPAL CODE OF CHICAGO',
			//'TABLES',
		)))
		{
			$this->logger->message('Handling code intro.', 3);

			$this->section_regex = $this->preface_section_regex;

			$structure = new stdClass();
			$structure->name = $this->clean_title($title);

			switch($title)
			{
				case 'MUNICIPAL CODE OF CHICAGO' :
					$structure->identifier = 'Code';
					$structure->order_by = '0';
					$structure->label = 'Code';
					break;

				case 'TABLES' :
					$structure->identifier = 'Tables';
					$structure->order_by = '999';
					$structure->label = 'Tables';
					break;
			}


			$structure->level = count($this->structures) + 1;

			if (isset($matches[3]) && strlen(trim($matches[3])))
			{
				$structure->metadata = new stdClass();
				$structure->metadata->text = trim($matches[3]);
			}

			$this->create_structure($structure);

			$this->structures[] = $structure;

		}
	}

	public function get_section_parts($section)
	{
		/*
		 * Parse the catch line and section number.
		 */
		$section_title = trim((string) $section->RECORD->HEADING);
		$section_title = str_replace('&#160;', ' ', $section_title);

		$this->logger->message('Title: ' . $section_title, 1);

		switch($section_title) {
			case 'PREFACE' :
				$section_parts = array(
					'number' => 'Preface',
					'catch_line' => $section_title,
					'order_by' => 1
				);
				break;

			case 'ADOPTING ORDINANCE' :
				/*
				 * This appears twice in the code.  We skip it the second time.
				 */
				if($this->adopting_done !== true) {
					$section_parts = array(
						'number' => 'Adopting',
						'catch_line' => $section_title,
						'order_by' => 2
					);
					$this->adopting_done = true;
				}
				else {
					return false;
				}
				break;

			case 'MUNICIPAL CODE OF CHICAGO' :
				$section_parts = array(
					'number' => 'MunicipalCode',
					'catch_line' => $section_title,
					'order_by' => 3
				);
				break;

			default:
				preg_match($this->section_regex, $section_title, $section_parts);
		}

		// If we have an appendix.
		if (!$section_parts['catch_line'] && $section_parts['number'] &&
			substr($section_parts['number'], 0, 9) === 'APPENDIX ') {
			$section_parts['catch_line'] = $section_title;
		}

		return $section_parts;
	}

	public function clean_title($text)
	{
		// We often see <LINEBRK/> inside of titles.
		$text = str_replace('<LINEBRK/>', ' ', $text);

		// Sometimes, different parts of the code will have different
		// numbers of spaces in the title.
		$text = preg_replace('/\s+/', ' ', $text);

		// Trim the text for any spaces or periods.
		$text = trim($text, ". \t\n\r\0\x0B");

		$text = ucwords(strtolower($text));

		return $text;
	}

	public function clean_identifier($text)
	{
		// Some structures have a collection of sections, so we use the range
		// here instead.
		$text = str_replace(' THROUGH ', '-', $text);

		// Trim the text for any spaces or periods.
		$text = trim($text, ". \t\n\r\0\x0B");

		return $text;
	}

	/**
	 * Wrap up the convoluted logic for creating the order_by value.
	 * Feel free to override this, but keep in mind it's a natural sort.
	 */

	/*
	 * Override: split on dashes and zero-pad each set.
	 */

	public function get_structure_order_by($structure)
	{
		return $this->get_order_by($structure->identifier);
	}

	public function get_section_order_by($code)
	{
		return $this->get_order_by($code->section_number);
	}

	public function get_order_by($identifier)
	{
		$parts = explode('-', $identifier);

		foreach($parts as $index => $part)
		{
			$parts[$index] = str_pad($part, 4, '0', STR_PAD_LEFT);

		}

		$order_by = join($parts);

		return $order_by;
	}
}
