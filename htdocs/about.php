<?php

/**
 * The "About" page, explaining this State Decoded website.
 *
 * PHP version 5
 *
 * @license		http://www.gnu.org/licenses/gpl.html GPL 3
 * @version		0.8
 * @link		http://www.statedecoded.com/
 * @since		0.1
 *
 */

/*
 * Create a container for our content.
 */
$content = new Content();

/*
 * Define some page elements.
 */
$content->set('browser_title', 'About');
$content->set('page_title', 'About');

$body = '<h2>Introduction</h2>
<p>
	<a href="http://chicagocode.org">ChicagoCode.org</a>&nbsp;is a non-profit,
non-governmental, non-partisan implementation of <a
href="http://www.statedecoded.com/">The State Decoded</a>&nbsp;brought to you
by the folks at the <a href="http://opengovfoundation.org/">OpenGov
Foundation</a>. It is part of a broader initiative to bring the law - the most
important information in any community - to the people in more accessible,
modern formats that can be used and reused. <a
href="http://chicagocode.org">ChicagoCode.org</a>&nbsp;provides a platform to
display Windy City legal information in a friendly, accessible, modern
fashion. This is the fourth municipal implementation of the software,
following <a href="http://sanfranciscocode.org">San Francisco (CA)</a>, <a
href="http://baltimorecode.org">Baltimore (MD)</a>&nbsp;and <a
href="http://phillycode.org">Philadelphia (PA)</a>, and state-level
deployments in <a href="http://marylandcode.org">Maryland</a>, <a
href="http://vacode.org">Virgina </a>and <a
href="http://www.sunshinestatutes.com/">Florida</a>. &nbsp;More are coming
soon as we move closer to the goal of accessible and user-friendly American
law from sea to shining sea.
</p>

<h2>Beta Testing</h2>
<p>
	<a href="http://chicagocode.org">ChicagoCode.org</a>&nbsp;is currently in
public beta, which is to say that the site is under active development, with
known shortcomings, but it has reached a point where it would benefit from
being used by the general public (who one hopes will likewise benefit from
it). While every effort is made to ensure that the data provided on <a
href="http://chicagocode.org">ChicagoCode.org</a>&nbsp;is accurate and
up-to-date, it would be gravely unwise to rely on it for any matter of
importance while it is in this beta testing phase.
</p>
<p>
	Many more features are under development, including city council
legislation, regulations, calculations of the importance of given laws,
inclusion of city attorney&rsquo;s opinions, court rulings, extensive
explanatory text, social media integration, significant navigation
enhancements, a vastly expanded built-in glossary of legal terms, scholarly
article citations, and much more.
</p>

<h2>Data Sources</h2>
<p>
	The data that powers <a
href="http://chicagocode.org">ChicagoCode.org</a>&nbsp; is also available from
<a href="http://www.amlegal.com/library/il/chicago.shtml">American Legal
Publishing</a>. &nbsp;The official code is maintained by the City of Chicago
and should be the primary reference for any legal questions. Even then, it is
always good to consult with a lawyer when interpreting the law.
</p>

<h2>API</h2>
<p>
	The site has a RESTful, JSON-based API. <a
href="/downloads/">Register for an API key</a>&nbsp;and <a
href="https://github.com/statedecoded/statedecoded/wiki/API-Documentation">
read the documentation</a>&nbsp;for details.
</p>

<h2>Thanks</h2>
<p>
<a href="http://chicagocode.org">ChicagoCode.org </a>wouldn&rsquo;t be
possible without the contributions and years of work by <a
href="http://waldo.jaquith.org/">Waldo Jaquith</a>, and the many dozens of
people who participated in 18 months of private alpha and beta testing of <a
href="http://vacode.org/about/">Virginia Decoded</a>&nbsp;-&nbsp;the first <a
href="http://www.statedecoded.com/">Decoded</a>&nbsp;site - beginning in 2010.
The platform on which this site is based, <a
href="http://www.statedecoded.com/">The State Decoded</a>, was expanded to
function beyond Virginia thanks to a generous grant by the <a
href="http://knightfoundation.org/">John S. and James L. Knight
Foundation.</a>&nbsp;Special thanks to the awesome people working in Chicago,
both inside and outside of government, to produce and maintain the laws of the
city and open up government to citizens. &nbsp;You know who you are. &nbsp;
</p>

<h2>Colophon</h2>
<p>
	Hosted on <a href="http://www.centos.org/">CentOS</a>, driven by <a
href="http://httpd.apache.org/">Apache</a>, <a
href="http://www.mysql.com/">MySQL</a>, and <a
href="http://www.php.net/">PHP</a>. Hosting by Rackspace. Search by <a
href="http://lucene.apache.org/solr/">Solr</a>. Comments by <a
href="http://disqus.com/">Disqus</a>.
</p>

<h2>Disclaimer</h2>
<p>
	This is not the official copy of the Chicago Municipal Code and should not
be relied upon for legal or any other official purposes. &nbsp;The <a
href="http://opengovfoundation.org/">OpenGov Foundation</a>&nbsp;offers open
law data with no warranty as to accuracy or completeness.
</p>
';

$sidebar = '';

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
