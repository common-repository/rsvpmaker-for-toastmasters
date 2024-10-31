jQuery( document ).ready(
	function($) {

		$.ajaxSetup(
			{
				headers: {
					'X-WP-Nonce': wpt_rest.nonce,
				}
			}
		);

		var time_tally;

		var agenda_add_minutes = function (dt, minutes) {
			return new Date( dt.getTime() + minutes * 60000 );
		}

		function agenda_time_format(time_tally) {
			var hour   = time_tally.getHours();
			var minute = time_tally.getMinutes();
			var ampm   = (hour >= 12) ? 'pm' : 'am';
			hour       = (hour >= 12) ? hour - 12 : hour;
			if (minute < 10) {
				minute = '0' + minute;
			}
			return hour + ":" + minute + ' ' + ampm;
		}

		var agenda_time_tally = function () {
			$( '#rsvpsection' ).html( '' );// don't combine with rsvp form
			time_tally = new Date( $( '#tweak_time_start' ).val() );// start time
			$( '.time_allowed' ).each(
				function(index) {
					var block_count = $( this ).attr( 'block_count' );
					var formatted   = agenda_time_format( time_tally );
					$( '#cacltime' + index ).fadeTo( "fast", 0.1 );
					$( '#calctime' + index ).text( formatted );
					$( '#calctime' + index ).delay( index * 50 ).fadeTo( "fast", 1.0 );
					var tallyadd = 0;
					var addthis  = Number( $( this ).val() );
					if ( ! isNaN( addthis )) {
						tallyadd += addthis;
					}
					var padding = $( this ).attr( 'id' ).replace( 'time_allowed','padding_time' );
					addthis     = Number( $( '#' + padding ).val() );
					if ( ! isNaN( addthis )) {
						tallyadd += addthis;
					}
					time_tally = agenda_add_minutes( time_tally,tallyadd );
				}
			);
			$( '#tweak_time_end' ).text( agenda_time_format( time_tally ) );
		};
		if (typeof tm_vars.tweak_times !== 'undefined') {
			agenda_time_tally();
		}

		$( '.time_allowed' ).on(
			'change',
			function(){
				agenda_time_tally();
			}
		);
		$( '.padding_time' ).on(
			'change',
			function(){
				agenda_time_tally();
			}
		);

		$( '.count' ).on(
			'change',
			function(){
				var role        = $( this ).attr( 'role' );
				var block_count = $( this ).attr( 'block_count' );
				var count       = $( this ).val();
				var time        = 0;
				if (role == 'Speaker') {
					time = 7 * parseInt( count );
					$( '#time_allowed_' + block_count ).val( time );
					agenda_time_tally();
				} else if (role == 'Evaluator') {
					time = 3 * parseInt( count );
					$( '#time_allowed_' + block_count ).val( time );
					agenda_time_tally();
				}
			}
		);

		$( "#tweak_times_form" ).submit(
			function( event ) {

				// Stop form from submitting normally
				event.preventDefault();
				// Get some values from elements on the page:
				$( '#tweak_times_result' ).html( "Updating ..." );
				data = $( "#tweak_times_form" ).serialize();
				jQuery.post(
					wpt_rest.url + 'rsvptm/v1/tweak_times',
					data,
					function(response) {
						$( '#tweak_times_result' ).html( response.next );
					}
				);
			}
		);

		$( '.planner_edits_wrapper' ).hide();

		$( '.planner_edits_checkbox' ).click(
			function() {
				var index = $( this ).val();
				index     = index.replace( '.','\\.' );
				console.log( 'index ' + index );
				console.log( $( '#check-wrapper-' + index ).html() );
				$( '#check-wrapper-' + index ).hide();
				$( '#wrapper-' + index ).show();
			}
		);

		$( '.role_remove' ).click(
			function () {
				var block_count = $( this ).val();
				$( '#time_allowed_' + block_count ).val( 0 );
				$( '#padding_time_' + block_count ).val( 0 );
				$( '#count_' + block_count ).val( 0 );
				$( '#timeline_' + block_count ).fadeOut();
				agenda_time_tally();
			}
		);

		$( '.remove_names' ).click(
			function() {
				$('.remove_absences').show();
				$('.remove_in_person').show();
				$('.remove_names_line').hide();
			}
		);

		$( '.tmsortable' ).sortable(
			{
				containment: "parent",
				cursor: "move",
				update: function (event, ui) {
					var datastr = 'action=wpt_reorder&post_id=' + this.closest( '.post_id' );// $('#post_id').val();
					// $('#post_id').val();
					var order       = $( this ).sortable( 'toArray' );
					var assigned    = 0;
					var basefield   = order[0].replace( /_[0-9]+/,'' );
					var field       = basefield + '[]';
					var post_id     = $( '#' + basefield + 'post_id' ).val();
					var datastr     = 'action=wpt_reorder&reorder_nonce=' + $( '#reorder_nonce' ).val() + '&post_id=' + post_id;
					var arrayLength = order.length;
					for (var i = 0; i < arrayLength; i++) {
						assigned = $( '#' + order[i] + '_assigned' ).val();
						if ('undefined' !== typeof assigned) {
							datastr = datastr + '&' + field + '=' + assigned;
						}
					}
					var id = $( this ).prop( "id" );
					$( '#' + id + '_sortresult' ).text( 'Working ...' );
					var ajaxurl = wpt_rest.url + 'rsvptm/v1/reorder';
					console.log(ajaxurl);
					console.log(datastr);
					jQuery.post(
						ajaxurl,
						datastr,
						function(response) {
							console.log(response);
							$( '#' + id + '_sortresult' ).html( response );
							$( '#' + id + '_sortresult' ).fadeIn( 200 );
						}
					);
				}
			}
		);
		$( '.tmsortable' ).disableSelection();

		$( "div.role-block" ).mouseenter(
			function(){
				$( this ).css( "background-color","#EFEFEF" );
			}
		);
		$( "div.role-block" ).mouseleave(
			function(){
				$( this ).css( "background-color","white" );
			}
		);

		var menu      = $( '#cssmenu' );
		var menuList  = menu.find( 'ul:first' );
		var listItems = menu.find( 'li' ).not( '#responsive-tab' );

		// Create responsive trigger
		menuList.prepend( '<li id="responsive-tab"><a href="#">Menu</a></li>' );

		// Toggle menu visibility
		menu.on(
			'click',
			'#responsive-tab',
			function(){
				listItems.slideToggle( 'fast' );
				listItems.addClass( 'collapsed' );
			}
		);

		var sum = 0;
		$( '.maxtime' ).each(
			function() {
				sum += Number( $( this ).val() );
			}
		);
		var time_limit = 0;
		$( '.time_limit' ).each(
			function() {
				time_limit += Number( $( this ).val() );
			}
		);

		if ((time_limit != 0) && (sum > time_limit) ) {
			$( '.time_message' ).html( 'Time reserved, all speakers: ' + sum + ' minutes <span style="color:red;">(limit:' + time_limit + ')</span>' );
		} else if ((time_limit != 0) && (sum > 0)) {
			$( '.time_message' ).html( 'Time reserved, all speakers: ' + sum + ' minutes (limit:' + time_limit + ').' );
		} else if (sum > 0) {
			$( '.time_message' ).html( 'Time reserved, all speakers: ' + sum + ' minutes.' );
		}

		$( '.recommend_instead' ).on(
			'click',
			function(){
				var target = this.value;
				var role   = target.replace( '_rm','' );
				$( '#' + target ).html( '<p>Add a personal note (optional):<br /><textarea rows="3" cols="40" name="editor_suggest_note[' + role + ']"></textarea><br /><input type="checkbox" name="ccme" value="1" /> Send me a copy</p>' );
			}
		);

		var suggest_mode = false;
		// delegation code? $('.role_data').on('change', '.manual', function(){
		$( '.editor_assign' ).on(
			'change',
			function(){
				if(suggest_mode)
					return;
				var user_id = this.value;
				// alert('user_id '+user_id);
				var id    = this.id;
				var parts = id.split( 'editor_assign' );
				var role  = parts[1];
				if ( $( 'input[name="recommend_instead' + role + '"]' ).is( ':checked' ) ) {
					return false;}
				$( '#_manual_' + role ).html( project_list.manuals );
				$( '#_project_' + role ).html( '<option value="">Pick Manual for Project List</option>' );
				$( '#title_text' + role ).val( '' );
				$( '#_intro_' + role ).val( '' );
				var post_id   = $( this ).attr( 'post_id' );
				var editor_id = $( '#editor_id' ).val();
				$( '#status' + role ).html( 'Saving ... ' + role );
				if (post_id > 0) {
					var data = {
						'action': 'editor_assign',
						'role': role,
						'user_id': user_id,
						'editor_id': editor_id,
						'post_id': post_id,
						'timelord': rsvpmaker_rest.timelord 
					};
					$.post(
						wpt_rest.url + 'rsvptm/v1/editor_assign',
						data,
						function(response) {
							if (response.status) {
								$( '#status' + role ).html( response.status );
							}
							if (response.list) {
								var test = $( '#_manual_' + role ).val();
								if (typeof test !== 'undefined') {
									$( '#_manual_' + role ).html( response.list );
									$( '#_project_' + role ).html( response.projects );
									$( '#_manualtype_' + role ).val( response.type );
								} else {
									$( '#editone_manual_' + role ).html( response.list );
									$( '#editone_project_' + role ).html( response.projects );
									$( '#editone_manualtype_' + role ).val( response.type );
									$( '#editone_title_text' + role ).val( '' );
									$( '#editone_intro_' + role ).val( '' );
								}
							}
						}
					);

				}
			}
		);

		$( '.manual' ).on(
			'change',
			function(){
				var manual = this.value;
				var target = this.id.replace( 'manual','project' );
				var list   = project_list.projects[manual];
				$( '#' + target ).html( '<option value="">Pick a Project</option>' + list );
			}
		);

		$( '.manualtype' ).on(
			'change',
			function(){
				var manualtype      = this.value;
				var target          = this.id.replace( 'manualtype','manual' );
				var projects_target = this.id.replace( 'manualtype','project' );
				var current         = $( '#' + target ).val();
				$.get(
					wpt_rest.url + 'rsvptm/v1/type_to_manual/' + manualtype,
					function(data) {
						if (data.list) {
							$( '#' + target ).html( data.list );
							$( '#' + projects_target ).html( data.projects );
						}
					}
				);
				// var list = project_list[manual];
				// $('#'+target).html('<option value="">Pick a Project</option>' + list);
			}
		);

		$( '.project' ).on(
			'change',
			function(){
				var project         = this.value;
				var time_id         = this.id.replace( 'project','maxtime' );
				var display_time_id = this.id.replace( 'project','display_time' );
				var time_msg_id     = this.id.replace( 'project','tmsg' );
				var time            = project_times[project];
				var display_time    = display_times[project];
				$( '#' + time_id ).val( time );
				$( '#' + display_time_id ).val( display_time );

				if (this.id.indexOf( 'Backup' ) > -1) {
					return;
				}

				var sum = 0;
				$( '.maxtime' ).each(
					function() {
						sum += Number( $( this ).val() );
					}
				);

				if ((time_limit != 0) && (sum > time_limit) ) {
					$( '#' + time_msg_id ).html( '<span style="color:red">This choice would push the total time required for speeches over the limit set for the agenda (' + time_limit + ' minutes). You may need to speak to club and meeting organizers about adjusting the agenda. You can also manually adjust the Time Required field if you do not need the maximum time specified by the manual.</span>' );
					$( '.time_message' ).html( 'Time reserved, all speakers: ' + sum + ' minutes <span style="color: red;">(limit:' + time_limit + ')</span>.' );
				} else if ((time_limit != 0) && (sum > 0)) {
					$( '.time_message' ).html( 'Time reserved, all speakers: ' + sum + ' minutes (limit:' + time_limit + ').' );
					$( '#' + time_msg_id ).html( '' );
				} else if (sum > 0) {
					$( '.time_message' ).html( 'Time reserved, all speakers: ' + sum + ' minutes.' );
					$( '#' + time_msg_id ).html( '' );
				}
			}
		);

		$( '.moremeetings' ).hide();
		$( '#showmore' ).click(
			function() {
				$( '.moremeetings' ).slideDown();
				$( '#showmore' ).hide();
			}
		);

		$( ".tm_edit_detail" ).submit(
			function( event ) {

				// Stop form from submitting normally
				event.preventDefault();

				// Get some values from elements on the page:
				var $form  = $( this );
				var status = $( this ).attr( 'status' );

				data = $form.serialize();
				jQuery.post(
					ajaxurl,
					data,
					function(response) {
						$( '#form' + status ).html( response );
						$( '#delete' + status ).html( '' );
					}
				);

			}
		);

		$( ".delete_tm_detail" ).click(
			function( event ) {

				// Stop form from submitting normally
				event.preventDefault();

				// Get some values from elements on the page:
				var key     = $( this ).attr( 'key' );
				var status  = $( this ).attr( 'status' );
				var user_id = $( '#user_id_' + status ).val();

				data = {
					'action': "delete_tm_detail",
					'timelord': rsvpmaker_rest.timelord,
					'user_id': user_id,
					'key': key
				};

				jQuery.post(
					ajaxurl,
					data,
					function(response) {
						$( '#form' + status ).html( response );
						$( '#delete' + status ).html( '' );
					}
				);

			}
		);

		$( document ).on(
			'submit',
			'form.toastrole',
			function(event) {
				event.preventDefault();
				var conjunction = (wpt_rest.url.indexOf( '?' ) > 0) ? '&' : '?';
				var action      = wpt_rest.url + 'rsvptm/v1/tm_role' + conjunction + 'tm_ajax=role';
				var formid      = $( this ).attr( 'id' );
				var data        = $( this ).serialize();
				$( '#' + formid ).html( '<div style="line-height: 3">Saving ...</div>' );
				setTimeout(
					function () {
						$( '#' + formid ).addClass( 'bounce' );
					},
					1000
				);

				jQuery.post(
					action,
					data,
					function(response) {
						$( '#' + formid ).html( response.content );
						 $( '#' + formid ).removeClass( 'bounce' );
						$( '#' + formid ).css( "opacity", '1' );
						$( '#' + formid ).css( "display", 'block' );

						 $( '#' + formid ).addClass( 'grow' );
					}
				);
			}
		);

		$( document ).on(
			'submit',
			'form.remove_me_form',
			function(event) {
				event.preventDefault();
				var action      = wpt_rest.url + 'rsvptm/v1/tm_role?tm_ajax=remove_role';
				var formid      = $( this ).attr( 'id' );
				$( '#' + formid ).hide();
				var signup_id = formid.replace( 'remove','' );
				var data      = $( this ).serialize();
				setTimeout(
					function () {
						$( '#' + signup_id ).addClass( 'bounce' );
					},
					1000
				);
				jQuery.post(
					action,
					data,
					function(response) {
						$( '#' + signup_id ).html( '<div style="min-height: 3em;">' + response.content + '</div>' );
						 $( '#' + signup_id ).removeClass( 'bounce' );
						$( '#' + signup_id ).css( "opacity", '1' );
						$( '#' + signup_id ).css( "display", 'block' );

						 $( '#' + signup_id ).addClass( 'grow' );
					}
				);
			}
		);

		$( '.absences' ).on(
			'change',
			function(){
				var user_id = this.value;
				if (user_id < 1) {
					return;
				}
				var id       = this.id;
				var post_id  = $( '#' + id ).attr( 'post_id' );
				var statusid = 'status_absences' + post_id;
				$( '#' + statusid ).html( 'Saving ...' );
				var editor_id = $( '#editor_id' ).val();
				if (security && (post_id > 0)) {
					var data = {
						'action': 'editor_absences',
						'user_id': user_id,
						'editor_id': editor_id,
						'post_id': post_id,
						'timelord': rsvpmaker_rest.timelord 
					};
					jQuery.post(
						ajaxurl,
						data,
						function(response) {
							$( '#' + statusid ).html( response );
							$( '#' + statusid ).fadeIn( 200 );
						}
					);
				}
			}
		);

		$( '.absences_remove' ).on(
			'click',
			function(){
				var user_id = this.value;
				if (user_id < 1) {
					return;
				}
				var id       = this.id;
				var post_id  = $( '#' + id ).attr( 'post_id' );
				var statusid = 'current_absences' + post_id + user_id;
				$( '#' + statusid ).html( 'Saving ...' );
				var editor_id = $( '#editor_id' ).val();
				if (security && (post_id > 0)) {
					var data = {
						'action': 'absences_remove',
						'user_id': user_id,
						'editor_id': editor_id,
						'timelord': rsvpmaker_rest.timelord,
						'post_id': post_id
					};
					jQuery.post(
						ajaxurl,
						data,
						function(response) {
							$( '#' + statusid ).html( response );
							$( '#' + statusid ).fadeIn( 200 );
						}
					);
				}
			}
		);

		if($('#edit_roles_new').length) {
			$( '.toastrole' ).hide();
			$( '.editone_wrapper' ).hide();
			$( '.remove_me_form' ).hide();
			$( '.agenda_note_editable_editone' ).show();
			$( '.agenda_note_editable_editone_wrapper' ).hide();
			$( '.editable_content' ).hide();
		}
		else
			$( '.edit_one_form' ).hide();

		$( '.editonelink' ).on(
			'click',
			function(e){
				suggest_mode = false;
				e.preventDefault();
				var field = $( this ).attr( 'editone' );
				$( '#editone' + field ).show();
				$( '#edito newrapper' + field ).hide();
				$( '#' + field + '_form' ).hide();
				$( '#remove' + field + '_form' ).hide();
			}
		);

		$( '.suggestonelink' ).on(
			'click',
			function(e){
				suggest_mode = true;
				e.preventDefault();
				var field = $( this ).attr( 'editone' );
				$( '#editone' + field ).show();
				$( '#edito newrapper' + field ).hide();
				$( '#' + field + '_form' ).hide();
				$( '#remove' + field + '_form' ).hide();
				$( '.speaker_details_form' ).hide();
				$('#suggest' + field).html('<p>Nominate the member for a role. Send them an email with your note and a one-click signup link.</p><p><textarea name="suggest_note" rows="3" cols="80"></textarea><br />Send to <input type="radio" name="ccme" value="0" checked="checked" /> member <input type="radio" name="ccme" value="1" /> member + copy to me <input type="radio" name="ccme" value="2" /> only to me </p>');
			}
		);

		$( '.agenda_note_editable_editone' ).hide();

		$( '.agenda_note_editable_editone_on' ).on(
			'click',
			function(e){
				e.preventDefault();
				$( '.agenda_note_editable_editone' ).show();
				$( '.agenda_note_editable_editone_wrapper' ).hide();
				$( '.editable_content' ).hide();
			}
		);

		$( '.agenda_note_editable_editone' ).submit(
			function (e) {
				e.preventDefault();
				var data = $(this).serializeArray();
				$(this).html(data[0].value);
				var form = this;
				console.log(data);
				var postdata = {
					agenda_note : data[0].value,
					agenda_note_label : data[1].value,
					post_id : data[2].value,
					timelord: data[3].value,
				};
				$.post(
					wpt_rest.url + 'rsvptm/v1/editable_note_update',
					data,
					function(response) {
						console.log('posting');
						console.log(data);
						$(form).html(data[0].value + response);
						console.log(response);
					}
				);
			}
		);

		$( document ).on(
			'submit',
			'form.edit_one_form',
			function(event) {
				event.preventDefault();
				var conjunction = '?';// (wpt_rest.url.indexOf('?')) ? '&' : '?';
				var action      = wpt_rest.url + 'rsvptm/v1/tm_role' + conjunction + 'tm_ajax=role';
				var formid      = $( this ).attr( 'id' );
				var data        = $( this ).serialize();
				var user_id     = $( '#' + formid + ' .editor_assign' ).val();
				data            = data.concat( '&user_id=' + user_id );
				$( '#' + formid ).html( '<div style="line-height: 3">Saving ...</div>' );
				setTimeout(
					function () {
						$( '#' + formid ).addClass( 'bounce' );
					},
					1000
				);

				jQuery.post(
					action,
					data,
					function(response) {
						$( '#' + formid ).html( response.content );
						 $( '#' + formid ).removeClass( 'bounce' );
						$( '#' + formid ).css( "opacity", '1' );
						$( '#' + formid ).css( "display", 'block' );

						 $( '#' + formid ).addClass( 'grow' );
					}
				);
			}
		);

		$( '.editor_assign' ).select2();

	}
);
