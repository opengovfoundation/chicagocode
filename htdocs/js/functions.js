$(document).ready(function () {
	
	/* Provide the ability to navigate with arrow keys. */
	Mousetrap.bind(['ctrl+left', 'left', 'j', 'a'], function(e) {
		var url = $('link[rel=prev]').attr('href');
		if (url) {
			window.location = url;
		}
	});
	
	Mousetrap.bind(['ctrl+right', 'right', 'k', 'd'], function(e) {
		var url = $('link[rel=next]').attr('href');
		if (url) {
			window.location = url;
		}
	});
	
	Mousetrap.bind(['ctrl+up', 'w'], function(e) {
		var url = $('link[rel=up]').attr('href');
		if (url) {
			window.location = url;
		}
	});
	
	Mousetrap.bind(['ctrl+down', 's'],  function(e) {
		var url = $('link[rel=down]').attr('href');
		if (url) {
			window.location = url;
		}
	});
	
	Mousetrap.bind(['/', 'ctrl+/'], function(e) {
		$('#search-input').focus();
	});
	
	/* Highlight a section chosen in an anchor (URL fragment). The first stanza is for externally
	originating traffic, the second is for when clicking on an anchor link within a page. */
	if (document.location.hash) {
	
		$(document.location.hash).slideto({
			slide_duration: 500
		});
		
		$(document.location.hash).show('highlight', {color: '#ffff00'}, 'fast');
	}
	
	$('a[href*=#]').click(function(){
	
		var elemId = '#' + $(this).attr('href').split('#')[1];
		$(elemId).slideto({
			slide_duration: 500
		});
		
		$(document.location.hash).show('highlight', {color: '#ffff00'}, 'fast');
		
	});
	
		
	/* Display a tooltip for permalinks. */
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
	$("a.law").each(function() {
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
					url: '/api/law/'+section_number,
					type: 'GET',
					data: { fields: 'catch_line,ancestry', key: api_key },
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
	
	/* Words for which we have dictionary terms.*/
	$("span.dictionary").each(function() {
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
					url: '/api/dictionary/' + encodeURI(term),
					type: 'GET',
					data: { section: section_number, key: api_key },
					dataType: 'json',
					success: function(data, status) {
						var content = data.definition.truncate();
						if (data.section_number != null) {
							content = content + ' (<a href="' + data.url + '">§&nbsp;' + data.section_number + '</a>)';
						}
						else if (data.source) {
							content = content + ' (Source: <a href="' + data.url + '">' + data.source + '</a>)';
						}
						this.set('content.text', content);
					}
				}
			}
		})
	});
});