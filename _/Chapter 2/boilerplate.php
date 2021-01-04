<?php   
    /* the document title in the <head> */  
    $documentTitle = "jQuery Mobile PHP Boilerplate";       

    /* Left link of the header bar       
     *   
     * NOTE: If you set the $headerLeftLinkText = 'Back'     
     * then it will become a back button, in which case,     
     * no other field for $headerLeft need to be defined.    
     */     
    $headerLeftHref = "/";  
    $headerLeftLinkText = "Home";   
    $headerLeftIcon = "home";       

    /* The text to show up in the header bar */ 
    $headerTitle = "Boilerplate";   
 
    /* Right link of the heaer bar */   
    $headerRightHref = "tel:8165557438";    
    $headerRightLinkText = "Call";  
    $headerRightIcon = "grid";      

    /* The href to the full-site link */    
    $fullSiteLinkHref = "/";     
?>  
<!DOCTYPE html>  
<html> 
  <head>    
    <?php include "includes/meta.php" ?> 
  </head>  
  <body>
    <div data-role="page">

      <?php include "includes/header.php" ?>
       
      <div data-role="content">              
        <p>Page Body content</p>         
      </div>      

      <?php include "includes/footer.php" ?>                    
    </div> 
  </body> 
</html> 
