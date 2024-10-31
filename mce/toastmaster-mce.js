(function() {
	tinymce.PluginManager.add(
		'toastmaster',
		function( editor, url ) {
			var sh_tag = 'toastmaster';

			// helper functions
			function getAttr(s, n) {
				n = new RegExp( n + '=\"([^\"]+)\"', 'g' ).exec( s );
				return n ? window.decodeURIComponent( n[1] ) : '';
			};

			function html( cls, data) {

				var urlparts = url.split( "wp-content" );
				var baseurl  = urlparts[0] + '?placeholder_image=1';

				// var baseurl = window.location.protocol + "//" + window.location.host + '/?placeholder_image=1';

				if (getAttr( data,'themewords' )) {
					placeholder = baseurl + '&themewords=1';
				} else {
					placeholder = baseurl + '&role=' + getAttr( data,'role' ) + '&count=' + getAttr( data,'count' );
				}
				data = window.encodeURIComponent( data );
				return '\n\n<img src="' + placeholder + '" class="mceItem ' + cls + '" ' + 'data-tm-attr="' + data + '"' + 'alt="' + data + '" data-mce-resize="false" data-mce-placeholder="1" />\n\n';
			}

			function replaceShortcodes( content ) {
				return content.replace(
					/\[toastmaster([^\]]*)\]/g,
					function( all,attr) {
						return html( 'wp-toastmaster', attr );
					}
				);
			}

			function restoreShortcodes( content ) {
				return content.replace(
					/(?:<p(?: [^>]+)?>)*(<img [^>]+>)(?:<\/p>)*/g,
					function( match, image ) {
						var data = getAttr( image, 'data-tm-attr' );

						if ( data ) {
							return '<p>[' + sh_tag + data + ']</p>' + '\n\n';
						}
						return match;
					}
				);
			}

			// add popup
			editor.addCommand(
				'toastmaster_popup',
				function(ui, v) {
					if (v.themewords) {
						return;
					}
					// setup defaults
					var count = '1';
					if (v.count) {
						count = v.count;
					}
					var custom = '';
					var role   = '';
					if (v.role) {
						role = v.role;
					}
					var standard_roles = ['Ah Counter','Body Language Monitor','Evaluator','General Evaluator','Grammarian','Speaker','Backup Speaker','Topics Master','Timer','Toastmaster of the Day','Vote Counter'];
					if (standard_roles.indexOf( role ) == -1) {
						custom = role;
						role   = 'Custom';
					}
					var agenda_note = '';
					if (v.agenda_note) {
						agenda_note = v.agenda_note;
					}
					var time_allowed = 0;
					if (v.time_allowed) {
						time_allowed = v.time_allowed;
					}
					var padding_time = 0;
					if (v.padding_time) {
						padding_time = v.padding_time;
					}
					var indent = '0';
					if (v.indent) {
						indent = v.indent;
					}

					editor.windowManager.open(
						{
							title: 'Roles Editor',
							body: [
							{
								type: 'listbox',
								name: 'role',
								label: 'Role',
								value: role,
								'values': [
								{text: 'Custom', value: 'Custom'},
								{text: 'Ah Counter', value: 'Ah Counter'},
								{text: 'Body Language Monitor', value: 'Body Language Monitor'},
								{text: 'Evaluator', value: 'Evaluator'},
								{text: 'General Evaluator', value: 'General Evaluator'},
								{text: 'Grammarian', value: 'Grammarian'},
								{text: 'Speaker', value: 'Speaker'},
								{text: 'Backup Speaker', value: 'Backup Speaker'},
								{text: 'Topics Master', value: 'Topics Master'},
								{text: 'Timer', value: 'Timer'},
								{text: 'Toastmaster of the Day', value: 'Toastmaster of the Day'},
								{text: 'Vote Counter', value: 'Vote Counter'}
								],
								tooltip: 'Standardized roles from educational program'
							},
							{
								type: 'textbox',
								name: 'custom',
								label: 'Custom Role',
								value: custom,
								tooltip: 'Additional roles such as Humorist'
							},
							{
								type: 'listbox',
								name: 'count',
								label: 'Count',
								value: count,
								'values': [
								{text: '1', value: '1'},
								{text: '2', value: '2'},
								{text: '3', value: '3'},
								{text: '4', value: '4'},
								{text: '5', value: '5'},
								{text: '6', value: '6'},
								{text: '7', value: '7'},
								{text: '8', value: '8'},
								{text: '9', value: '9'},
								{text: '10', value: '10'}
								],
								tooltip: 'How many members can sign up?'
							},
							{
								type: 'listbox',
								name: 'indent',
								label: 'Indent?',
								value: indent,
								'values': [
								{text: 'No', value: '0'},
								{text: 'Yes', value: '1'}
								],
								tooltip: 'Should this be indented on the printed agenda?'
							},
							{
								type: 'textbox',
								name: 'agenda_note',
								label: 'Agenda Note',
								value: agenda_note,
								tooltip: 'Explanation of role (optinal). To show Speaker/Evaluator matches, you can use "Evaluates {Speaker}" in the note for Evaluator role'
							},
							{
								type: 'listbox',
								name: 'time_allowed',
								label: 'Total Time Allowed',
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
								tooltip: 'Optional: Time in minutes'
							},
							{
								type: 'listbox',
								name: 'padding_time',
								label: 'Extra Time',
								value: padding_time,
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
								{text: '10', value: '10'}
								],
								tooltip: 'Optional: Extra minutes allowed for introductions and other stage business'
							}
							],
							onsubmit: function( e ) {

								if ( e.data.role == 'Custom') {
									e.data.role = e.data.custom;
								}

								var shortcode_str = '[' + sh_tag + ' role="' + e.data.role + '" count="' + e.data.count + '"' + ' agenda_note="' + e.data.agenda_note + '"' + ' time_allowed="' + e.data.time_allowed + '"' + ' padding_time="' + e.data.padding_time + '"' + ' indent="' + e.data.indent + '"]' + '\n\n';
								// insert shortcode to tinymce
								editor.insertContent( shortcode_str );
							}
						}
					);
				}
			);

			// add button
			editor.addButton(
				'toastmaster',
				{
					icon: 'toastmaster',
					tooltip: 'Toastmaster Role',
					onclick: function() {
						editor.execCommand(
							'toastmaster_popup',
							'',
							{
								count   : '1',
								role: ''
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
					var cls = e.target.className.indexOf( 'wp-toastmaster' );
					if ( e.target.nodeName == 'IMG' && e.target.className.indexOf( 'wp-toastmaster' ) > -1 ) {
						var title = e.target.attributes['data-tm-attr'].value;
						title     = window.decodeURIComponent( title );
						console.log( title );
						editor.execCommand(
							'toastmaster_popup',
							'',
							{
								count   : getAttr( title,'count' ),
								role   : getAttr( title,'role' ),
								indent   : getAttr( title,'indent' ),
								agenda_note   : getAttr( title,'agenda_note' ),
								themewords   : getAttr( title,'themewords' ),
								time_allowed   : getAttr( title,'time_allowed' ),
								padding_time   : getAttr( title,'padding_time' )
							}
						);
					}
				}
			);
		}
	);
})();
