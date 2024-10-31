(function() {
	tinymce.PluginManager.add(
		'agenda_note',
		function( editor, url ) {
			var sh_tag = 'agenda_note';

			// helper functions
			function getAttr(s, n) {
				n = new RegExp( n + '=\"([^\"]+)\"', 'g' ).exec( s );
				return n ? window.decodeURIComponent( n[1] ) : '';
			};

			function html( cls, data ,con) {
				var urlparts = url.split( "wp-content" );
				var baseurl  = urlparts[0] + '?placeholder_image=1';
				con          = con.replace( '\r',' ' );
				con          = con.replace( '\n',' ' );
				con          = con.replace( /(<([^>]+)>)/ig,"" );
				var editable = getAttr( data,'editable' );
				if (editable) {
					editable = ' editable:' + editable;
				}
				placeholder = baseurl + '&agenda_note=' + window.encodeURIComponent( con.substr( 0,50 ) + '... ' ) + editable + '&agenda_display=' + getAttr( data,'agenda_display' );
				data        = window.encodeURIComponent( data );
				content     = window.encodeURIComponent( con );
				return '\n\n<img src="' + placeholder + '" class="mceItem ' + cls + '" ' + 'data-sh-attr="' + data + '"' + 'alt="' + data + '" data-sh-content="' + con + '" data-mce-resize="false" data-mce-placeholder="1" />\n\n';
			}

			function replaceShortcodes( content ) {
				return content.replace(
					/\[agenda_note([^\]]*)\]([^\]]*)\[\/agenda_note\]/g,
					function( all,attr,con) {
						return html( 'wp-agenda_note', attr , con );
					}
				);
			}

			function restoreShortcodes( content ) {
				return content.replace(
					/(?:<p(?: [^>]+)?>)*(<img [^>]+>)(?:<\/p>)*/g,
					function( match, image ) {
						var data = getAttr( image, 'data-sh-attr' );
						var con  = getAttr( image, 'data-sh-content' );

						if ( data ) {
							return '<p>[' + sh_tag + data + ']' + con + '[/' + sh_tag + ']</p>' + '\n\n';
						}
						return match;
					}
				);
			}

			// add popup
			editor.addCommand(
				'agenda_note_popup',
				function(ui, v) {
					// setup defaults
					var agenda_display = 'agenda';
					if (v.agenda_display) {
						agenda_display = v.agenda_display;
					}
					var strong = '';
					if (v.strong) {
						strong = v.strong;
					}
					var italic = '';
					if (v.italic) {
						italic = v.italic;
					}
					var size = '';
					if (v.size) {
						size = v.size;
					}
					var style = '';
					if (v.style) {
						style = v.style;
					}
					var editable = '';
					if (v.editable) {
						editable = v.editable;
					}
					var time_allowed = '';
					if (v.time_allowed) {
						time_allowed = v.time_allowed;
					}
					var content = '';
					if (v.content) {
						content = v.content;
					}
					var alink = '';
					if (v.alink) {
						alink = v.alink;
					}

					editor.windowManager.open(
						{
							title: 'Agenda Note',
							body: [
							{
								type: 'textbox',
								name: 'content',
								label: 'Note',
								value: content,
								multiline: true,
								minWidth: 300,
								minHeight: 50
							},
							{
								type: 'listbox',
								name: 'agenda_display',
								label: 'Display On',
								value: agenda_display,
								'values': [
								{text: 'agenda', value: 'agenda'},
								{text: 'web', value: 'web'},
								{text: 'both', value: 'both'}
								],
								tooltip: 'Where should this be displayed?'
							},
							{
								type: 'listbox',
								name: 'strong',
								label: 'Bold?',
								value: strong,
								'values': [
								{text: 'no', value: ''},
								{text: 'yes', value: 'bold'}
								],
								tooltip: 'Bold font?'
							},
							{
								type: 'listbox',
								name: 'italic',
								label: 'Italic?',
								value: italic,
								'values': [
								{text: 'no', value: ''},
								{text: 'yes', value: 'italic'}
								],
								tooltip: 'Bold font?'
							},
							{
								type: 'listbox',
								name: 'size',
								label: 'Font size',
								value: size,
								'values': [
								{text: 'default', value: ''},
								{text: 'small', value: 'small'},
								{text: 'large', value: 'large'},
								{text: 'extra large', value: 'x-large'},
								{text: '30 pixels', value: '30px'},
								{text: '35 pixels', value: '35px'},
								{text: '40 pixels', value: '40px'},
								{text: '45 pixels', value: '45px'},
								{text: '50 pixels', value: '50px'}
								],
								tooltip: 'Larger or smaller font'
							},
							{
								type: 'textbox',
								name: 'style',
								label: 'CSS Style (advanced)',
								value: style,
								tooltip: 'Leave blank for none'
							},
							{
								type: 'textbox',
								name: 'alink',
								label: 'Link (web address)',
								value: alink,
								tooltip: 'Leave blank for none'
							},
							{
								type: 'textbox',
								name: 'editable',
								label: 'Editable field',
								value: editable,
								tooltip: 'Leave blank for none'
							},
							{
								type: 'listbox',
								name: 'time_allowed',
								label: 'Time Allowed',
								value: time_allowed,
								'values': [
								{text: 'Not set', value: '0'},
								{text: '1', value: '1'},
								{text: '2', value: '2'},
								{text: '3', value: '3'},
								{text: '4', value: '4'},
								{text: '5', value: '5'},
								{text: '6', value: '6'},
								{text: '7', value: '7'},
								{text: '8', value: '8'},
								{text: '9', value: '9'},
								{text: '10', value: '10'},
								{text: '11', value: '11'},
								{text: '12', value: '12'},
								{text: '13', value: '13'},
								{text: '14', value: '14'},
								{text: '15', value: '15'},
								{text: '16', value: '16'},
								{text: '17', value: '17'},
								{text: '18', value: '18'},
								{text: '19', value: '19'},
								{text: '20', value: '20'},
								{text: '21', value: '21'},
								{text: '22', value: '22'},
								{text: '23', value: '23'},
								{text: '24', value: '24'},
								{text: '25', value: '25'},
								{text: '26', value: '26'},
								{text: '27', value: '27'},
								{text: '28', value: '28'},
								{text: '29', value: '29'},
								{text: '30', value: '30'},
								{text: '31', value: '31'},
								{text: '32', value: '32'},
								{text: '33', value: '33'},
								{text: '34', value: '34'},
								{text: '35', value: '35'},
								{text: '36', value: '36'},
								{text: '37', value: '37'},
								{text: '38', value: '38'},
								{text: '39', value: '39'},
								{text: '40', value: '40'},
								{text: '41', value: '41'},
								{text: '42', value: '42'},
								{text: '43', value: '43'},
								{text: '44', value: '44'},
								{text: '45', value: '45'},
								{text: '46', value: '46'},
								{text: '47', value: '47'},
								{text: '48', value: '48'},
								{text: '49', value: '49'},
								{text: '50', value: '50'},
								{text: '51', value: '51'},
								{text: '52', value: '52'},
								{text: '53', value: '53'},
								{text: '54', value: '54'},
								{text: '55', value: '55'},
								{text: '56', value: '56'},
								{text: '57', value: '57'},
								{text: '58', value: '58'},
								{text: '59', value: '59'},
								{text: '60', value: '60'}
								],
								tooltip: 'Time in minutes allowed for this activity'
							}
							],
							onsubmit: function( e ) {
								var shortcode_str = '[' + sh_tag + ' agenda_display="' + e.data.agenda_display + '"' + ' strong="' + e.data.strong + '"' + ' italic="' + e.data.italic + '"' + ' size="' + e.data.size + '"' + ' style="' + e.data.style + '"' + ' alink="' + e.data.alink + '"' + ' editable="' + e.data.editable + '"' + ' time_allowed="' + e.data.time_allowed + '"';
								// add panel content
								shortcode_str += ']' + e.data.content + '[/' + sh_tag + ']';
								// insert shortcode to tinymce
								editor.insertContent( shortcode_str );
							}
						}
					);
				}
			);

			// add button
			editor.addButton(
				'agenda_note',
				{
					icon: 'agenda_note',
					tooltip: 'Agenda Note',
					onclick: function() {
						editor.execCommand(
							'agenda_note_popup',
							'',
							{
								agenda_display   : 'agenda',
								content: ''
							}
						);
					}
				}
			);

			// replace from shortcode to an image placeholder
			editor.on(
				'BeforeSetcontent',
				function(event){
					event.content = replaceShortcodes( event.content );
				}
			);

			// replace from image placeholder to shortcode
			editor.on(
				'GetContent',
				function(event){
					event.content = restoreShortcodes( event.content );
				}
			);

			// open popup on placeholder double click
			editor.on(
				'DblClick',
				function(e) {
					var cls = e.target.className.indexOf( 'wp-agenda_note' );
					if ( e.target.nodeName == 'IMG' && e.target.className.indexOf( 'wp-agenda_note' ) > -1 ) {
						var title = e.target.attributes['data-sh-attr'].value;
						title     = window.decodeURIComponent( title );
						console.log( title );
						var content = e.target.attributes['data-sh-content'].value;
						editor.execCommand(
							'agenda_note_popup',
							'',
							{
								agenda_display   : getAttr( title,'agenda_display' ),
								strong   : getAttr( title,'strong' ),
								italic   : getAttr( title,'italic' ),
								size   : getAttr( title,'size' ),
								style   : getAttr( title,'style' ),
								alink   : getAttr( title,'alink' ),
								editable   : getAttr( title,'editable' ),
								time_allowed   : getAttr( title,'time_allowed' ),
								content: content
							}
						);
					}
				}
			);
		}
	);
})();
