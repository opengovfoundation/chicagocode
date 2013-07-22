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
	//     Patterns:                         | section number                          |   | hyphen | catch line
	public $section_regex = '/^(?:Â§ )?(?P<number>X?[0-9]+-[0-9]+-[0-9]+(\.[0-9]+)?)\s*(?P<catch_line>.*?)\.?\]?$/i';

	public $default_structure_regex = '/^(?P<type>ARTICLE|TITLE|CHAPTER|DIVISION|PART|SECTION)\s+(?P<number>[A-Za-z0-9\-\.]+)\s+(?P<name>.*?)$/i';
	public $preface_structure_regex = '/^(?P<name>.*)$/';

	public function pre_parse_chapter(&$chapter)
	{

		$title = trim($chapter->REFERENCE->TITLE[0]);

		/*
		 * Get the part of the building code from the title.
		 */
		$this->logger->message('Generating top sections.', 2);

		$this->structure_regex = $this->default_structure_regex;

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

			$this->structure_regex = $this->preface_structure_regex;

			$structure = new stdClass();
			$structure->name = ucwords(strtolower($title));

			switch($title)
			{
				case 'MUNICIPAL CODE OF CHICAGO' :
					$structure->identifier = 'Municipal Code';
					$structure->order_by = '0';
					break;

				case 'TABLES' :
					$structure->identifier = 'Tables';
					$structure->order_by = '999';
					break;
			}

			$structure->label = 'Code';
			$structure->order_by = '0';

			$structure->level = count($this->structures) + 1;

			if(isset($matches[3]) && strlen(trim($matches[3])))
			{
				$structure->metadata = new stdClass();
				$structure->metadata->text = trim($matches[3]);
			}

			$this->create_structure($structure);

			$this->structures[] = $structure;

		}

		elseif(preg_match('/^TITLE (?P<number>[0-9]+) (?P<name>.*)$/', $title, $matches))
		{
			// Skip the first level.
			$this->logger->message('Skipping first level.', 2);
			unset($chapter->LEVEL->LEVEL[0]);

			$this->logger->message('TITLE: ' . $matches[1], 1);

			$structure = new stdClass();
			$structure->name = ucwords(strtolower($matches['name']));
			$structure->label = 'Code';
			$structure->identifier = strtolower($matches['number']);
			$structure->order_by = $structure->identifier;

			$structure->level = count($this->structures) + 1;

			if(isset($matches[3]) && strlen(trim($matches[3])))
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

		$this->logger->message('Title: ' . $section_title, 1);

		if ($section_title == "PREFACE")
		{
			$section_parts = array(
				'number' => "preface",
				'catch_line' => "Preface"
			);
		}
		else
		{

			preg_match($this->section_regex, $section_title, $section_parts);
		}

		return $section_parts;
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
