	<div data-theme="f" data-role="header">
    	<?PHP if(strtoupper ($headerLeftLinkText) == "BACK"){?>
        	<a data-icon="arrow-l" href="javascript://" 
               data-rel="back"><?=$headerLeftLinkText?></a>	
    	<?PHP } else if($headerLeftHref != ""){ ?>
            <a <?PHP if($headerLeftIcon != ""){ ?>
            	   data-icon="<?=$headerLeftIcon ?>"
			   <? } ?>
            href="<?=$headerLeftHref?>"><?=$headerLeftLinkText?></a>
        <?PHP } ?>
		<h1><?=$headerTitle ?></h1>
        <?PHP if($headerRightHref != ""){ ?>
            <a <?PHP if($headerRightIcon != ""){ ?>
            	   data-icon="<?=$headerRightIcon ?>" data-iconpos="right" 
			   <? } ?>
            href="<?=$headerRightHref?>"><?=$headerRightLinkText?></a>
        <?PHP } ?>
	</div><!-- /header -->
