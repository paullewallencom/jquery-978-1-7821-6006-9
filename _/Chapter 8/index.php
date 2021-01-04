
<!DOCTYPE html> 
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<title class="pageTitle">Loading...</title> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.js"></script>
    <script src="jquery.cookie.js"></script>
    <style type="text/css">
		#iscfz,.comment-bubble{display:none;}
		#bottomMenu .byline{padding:0 0 8px 12px; font-weight:normal;}
	</style>
</head> 

<body> 

<div id="mainPage" data-role="page">

	<div data-role="header">
		<h1 class="pageTitle">Loading...</h1>
        <a href="#menu" class="ui-btn-right" data-icon="grid" data-transition="slidedown" data-rel="dialog">Menu</a>
	</div><!-- /header -->

	<div id="mainContent" data-role="content">	
		
        
	</div><!-- /content -->
    <div>
    	<ul id="bottomMenu" data-role="listview"></ul>
    </div>
	<div data-role="footer">
		<h4><a class="fullSiteLink" data-role="button" data-inline="true" href="<?php echo htmlspecialchars(strip_tags($_REQUEST["p"])) ?>" target="fullsite">Full Site View</a></h4>
	</div><!-- /footer -->
	
</div><!-- /page -->

<div id="menu" data-role="page">
	<div data-role="header">
		<h1>Main Menu</h1>
	</div><!-- /header -->
    <div id="mainMenuContent" data-role="content">
    	<ul data-role="listview" data-inset="true"></ul>
    </div>
</div>

<script type="text/javascript">
	$.cookie("mobileFullSiteClicked","true", {path:"/",expires:0});  //0 minutes - erase cookie
	
	try{
		//make the url the original url so if the user shares it with others, they'll be sent
		//to the appropriate URL and that will govern if they should be shown mobile view.
		history.replaceState({},"","<?php echo htmlspecialchars(strip_tags($_REQUEST["p"])) ?>");
	}catch(e){
		//history state manipulation is not supported
	}

	//Global variable for the storage of the imported page content
	//Never know when we might need it
	var $pageContent = null;
	
	//Go get the content we're supposed to show here
	function loadPageContent(){
		
		//Show the loading icon
		$.mobile.showPageLoadingMsg();
		
		$.ajax({
			//strip_tags and htmlspecialchars are to to help prevent cross-site scripting attacks
			url:"<?php echo htmlspecialchars(strip_tags($_REQUEST["p"])) ?>"
		})
		.success(function(data, textStatus, jqXHR){
			//hide the loading icon
			$.mobile.hidePageLoadingMsg();
			
			//jQuery the returned page and thrown it into the global variable
			$pageContent = $(data);
			
			//take the pieces we want and construct the view
			renderPage();
		})
		.error(function(jqXHR, textStatus, errorThrown){
			//hide the loading icon
			$.mobile.hidePageLoadingMsg();
			
			//let the user know that something went wrong
			$("mainContent").html("<p class='ui-bar-e'>Aw snap! Something went wrong:<br/><pre>"+errorThrown+"</pre></p>");
		});
	}
	
	function renderPage(){
		
		//Anything you're going to call on more than once should be 
		//placed into a variable to make things run quicker. 

		//Placing a $ in front of a variable is a good notation
		//for indicating that the stored variable 
		//has been jQueried.  
		var $importedPageMainContent = $pageContent.find("#main");
		var $thisPageMainContent = $("#mainContent");
		
		//pull the title and inject it.
		var title = $importedPageMainContent.find("h1.title").text();
		$(".pageTitle").text(title);
		
		//set the content for the main page starting with the logo
		//then appending the headline, byline, and main content
		var $logo = $pageContent.find("#logo-headerC img");
		$thisPageMainContent.html($logo);
		$thisPageMainContent.append($importedPageMainContent.find("h1.title"));
		$thisPageMainContent.append($importedPageMainContent.find("div.byline"));
		$thisPageMainContent.append($importedPageMainContent.find("div.the-content"));
		
		var $bottomMenu = $("#bottomMenu");
		
		//Take the next 3 top stories and place them in the bottom menu 
		//to give the user something to move on to.  
		$bottomMenu.html("<li data-role='list-divider'>Read On...</li>");
		$bottomMenu.append($pageContent.find("#alldiaries li:lt(3)")); 
		
		//Inject the main menu items tinto the bottom menu
		$bottomMenu.append("<li data-role='list-divider'>Menu</li>");
		var $mainMenuContent = $pageContent.find("#NavMain");
		$bottomMenu.append($mainMenuContent.html());
		
		//After doing all this injection, refresh the listview
		$bottomMenu.listview("refresh");
		
		//inject the main menu content into main menu page
		var $mainMenContent = $("#mainMenuContent");
		$mainMenContent.find("ul").append($mainMenuContent.html());
		
	}
	
	//once the page is initizlized, go get the content.
	$("[data-role='page']").live("pageinit", loadPageContent);
	
	$("a.fullSiteLink").live("click", function(){
		$.cookie("mobileFullSiteClicked","true", {path:"/",expires:30});  //30 minutes
	});
	
</script>
</body>
</html>