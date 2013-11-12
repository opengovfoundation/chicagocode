<?php

/**
 * The page that displays an individual law.
 *
 * PHP version 5
 *
 * @license		http://www.gnu.org/licenses/gpl.html GPL 3
 * @version		0.8
 * @link		http://www.statedecoded.com/
 * @since		0.1
*/

/*
 * Create a new instance of Law.
 */
$laws = new Law();

/*
 * Use the ID passed to look up the law.
 */
if ( isset($args['relational_id']) )
{

	$laws->law_id = filter_var($args['relational_id'], FILTER_SANITIZE_STRING);

	/*
	 * Retrieve a copy of the law.
	 */
	$law = $laws->get_law();

}

if (!isset($law) || $law === FALSE)
{
	send_404();
}

/*
 * Store a record that this section was viewed.
 */
$laws->record_view();

/*
 * If this is a request for a plain text version of this law, simply display that and exit.
 */
if (isset($_GET['plain_text']))
{

	/*
	 * Instruct the browser that this is plain text.
	 */
	header("Content-Type: text/plain");

	/*
	 * Send the text, which is already formatted properly.
	 */
	echo $law->plain_text;

	/*
	 * End processing and exit.
	 */
	exit;
}

/*
 * Create a container for our content.
 */
$content = new Content();

/*
 * Make some section information available globally to JavaScript.
 */
$content->set('javascript', "var section_number = '" . $law->section_number . "';");
$content->append('javascript', "var section_id = '" . $law->section_id . "';");
$content->append('javascript', "var api_key = '" . API_KEY . "';");

/*
 * Define the browser title.
 */
$content->set('browser_title', $law->catch_line . ' (' . SECTION_SYMBOL . ' '
	. $law->section_number . ')—' . SITE_TITLE);

/*
 * Define the page title.
 */
$content->set('page_title', '<h1>' . SECTION_SYMBOL . '&nbsp;' . $law->section_number . '</h1>');
$content->append('page_title', '<h2>' . $law->catch_line . '</h2>');

/*
 * If we have Dublin Core metadata, display it.
 */
if (is_object($law->dublin_core))
{
	$content->set('meta_tags', '');
	foreach ($law->dublin_core AS $name => $value)
	{
		$content->append('meta_tags', '<meta name="DC.' . $name . '" content="' . $value . '" />');
	}
}

/*
 * Define the breadcrumb trail text.
 */
$content->set('breadcrumbs', '');
foreach (array_reverse((array) $law->ancestry) as $ancestor)
{
	$content->append('breadcrumbs', '<li><a href="'.$ancestor->url.'">'.$ancestor->identifier.' '
		.$ancestor->name.'</a></li>');
}
$content->append('breadcrumbs', '<li class="active"><a href="/'.$law->section_number.'/">§&nbsp;' .
	 $law->section_number.' '.$law->catch_line.'</a></li>');

$content->prepend('breadcrumbs', '<nav class="breadcrumbs"><ul class="steps-nav">');
$content->append('breadcrumbs', '</ul></nav>');

/*
 * If there is a prior section in this structural unit, provide a back arrow.
 */
if (isset($law->previous_section))
{
	$content->set('prev_next', '<li><a href="' . $law->previous_section->url .
		'" class="prev" title="Previous section"><span>&larr; Previous</span>' .
		$law->previous_section->section_number . ' ' .
		$law->previous_section->catch_line . '</a></li>');
	$content->append('link_rel', '<link rel="prev" title="Previous" href="' .
		$law->previous_section->url . '" />');
}
else
{
	$content->set('prev_next', '<li></li>');
}

/*
 * If there is a next section in this chapter, provide a forward arrow.
 */
if (isset($law->next_section))
{
	$content->append('prev_next', '<li><a href="' . $law->next_section->url .
		'" class="next" title="Next section"><span>Next &rarr;</span>' .
		$law->next_section->section_number . ' ' .
		$law->next_section->catch_line . '</a></li>');
	$content->append('link_rel', '<link rel="next" title="Next" href="' . $law->next_section->url . '" />');
}
else
{
	$content->append('prev_next', '<li></li>');
}

$content->set('heading', '<nav class="prevnext" role="navigation"><ul>' .
	$content->get('prev_next') . '</ul></nav><nav class="breadcrumbs" role="navigation">' .
	$content->get('breadcrumbs') . '</nav>');

/*
 * Store the URL for the containing structural unit.
 */
$content->append('link_rel', '<link rel="up" title="Up" href="' . $law->ancestry->{1}->url . '" />');

/*
 * Start assembling the body of this page by indicating the beginning of the text of the section.
 */
$body = '<article id="law">';

/*
 * Display the rendered HTML of this law.
 */
$body .= $law->html;

/*
 * If we both the raw history text and translated (prose-style) history text, display both formats.
 */
// Commented out temporarily, per https://github.com/statedecoded/statedecoded/issues/283
//if ( isset($law->history) && isset($law->history_text))
//{
//	$body .= '<section id="history">
//				<h2>History</h2>
//				<ul class="nav nav-tabs">
//				  <li class="active"><a href="#">Translated</a></li>
//				  <li class="active"><a href="#">Original</a></li>
//				</ul>
//				<div class="tab-content">
//				  <div class="tab-pane active" id="tab1">
//						<p>'.$law->history_text.'</p>
//				  </div>
//				  <div class="tab-pane" id="tab2">
//						<p>'.$law->history.'</p>
//				  </div>
//				</section>';
//}
//
/*
 * If we only have the raw history text, display that.
 */
//elseif (isset($law->history))
//{
	
	$body .= '<section id="history">
				<h2>History</h2>
				<p>'.$law->history.'</p>
			</section>';
			
//}

/*
 * Indicate the conclusion of the "section" article, which is the container for the text of a
 * section of the code.
 */
$body .= '</article>';

/*
 * Display links to representational variants of the text of this law.
 */
$formats[] = array('doc' => 'Word doc', 'epub' => 'ePub', 'json' => 'JSON', 'pdf' => 'PDF',
	'rtf' => 'Rich Text Format', 'txt' => 'Plain Text');
$body .= '<section id="rep_variant">
			<h2>Download</h2>
				<ul>';
foreach ($law->formats as $type => $url)
{
	$body .= '<li><a href="' . $url . '"><img src="/themes/StateDecoded2013/static/images/icon_'
		. $type . '_32.png" alt="' . $formats[$type] . '"></a></li>';
}
$body .= '
				</ul>
			</section>';

/*
 * Establish the $sidebar variable, so that we can append to it in conditionals.
 */
$sidebar = '';

/*
 * Commenting functionality.
 */
if (defined('DISQUS_SHORTNAME') === TRUE)
{
	$body .= "
	<section id=\"comments\">
		<h2>Comments</h2>
		<div id=\"disqus_thread\"></div>
		<script>
			var disqus_shortname = '" . DISQUS_SHORTNAME . "'; // required: replace example with your forum shortname

			/* * * DON'T EDIT BELOW THIS LINE * * */
			(function() {
				var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
				dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
				(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
			})();
		</script>
	</section>";
}

/*
 * General info
 */
$sidebar .= '<section class="info-box" id="elsewhere">
				<h1>Trust, But Verify</h1>
				<p>If you’re reading this for anything important, you should double-check its
				accuracy';
if (isset($law->official_url))
{
	$sidebar .= '—<a href="' . $law->official_url . '">read ' . SECTION_SYMBOL . '&nbsp;'
		. $law->section_number . ' ';
}
$sidebar .= ' on the official ' . LAWS_NAME . ' website</a>.
				</p>
			</section>';

/*
 * Start the Masonry.js wrapper
 */
$sidebar .= '<div class="grouping js-masonry"
                  data-masonry-options=\'{
                    "itemSelector": ".grid-box",
                    "columnWidth": ".grid-sizer",
                    "gutter": 10 }\'>';

/*
 * Get the help text for the requested page.
 */
$help = new Help();

// The help text is now available, as a JSON object, as $help->get_text()

$sidebar .= '<p class="keyboard"><a id="keyhelp">' . $help->get_text('keyboard')->title . '</a></p>';


/*
 * If this section has been cited in any court decisions, list them.
 */
if ( isset($law->court_decisions) && ($law->court_decisions != FALSE) )
{
	
	$sidebar .= '<section class="grid-box grid-sizer" id="court-decisions">
				<h1>Court Decisions</h1>
				<ul>';
				
	foreach ($law->court_decisions as $decision)
	{
	
		$sidebar .= '<li><a href="' . $decision->url . '"><em>' . $decision->name . '</em></a> ('
			. $decision->court_html . ', ' . date('m/d/y', strtotime($decision->date)) . ')';
		if (isset($decision->abstract))
		{
			$sidebar .= '<br />' . $decision->abstract;
		}
		$sidebar .= '</li>';
		
	}
	
	$sidebar .= '</ul>
			</section>';
			
}


/*
 * If any legislation has attempted to amend this law, list it.
 */
if ( isset($law->amendment_attempts) && ($law->amendment_attempts != FALSE) )
{
	
	$sidebar .= '<section class="grid-box grid-sizer" id="amendment-attempts">
				<h1>Amendment Attempts</h1>
				<ul>';
				
	foreach ($law->amendment_attempts as $bill)
	{
	
		$sidebar .= '<li><a href="' . $bill->url . '">' . $bill->number . '</a>: '
			. $bill->catch_line . ' (' . $bill->outcome . ')</li>';
		
	}
	
	$sidebar .= '</ul>
			</section>';
			
}

/*
 * If we have a list of cross-references, list them.
 */
if ($law->references !== FALSE)
{

	$sidebar .= '
			<section class="related-group grid-box" id="cross_references">
				<h1>Cross References</h1>
				<ul>';
	foreach ($law->references as $reference)
	{
		$sidebar .= '<li><span class="identifier">'
			. SECTION_SYMBOL . '&nbsp;<a href="' . $reference->url . '" class="law">'
			. $reference->section_number . '</a></span>
			<span class="title">' . $reference->catch_line . '</li>';
	}
	$sidebar .= '</ul>
			</section>';
}

/*
 * If we have a list of related laws, list them.
 */
if (isset($law->related) && (count((array) $law->related) > 0))
{
	$sidebar .= '
			<section class="related-group grid-box" id="related-links">
				<h1>Related Laws</h1>
				<ul id="related">';
	foreach ($law->related as $related)
	{
		$sidebar .= '<li>' . SECTION_SYMBOL . '&nbsp;<a href="' . $related->url . '">'
			. $related->section_number . '</a> ' . $related->catch_line . '</li>';
	}
	$sidebar .= '
				</ul>
			</section>';
}

/*
 *	If we have citation data and it's formatted properly, display it.
 */
if ( isset($law->citation) && is_object($law->citation) )
{

	$sidebar .= '<section class="related-group dark grid-box" id="cite-as">
				<h1>Cite As</h1>
				<ul>';
	foreach ($law->citation as $citation)
	{
		$sidebar .= '<li>' . $citation->label . ': <span class="' . strtolower($citation->label) . '">'
			. $citation->text . '</span></li>';
	}
	$sidebar .= '</ul>
			</section>';

}

/*
 * End Masonry.js wrapper
 */
$sidebar .= '</section>';

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
$content->set('content_class', 'nest wide');

