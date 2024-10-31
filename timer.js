$( document ).ready(

	function () {

		var greenchime  = true;

		var yellowchime = true;

		var redchime    = true;

		var colorWin;

		var colorWinOpened = false;

		var colorNow       = 'default';

		var gotvotetimer;

		var timer;

		var speeches   = [];

		var timeNow    = 0;

		var correction = 0;

		var lastdata;

		var lastupdate     = 0;

		var checktimer     = 15;

		var instructionsOn = true;

		var greenimg       = '';

		var yellowimg      = '';

		var redimg         = '';

		var defaultcolor   = '#000000';



		function timeoutCheck() {

			var beenwaiting = new Date().getTime();

			var diff        = beenwaiting - lastupdate;

			console.log( 'beenwaiting ' + beenwaiting + ' - lastupdate ' + lastupdate + ' = ' + diff );

			if (lastupdate) {

				if (diff > 1200000) { // 1200000 = 20 minutes

					$( '#checkstatus' ).html( 'Timed out. Click <strong>Check Now</strong> to restart' );

					return true;

				}

			}

			return false;

		}



		function isTimerView() {

			var view = $( '#view' ).children( "option:selected" ).val();

			return (view == 'timer');

		}



		function sendTimerSignal(signal) {

			var view = $( '#view' ).children( "option:selected" ).val();

			if (view != 'timer') {

				return;

			}

			var url = jQuery( '#seturl' ).val();

			console.log( 'send signal to ' + url );

			console.log( signal );

			jQuery.post( url, signal );

		}



		// timer send

		function colorChange(colorNow) {

			var view = $( '#view' ).children( "option:selected" ).val();

			setBackgroundColor( colorNow );

		}



		function setBackgroundColor(color) {

			var colorCode = $( 'body' ).css( 'background-color' );

			var colorLabel;

			var colorImage;

			if (color == 'green') {

				colorCode  = '#A7DA7E';

				colorLabel = 'Green';

				colorImage = (greenimg) ? 'url(' + greenimg + ')' : 'none';

			} else if (color == 'yellow') {

				colorCode  = '#FCDC3B';

				colorLabel = 'Yellow';

				colorImage = (yellowimg) ? 'url(' + yellowimg + ')' : 'none';

			} else if (color == 'red') {

				colorCode  = '#FF4040';

				colorLabel = 'Red';

				colorImage = (redimg) ? 'url(' + redimg + ')' : 'none';

			} else if (color == 'start') {

				colorLabel = $( '#green-light' ).val().replace( ':00','' ) + ' - ' + $( '#red-light' ).val().replace( ':00','' );

				colorCode  = defaultcolor;

				colorImage = 'none';

			} else {

				colorCode  = defaultcolor;

				colorLabel = 'Ready';

				colorImage = 'none';

			}



			$( 'body' ).css( 'background-color', colorCode );

			$( '#jitsi' ).css( 'background-image', colorImage );

			hideInstructions();

			$( '#timer2021' ).text( colorLabel );

			if (colorWin) {

				colorWin.document.body.style.backgroundColor               = colorCode;

				colorWin.document.body.style.backgroundImage               = colorImage;

				colorWin.document.getElementById( 'popuplabel' ).innerHTML = colorLabel;

			}

		}



		$( '.background-image-picker' ).change(

			function() {

				let id    = $( this ).attr( 'id' );

				let color = id.replace( 'bg-','' );

				if (color == 'default') {

					defaultcolor = $( this ).val();

				} else if (color == 'green') {

					greenimg = $( this ).val();

				} else if (color == 'yellow') {

					yellowimg = $( this ).val();

				} else if (color == 'red') {

					redimg = $( this ).val();

				}

				setBackgroundColor( color );

			}

		);



		function audienceStartTimer(data) {

			$( '#green-light' ).val( data.green );

			$( '#yellow-light' ).val( data.yellow );

			$( '#red-light' ).val( data.red );

			var ts = Date.parse( data.start );

			timer  = new TSTimer( speeches );

			timer.start();

			console.log( 'timer from server ' + data.start );

			console.log( 'start now set to ' + timer.startTime.toTimeString() );

			correction = Math.round( (timer.startTime.getTime() - ts) / 1000 );

			console.log( 'local correction ' + correction );

			if (data.correction) {

				correction += parseInt( data.correction );

				console.log( 'remote correction ' + data.correction );

			}

			console.log( 'correction ' + correction );

			$( '#checkstatus' ).text( 'Timer started with ' + correction + ' second adjustment' );

		}



		// audience check

		function checkColorChange() {

			if (timeoutCheck()) {

				stopRefreshReceived();

				return;

			}

			console.log( 'check ' + checktimer );

			var statuslabel = (timer && timer.started) ? 'Timing ... ' : 'Waiting ... ';

			if (checktimer) {

				$( '#checkstatus' ).html( statuslabel + '<br />Polling server in ' + checktimer + ' seconds' );

				checktimer--;

				return;

			}

			checktimer = 15;

			$( 'checkstatus' ).html( statuslabel + '<br />Checking server for updates' );

			var url = jQuery( '#seturl' ).val();

			$.get(

				url,

				function( data ) {

					if ( ! lastdata || (data.status == 'keepalive') || (lastdata.status && (lastdata.status != data.status)) ) {

						lastupdate = new Date().getTime();

					}

					// console.log(data);

					if (data.status && ((data.status == 'start') || (data.status == 'keepalive')) ) {

						if (timer && timer.started) {

							console.log( 'timer already started' );

							if (lastdata.green) {

								if ((data.green != lastdata.green) || (data.yellow != lastdata.yellow) || (data.red != lastdata.red) || (data.correction != lastdata.correction) ) {

									audienceStartTimer( data );

									// adjust as necessary

									console.log( 'data CHANGED' );

									console.log( data );

									lastdata   = data;

									lastupdate = new Date().getTime();

								} else {

									console.log( 'data unchanged' );

								}

							}

						} else {

							console.log( 'start timer' );

							colorChange( 'start' );

							audienceStartTimer( data );

							lastdata = data;

						}

					} else if (data.status && (data.status == 'stop')) {

						if (timer && timer.started) {

							timer.resetButton();

						}

						console.log( 'Timer reset' );

					}

				}

			);

		}



		$( "#clearlog" ).click(

			function() {

				$( '#logentries' ).html( '' );

			}

		);



		function refreshView() {

			 var view = $( '#view' ).children( "option:selected" ).val();

			 console.log( 'switch view: ' + view );

			if (view == 'normal') {

				if (timer && timer.started) {

					window.location.replace( window.location.href );

				}

				$( '#smallcounter' ).html( '' );

				$( '#logentries' ).html( '' );

				$( 'iframe' ).css( "height", window.innerHeight - 50 );

				$( 'iframe' ).css( "width", window.innerWidth - 100 );

				$( '.timer-controls' ).hide();

				$( '#checkcontrols' ).show();

				checkColorChange(); // check now

				gotvotetimer = setInterval(

					function(){

						checkColorChange();

					},

					15000

				);

				$( '#checkstatus' ).html( 'Click <strong>Check Now</strong> to start checking for Timer updates' );

				if (timer) {

					timer.resetButton();

				}

			} else {

				$( '#explanation' ).hide();

				$( '#checkcontrols' ).hide();

				$( 'iframe' ).css( "height", window.innerHeight - 50 );

				$( 'iframe' ).css( "width", window.innerWidth - 100 );

				$( '.timer-controls' ).show();

				if (gotvotetimer) {

					stopRefreshReceived();

				}

			}

			if (timer) {

				timer.stop();

			}

		}



		function stopRefreshReceived() {

			clearInterval( gotvotetimer );

		}



		refreshView(); // initial load

		$( '#view' ).change( refreshView );



		$( '#popup' ).click(

			function(){

				if (colorWin) {

					colorWin.focus();

				} else {

					colorWin = window.open( "about:blank", "Color Light", "width=800,height=600,top=50,left=400" );

					colorWin.document.write( "<body><h1 id=\"popuplabel\" style=\"font-size: 10vw; position: absolute; right: 2vw; top: 2vw; width: 50vw;\">Ready</h1></body>" );

					colorWin.document.body.style.backgroundColor                           = '#000';

					colorWin.document.body.style.backgroundSize                            = 'contain';

					colorWin.document.body.style.backgroundRepeat                          = 'no-repeat';

					colorWin.document.body.style.padding                                   = '0';

					colorWin.document.getElementById( 'popuplabel' ).style.margin          = '0';

					colorWin.document.getElementById( 'popuplabel' ).style.backgroundColor = 'rgba(255,255, 255, 0.8)';

					colorWin.document.getElementById( 'popuplabel' ).style.borderRadius    = '25px';

					colorWin.document.getElementById( 'popuplabel' ).style.textAlign       = 'center';

					colorWin.document.title = 'Popup Timing Light';

					setBackgroundColor( colorNow );

					colorWin.addEventListener( "unload", function(event) { colorWin = undefined } );

				}

				return false;

			}

		);



		$( '#timerpopup' ).click(

			function(){

				if (typeof timerWin !== 'undefined') {

					timerWin.focus();

				} else {

					timerWin = window.open( "about:blank", "Timer", "width=200,height=200,top=300,left=0" );

					timerWin.document.write( "<body><p><button class=\"btn-primary btnStart\" type=\"button\" value=\"Start\">Start</button></p><p><button class=\"btn-default btnReset\" type=\"button\" value=\"Reset\">Reset</button></p></body>" );

					timerWin.document.body.style.backgroundColor = '#DDDDDD';

					timerWin.document.title                      = 'Timer';

					// window.resizeBy(window.innerWidth,50);

				}

				return false;

			}

		);



		$( 'form#voting' ).submit(

			function(){

				if ( ! $( '#readytovote' ).is( ':checked' )) {

					$( "#readyprompt" ).html( '<span style="color: red;">You must check the final checkbox first</span>' );

					$( '#readyline' ).css( {'border': 'thin solid red'} );

					return false;

				}

			}

		);



		$( document ).on(

			'change',

			'#dropdowntime',

			function() {

				var timevars = $( '#dropdowntime' ).val();

				var parts    = timevars.split( '|' );

				$( '#speakername' ).val( parts[0] );

				$( '#green-light' ).val( parts[1] );

				$( '#yellow-light' ).val( parts[2] );

				$( '#red-light' ).val( parts[3] );

				$( '#speechid' ).val( parts[4] );

			}

		);



		$( document ).on(

			'change',

			'#correction',

			function() {

				correction = parseInt( $( '#correction' ).val() );

				if (timer && timer.started) {

					var signal = {status: 'start', start: timer.startTime.toString(), green: $( '#green-light' ).val(), yellow: $( '#yellow-light' ).val(),red: $( '#red-light' ).val(), correction: $( '#correction' ).val() };

					sendTimerSignal( signal );

				}

			}

		);



		$( '#rednow' ).click(

			function () {

				// $('body').css('background-color', '#FF4040');

				colorNow = 'red';

				colorChange( colorNow );

				// setBackgroundColor(colorNow);

			}

		);

		$( '#yellownow' ).click(

			function () {

				// $('body').css('background-color', '#FCDC3B');

				colorNow = 'yellow';

				colorChange( colorNow );

				// setBackgroundColor(colorNow);

			}

		);



		$( '#greennow' ).click(

			function () {

				// $('body').css('background-color', '#A7DA7E');

				colorNow = 'green';

				colorChange( colorNow );

				// setBackgroundColor(colorNow);

			}

		);



		$( '#checknow' ).click(

			function () {

				lastupdate = 0;

				checkColorChange();

				gotvotetimer = setInterval(

					function(){

						checkColorChange();

					},

					1000

				);

			}

		);



		$( '#hideit' ).click(

			function() {

				hideInstructions();

			}

		);



		function hideInstructions() {

			if (instructionsOn) {

				$( '#instructions' ).hide();

				$( '#hideit' ).hide();

				$( '#timer2021' ).show();

			}

			instructionsOn = false;

		}



		var TSTimer = (function () {

			function TSTimer(speeches, ts = null) {

				var _this     = this;

				this.started  = false;

				this.speeches = speeches;

				if (ts) {

					this.startTime = new Date( ts );

					console.log( 'initialize start time' );

					console.log( this.startTime );

				}

				this.audioElement = document.createElement( 'audio' );

				this.audioElement.setAttribute( 'src', $( '#chimeurl' ).val() );



				$.each(

					this.speeches,

					function (indexInArray, valueOfElement) {

						var newButton = $( '<span>' ).attr( 'id', valueOfElement.id ).addClass( 'speech-type' ).html( valueOfElement.name );

						newButton.click(

							function (event) {

								_this.activateSpeech( $( event.target ).attr( 'id' ) );

							}

						);

						newButton.appendTo( '#buttons' );

						$( '#buttons' ).append( '<br />' );

					}

				);



				$( window ).resize(

					function () {

						_this.resizeTime();

					}

				);



				this.resizeTime();



				$( '.btnReset' ).click(

					function () {

						_this.resetButton();

					}

				);



				$( '.btnStart' ).click(

					function () {

						_this.startButton();

					}

				);



			}

			TSTimer.prototype.resetButton = function () {

				if (this.started) {

					this.stop();

				}

				if (colorNow != 'default') {

					colorNow = 'default';

					colorChange( colorNow );

				}

				correction = 0;

				if ($( '#showdigits' ).is( ':checked' )) {

					$( '#trafficlight' ).text( '0:00' );

				}

				$( '#correction' ).val( 0 );

				this.startTime = null;

				greenchime     = true;

				yellowchime    = true;

				redchime       = true;

			};



			TSTimer.prototype.startButton = function () {

				if (this.started) {

					if (colorWinOpened) {

						colorWin.document.getElementById( 'popuplabel' ).innerHTML = 'Paused';

					}

					this.stop();

				} else {

					if (colorWinOpened) {

						colorWin.document.getElementById( 'popuplabel' ).innerHTML = 'Timing ...';

					}

					this.start();

					colorChange( 'start' );

				}

			};



			TSTimer.prototype.resizeTime = function () {

				var width = $( window ).width();

				var x     = Math.floor( (width < 900) ? (width / 900) * 28 : 28 );

				$( '#trafficlight' ).css( 'font-size', x + 'em' );

			};



			TSTimer.prototype.setElementText = function (elapsedSeconds) {

				this.formattedTime = this.formatTime( elapsedSeconds );

				var view           = $( '#view' ).children( "option:selected" ).val();

				if ((view == 'timer') || view == 'self') {

					$( '#smallcounter' ).text( this.formattedTime );

				}

				// else

				// console.log(this.formattedTime);

				if ((this.red > 4000) && ( elapsedSeconds == 4000 ) ) {// about 64 minutes

					if (colorNow != 'keepalive4000') {

						console.log( 4000 );

						var signal = {status: 'keepalive', start: timer.startTime.toString(), green: $( '#green-light' ).val(), yellow: $( '#yellow-light' ).val(),red: $( '#red-light' ).val(), correction: $( '#correction' ).val() };

						sendTimerSignal( signal );

					}

					colorNow = 'keepalive4000';

					// for long speeches, prevent timeout

				} else if ((this.red > 3000) && ( elapsedSeconds == 3000 ) ) {// about 48 minutes

					if (colorNow != 'keepalive3000') {

						console.log( 3000 );

						var signal = {status: 'keepalive', start: timer.startTime.toString(), green: $( '#green-light' ).val(), yellow: $( '#yellow-light' ).val(),red: $( '#red-light' ).val(), correction: $( '#correction' ).val() };

						sendTimerSignal( signal );

					}

					colorNow = 'keepalive3000';

					// for long speeches, prevent timeout

				} else if ((this.red > 2000) && ( elapsedSeconds == 2000 ) ) {// about 32 minutes

					if (colorNow != 'keepalive2000') {

						console.log( 2000 );

						var signal = {status: 'keepalive', start: timer.startTime.toString(), green: $( '#green-light' ).val(), yellow: $( '#yellow-light' ).val(),red: $( '#red-light' ).val(), correction: $( '#correction' ).val() };

						sendTimerSignal( signal );

					}

					colorNow = 'keepalive2000';

					// for long speeches, prevent timeout

				} else if ((elapsedSeconds == 1000)) {// about 16 minutes

					if (colorNow != 'keepalive') {

						console.log( 1000 );

						var signal = {status: 'keepalive', start: timer.startTime.toString(), green: $( '#green-light' ).val(), yellow: $( '#yellow-light' ).val(),red: $( '#red-light' ).val(), correction: $( '#correction' ).val() };

						sendTimerSignal( signal );

					}

					colorNow = 'keepalive';

					// for long speeches, prevent timeout

				} else if (elapsedSeconds >= this.red) {

					if (colorNow != 'red') {

						colorNow = 'red';

						colorChange( colorNow );

					}

					if (redchime && $( '#playchime' ).is( ':checked' )) {

						this.audioElement.play();

						redchime = false;

					}

				} else if (elapsedSeconds >= this.yellow) {

					if (colorNow != 'yellow') {

						colorNow = 'yellow';

						colorChange( colorNow );

					}

					if (yellowchime && $( '#playchime' ).is( ':checked' )) {

						this.audioElement.play();

						yellowchime = false;

					}

				} else if (elapsedSeconds >= this.green) {

					if (colorNow != 'green') {

						colorNow = 'green';

						colorChange( colorNow );

					}

					if (greenchime && $( '#playchime' ).is( ':checked' )) {

						this.audioElement.play();

						greenchime = false;

					}

				}



			};



			TSTimer.prototype.timerEvent = function () {

				if ( ! this.startTime) {

					this.startTime = new Date();

				}

				timeNow = new Date();

				if (isTimerView()) {

					correction = parseInt( $( "#correction" ).val() );

				}

				var elapsedSeconds = this.timeDiffInSeconds( this.startTime, timeNow ) + correction;

				var timetest       = new Date().getTime() % 1000;

				// console.log('time since last second' + timetest);

				if (timetest < 100) {

					this.setElementText( elapsedSeconds );

				}

			};



			TSTimer.prototype.timeDiffInSeconds = function (earlyTime, lateTime) {

				var diff = lateTime.getTime() - earlyTime.getTime();

				return Math.floor( diff / 1000 );

			};



			TSTimer.prototype.formatTime = function (elapsedSeconds) {

				var minutes = Math.floor( elapsedSeconds / 60 );

				var seconds = elapsedSeconds % 60;

				if (elapsedSeconds > this.overtime) {

					this.disqualified = true;

				} else if (elapsedSeconds < this.undertime) {

					this.disqualified = true;

				} else {

					this.disqualified = false;

				}

				return minutes + ":" + ((seconds < 10) ? "0" + seconds.toString() : seconds.toString());

			};



			TSTimer.prototype.start = function () {

				var _this = this;

				$( '.btnStart' ).html( 'Pause' );

				$( '.hidecount' ).hide();

				this.started = true;

				if (this.startTime && this.stopTime) {

					var newStartTime = new Date().getTime() - (this.stopTime.getTime() - this.startTime.getTime());

					this.startTime.setTime( newStartTime );

				} else {

					this.startTime = new Date();

				}

				this.green  = this.getSecondsFromTextBox( '#green-light' );

				this.yellow = this.getSecondsFromTextBox( '#yellow-light' );

				this.red    = this.getSecondsFromTextBox( '#red-light' );

				var signal  = {status: 'start', start: new Date().toString(), green: $( '#green-light' ).val(), yellow: $( '#yellow-light' ).val(),red: $( '#red-light' ).val(), correction: $( '#correction' ).val() };

				sendTimerSignal( signal );

				$( '#explanation' ).html( $( '#green-light' ).val() + ' - ' + $( '#red-light' ).val() );

				$( '#explanation' ).show();

				this.undertime    = this.green - 30;

				this.overtime     = this.red + 30;

				this.disqualified = true;

				this.timerToken   = setInterval(

					function () {

						return _this.timerEvent();

					},

					100

				);

			};



			TSTimer.prototype.stop = function () {

				$( '.btnStart' ).html( 'Start' );

				this.started  = false;

				this.stopTime = new Date();

				clearInterval( this.timerToken );

				$( '.hidecount' ).show();

				if ($( '#showdigits' ).is( ':checked' )) {

					$( '#trafficlight' ).text( this.formattedTime );

				}

				var view = $( '#view' ).children( "option:selected" ).val();

				if ((view == 'timer') || view == 'self') {

					this.logStopTime();

					$( '#smallcounter' ).text( this.formattedTime );

					sendTimerSignal( {status: 'stop'} );

				}

				clearTimeout( this.timerToken );

				setBackgroundColor( 'stop' );

			};



			TSTimer.prototype.logStopTime = function () {

				if ((typeof this.formattedTime == 'undefined') || (this.formattedTime == 'undefined') ) {

					return;

				}

				var speechid    = $( '#speechid' ).val();

				var speakerName = $( '#speakername' ).val();

				if ( ! speakerName) {

					speakerName = '?';

				}

				speechid = speechid.replace( 'agenda-speech','' );

				// var checked = '';

				if (this.disqualified) {

					$( '#disqualified' + speechid ).prop( 'checked', true );

				} else {

					$( '#disqualified' + speechid ).prop( 'checked', false );

				}

				$( '#actualtime' + speechid ).val( this.formattedTime );

				$( '#logentries' ).append( '<p>' + speakerName + ' ' + this.formattedTime + '</p>' );

			};



			TSTimer.prototype.getSecondsFromTextBox = function (id) {

				var greenLight = $( id ).val();

				return parseInt( greenLight.split( ':' )[0] ) * 60 + parseInt( greenLight.split( ':' )[1] );

			};



			TSTimer.prototype.setDefault = function () {

				this.activateSpeech( 'st-standard' );

			};



			TSTimer.prototype.activateSpeech = function (speechId) {

				var button_name = '';

				this.resetButton();

				$.each(

					this.speeches,

					function (indexInArray, valueOfElement) {

						if (valueOfElement.id === speechId) {

							$( '#green-light' ).val( valueOfElement.greenTime );

							$( '#yellow-light' ).val( valueOfElement.yellowTime );

							$( '#red-light' ).val( valueOfElement.redTime );

							button_name          = this.name;

							TSTimer.current_name = button_name = button_name.replace( '&nbsp;',' ' );

							if ((button_name == 'Standard') || (button_name == 'Advanced') || (button_name == 'Icebreaker')) {

								$( '#speakername' ).val( '' );

							} else {

								$( '#speakername' ).val( button_name );

							}

						}

					}

				);

				$( '.active-speech' ).removeClass( 'active-speech' );

				$( '#' + speechId ).addClass( 'active-speech' );

			};

			return TSTimer;

		})();



		var SpeechType = (function () {

			function SpeechType(name, greenTime, yellowTime, redTime, id) {

				this.name       = name;

				this.greenTime  = greenTime;

				this.yellowTime = yellowTime;

				this.redTime    = redTime;

				this.id         = id;

			}

			return SpeechType;

		})();



		speeches.push( new SpeechType( "Standard", "5:00", "6:00", "7:00", "st-standard" ) );

		speeches.push( new SpeechType( "Table&nbsp;Topics", "1:00", "1:30", "2:00", "st-table-topics" ) );

		speeches.push( new SpeechType( "Evaluation", "2:00", "2:30", "3:00", "st-evaluation" ) );

		speeches.push( new SpeechType( "Icebreaker", "4:00", "5:00", "6:00", "st-icebreaker" ) );

		timer = new TSTimer( speeches );

		timer.setDefault();



		$( '#enlargecontrols' ).click(

			function() {

				$( '#timelog' ).css( "font-size",'16px' );

				$( '#timelog' ).css( "width",'200px' );

				$( '#dropdowntime' ).css( "width",'200px' );

				$( '#speakername' ).css( "width",'200px' );

				$( '#correction' ).css( "width",'190px' );

				$( '#red-light' ).css( "width",'200px' );

				$( '#green-light' ).css( "width",'200px' );

				$( '#yellow-light' ).css( "width",'200px' );

				$( '.colorbuttons' ).css( "width",'200px' );

				hideInstructions();

				$( '#enlargecontrols' ).hide();

			}

		);

		const form = document.querySelector('form.newcolor');
		console.log('form',form);
		form.addEventListener('submit', handleImageSubmit);
		
		function handleImageSubmit(event) {
		event.preventDefault();
		console.log('handleSubmit');
		  /** @type {HTMLFormElement} */
		  const form = event.currentTarget;
		  const url = new URL(form.action);
		  const formData = new FormData(form);
		  const searchParams = new URLSearchParams(formData);
		const wp_nonce = document.getElementById('checkcheck').value;
		console.log('wp_nonce',wp_nonce);
		  /** @type {Parameters<fetch>[1]} */
		  const fetchOptions = {
			method: form.method, // or 'POST', 'PUT', etc.
			headers: {
				'X-WP-Nonce': wp_nonce,
			},
		  };		
		  if (form.method.toLowerCase() === 'post') {
			if (form.enctype === 'multipart/form-data') {
			  fetchOptions.body = formData;
			} else {
			  fetchOptions.body = searchParams;
			}
		  } else {
			url.search = searchParams;
		  }
		  fetch(url, fetchOptions).then((response) => response.json())
		  .then((data) => {
			console.log(data);
			let target = '#by-'+data.color;
			console.log(target);
			let x;
			let y = document.querySelectorAll('.background-image-picker');
			console.log('all',y);
			if('green' == data.color) {
				greenimg = data.url;
				x = y[0];
			}
			else if('yellow' == data.color) {
				yellowimg = data.url;
				x = y[1];
			}
			else if('red' == data.color)
			 {
				redimg = data.url;
				x = y[2];
			}
			var option = document.createElement("option");
			option.text = data.file;
			option.value = data.url;
			x.add(option);
			x.value = data.url;
			colorChange(data.color);
			document.getElementById('file').value = '';
		  })
		  .catch(console.error);;
		
		}

	}
);// end jquery closure

