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
	'<!-- UNCOMMENT TO DISPLAY AN INTRODUCTORY VIDEO HERE
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
					<h2>Tagline goes here.</h2>
				</hgroup>

				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ac scelerisque sem, a pellentesque urna. Nam ac aliquet sem. Phasellus vel eros nisl. Sed dapibus eu dolor in congue. Nulla placerat, orci eu facilisis varius, nibh velit scelerisque augue, pharetra ornare nunc arcu vel magna. Sed vel eleifend neque. Praesent eleifend odio quis nisi consectetur vulputate. Suspendisse vestibulum nisl ut interdum laoreet.</p>

				<p>Nulla facilisi. Nunc eleifend sem est, vel sagittis arcu lobortis quis. Mauris gravida odio eu blandit venenatis. Nam maximus felis eu justo tincidunt, sed posuere lectus ullamcorper. Pellentesque et ex interdum, gravida neque in, placerat diam. Aliquam erat felis, cursus in dictum at, porttitor vitae tortor. Proin leo urna, commodo vitae augue ut, pretium placerat elit. Mauris vehicula quam eget rutrum lobortis. Nam ornare, mi a sollicitudin finibus, tellus eros porta ligula, in placerat erat tellus eget sapien. Morbi nibh metus, tincidunt eget libero sed, lacinia condimentum ligula. Vestibulum tempor tristique ex, a tincidunt metus sagittis nec.</p>

				<p>Vivamus auctor augue nulla, pulvinar accumsan ex malesuada id. Praesent sed mollis ligula, laoreet ornare mi. Cras id dictum tortor. Mauris sollicitudin vestibulum egestas. Cras pharetra auctor fermentum. Aenean quis erat eu ante pharetra accumsan. Morbi quis nibh porttitor, porta dui nec, egestas nisl. Morbi aliquam vehicula est, volutpat tempus ex suscipit eget. Vestibulum ultricies purus quis finibus consectetur. Ut hendrerit porttitor felis sit amet condimentum. Proin posuere dui a varius auctor. Ut sollicitudin sagittis lectus, ut rutrum risus consectetur vitae. Maecenas non ligula convallis, malesuada ipsum non, molestie erat. In rhoncus vestibulum tristique. Nam luctus nunc risus, vitae elementum lacus suscipit sit amet.</p>

			</section> <!-- // .feature -->

			<section class="secondary-content">

				<article class="abstract">

				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ac scelerisque sem, a pellentesque urna. Nam ac aliquet sem. Phasellus vel eros nisl. Sed dapibus eu dolor in congue. Nulla placerat, orci eu facilisis varius, nibh velit scelerisque augue, pharetra ornare nunc arcu vel magna. Sed vel eleifend neque. Praesent eleifend odio quis nisi consectetur vulputate. Suspendisse vestibulum nisl ut interdum laoreet.</p>

				<p>Nulla facilisi. Nunc eleifend sem est, vel sagittis arcu lobortis quis. Mauris gravida odio eu blandit venenatis. Nam maximus felis eu justo tincidunt, sed posuere lectus ullamcorper. Pellentesque et ex interdum, gravida neque in, placerat diam. Aliquam erat felis, cursus in dictum at, porttitor vitae tortor. Proin leo urna, commodo vitae augue ut, pretium placerat elit. Mauris vehicula quam eget rutrum lobortis. Nam ornare, mi a sollicitudin finibus, tellus eros porta ligula, in placerat erat tellus eget sapien. Morbi nibh metus, tincidunt eget libero sed, lacinia condimentum ligula. Vestibulum tempor tristique ex, a tincidunt metus sagittis nec.</p>

				<p>Vivamus auctor augue nulla, pulvinar accumsan ex malesuada id. Praesent sed mollis ligula, laoreet ornare mi. Cras id dictum tortor. Mauris sollicitudin vestibulum egestas. Cras pharetra auctor fermentum. Aenean quis erat eu ante pharetra accumsan. Morbi quis nibh porttitor, porta dui nec, egestas nisl. Morbi aliquam vehicula est, volutpat tempus ex suscipit eget. Vestibulum ultricies purus quis finibus consectetur. Ut hendrerit porttitor felis sit amet condimentum. Proin posuere dui a varius auctor. Ut sollicitudin sagittis lectus, ut rutrum risus consectetur vitae. Maecenas non ligula convallis, malesuada ipsum non, molestie erat. In rhoncus vestibulum tristique. Nam luctus nunc risus, vitae elementum lacus suscipit sit amet.</p>

				</article>

				<article class="abstract">

				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ac scelerisque sem, a pellentesque urna. Nam ac aliquet sem. Phasellus vel eros nisl. Sed dapibus eu dolor in congue. Nulla placerat, orci eu facilisis varius, nibh velit scelerisque augue, pharetra ornare nunc arcu vel magna. Sed vel eleifend neque. Praesent eleifend odio quis nisi consectetur vulputate. Suspendisse vestibulum nisl ut interdum laoreet.</p>

				<p>Nulla facilisi. Nunc eleifend sem est, vel sagittis arcu lobortis quis. Mauris gravida odio eu blandit venenatis. Nam maximus felis eu justo tincidunt, sed posuere lectus ullamcorper. Pellentesque et ex interdum, gravida neque in, placerat diam. Aliquam erat felis, cursus in dictum at, porttitor vitae tortor. Proin leo urna, commodo vitae augue ut, pretium placerat elit. Mauris vehicula quam eget rutrum lobortis. Nam ornare, mi a sollicitudin finibus, tellus eros porta ligula, in placerat erat tellus eget sapien. Morbi nibh metus, tincidunt eget libero sed, lacinia condimentum ligula. Vestibulum tempor tristique ex, a tincidunt metus sagittis nec.</p>

				<p>Vivamus auctor augue nulla, pulvinar accumsan ex malesuada id. Praesent sed mollis ligula, laoreet ornare mi. Cras id dictum tortor. Mauris sollicitudin vestibulum egestas. Cras pharetra auctor fermentum. Aenean quis erat eu ante pharetra accumsan. Morbi quis nibh porttitor, porta dui nec, egestas nisl. Morbi aliquam vehicula est, volutpat tempus ex suscipit eget. Vestibulum ultricies purus quis finibus consectetur. Ut hendrerit porttitor felis sit amet condimentum. Proin posuere dui a varius auctor. Ut sollicitudin sagittis lectus, ut rutrum risus consectetur vitae. Maecenas non ligula convallis, malesuada ipsum non, molestie erat. In rhoncus vestibulum tristique. Nam luctus nunc risus, vitae elementum lacus suscipit sit amet.</p>

				</article>

			</section> <!-- // .secondary-content -->

		</div> <!-- // .nest -->

	</section>');

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
