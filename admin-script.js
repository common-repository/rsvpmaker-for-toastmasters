(function($) {
	$.ajaxSetup(
		{
			headers: {
				'X-WP-Nonce': wpt_rest.nonce,
			}
		}
	);
	$( '.editvoid' ).click(
		function() {
			let x = $( this ).val();
			if (x == 'edit') {
				let name      = $( this ).attr( 'name' );
				let member_id = $( this ).attr( 'member_id' );
				var key       = $( '#tipaymentkey' ).val();
				$( '#editline' + member_id ).html( '<input type="hidden" name="markpaid[' + member_id + ']" value="1" />Paid until <input type="text" name="until[' + member_id + ']" value="' + $( this ).attr( 'until' ) + '" /> Paid to TI <input type="text" name="' + key + '[' + member_id + ']" value="' + $( this ).attr( 'paid_to_ti' ) + '" />' );
			}
		}
	);

	$( 'form.member_dues_update' ).submit(
		function (e) {
			e.preventDefault();
			// This does the ajax request
			data = $( this ).serialize();
			$.ajax(
				{
					url: wpt_rest.url + 'rsvptm/v1/dues',
					method: 'POST',
					data: data,
					success:function(data) {
						console.log( data );
						let message = '';
						if (data.marked_paid) {
							message += data.marked_paid + ' ';
						}
						if (data.paid_ti) {
							message += data.paid_ti + ' ';
						}
						if (data.no_renewal) {
							message += data.no_renewal + ' ';
						}
						if (data.note) {
							message += data.note + ' ';
						}

						$( '#confirm' + data.member_id ).html( message );
						$( '#data-entry-' + data.member_id ).hide();
						$( '#paid-ti-' + data.member_id ).hide();
						$( '#member_dues_update_' + data.member_id + ' .enter_notes' ).hide();
					},
					error: function(errorThrown){
						console.log( errorThrown );
					}
				}
			);
			return false;
		}
	);

	$( '#default_css' ).hide();

	$( "#default_css_show" ).click(
		function(){
			$( '#default_css' ).show();
			$( "#default_css_show" ).hide();
		}
	);

	$( '.speech_update' ).hide();

	$('a.nav-tab-active').click( function() {
		var activetab = $( 'a.nav-tab-active' ).attr( 'href' );
		if (activetab) {
			$( '.toastmasters section' ).hide();
			if (activetab == '#pathways') {
				let user_id = $( '#toastmaster_select' ).val();
				wpt_fetch_report( 'pathways',user_id );
			}
		}	
	});

	$( document ).on(
		'click',
		'.remove_meta_speech',
		function() {
			var user_id = $( this ).attr( 'user_id' );
			var project = $( this ).attr( 'project' );
			$.ajax(
				{
					url: rsvpmaker_rest.ajaxurl,
					method: 'POST',
					data: {
						'action':'remove_meta_speech',
						'project': project,
						'timelord': rsvpmaker_rest.timelord,
						'user_id': user_id
					},
					success:function(data) {
						// This outputs the result of the ajax request
						console.log( data );
						alert( 'Remove ' + project + ' for user id: ' + user_id );
						location.reload( true );
					},
					error: function(errorThrown){
						console.log( errorThrown );
					}
				}
			);
			return false;
		}
	);

	$( document ).on(
		'change',
		'#tm_select_member select',
		function() {
			var user_id    = $( '#tm_select_member select' ).val();
			var member_url = location.href;
			var urlparts   = member_url.split( '&toastmaster' );
			var member_url = urlparts[0] + '&toastmaster=' + user_id + '&active=' + tab;
			location.href  = member_url;
		}
	);

	$( document ).on(
		'change',
		'#pick_event',
		function() {
			var post_id    = $( '#pick_event' ).val();
			var event_url  = location.href;
			var urlparts   = event_url.split( '&post_id' );
			var member_url = urlparts[0] + '&post_id=' + post_id;
			location.href  = member_url;
		}
	);

	var add_speech_blank = $( 'form#add_speech_form' ).html();

	$( 'form#add_speech_form' ).submit(
		function(e) {
			e.preventDefault();
			// This does the ajax request

			$.ajax(
				{
					url: rsvpmaker_rest.ajaxurl,
					method: 'POST',
					data: {
						'action':'add_speech',
						'_manual_meta': $( '#_manual_' ).val(),
						'_project_meta': $( '#_project_' ).val(),
						'_title_meta': $( '#title_text' ).val(),
						'_intro_meta': $( '#_intro_' ).val(),
						'project_year': $( '#project_year_add' ).val(),
						'project_month': $( '#project_month_add' ).val(),
						'project_day': $( '#project_day_add' ).val(),
						'timelord': rsvpmaker_rest.timelord,
						'user_id': $( '#member' ).val()
					},
					success:function(data) {
						// This outputs the result of the ajax request
						$( '#add_speech_status' ).html( data );
						$( '#add_speech_status' ).fadeIn( 200 );
						console.log( data );
						$( 'form#add_speech_form' ).html( add_speech_blank );
					},
					error: function(errorThrown){
						console.log( errorThrown );
					}
				}
			);
			return false;
		}
	);

	$( 'form#add_role_form' ).submit(
		function(e) {
			e.preventDefault();
			// This does the ajax request

			$.ajax(
				{
					url: rsvpmaker_rest.ajaxurl,
					method: 'POST',
					data: {
						'action':'add_speech',
						'_role_meta': $( '#_role_meta' ).val(),
						'project_year': $( '#role_year_add' ).val(),
						'project_month': $( '#role_month_add' ).val(),
						'project_day': $( '#role_day_add' ).val(),
						'timelord': rsvpmaker_rest.timelord,
						'user_id': $( '#member' ).val()
					},
					success:function(data) {
						// This outputs the result of the ajax request
						$( '#add_role_status' ).html( data );
						$( '#add_role_status' ).fadeIn( 200 );
						console.log( data );
					},
					error: function(errorThrown){
						console.log( errorThrown );
					}
				}
			);
			return false;
		}
	);

	$( 'form#edit_member_stats' ).submit(
		function(e) {
			e.preventDefault();
			// This does the ajax request

			$.ajax(
				{
					url: rsvpmaker_rest.ajaxurl,
					method: 'POST',
					data: $( this ).serialize(),
					success:function(data) {
						// This outputs the result of the ajax request
						console.log( data );
						alert( 'Saved (reload to see changes on reports)' );
					},
					error: function(errorThrown){
						console.log( errorThrown );
					}
				}
			);
			return false;
		}
	);

	$( '.increment_stat' ).click(
		function() {
			var user_id = $( this ).attr( 'user_id' );
			var role    = $( this ).attr( 'role' );
			var counter = $( this ).attr( 'counter' );

			$.ajax(
				{
					url: rsvpmaker_rest.ajaxurl,
					method: 'POST',
					data: {
						'action':'increment_stat',
						'role': role,
						'timelord': rsvpmaker_rest.timelord,
						'user_id': user_id
					},
					success:function(data) {
						// This outputs the result of the ajax request
						console.log( data );
						// alert(data);
						$( '#increment_stat_result' + counter ).html( data );
					},
					error: function(errorThrown){
						console.log( errorThrown );
					}
				}
			);

			return false;
		}
	);

	$( '#add_speech_form' ).on(
		"change",
		".manual",
		function() {
			var manual = this.value;
			var target = this.id.replace( 'manual','project' );
			var list   = project_list.projects[manual];
			$( '#' + target ).html( '<option value="">Pick a Project</option>' + list );
		}
	);

	$( "#checkAllDelete" ).click(
		function(){
			$( '#deleterecords input:checkbox' ).not( this ).prop( 'checked', this.checked );
		}
	);

	$( document ).on(
		'click',
		'div.wptoast-notice button.notice-dismiss',
		function () {
			var type = $( this ).closest( '.wptoast-notice' ).data( 'notice' );
			console.log( 'notice dismiss: ' + type );
			$.ajax(
				rsvpmaker_rest.ajaxurl,
				{
					type: 'POST',
					data: {
						action: 'wptoast_dismissed_notice_handler',
						'timelord': rsvpmaker_rest.timelord,
						type: type,
					}
				}
			);
		}
	);

	$( ".roleplanupdate" ).click(
		function( event ) {
			event.preventDefault();
			var datepost     = $( this ).attr( 'datepost' );
			var takerole     = $( '#takerole' + datepost + ' option:checked' ).val();
			var was          = $( '#was' + datepost ).val();
			var user_id      = $( '#user_id' ).val();
			var manual       = '';
			var project      = '';
			var title        = '';
			var display_time = '';
			var maxtime      = '';
			var intro        = '';
			if (takerole.search( 'Speaker' ) > -1) {
				manual       = $( '#_manual__Speaker_' + datepost ).val();
				project      = $( '#_project__Speaker_' + datepost ).val();
				title        = $( '#title_text_Speaker_' + datepost ).val();
				intro        = $( '#_intro__Speaker_' + datepost ).val();
				display_time = $( '#_display_time__Speaker_' + datepost ).val();
				maxtime      = $( '#_maxtime__Speaker_' + datepost ).val();
				console.log( manual + ' ' + project + ' ' + title + ' ' + intro + ' ' + display_time + ' ' + maxtime );
			}
			$.ajax(
				rsvpmaker_rest.ajaxurl,
				{
					type: 'POST',
					data: {
						action: 'wptoast_role_planner_update',
						datepost: datepost,
						takerole: takerole,
						was: was,
						user_id: user_id,
						manual: manual,
						project: project,
						title: title,
						intro: intro,
						display_time: display_time,
						'timelord': rsvpmaker_rest.timelord,
						maxtime: maxtime,
					}
				}
			)
			.done(
				function( data ) {
					$( '#change' + datepost ).html( data );
					$( '#was' + datepost ).val( takerole );
					$( '#takerolespeaker' + datepost ).hide();
				}
			);
		}
	);
	$( ".takerole_speaker" ).hide();
	$( ".takerole" ).change(
		function(  ) {
			var role     = $( this ).val();
			var datepost = $( this ).attr( 'post_id' );
			if (role.search( 'Speaker' ) > -1) {
				$( '#takerolespeaker' + datepost ).show();
			} else {
				$( '#takerolespeaker' + datepost ).hide();
			}

		}
	);

	$( '.dashdate' ).mouseover(
		function () {
			var dateid = $( this ).attr( 'id' );
			$( '#' + dateid + ' .has-sub li' ).show();
		}
	);
	$( '.dashdate' ).mouseout(
		function () {
			var dateid = $( this ).attr( 'id' );
			$( '#' + dateid + ' .has-sub li' ).hide();
		}
	);

	$( "#show_speeches_by_manual" ).click(
		function () {
			let user_id = $( '#toastmaster_select' ).val();
			wpt_fetch_report( 'speeches_by_manual',user_id );
		}
	);

	$( "#show_traditional_program" ).click(
		function () {
			let user_id = $( '#toastmaster_select' ).val();
			wpt_fetch_report( 'traditional_program',user_id );
		}
	);

	$( "#show_traditional_advanced" ).click(
		function () {
			let user_id = $( '#toastmaster_select' ).val();
			wpt_fetch_report( 'traditional_advanced',user_id );
		}
	);

	$( "#show_pathways" ).click(
		function () {
			let user_id = $( '#toastmaster_select' ).val();
			wpt_fetch_report( 'pathways',user_id );
		}
	);

	function wpt_fetch_report(report, user_id) {
		let fetchurl = wpt_rest.url + 'rsvptm/v1/reports/' + report + '/' + user_id;
		$( '#' + report + '_content' ).html( 'Loading from ' + fetchurl + ' ...' );
		fetch( fetchurl, {headers: {'X-WP-Nonce' : wpt_rest.nonce}} )
		.then( response => response.json() )
		.then( data => $( '#' + report + '_content' ).html( data.content ) );
	}

	$( '#ti-transactions-refresh, #ti-transactions-tab' ).click(
		function () {
			let fetchurl = wpt_rest.url + 'rsvptm/v1/money';
			$( '#ti-transactions-content' ).html( 'Loading from ' + fetchurl + ' ...' );
			fetch( fetchurl, {headers: {'X-WP-Nonce' : wpt_rest.nonce}} )
			.then( response => response.json() )
			.then( data => {$( '#ti-transactions-content' ).html( data.content ), $( '#dues-report-export' ).text( data.export ), $( '#dues-report-export' ).select()} );
			// .then(data => $('#dues-report-export').text(data.export) );
		}
	);

	$( '#reminder-thank-you-refresh, #reminder-thank-you-tab' ).click(
		function () {
			let fetchurl = wpt_rest.url + 'rsvptm/v1/duesreminders';
			$( '#reminder-thank-you-content' ).html( 'Loading from ' + fetchurl + ' ...' );
			fetch( fetchurl, {headers: {'X-WP-Nonce' : wpt_rest.nonce}} )
			.then( response => response.json() )
			.then( data => $( '#reminder-thank-you-content' ).html( data.content ) );
		}
	);

	$( '#second_language_checkbox' ).click(
		function () {
			var count = parseInt($( '#second_language_checkbox' ).val());
			var prompt;
			var prompts;
			count++;
			prompt = 'Pace: not too fast or too slow';
			prompts = '<p><strong>'+prompt+'</strong><input type="hidden" name="prompt['+count+']" value="'+prompt+'"></p>'
			+'<p><input type="radio" name="check['+count+']" value="5 (Exemplary)"> 5 (Exemplary) <input type="radio" name="check['+count+']" value="4 (Excels)"> 4 (Excels) <input type="radio" name="check['+count+']" value="3 (Accomplished)"> 3 (Accomplished) <input type="radio" name="check['+count+']" value="2 (Emerging)"> 2 (Emerging) <input type="radio" name="check['+count+']" value="1 (Developing)"> 1 (Developing) </p>'
			+'<p><textarea name="comment['+count+']" style="width: 100%; height: 3em;"></textarea></p>';

			count++;
			prompt = 'Grammar and word usage';
			prompts += '<p><strong>'+prompt+'</strong><input type="hidden" name="prompt['+count+']" value="'+prompt+'"></p>'
			+'<p><input type="radio" name="check['+count+']" value="5 (Exemplary)"> 5 (Exemplary) <input type="radio" name="check['+count+']" value="4 (Excels)"> 4 (Excels) <input type="radio" name="check['+count+']" value="3 (Accomplished)"> 3 (Accomplished) <input type="radio" name="check['+count+']" value="2 (Emerging)"> 2 (Emerging) <input type="radio" name="check['+count+']" value="1 (Developing)"> 1 (Developing) </p>'
			+'<p><textarea name="comment['+count+']" style="width: 100%; height: 3em;"></textarea></p>';

			count++;
			prompt = 'Word tense, gender, and pronouns';
			prompts += '<p><strong>'+prompt+'</strong><input type="hidden" name="prompt['+count+']" value="'+prompt+'"></p>'
			+'<p><input type="radio" name="check['+count+']" value="5 (Exemplary)"> 5 (Exemplary) <input type="radio" name="check['+count+']" value="4 (Excels)"> 4 (Excels) <input type="radio" name="check['+count+']" value="3 (Accomplished)"> 3 (Accomplished) <input type="radio" name="check['+count+']" value="2 (Emerging)"> 2 (Emerging) <input type="radio" name="check['+count+']" value="1 (Developing)"> 1 (Developing) </p>'
			+'<p><textarea name="comment['+count+']" style="width: 100%; height: 3em;"></textarea></p>';

			count++;
			prompt = 'Clear pronunciation';
			prompts += '<p><strong>'+prompt+'</strong><input type="hidden" name="prompt['+count+']" value="'+prompt+'"></p>'
			+'<p><input type="radio" name="check['+count+']" value="5 (Exemplary)"> 5 (Exemplary) <input type="radio" name="check['+count+']" value="4 (Excels)"> 4 (Excels) <input type="radio" name="check['+count+']" value="3 (Accomplished)"> 3 (Accomplished) <input type="radio" name="check['+count+']" value="2 (Emerging)"> 2 (Emerging) <input type="radio" name="check['+count+']" value="1 (Developing)"> 1 (Developing) </p>'
			+'<p><textarea name="comment['+count+']" style="width: 100%; height: 3em;"></textarea></p>';

			$('#second_language').html(prompts);
		}
	);


})( jQuery );
