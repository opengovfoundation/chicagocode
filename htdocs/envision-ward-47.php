<?php

/**
 * The "Envision" page.
 *
 * PHP version 5
 *
 * @license		http://www.gnu.org/licenses/gpl.html GPL 3
 * @version		0.8
 * @link		http://www.statedecoded.com/
 * @since		0.8
 *
 */

/*
 * Fire up our templating engine.
 */
$content = new Content();

/*
 * Define some page elements.
 */
$content->set('browser_title', 'Envision Chicago');
$content->set('page_title', '');

$content->set('body',
<<<EOT
	<!-- UNCOMMENT TO DISPLAY AN INTRODUCTORY VIDEO HERE
	<div class="nest video">
		<div class="video-frame">
			<div class="video-container">
				<video width="" height="" controls="controls">
					<source src="" type="video/mp4">
					<source src="" type="video/webm">
				</video>
			</div>
		</div>
	</div>--> <!-- // .nest -->

	<section class="homepage" role="main">
		<div class="nest">
			<section class="feature-content">
				<hgroup>
					<h1>Envision Chicago</h1>
					<h2>Envision A Better Chicago</h2>
				</hgroup>
				<p>
				<strong>Hello Lake View High School! Welcome to the <a href="/envision/">Envision Chicago</a> scholarship contest!</strong>
				</p>
				<p>
				Here’s how you can participate:
				</p>
				<p>
				Imagine a Better Chicago! Think about what you like best - and like least - about living in Chicago. What issues do you care about? What do you see in your neighborhood, in your ward and in your school that could be improved? Odds are, there's a law to match. How would you fix what you don't like or build on what you do?
				</p>
				<p>
				Find the Laws You Care About! Now that you have a vision for improving city life, visit ChicagoCode.org. Browse and search through the laws to find what you care about most.
				</p>
				<p>
				Rewrite the Rules! See how the law is written with ChicagoCode.org. Decide how you'd improve it. Tell us why this matters to you and your community. Share your ideas with the alderman who represents you on the Chicago City Council by April 15. There is NO LIMIT to how many ideas you can enter to win the $1,000 scholarship! Submit your idea by clicking the “Envision This Law” at the bottom of each law or by <a href="https://docs.google.com/a/opengovfoundation.org/forms/d/1IH1LUdPYB8lYCLTLS5YMNMd7Rg5EId0Xt_ZZ4sCixvg/viewform">filling out this form</a>.
				</p>
				<p>
				What Happens Next?
				</p>
				<p>
				After April 15, your ideas to Envision a Better Chicago will be reviewed by your Alderman, Chicago City Clerk Susana Mendoza and The OpenGov Foundation’s Executive Director Seamus Kraft. A winning idea will be selected from each ward, earning the winning student $1,000 for school and a shot at their idea becoming a legislative proposal before the Chicago City Council.
				</p>
			</section> <!-- // .feature -->

			<section class="secondary-content">

				<article class="abstract">

					<img src="/themes/ChicagoCode2013/static/images/ward47.jpg">
					<div style="font-size: 12px; text-align: center; margin-bottom: 2rem;">Ward map via <a href="https://chicago.councilmatic.org/council-members/">Chicago Councilmatic</a></div>

					<img src="http://placehold.it/300x400?text=Alderman Photo" style="">
					<div style="text-align: center;">Alderman Ameya Pawar</div>

				</article>

				<article class="abstract">

					<p>
					<strong>Important Dates</strong>
					</p>
					<ul>
					<li>March 11, 2016 &mdash; Competition begins</li>
					<li>April 15, 2016 &mdash; Submissions Deadline</li>
					<li>June 1, 2016 &mdash; Winners Announced</li>
					</ul>

					<p>
					<strong>Resources</strong>
					</p>
					<ul>
						<li><a href="http://www.cityofchicago.org/city/en/about/council.html">How City Council Works</a> (via The City of Chicago’s Official Site)</li>
						<li><a href="http://www.chicityclerk.com/">Office of the City Clerk</a> (via City of Chicago, Office of the City Clerk)</li>
						<li><a href="http://www.mikvachallenge.org/educators/opportunities-for-students/">Center for Action Civics: Opportunities for Youth</a> (via Mikva Challenge)</li>
						<li><a href="http://cps.edu/pages/timeline.aspx#g912pic">Chicago Public School High School Resources</a> (via Chicago Public Schools) </li>
					</ul>
					<p>
					<strong>Envision Chicago Sponsors</strong>
					</p>
					<ul>
						<li><a href="http://microsoft-chicago.com/">Microsoft Chicago</a></li>
						<li><a href="http://www.smartchicagocollaborative.org/">The Smart Chicago Collaborative</a></li>
						<li><a href="http://www.haymarket.net/">Haymarket</a></li>
						<li><a href="https://www.comed.com/">ComEd</a></li>
					</ul>
					<p>
					<strong>Envision Chicago Supporters</strong>
					</p>
					<ul>
						<li><a href="http://www.mikvachallenge.org/">Mikva Challenge</a></li>
						<li><a href="http://www.chipublib.org/">Chicago Public Library</a></li>
						<li><a href="http://www.1871.com/">1871</a></li>
					</ul>
				</article>

			</section> <!-- // .secondary-content -->

		</div> <!-- // .nest -->

	</section>

EOT
);

/*
 * Put the shorthand $sidebar variable into its proper place.
 */
$content->set('sidebar', '');

/*
 * Add the custom classes to the body.
 */
$content->set('body_class', 'preload');

/*
 * Parse the template, which is a shortcut for a few steps that culminate in sending the content
 * to the browser.
 */
$template = Template::create();
$template->parse($content);
