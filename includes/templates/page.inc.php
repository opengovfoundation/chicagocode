<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <html lang="en" class="ie ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="ie ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="ie ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="ie ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8"/>
	<title>{{browser_title}}</title>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
	<!--<link rel="shortcut icon" href="/images/favicon.png"/>-->
	<!--<link rel="apple-touch-icon" href="/images/custom_icon.png"/>-->
	<!-- The is the icon for iOS's Web Clip.
	- size: 57x57 for older iPhones, 72x72 for iPads, 114x114 for iPhone4's retina display (IMHO, just go ahead and use the biggest one)
	- To prevent iOS from applying its styles to the icon name it thusly: apple-touch-icon-precomposed.png
	- Transparency is not recommended (iOS will put a black BG behind the icon) -->
	
	<link rel="stylesheet" href="/css/reset.css" type="text/css" media="screen">
	<link rel="stylesheet" href="/css/master.css" type="text/css" media="screen">
	<link rel="stylesheet" href="/css/jquery.qtip.css" type="text/css" media="screen">
	<link rel="home" title="Home" href="/" />
	{{link_rel}}
	{{css}}
	{{inline_css}}
	<!-- CSS: Generic print styles -->
	<!--<link rel="stylesheet" media="print" href="/css/print.css"/>-->
	
	<!-- For the less-enabled mobile browsers like Opera Mini -->
	<!--<link rel="stylesheet" media="handheld" href="/css/handheld.css"/>-->
	
	<!-- Make MSIE play nice with HTML5 & Media Queries -->
	<script src="/js/modernizr.custom.23612.js"></script>
	<script src="/js/respond.min.js"></script>
	<!--[if lt IE 9]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
	<![endif]-->

	<script src="https://www.google.com/jsapi?key=YOURKEY"></script>
	<script>
		google.load("jquery", "1.4.3");
		google.load("jqueryui", "1.8.11");
	</script>
	<!-- Other Javascript is at the end of the page for faster loading pages -->
</head>
<body>
	<header id="masthead">
		<hgroup>
			<h1><a href="/">The State Decoded</a></h1>
		</hgroup>
		<nav id="main_navigation">
			<div id="search">
				<form method="get" action="/search/">
					<input type="search" size="20" name="q" placeholder="Search the Code"/>
					<input type="submit" value="Search" />
				</form>
			</div> <!-- // #search -->
			<ul>
				<li><a href="/" class="ir" id="home">Home</a></li>
				<li><a href="/about/" class="ir" id="about">About</a></li>
			</ul>
		</nav> <!-- // #main_navigation -->
	</header> <!-- // #masthead -->

	<section id="page">
		<nav id="breadcrumbs">
			{{breadcrumbs}}
		</nav>
		
		<nav id="intercode">
			{{intercode}}
		</nav> <!-- // #intercode -->

		<h1>{{page_title}}</h1>
    	
    	<section id="sidebar">
		{{sidebar}}
		</section>
		
		{{body}}
		
	</section> <!-- // #page -->
  
	<footer id="page_footer">
		<p>Powered by <a href="http://www.statedecoded.com/">The State Decoded</a>.</p>
	</footer>
	<script>
		{{javascript}}
	</script>
	{{javascript_files}}
	<script src="/js/jquery.qtip.min.js"></script>
	<script src="/js/jquery.color.js"></script>
	<script src="/js/jquery.cookies.2.2.0.min.js"></script>
  	<script>
	$('a.section-permalink').qtip({
		content: "Permanent link to this subsection",
		show: {
			event: "mouseover"
		},
		hide: {
			event: "mouseout"
		},
		position: {
			at: "top center",
			my: "bottom center"
		}
	})
	
	/* Mentions of other sections of the code. */
	$("a.section").each(function() {
		var section_number = $(this).text();
		$(this).qtip({
			tip: true,
			hide: {
				when: 'mouseout',
				fixed: true,
				delay: 100
			},
			position: {
				at: "top center",
				my: "bottom left"
			},
			style: {
				width: 300,
				tip: "bottom left"
			},
			content: {
				text: 'Loading .&thinsp;.&thinsp;.',
				ajax: {
					url: '/api/0.1/section/'+section_number,
					type: 'GET',
					data: { fields: 'catch_line,ancestry' },
					dataType: 'json',
					success: function(section, status) {
						if( section.ancestry instanceof Object ) {
							var content = '';
							for (key in section.ancestry) {
								var content = section.ancestry[key].name + ' → ' + content;
							}
						}
						var content = content + section.catch_line;
						this.set('content.text', content);
					}
				}
			}
		})
	});

	/* Attach to every bill number link an Ajax method to display a tooltip.*/
	$("a.bill").each(function() {
		
		/* Use the Richmond Sunlight URL to determine the bill year and number. */
		var url = $(this).attr("href");
		var url_components = url.match(/\/bill\/(\d{4})\/(\w+)\//);
		var year = url_components[1];
		var bill_number = url_components[2];
		
		$(this).qtip({
			tip: true,
			hide: {
				when: 'mouseout',
				fixed: true,
				delay: 100
			},
			position: {
				at: "top center",
				my: "bottom right"
			},
			style: {
				width: 300,
				tip: "bottom right"
			},
			content: {
				text: 'Loading .&thinsp;.&thinsp;.',
				ajax: {
					url: 'http://api.richmondsunlight.com/1.0/bill/'+year+'/'+bill_number+'.json',
					type: 'GET',
					dataType: 'jsonp',
					success: function(data, status) {
						var content = '<a href="http://www.richmondsunlight.com/legislator/'
							+ data.patron.id + '/">' + data.patron.name + '</a>: ' + data.summary.truncate();
						this.set('content.text', content);
					}
				}
			}
		})
	});

	/* Truncate text at 250 characters of length. Written by "c_harm" and posted to Stack Overflow
	at http://stackoverflow.com/a/1199627/955342 */
	String.prototype.truncate = function(){
		var re = this.match(/^.{0,500}[\S]*/);
		var l = re[0].length;
		var re = re[0].replace(/\s$/,'');
		if(l < this.length)
			re = re + "&nbsp;.&thinsp;.&thinsp;.&thinsp;";
		return re;
	}
	
	/* Words for which we have definitions.*/
	$("span.definition").each(function() {
		var term = $(this).text();
		$(this).qtip({
			tip: true,
			hide: {
				when: 'mouseout',
				fixed: true,
				delay: 100
			},
			position: {
				at: "top center",
				my: "bottom left"
			},
			style: {
				width: 300,
				tip: "bottom left"
			},
			content: {
				text: 'Loading .&thinsp;.&thinsp;.',
				ajax: {
					url: '/api/0.1/glossary',
					type: 'GET',
					data: { term: term, section: section_number },
					dataType: 'json',
					success: function(data, status) {
						var content = data.formatted.truncate();
						this.set('content.text', content);
					}
				}
			}
		})
	});
  
	/* Highlight a section just linked to via an anchor. */
	function highlight(elemId){
		var elem = $(elemId);
		$(elemId).css("backgroundColor", "#fff"); // hack for Safari
		$(elemId).animate({ backgroundColor: 'rgb(255,255,170)' }, 1500);
		setTimeout(function(){$(elemId).animate({ backgroundColor: "transparent" }, 3000)},1000);
	}
	if (document.location.hash) {
		highlight(document.location.hash);
	}
	$('a[href*=#]').click(function(){
		var elemId = '#' + $(this).attr('href').split('#')[1];
		highlight(elemId);
	});

	</script>
</body>
</html>