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
	<section class="homepage" role="main">
		<div class="nest">
			<section class="feature-content">
				<hgroup>
					<h1>Envision Chicago</h1>
					<h2>Students Building A Better Chicago</h2>
				</hgroup>
				<img src="/themes/ChicagoCode2013/static/images/envision_logo_lofi.png"
					style="float: right; margin: 15px;">
				<p>
				Chicago is your city.  How would you make it even better?
				</p>
				<p>
				Find an issue you care about.
				</p>
				<p>
				Submit your ideas by April 15.
				</p>
				<p>
				Earn a shot at a $1,000 scholarship and your idea going before the Chicago City Council.
				</p>
				<p>
				Here's how Envision Chicago works:
				</p>
				<p>
				Imagine a Better Chicago! Think about what you like best - and like least - about living in Chicago. What issues do you care about? What do you see in your neighborhood, in your ward and in your school that could be improved? Odds are, there's a law to match. How would you fix what you don't like or build on what you do?
				</p>
				<p>
				Find the Laws You Care About! Now that you have a vision for improving city life, visit ChicagoCode.org. <a href="/browse/">Browse and search through the laws</a> to find what you care about most. Here are a few topics to get started:
				</p>
				<ul style="margin-left: 60px">
					<li><a href="/7/">Health and Safety</a></li>
					<li><a href="/9/">Transportation</a></li>
					<li><a href="/4/">Consumer Protection</a></li>
					<li><a href="/2-45-115/">2015 Affordable Housing Requirements</a></li>
					<li><a href="/5/5-8/">Fair Housing</a></li>
				</ul>
				<p>
				Rewrite the Rules! See how the law is written with ChicagoCode.org. Decide how you'd improve it. Tell us why this matters to you and your community. Share your ideas with the alderman who represents you on the Chicago City Council by April 15. There is NO LIMIT to how many ideas you can enter to win the $1,000 scholarship! Submit your idea by clicking the "Envision This Law" at the bottom of each law or by <a href="https://docs.google.com/a/opengovfoundation.org/forms/d/1IH1LUdPYB8lYCLTLS5YMNMd7Rg5EId0Xt_ZZ4sCixvg/viewform">filling out this form</a>.
				<p>
				</p>
				What Happens Next?
				<p>
				</p>
				After April 15, your ideas to Envision a Better Chicago will be reviewed by your Alderman, Chicago City Clerk Susana Mendoza and The OpenGov Foundation’s Executive Director Seamus Kraft. A winning idea will be selected from each ward, earning the winning student $1,000 for school and a shot at their idea becoming a legislative proposal before the Chicago City Council.
				<p>
				</p>
				Make an impact. Win a scholarship. Envision Chicago.
				</p>

				<iframe width="560" height="315" src="https://www.youtube.com/embed/YOsD64MuoUQ" frameborder="0" allowfullscreen></iframe>

			</section> <!-- // .feature -->

			<section class="secondary-content">

				<article class="abstract">

					<h3>Questions and Answers</h3>

					<p>
					<strong>How do I submit an idea?</strong>
					</p>
					<p>
					Submit your idea by clicking the "Envision This Law" at the bottom of each law or by <a href="https://docs.google.com/a/opengovfoundation.org/forms/d/1IH1LUdPYB8lYCLTLS5YMNMd7Rg5EId0Xt_ZZ4sCixvg/viewform">filling out this form</a>.
					</p>
					<p>
					<strong>How many ideas can I submit to win a $1,000 scholarship?</strong>
					</p>
					<p>
					You may submit as many ideas as you want, but you can only win once and there is only one winner as each of the four schools.
					</p>
					<p>
					<strong>How will Envision Chicago winners be selected?</strong>
					</p>
					<p>
					Your school, the alderman who represents you on the Chicago City Council, <a href="http://chicityclerk.com/">Chicago City Clerk Susana Mendoza</a> and Seamus Kraft, Executive Director of <a href="http://www.opengovfoundation.org/">The OpenGov Foundation</a> will review and select a winner for each participating ward. Be sure to be thoughtful, thorough and creative!
					</p>
					<p>
					<strong>Can my friend post a comment?</strong>
					</p>
					<p>
					Anyone can post a comment on ChicagoCode.org, but only students of participating schools and classes will be eligible for the Envision Chicago scholarships.
					</p>
					<p>
					<strong>I want my school to participate. Who do I talk to?</strong>
					</p>
					<p>
					Great! Send an email to <a href="mailto:sayhello@opengovfoundation.org">sayhello@opengovfoundation.org</a> and contact your representative to let them know you’d like to participate in future Envision Chicago initiatives.
					</p>
					<p>
					<strong>I found an error.</strong>
					</p>
					<p>
					Report any issues you find to <a href="mailto:support@opengovfoundation.org">support@opengovfoundation.org</a>.
					</p>
					<p>
					<strong>How do I know if my submission went through?</strong>
					</p>
					<p>
					After hitting submit on the form there will be a screen saying "Thank you for participating in Envision Chicago! Your idea to improve the city was submitted successfully!"
					</p>
					<p>
					<strong>How do I stay involved after the competition?</strong>
					</p>
					<p>
					Stay tuned to The OpenGov Foundation’s <a href="https://twitter.com/FoundOpenGov">Twitter</a> and <a href="https://www.facebook.com/Opengovfoundation/">Facebook account</a> for more news about the Envision Chicago initiative and other work in Chicago.
					</p>
					<p>
					<strong>I have another question.</strong>
					</p>
					<p>
					We’re here to answer your questions on Envision Chicago, ChicagoCode.org, how the City Council works...anything! Email us at <a href="mailto:support@opengovfoundation.org">support@opengovfoundation.org</a> or tweet at us at <a href="https://twitter.com/FoundOpenGov">@FoundOpenGov</a>.
					</p>

				</article>

				<article class="abstract">

					<p>
					<strong>Participating Schools</strong>
					</p>
					<ul>
					<li><a href="/envision/ward-26/">Ward 26 - Marine Leadership Academy at Ames</a></li>
					<li><a href="/envision/ward-34/">Ward 34 - Chicago Excel Academy of Roseland</a></li>
					<li><a href="/envision/ward-41/">Ward 41 - Taft High School</a></li>
					<li><a href="/envision/ward-47/">Ward 47 - Lake View High School</a></li>
					</ul>

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
