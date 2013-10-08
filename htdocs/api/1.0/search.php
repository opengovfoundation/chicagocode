<?php

/**
 * The API's search method
 *
 * PHP version 5
 *
 * @author		Waldo Jaquith <waldo at krues8dr.com>
 * @copyright	2013 Waldo Jaquith
 * @license		http://www.gnu.org/licenses/gpl.html GPL 3
 * @version		0.9
 * @link		http://www.statedecoded.com/
 * @since		0.9
 *
 */

header("HTTP/1.0 200 OK");
header('Content-type: application/json');

/*
 * Retrieve a list of all valid API keys.
 */
$api = new API;
$api->list_all_keys();

/*
 * Make sure that the provided API key is the correct length.
 */
if ( strlen($_GET['key']) != 16 )
{
	json_error('Invalid API key.');
	die();
}

/*
 * Localize the provided API key, filtering out unsafe characters.
 */
$key = filter_input(INPUT_GET, 'key', FILTER_SANITIZE_STRING);

/*
 * If the provided API key has no content, post-filtering, or if there are no registered API keys.
 */
if ( empty($key) || (count($api->all_keys) == 0) )
{
	json_error('API key not provided. Please register for an API key.');
	die();
}

/*
 * But if there are API keys, and our key is valid-looking, check whether the key is registered.
 */
elseif (!isset($api->all_keys->$key))
{
	json_error('Invalid API key.');
	die();
}

/*
 * Use a provided JSONP callback, if it's safe.
 */
if (isset($_REQUEST['callback']))
{
	$callback = $_REQUEST['callback'];

	# If this callback contains any reserved terms that raise XSS concerns, refuse to proceed.
	if (valid_jsonp_callback($callback) === FALSE)
	{
		json_error('The provided JSONP callback uses a reserved word.');
		die();
	}
}

/*
 * Make sure we have a search term.
 */
if (!isset($args['term']) || empty($args['term']))
{
	json_error('Search term not provided.');
	die();
}

/*
 * Clean up the search term.
 */
$term = filter_var($args['term'], FILTER_SANITIZE_STRING);

/*
 * Determine how verbose the search results should be.
 */
if (!isset($_GET['verbose']) || empty($_GET['verbose']))
{
	$verbose = TRUE;
}
else
{
	$verbose = filter_var($_GET['verbose'], FILTER_SANITIZE_STRING);
	if ( ($verbose != TRUE) && ($verbose != FALSE) )
	{
		$verbose = FALSE;
	}
}

/*
 * Intialize Solarium.
 */
Solarium_Autoloader::register();
$client = new Solarium_Client($GLOBALS['solr_config']);
	
/*
 * Set up our query.
 */
$query = $client->createSelect();
$query->setQuery($term);
	
/*
 * We want the most useful bits extracted as search results snippets.
 */
$hl = $query->getHighlighting();
$hl->setFields('catch_line, text');
	
/*
 * Specify that we want the first 100 results.
 */
$query->setStart(0)->setRows(100);

/*
 * Execute the query.
 */
$search_results = $client->select($query);
	
/*
 * Display uses of the search terms in a preview of the result.
 */
$highlighted = $search_results->getHighlighting();

/*
 * If there are no results.
 */
if (count($search_results) == 0)
{

	$response->records = 0;
	$response->total_records = 0;
	
}

/*
 * If we have results.
 */
 
/*
 * Instantiate the Law class.
 */
$law = new Law;

/*
 * Save an array of the legal code's structure, which we'll use to properly identify the structural
 * data returned by Solr. We hack off the last element of the array, since that identifies the laws
 * themselves, not a structural unit.
 */
$code_structures = array_slice(explode(',', STRUCTURE), 0, -1);

$i=0;
foreach ($search_results as $document)
{
			
	/*
	 * Attempt to display a snippet of the indexed law.
	 */
	$snippet = $highlighted->getResult($document->id);
	if ($snippet != FALSE)
	{
		foreach ($snippet as $field => $highlight)
		{
			$response->results->{$i}->excerpt .= strip_tags( implode(' ... ', $highlight) )
				. ' ... ';
		}
	}
	
	/*
	 * At the default level of verbosity, just give the data indexed by Solr, plus the URL.
	 */
	if ($verbose === FALSE)
	{
		
		/*
		 * Store the relevant fields within the response we'll send.
		 */
		$response->results->{$i}->section_number = $document->section;
		$response->results->{$i}->catch_line = $document->catch_line;
		$response->results->{$i}->text = $document->text;
		$response->results->{$i}->url = $law->get_url($document->section);
		$response->results->{$i}->score = $document->score;
		$response->results->{$i}->ancestry = (object) array_combine($code_structures, explode('/', $document->structure));
	
	}
	
	/*
	 * At a higher level of verbosity, replace the data indexed by Solr with the data provided
	 * by Law::get_law(), at *its* default level of verbosity.
	 */
	else
	{
		$law->section_number = $document->section;
		$response->results->{$i} = $law->get_law();	
	}
	
	$i++;
	
}
	
/*
 * Provide the total number of available documents, beyond the number returned by or available
 * via the API.
 */
$response->total_records = $search_results->getNumFound();
	


/*
 * If the request contains a specific list of fields to be returned.
 */
if (isset($args['fields']))
{
	
	/*
	 * Turn that list into an array.
	 */
	$returned_fields = explode(',', urldecode(filter_var($args['fields'], FILTER_SANITIZE_STRING)));
	foreach ($returned_fields as &$field)
	{
		$field = trim($field);
	}

	/*
	 * It's essential to unset $field at the conclusion of the prior loop.
	 */
	unset($field);

	/*
	 * Step through our response fields and eliminate those that aren't in the requested list.
	 */
	foreach($response as $field => &$value)
	{
		if (in_array($field, $returned_fields) === false)
		{
			unset($response->$field);
		}
	}
}

/*
 * Include the API version in this response.
 */
if(isset($args['api_version']) && strlen($args['api_version']))
{
	$response->api_version = filter_var($args['api_version'], FILTER_SANITIZE_STRING);
}
else
{
	$response->api_version = CURRENT_API_VERSION;
}

if (isset($callback))
{
	echo $callback.' (';
}
echo json_encode($response);
if (isset($callback))
{
	echo ');';
}
