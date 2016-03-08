<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IEMobile 7 ]><html class="no-js iem7"><![endif]-->
<!--[if IE 7]>	<html class="no-js lt-ie9 lt-ie8 ie7"> <![endif]-->
<!--[if IE 8]>	<html class="no-js lt-ie9 ie8"> <![endif]-->
<!--[if (gt IE 8)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html class="" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>{{browser_title}}</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	{{meta_tags}}
	<link rel="home" title="Home" href="/" />
	{{link_rel}}

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

	{{css}}
	{{inline_css}}

</head>
<body class="preload {{body_class}}">
	<!--[if lt IE 7]>
		<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
	<![endif]-->
  <div id="container"><!-- Hack for footer lock -->
	<header id="page_header">
		<div class="nest">
			<a href="/" class="noprint">
				<hgroup id="place_logo">
					<h1>{{place_name}}</h1>
					<h2>Decoded</h2>
				</hgroup>
			</a>
			<section id="search">
				<form id="search_form" method="get" action="/search/">
					<label for="search">Search the code by keyword, phrase, or title</label>
					<input type="search" name="q" value="" id="search" placeholder="Search the Laws">
					<input type="submit" name="" value="Search" id="submit" class="btn btn-success">
					<!--a class="advanced" href="#">Advanced</a-->
				</form>
			</section> <!-- // #search -->
		</div> <!-- // .nest -->
		<nav id="main_navigation" role="navigation">
			<div class="nest">
				<ul>
					<li>
						<a href="/browse/" id="browse">Browse</a>
					</li>
					<li>
						<a href="/about/" id="about">About Us</a>
					</li>
					<li>
						<a href="/downloads/" id="downloads">Downloads</a>
					</li>
					<li>
						<a href="/envision/" id="envision">Envision</a>
					</li>

				</ul>
			</div> <!-- // .nest -->
		</nav> <!-- // #main_navigation -->
	</header> <!-- // #page_header -->

	<section id="main_content" role="main">
		<div class="{{content_class}}">
			<header>
				{{heading}}
			</header>

			<section class="primary-content">

				<nav id="intercode">
					{{intercode}}
				</nav> <!-- // #intercode -->

				<h1>{{page_title}}</h1>

				{{body}}
			</section>

			<aside id="sidebar" class="secondary-content">
			{{sidebar}}
			</aside>
		</div>

	</section> <!-- // #page -->

		<footer id="page_footer">
			<div class="nest">
				<p class="legalese">
					All user-contributed content is, of course, owned by its authors. The Chicago code
					is owned by the citizens of Chicago and, consequently, it is not governed by
					copyright—so do whatever you want with it! The information on this website does
					not constitute legal advice—nobody here is acting as your attorney, and nothing
					that you read here is a substitute for a competent attorney. OpenGov makes no
					guarantee that this information is accurate or up-to-date, although we try our
					best. Seriously, OpenGov is not your attorney. Heck, we’re not attorneys at all.
				</p>
				<p class="credits">
					Maintained by the <a href="http://opengovfoundation.org">OpenGov Foundation</a><br />
					Powered by <a href="http://www.statedecoded.com/">The State Decoded</a><br />
					Design by <a href="http://www.meticulous.com">Meticulous</a>
				</p>
			</div> <!-- // .nest -->
		</footer> <!-- // #page_footer -->
  </div> <!-- // #container -->
	{{javascript_files}}
  <script type="text/javascript">
	{{javascript}}
  </script>
</body>
</html>
