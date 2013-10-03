<?php

/**
 * The Search page, handling search requests.
 *
 * PHP version 5
 *
 * @author		Waldo Jaquith <waldo at jaquith.org>
 * @copyright	2010-2013 Waldo Jaquith
 * @license		http://www.gnu.org/licenses/gpl.html GPL 3
 * @version		0.8
 * @link		http://www.statedecoded.com/
 * @since		0.8
 *
 */

/*
 * Intialize Solarium.
 */
$client = new Solarium_Client($GLOBALS['solr_config']);

/*
 * Create a container for our content.
 */
$content = new Content();

/*
 * Define some page elements.
 */
$content->set('browser_title', 'Search');
$content->set('page_title', 'Search');

// Move this into sitewide CSS
$content->set('inline_css', '
	<style>
		ul#paging {
			margin: 0 auto;
			text-align: center;
		}
		ul#paging li {
			display: inline;
			list-style-type: none;
		}
			ul#paging li + li {
				margin-left: 1em;
			}
		form input[type=text] {
			width: 70%;
			margin-right: 5%;
		}
	</style>');

/*
 * Initialize our two primary content variables.
 */
$body = '';
$sidebar = '';

/*
 * Create a new instance of our search class. We use this to display the search form and the result
 * page numbers.
 */
$search = new Search();

/*
 * If a search is being submitted.
 */
if (!empty($_GET['q']))
{

	/*
	 * Localize the search string, filtering out unsafe characters.
	 */
	$q = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING);
	
	/*
	 * If a page number has been specified, include that. Otherwise, it's page 1.
	 */
	if (!empty($_GET['p']))
	{
		$page = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_STRING);
	}
	else
	{
		$page = 1;
	}
	
	/*
	 * If the number of results to display per page has been specified, include that. Otherwise,
	 * the default is 10.
	 */
	if (!empty($_GET['num']))
	{
		$per_page = filter_input(INPUT_GET, 'num', FILTER_SANITIZE_STRING);
	}
	else
	{
		$per_page = 10;
	}
	
	/*
	 * Display our search form.
	 */
	$search->query = $q;
	$body .= $search->display_form();
	
	/*
	 * Set up our query.
	 */
	$query = $client->createSelect();
	$query->setQuery($q);
	
	/*
	 * We want the most useful bits highlighted as search results snippets.
	 */
	$hl = $query->getHighlighting();
	$hl->setFields('catch_line, text');
	$hl->setSimplePrefix('<span>');
	$hl->setSimplePostfix('</span>');

	/*
	 * Check the spelling of the query and suggest alternates.
	 */
	$spellcheck = $query->getSpellcheck();
	$spellcheck->setQuery($q);
	$spellcheck->setBuild(TRUE);
	$spellcheck->setCollate(TRUE);
	$spellcheck->setExtendedResults(TRUE);
	$spellcheck->setCollateExtendedResults(TRUE);
	
	/*
	 * Specify which page we want, and how many results.
	 */
	$query->setStart(($page - 1) * $per_page)->setRows($per_page);
	
	/*
	 * Execute the query.
	 */
	$results = $client->select($query);
	
	/*
	 * Gather highlighted uses of the search terms, which we may use in display results.
	 */
	$highlighted = $results->getHighlighting();
	
	/*
	 * If this search term appears to be misspelled, gather a list of alternatives.
	 */
// Commented out temporarily, per issue #437
//	$spelling = $results->getSpellcheck();
//	
//	if ($spelling->getCorrectlySpelled() == FALSE)
//	{
//		
//		$body .= '<h1>Suggestions</h1>';
//		foreach($spelling as $suggestion)
//		{
//			$body .= 'NumFound: '.$suggestion->getNumFound().'<br/>';
//			$body .= 'StartOffset: '.$suggestion->getStartOffset().'<br/>';
//			$body .= 'EndOffset: '.$suggestion->getEndOffset().'<br/>';
//			$body .= 'OriginalFrequency: '.$suggestion->getOriginalFrequency().'<br/>';
//			$body .= 'Frequency: '.$suggestion->getFrequency().'<br/>';
//			$body .= 'Word: '.$suggestion->getWord().'<br/>';
//		}
//	}
	
	/*
	 * If there are no results.
	 */
	if (count($results) == FALSE)
	{
		
		$body .= '<p>No results found. [suggestions for better results]';
		
	}
	
	/*
	 * If there are results, display them.
	 */
	else
	{
	
		/*
		 * Store the total number of documents returned by this search.
		 */
		$total_results = $results->getNumFound();
		
		/*
		 * Start the DIV that stores all of the search results.
		 */
		$body .= '
			<div class="search-results">
			<p>' . number_format($total_results) . ' results found.</p>
			<ul>';
		
		/*
		 * Iterate through the results.
		 */
		$law = new Law;
		foreach ($results as $result)
		{
			
			$url = $law->get_url($result->section);
			
			$body .= '<li><div class="result">';
			$body .= '<h1><a href="' . $url . '">' . $result->catch_line . ' (' . SECTION_SYMBOL . '&nbsp;'
				. $result->section . ')</a></h1>';
			
			/*
			 * Attempt to display a snippet of the indexed law, highlighting the use of the search
			 * terms within that text.
			 */
			$snippet = $highlighted->getResult($result->id);
			if ($snippet != FALSE)
			{
				foreach ($snippet as $field => $highlight)
				{
					$body .= strip_tags( implode(' .&thinsp;.&thinsp;. ', $highlight), '<span>' )
						. ' [.&thinsp;.&thinsp;.] ';
				}
			}
			
			/*
			 * If we can't get a highlighted snippet, just show the first few lines of the law.
			 */
			else
			{
				$body .= '<p>' . substr($result->text, 250) . ' .&thinsp;.&thinsp;.</p>';
			}
			$body .= '</div></li>';
// include breadcrumbs (class "breadcrumb")
		
		}
		
		/*
		 * End the UL that lists the search results.
		 */
		$body .= '</ul>';
		
		/*
		 * Display page numbers at the bottom, if we have more than one page of results.
		 */
		if ($total_results > $per_page)
		{
			$search->total_results = $total_results;
			$search->per_page = $per_page;
			$search->page = $page;
			$search->query = $q;
			$body .= $search->display_paging();
		}
		
		/*
		 * Close the #search-results div.
		 */
		$body .= '</div>';
	
	}
	
}

/*
 * If a search isn't being submitted, but the page is simply being loaded fresh.
 */
else
{

	$body .= $search->display_form();

}

/*
 * Put the shorthand $body variable into its proper place.
 */
$content->set('body', $body);
unset($body);

/*
 * Put the shorthand $sidebar variable into its proper place.
 */
$content->set('sidebar', $sidebar);
unset($sidebar);

/*
 * Add the custom classes to the body.
 */
$content->set('body_class', 'law inside');


/*
 * Fire up our templating engine.
 */
$template = Template::create();

/*
 * Parse the template, which is a shortcut for a few steps that culminate in sending the content
 * to the browser.
 */
$template->parse($content);
