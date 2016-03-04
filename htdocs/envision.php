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
				<p>
					Envision Chicago is coming soon!
				</p>
				<p>
					We'll be kicking off the project from 2-3pm on Friday, March 11th at 1871 Chicago.
				</p>
				<p>
					<a class="btn btn-success" href="https://envisionchicago.splashthat.com/">RSVP on Splash</a>
				</p>
			</section> <!-- // .feature -->





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
