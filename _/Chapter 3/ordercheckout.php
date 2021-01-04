<!DOCTYPE html>
<html>
<?php 
	$documentTitle = "Check Out | Nicky's Pizza";
	
	$headerLeftHref = "";
	$headerLeftLinkText = "Back";
	$headerLeftIcon = "";

	$headerRightHref = "tel:8165077438";
	$headerRightLinkText = "Call";
	$headerRightIcon = "grid";
	
	$fullSiteLinkHref = "/";
	
?>
<head>
	<?php include("includes/meta.php"); ?>
    <style type="text/css">
		#ordernameContainer{display:none;}
	</style>
</head>

<body>
	<form action="thankyou.php" method="post" class="validateMe">
        <div data-role="page" id="delivery">
            <?php $headerTitle = "Deliver To"; ?>
            <?php include("includes/header.php"); ?>
            <div data-role="content">
            	<h2>Where will we be delivering?</h2>
                
                <p>
                    <label for="streetAddress">Street Address</label>
                    <input type="text" name="streetAddress" id="streetAddress" class="pageRequired" />
                </p>
                
                <p>
                    <label for="streetAddress2">Address Line 2 | Apt#</label>
                    <input type="text" name="streetAddress2" id="streetAddress2" />
                </p>
                
                <p>
                	<label for="zip">Zip Code</label>
                    <input type="number" name="zip" id="zip" maxlength="5" class="pageRequired zip" />
                </p>
                
                <p>
                	<label for="phone">Phone Number</label>
                    <input type="tel" name="phone" id="phone" maxlength="10" class="number pageRequired" />
                </p>
                
                <p>
                    <div class="ui-grid-a">
                        <div class="ui-block-a"><a data-role="button" data-icon="delete" data-iconpos="left" data-theme="d" href="javascript://">Cancel</a></div>
                        <div class="ui-block-b"><a data-role="button" data-icon="arrow-r" data-iconpos="right" data-theme="b" href="#payment" class="validateContinue">Continue</a></div>
                    </div>
                </p>

            </div>
            <?php include("includes/footer.php"); ?>
        </div>
    
        <div data-role="page" id="payment">
            <?php $headerTitle = "Payment"; ?>
            <?php include("includes/header.php"); ?>
            <div data-role="content">
                <h2>Please enter payment information</h2>
                
                <p>
                	<label for="nameOnCard">Name on card</label>
                    <input type="text" name="nameOnCard" id="nameOnCard" class="pageRequired" />
                </p>
                
                <p>
                	<label for="cardNumber">Card Number</label>
                    <input type="tel" name="cardNumber" id="cardNumber" class="pageRequired creditcard" />
                </p>
                
                <p>
                	<label for="expiration">Expiration</label>
                    <input class="pageRequired number" type="tel" name="expiration" id="expiration" maxlength="4" size="4" placeholder="MMYY" />
                </p>
                
                <p>
                	<label for="cvv">CVV2 (on the back of your card)</label>
                    <input class="pageRequired number" type="number" name="cvv" id="cvv" minlength="3" maxlength="4" />
                </p>
               
                <p>
                    <input type="checkbox" value="true" name="savePayment" id="savePayment" /><label for="savePayment">Save payment info for easier ordering?</label>
                	<input type="checkbox" value="true" name="saveOrder" id="saveOrder" onchange="showHideOrderNameContainer()" /><label for="saveOrder">Save this order to your favorites?</label>
                </p>
                
                <p id="ordernameContainer">
                	<label for="ordername">Give your order a name</label>
                    <input type="text" name="ordername" id="ordername" placeholder="example: the usual" />
                </p>
                
                <p>
                    <div class="ui-grid-a">
                        <div class="ui-block-a"><a data-role="button" data-icon="delete" data-iconpos="left" data-theme="d" href="javascript://">Cancel</a></div>
                        <div class="ui-block-b"><input type="submit" data-icon="arrow-r" data-iconpos="right" data-theme="b" value="Submit" /></div>
                    </div>
                </p>

            </div>
            <?php include("includes/footer.php"); ?>
        </div>
    
    </form>
    <script type="text/javascript">
		function showHideOrderNameContainer(){
			if($("#saveOrder").attr("checked")){
				$("#ordernameContainer").show();
			}else{
				$("#ordernameContainer").hide();
			}
		}
		
		//page refresh mitigation
		$("[data-role='page']").live("pagebeforeshow", function(){
			if(document.location.hash != ""){
				var $firstRequiredInput = $("input.pageRequired").first();
				if($firstRequiredInput.val() == ""){
					var redirectPage = $firstRequiredInput.closest("[data-role='page']");
					$.mobile.changePage(redirectPage);
				}
			}
			
		});
	</script>
</body>
</html>
