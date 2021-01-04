		var media = {
			"debug":false,
			"currentTrack":0,
			"random":false,
			"tracklist":[
				"electricdaisy.html",
				"comewithus.html",
				"crystallize.html",
				"shadows.html",
				"skyrim.html"
			]
		}
		var lastDebugTS = (new Date).getTime();
	
		function getPercentProg() {
			try{
				var currentAudio = $.mobile.activePage.find("audio")[0];
				debug("id: "+currentAudio.id);
				var endBuf = currentAudio.buffered.end(0);
				debug("endbuffer: " +endBuf);
				var soFar = parseInt(((endBuf / currentAudio.duration) * 100));
				debug("soFar: "+soFar);
			}catch(e){}
        }
		
		function debug(str){ 
			try{
				if(media.debug){
					$.mobile.activePage.find("div[data-role='content']").append(""+((new Date()).getTime()-lastDebugTS)+": "+str+"<br/>");
					lastDebugTS = (new Date).getTime();	
				}
			}catch(e){}
		}

		function scrubberUpdateInterval(){
			
			//Grab the current page
			var $page = $.mobile.activePage;
			
			//Grab the audio element
			var $audio = $page.find("audio");
			var currentAudio = $audio[0];
			
			//Grab the progress monitor and the handle
			currentAudioProgress = $page.find("input.progressBar");
			scrubberHandle = currentAudioProgress.closest(".progressContainer").find("a.ui-slider-handle");
			
			//Is the user currently touching the bar?
			if(scrubberHandle.hasClass("ui-focus")){
				
				//Pause it if it's not paused already
				if(!currentAudio.paused){
					 currentAudio.pause();
				}
				
				//Find the last scrubber's last position
				var lastScrubPosition = currentAudioProgress.data("lastScrubPosition");
				if(lastScrubPosition == null) lastScrubPosition = 0;
				
				//Are we in the same place as we were last?
				if(Math.floor(lastScrubPosition) == Math.floor(currentAudio.currentTime)){
					var lastScrubUnchangedCount = currentAudioProgress.data("lastScrubUnchangedCount");
					
					//If the user held still for 3 or more cycles of the interval, resume playing
					if(++lastScrubUnchangedCount >= 2){
						scrubberHandle.removeClass("ui-focus");
						currentAudioProgress.data("lastScrubUnchangedCount", 0);
						currentAudio.play();
					}else{
						//increment the unchanged counter
						currentAudioProgress.data("lastScrubUnchangedCount", lastScrubUnchangedCount);
					}
				}else{
					//set the unchanged counter to 0 since we're not in the same place
					currentAudioProgress.data("lastScrubUnchangedCount", 0);
				}
				
				//set the last scrubbed position on the scrubber
				currentAudioProgress.data("lastScrubPosition", Number(currentAudioProgress.val()));
				
				//set the current time of the audio
				currentAudio.currentTime = currentAudioProgress.val(); 
			}else{
				//The user is not touching the scrubber, just update the position of the handle
				currentAudioProgress.val(currentAudio.currentTime).slider('refresh'); 
			}
		}
		
		function playAction(){
			try{
				
				var $page = $.mobile.activePage;
				var $audio = $page.find("audio");
				
				//toggle playing
				$audio.data("playing",!$audio.data("playing")); 
				
				//if we should now be playing
				if($audio.data("playing")) {
					
					//play the audio
					debug("--play "+$audio[0].id+"--");
					$audio[0].play();
					debug("--now playing "+$audio[0].id+"--");
					
					//switch the playing image for pause
					$page.find("img.playPauseImage").attr("src","images/xtras-gray/48-pause@2x.png");
					
					//kick off the progress interval
					$audio.data("progressThread", setInterval(scrubberUpdateInterval, 750));
				}else{
					
					//pause the audio
					$audio[0].pause();
					
					//switch teh pause image for the playing audio
					$page.find("img.playPauseImage").attr("src","images/xtras-gray/49-play@2x.png");
					
					//stop the progress interval
					clearInterval($audio.data("progressThread"));
				}
			}catch(e){alert(e)};		
		}
		
		$(document).live('vclick', 'a.play', playAction);
		
		//for every song page
		$(document).live("pagecreate", ".songPage", function(){
			debug("--jqm pagecreate--");
			var $page = $(this);
			var $currentAudio = $page.find("audio");
			$currentAudio[0].autoplay=true;
			//set references to the playing status, progress bar, and progress interval on the audio object itself
		
			$currentAudio.data("playing",false)
				.data("progressBar", $page.find("input.progressBar"))
				.data("progressThread",null);
				
			//loadstart and progress occur with autoload	
			$currentAudio[0].addEventListener('loadstart', function(){
				//Fires when the browser starts looking for the audio/video
				debug("Event: loadstart");
			}, false);
			$currentAudio[0].addEventListener('progress', function(){
				//Fires when the browser is downloading the audio/video
				//This will fire multiple times until the source is fully loaded
				debug("Event: progress");
				getPercentProg();
			}, false);
			
			
			//durationchange, loadedmetadata, loadeddata, canplay, canplaythrough are kicked off upon pressing play
			$currentAudio[0].addEventListener('durationchange', function(){
				//Fires when the duration of the audio/video is changed
				debug("Event: durationchange");
			}, false);
			$currentAudio[0].addEventListener('loadedmetadata', function(){
				//Fires when the browser has loaded meta data for the audio/video
				debug("Event: loadmetadata");
			}, false);
			$currentAudio[0].addEventListener('loadeddata', function(){
				//Fires when the browser has loaded the current frame of the audio/video
				debug("Event: loadeddata");
			}, false);
			$currentAudio[0].addEventListener('canplay', function(){ 
				//Fires when the browser can start playing the audio/video
				debug("Event: canplay");
			}, false);
			$currentAudio[0].addEventListener('canplaythrough', function(){
				//Fires when the browser can play through the audio/video without stopping for buffering
				debug("Event: canplaythrough");
			}, false);
			
			
			$currentAudio[0].addEventListener('ended', function(){
				debug("Event: ended");
				//Fires when the current playlist is ended
			}, false);
			
			
			$currentAudio[0].addEventListener('error', function(){ 
				//Fires when an error occurred during the loading of an audio/video
				debug("Event: error");
			}, true);

		});
	
		$(document).live("pageshow", ".songPage", function(){ 
			try{
				var $page = $(this);
				debug("--jqm pageshow--");
			}catch(e){
				alert(e);	
			}
		});
				
		$(document).live('vclick', "a.seekback", function(){
			$.mobile.activePage.find("audio")[0].currentTime -= 5.0;
		});
		
		$(document).live('vclick', "a.seek", function(){
			$.mobile.activePage.find("audio")[0].currentTime += 5.0;
		});
		
		$(document).live('vclick', "a.skipback", function(event){
			//grab the current audio
			var currentAudio = $.mobile.activePage.find("audio")[0];
			
			//if we're more than 5 seconds into the song, skip back to the beginning
			if(currentAudio.currentTime > 5){
				currentAudio.currentTime = 0;
			}else{
				//othewise, change to the previous track
				media.currentTrack--;
				if(media.currentTrack < 0) media.currentTrack = (media.tracklist.length - 1);
				$.mobile.changePage(media.tracklist[media.currentTrack]);
			}
		});
		
		$(document).live('vclick', "a.skip", function(event){
			//grab the current audio and switch to the next track
			var currentAudio = $.mobile.activePage.find("audio")[0];
			currentAudio.pause();
			currentAudio.currentTime = 0;
			media.currentTrack++;
			if(media.currentTrack >= media.tracklist.length) media.currentTrack = 0;
			$.mobile.changePage(media.tracklist[media.currentTrack]);
		});
		

