<!DOCTYPE html >
<html>
<?php 
	$documentTitle = "Dark Knight Rises | Dickinson Theaters";
	
	$headerLeftHref = "";
	$headerLeftLinkText = "Back";
	$headerLeftIcon = "";

	$headerRightHref = "index.php";
	$headerRightLinkText = "Home";
	$headerRightIcon = "home";
	
	$fullSiteLinkHref = "http://dtmovies.com/movie.aspx?mid=193818";
	
?>
<head>
	<?php include("includes/meta.php"); ?>
</head>

<body>
<div data-role="page" id="movieDetailsPage"> 
	<?php $headerTitle = "Menu"; ?>
	<?php include("includes/header.php"); ?>
    	<h3 class="pageTitle">Dark Knight Rises</h3>
        <div class="ui-shadow" data-role="content">
        	<img src="images/darkknightrises.jpeg" width="107" style="float:left; margin-right:10px;margin-bottom:10px;" class="ui-shadow" />
            <div id="freshmeter">
            	<strong>Community Ratings:</strong><br>
            	<div class="certifiedFresh">87% - Critics</div> <br/>
                <div class="audienceFresh">92% - Audiences</div>
            </div>
            <p id="runninglength"><strong>Running Length</strong>:  2:30</p>
            <p id="rated"><strong>Rated</strong>: PG-13 - for intense sequences of violence and action, some sensuality and language</p>
            <p id="showtimes"><strong>Show Times at Northglen 12:</strong><br />  12:30pm, 1:00pm (3D), 3:00pm, 3:30pm (3D), <a href="javascript://">7:00pm</a>, <a href="javascript://">7:30pm (3D)</a>, <a href="javascript://">10:00pm</a>, <a href="javascript://">10:30pm (3D)</a> </p>
            <video id="preview" width="100%" controls poster="images/preview.gif"> 
                <source src="previews/batmanTrailer-2_720.mp4" type="video/mp4"  media="only screen and (-webkit-min-device-pixel-ratio: 1.5), only screen and (min--moz-device-pixel-ratio: 1.5), only screen and (min-resolution: 240dpi)"/>
                <source src="previews/batmanTrailer-1_480.mov" type="video/mov" />
                <a data-role="button" href="http://www.youtube.com/watch?v=J9DlV9qwtF0">Watch Preview</a>
            </video> 
            <p id="buytickets"><a data-role="button" data-theme="b" href="javascript://">Buy Tickets</a></p>
            <p id="cast"><strong>Cast:</strong><br />
                Michael Caine, Anne Hathaway, Tom Hardy, Gary Oldman, Marion Cotillard, Joseph Gordon-Levitt, Morgan Freeman
            </p>
            <p id="summary"><strong>Summary:</strong><br/> 
            	Warner Bros. Pictures' and Legendary Pictures' "The Dark Knight Rises" is the epic conclusion to filmmaker Christopher Nolan's Batman trilogy, Leading an all-star international cast, Oscar winner Christian Bale ("The Fighter") again plays the dual role of Bruce Wayne/Batman. The film also stars Anne Hathaway, as Selina Kyle; Tom Hardy, as Bane; Oscar winner Marion Cotillard ("La Vie en Rose"), as Miranda Tate; and Joseph Gordon-Levitt, as John Blake. Returning to the main cast, Oscar winner Michael Caine ("The Cider House Rules") plays Alfred; Gary Oldman is Commissioner Gordon; and Oscar winner Morgan Freeman ("Million Dollar Baby") reprises the role of Lucius Fox. The screenplay is written by Christopher Nolan and Jonathan Nolan, story by Christopher Nolan & David S. Goyer. The film is produced by Emma Thomas, Christopher Nolan and Charles Roven, who previously teamed on "Batman Begins" and the record-breaking blockbuster "The Dark Knight." The executive producers are Benjamin Melnik
            </p>

    </div>
    <?php include("includes/footer.php"); ?>
</div>

</body>
</html>
