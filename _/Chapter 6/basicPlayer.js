		var media = {
			"currentTrack":0,
			"random":false,
			"tracklist":[
				"electricdaisy.html",
				"crystallize.html",
				"comewithus.html",
				"shadows.html",
				"skyrim.html"
			]
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
		
		$("a.play").live('click', function(){
			try{
				var $page = $.mobile.activePage;
				var $audio = $page.find("audio");
				
				//toggle playing
				$audio.data("playing",!$audio.data("playing"));
				
				//if we should now be playing
				if($audio.data("playing")) {
					
					//play the audio
					$audio[0].play();
					
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
		});
		
		//for every song page
		$(".songPage").live("pagecreate",function(){
			var $page = $(this);
			//set references to the playing status, progress bar, and progress interval on the audio object itself
			$page.find("audio")
				.data("playing",false)
				.data("progressBar", $page.find("input.progressBar"))
				.data("progressThread",null);
		});
				
		$("a.seekback").live('click',function(){
			$.mobile.activePage.find("audio")[0].currentTime -= 5.0;
		});
		
		$("a.seek").live('click',function(){
			$.mobile.activePage.find("audio")[0].currentTime += 5.0;
		});
		
		$("a.skipback").live('click',function(event){
			//grab the current audio
			var currentAudio = $.mobile.activePage.find("audio")[0];
			
			//if we're more than 5 seconds into the song, skip back to the beginning
			if(currentAudio.currentTime > 5){
				currentAudio.currentTime = 0;
			}else{
				//othewise, change to the previous track
				media.currentTrack--;
				if(media.currentTrack < 0) media.currentTrack = (media.tracklist.length - 1);
				$.mobile.changePage("#"+media.tracklist[currentTrack]);
			}
		});
		
		$("a.skip").live('click',function(event){
			//grab the current audio and switch to the next track
			var currentAudio = $.mobile.activePage.find("audio")[0];
			media.currentTrack++;
			if(media.currentTrack >= media.tracklist.length) media.currentTrack = 0;
			$.mobile.changePage("#"+media.tracklist[currentTrack]);
		});
		

