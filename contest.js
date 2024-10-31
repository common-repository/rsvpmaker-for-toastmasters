jQuery( document ).ready(

	function($) {



		$.ajaxSetup(

			{

				headers: {

					'X-WP-Nonce': contest.rest_nonce,

				}

			}

		);



		$( '#showboth' ).click(

			function() {

				if ($( "input#showboth:checked" ).val()) {

					$( '.other' ).show();

				} else {

					$( '.other' ).hide();

				}

			}

		);



		$('.contest_scoring').change(function() { $('#custom_contest').hide(); }) ;



		// hide to start with

		$( '.morejudges' ).hide();



		$( '#showmorejudges' ).click(

			function() {

				if ($( "input#showmorejudges:checked" ).val()) {

					$( '.morejudges' ).show();

				} else {

					$( '.morejudges' ).hide();

				}

			}

		);



		function votingLinkToggle () {

			if ($( "input#showlinks:checked" ).val()) {

				$( '.votinglink' ).show();

			} else {

				$( '.votinglink' ).hide();

			}

		}



		function emailLinksToggle () {

			if ($( "input#show_email_links:checked" ).val()) {

				$( '.email_links' ).show();

			} else {

				$( '.email_links' ).hide();

			}

		}



		function votingFormsToggle () {

			if ($( "input#showvotingforms:checked" ).val()) {

				$( '.votingforms' ).show();

			} else {

				$( '.votingforms' ).hide();

			}

		}



		var activetab = $( 'a.nav-tab-active' ).attr( 'href' );

		if (activetab) {

			$( 'section' ).hide();

			$( 'section' + activetab ).show();

		}



		$( document ).on(

			'click',

			'.nav-tab-wrapper a',

			function() {

				$( 'section' ).hide();

				$( 'a' ).removeClass( 'nav-tab-active' );

				$( 'section' ).eq( $( this ).index() ).show();

				$( this ).addClass( 'nav-tab-active' );

				return false;

			}

		);



		// check initial state of voting links

		votingLinkToggle();

		$( "input#showlinks" ).on( "click", votingLinkToggle );

		

		$('#multicontest').click(

			function() {

				$('#morecontests').show();

			}

		);



		votingFormsToggle();

		$( "input#showvotingforms" ).on( "click", votingFormsToggle );



		emailLinksToggle();

		$( "input#show_email_links" ).on( "click", emailLinksToggle );



		function refreshScores(now = false) {

			if (now || (countdown == 0)) {

				$( '#score_status' ).html( 'Checking for new scores ...' );

				console.log( 'checking for scores' );

				$.get(

					contest.votecheck,

					function( data ) {

						$( "#scores" ).html( data );

						$( '#score_status' ).html( 'Updated' );

					}

				);

				countdown = 30;

			} else {

				$( '#score_status' ).html( 'Checking in ' + countdown );

				countdown--;

			}



		}

		$( '#scoreupdate' ).click(

			function() {

				refreshScores();

			}

		);



		if (contest.scoring == 'voting') {



			$( '#autorank_now' ).click(

				function() {

					var autorank = '';

					scoreArr.sort( function (a, b) {return b.score - a.score} );



					var arrayLength = scoreArr.length;

					for (var i = 0; i < arrayLength; i++) {

						var name = $( '#contestant' + scoreArr[i].index ).val();

						autorank = autorank + '<br />' + name + ' ' + scoreArr[i].score;

					}

					$( '#autorank' ).html( '<div style="width: 300px; margin-bottom: 10px; padding: 5px; border: thin solid #555;"><h3>Best Scores</h3>' + autorank + '</div>' );

					$( '#nowvote' ).html( '<h3 style="color: red;">Now Vote! <span style="color: black">Your vote is not complete</span> until you make your selections below.</h3>' );

					var votingform   = document.getElementById( "voting" );

					votingform.style = 'border: thick solid red; padding: 10px; padding-bottom: 50px;';

					votingform.scrollIntoView();

				}

			);



				var max;

				var this_score;

				var indexmatch;



				$( '.score' ).on(

					'change',

					function(){

						var contestant = $( this ).attr( 'contestant' );

						var score      = 0;

						$( '.score' + contestant ).each(

							function() {

								max        = Number( $( this ).attr( 'max' ) );

								this_score = Number( $( this ).val() );

								if (this_score > max) {

									this_score = max;

									$( this ).val( this_score );

								}

								score += this_score;

							}

						);

						$( '#sum' + contestant ).html( score );

						

						indexmatch = scoreArr.findIndex( (element) => {

							console.log('contestant' + contestant);

							console.log(element);

							return element.index == contestant

						} );

						console.log('indexmatch '+indexmatch);

						if(indexmatch >= 0)

							scoreArr[indexmatch].score = score;

						else if (score) {

							scoreArr.push({

								'index' : contestant,

								'score' : score

							});	

						}

						console.log('initial');

						console.log(scoreArr);

						sortTally(scoreArr);

					}

				);



function sortTally(scoreArr) {

	scoreArr.sort((a, b) => (a.score < b.score) ? 1 : -1);

	let done = true;

	var autorank = '';



	var arrayLength = scoreArr.length;

	for (var i = 0; i < arrayLength; i++) {

		var name = $( '#contestant' + scoreArr[i].index ).val();

		autorank = autorank + '<br />' + name + ' ' + scoreArr[i].score;

		if(0 == scoreArr[i].score)

			done = false;

	}

	if(done)

		autorank = autorank + '<br /><strong>When you are done, vote</strong>';

	$( '#autorank' ).html( '<div style="width: 300px; margin-bottom: 10px; padding: 5px; border: thin solid #555;"><h3>Best Scores</h3>' + autorank + '</div>' );

}



				let findDuplicates = arr => arr.filter( (item, index) => arr.indexOf( item ) != index );



				$( 'form#voting' ).submit(

					function(){

						var empty      = false;

						var votes      = $( '.voteselect' );

						var checkvotes = [];

						votes.each(

							function() {

								checkvotes.push( $( this ).val() );

								if ($( this ).val() == '') {

									empty = true;

								}



							}

						);

						if (empty) {

							$( "#readyprompt" ).html( '<span style="color: red;">One or more votes left blank</span>' );

							return false;

						}



						if ( $( '#signature' ).val() == '') {

							$( "#readyprompt" ).html( '<span style="color: red;">You must complete your signature before you are allowed to vote</span>' );

							return false;

						}



						let findDuplicates = arr => arr.filter( (item, index) => arr.indexOf( item ) != index );

						let dups           = findDuplicates( checkvotes );

						if (dups.length) {

							$( "#readyprompt" ).html( '<span style="color: red;">You cannot vote for the same contestant twice.</span>' );

							return false;

						}

					}

				);

		}



		/*

		if((contest.scoring == 'dashboard') && scoreArr.length) //starts once speaking order is set

		{

		console.log('start checking for scores');

		setInterval(function(){

		refreshScores();

		}, 50000);

		}

		*/



		var checkvoteinterval;

		var countdown = 30;



		$( '#votecheck' ).click(

			function () {

				var label = $( '#votecheck' ).text();

				console.log( label + ' checking for scores' );

				if (label == 'Start') {

					refreshScores(true);

					checkvoteinterval = setInterval(

						function(){

							refreshScores();

						},

						1000

					);

					$( '#votecheck' ).text( 'Stop' );

				} else {

					clearInterval( checkvoteinterval );

					$( '#votecheck' ).text( 'Start' );

				}

			}

		);



		$( '#track_role' ).on(

			'change',

			function(){

				var role = $( this ).val();

				if (role == '') {

					$( '#role_track_status' ).html( '' );

					$( '#manual_contestants' ).show();

				} else {

					$( '#role_track_status' ).html( '<p>Contestant names will be pulled from the ' + role + ' role on the agenda</p>' );

					$( '#manual_contestants' ).hide();

				}

			}

		);



		$( '.send_contest_link' ).click(

			function (e) {

				e.preventDefault();

				let id     = $( this ).attr( 'id' );

				let action = $('#send_link_action' ).val();

				console.log(action);

				let data   = {

					email : $( '#email_link' + id ).val(),

					note : $( '#intro_note' ).val() + "\n\n" + $( '#email_link_note' + id ).val(),

					subject : $( '#email_subject' + id ).val(),

					code: id,

					post_id: contest.post_id,

				}

				console.log(data);

				$( '#send_link_status' + id ).text( 'Sending ...' );

				jQuery.post(

					action,

					data,

					function(response) {

						// data = JSON.parse(response);

						if (response.subject) {

							$( '#send_link_status' + id ).text( 'Sent: ' + response.subject );

						}

					}

				);

			}

		);



		$( '.show_ballot_links_preview' ).click(

			function(e) {

				e.preventDefault();

				$( '.ballot_links_preview' ).show();

				let id      = $( this ).attr( 'id' ).replace( 'p','' );

				var email   = $( '#email_link' + id ).val();

				var subject = $( '#email_subject' + id ).val();

				$( '#send_link_status' + id ).html( 'To email manually, click <a target="_blank" href="mailto:' + email + '?subject=' + subject + '">' + email + ' ' + subject + '</a>' );

			}

		);



		$( 'form#custom_contest' ).submit(

			function(){

				var score = 0;

				$( '.setscore' ).each(

					function() {

						score += Number( $( this ).val() );

					}

				);

				if (score != 100) {

					$( '#readyprompt' ).html( '<span style="color: red;">Scores total ' + score + ' (must total 100)</span>' );

					return false;

				} else {

					$( '#readyprompt' ).html( 'Saving ...' );

				}

			}

		);


		var check_seconds = 5;

		// END sequence runs on ballot after vote submitted



		if (contest.scoring == 'shuffle') {

			var hasrun = false;



			var ShuffleText = (function () {

				/**

				 * Constructor.

				 *

				 * @param element DOMã‚¨ãƒ¬ãƒ¡ãƒ³ãƒˆ

				 */

				function ShuffleText(element) {

					/**

					 * The string for random text.

					 * ãƒ©ãƒ³ãƒ€ãƒ ãƒ†ã‚­ã‚¹ãƒˆã«ç”¨ã„ã‚‹æ–‡å­—åˆ—ã§ã™ã€‚

				 *

					 * @type {string}

					 * @default 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'

					 */

					this.sourceRandomCharacter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

					/**

					 * The string for effect space.

					 * ç©ºç™½ã«ç”¨ã„ã‚‹æ–‡å­—åˆ—ã§ã™ã€‚

				 *

					 * @type {string}

					 * @default '-'

					 */

					this.emptyCharacter = '-';

					/**

					 * The milli seconds of effect time.

					 * ã‚¨ãƒ•ã‚§ã‚¯ãƒˆã®å®Ÿè¡Œæ™‚é–“ã§ã™ã€‚

				 *

					 * @type {number}

					 * @default 600

					 */

					this.duration                 = 600;

					this._isRunning               = false;

					this._originalStr             = '';

					this._originalLength          = 0;

					this._timeCurrent             = 0;

					this._timeStart               = 0;

					this._randomIndex             = [];

					this._requestAnimationFrameId = 0;

					this._element                 = element;

					this.setText( element.innerHTML );

				}

				/** ãƒ†ã‚­ã‚¹ãƒˆã‚’è¨­å®šã—ã¾ã™ã€‚ */

				ShuffleText.prototype.setText = function (text) {

					this._originalStr    = text;

					this._originalLength = text.length;

				};

				Object.defineProperty(

					ShuffleText.prototype,

					"isRunning",

					{

						/**

						 * It is running flag. å†ç”Ÿä¸­ã‹ã©ã†ã‹ã‚’ç¤ºã™ãƒ–ãƒ¼ãƒ«å€¤ã§ã™ã€‚

						 *

						 * @returns {boolean}

						 */

						get: function () {

							return this.isRunning;

						},

						enumerable: true,

						configurable: true

					}

				);

				/** å†ç”Ÿã‚’é–‹å§‹ã—ã¾ã™ã€‚ */

				ShuffleText.prototype.start = function () {

					if (hasrun) {

						return;

					}

					var _this = this;

					this.stop();

					this._randomIndex = [];

					var str           = '';

					for (var i = 0; i < this._originalLength; i++) {

						var rate             = i / this._originalLength;

						this._randomIndex[i] = Math.random() * (1 - rate) + rate;

						str                 += this.emptyCharacter;

					}

					this._timeStart               = new Date().getTime();

					this._isRunning               = true;

					this._requestAnimationFrameId = requestAnimationFrame(

						function () {

							_this._onInterval();

						}

					);

					this._element.innerHTML       = str;

				};

				/** åœæ­¢ã—ã¾ã™ã€‚ */

				ShuffleText.prototype.stop    = function () {

					this._isRunning = false;

					cancelAnimationFrame( this._requestAnimationFrameId );

				};

				ShuffleText.prototype.dispose = function () {

					this.sourceRandomCharacter    = null;

					this.emptyCharacter           = null;

					this._isRunning               = false;

					this.duration                 = 0;

					this._originalStr             = null;

					this._originalLength          = 0;

					this._timeCurrent             = 0;

					this._timeStart               = 0;

					this._randomIndex             = null;

					this._element                 = null;

					this._requestAnimationFrameId = 0;

				};

				/**

				 * ã‚¤ãƒ³ã‚¿ãƒ¼ãƒãƒ«ãƒãƒ³ãƒ‰ãƒ©ãƒ¼ã§ã™ã€‚

				 *

				 * @private

				 */

				ShuffleText.prototype._onInterval = function () {

					var _this         = this;

					this._timeCurrent = new Date().getTime() - this._timeStart;

					var percent       = this._timeCurrent / this.duration;

					var str           = '';

					for (var i = 0; i < this._originalLength; i++) {

						if (percent >= this._randomIndex[i]) {

							str += this._originalStr.charAt( i );

						} else if (percent < this._randomIndex[i] / 3) {

							str += this.emptyCharacter;

						} else {

							str += this.sourceRandomCharacter.charAt( Math.floor( Math.random() * (this.sourceRandomCharacter.length) ) );

						}

					}

					if (percent > 1) {

						str             = this._originalStr;

						this._isRunning = false;

					}

					this._element.innerHTML = str;

					if (this._isRunning === true) {

						this._requestAnimationFrameId = requestAnimationFrame(

							function () {

								_this._onInterval();

							}

						);

					}

				};

				return ShuffleText;

			}());



			function shuffle_init() {

				var arr = [];

				for (var i = 0; i < 20; i++) {

					var line = document.querySelector( '#text' + i );

					if ( ! line) {

						break;

					}

					arr[i] = new ShuffleText( line );

				}



				for (var i = 0; i < arr.length; i++) {

					$( '#text' + i )

					.data( 'index', i )

					.hover(

						function () {

							arr[$( this ).data( 'index' )].start();

						},

						function () {

							arr[$( this ).data( 'index' )].start();

						}

					);

					arr[i].start();

				}

				hasrun = true;

			}



			shuffle_init();

		}



	}

);



