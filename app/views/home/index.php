<!DOCTYPE html>
<html lang="en" class="HomePageBody">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>Capital</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script> 
<script src="<?=$data["header"]["public"]?>js/web/materialize.js"></script>
<script src="<?=$data["header"]["public"]?>js/web/jquery.bxslider.js"></script>
<script src="<?=$data["header"]["public"]?>js/web/jquery.fullPage.js"></script>
<script src="<?=$data["header"]["public"]?>js/web/scripts.js"></script> 

<link href="<?=$data["header"]["public"]?>css/web/materialize.css" rel="stylesheet">
<link href="<?=$data["header"]["public"]?>css/web/bootstrap.css" rel="stylesheet">
<link href="<?=$data["header"]["public"]?>css/web/jquery.fullPage.css" rel="stylesheet">
<link href="<?=$data["header"]["public"]?>css/web/style.css" rel="stylesheet">
<link href="<?=$data["header"]["public"]?>css/web/custom_res.css" rel="stylesheet">

<style>
	*{ word-wrap: break-word; }
	body{ margin: 0 10px 10px 10px; padding:0; overflow-x: hidden; }
	.datas{ margin-top: 10px; font-size: 8px; border: solid 1px #000000; padding: 10px; }
	h2{ margin: 0; padding: 0 0 10px 0; border-bottom: solid 1px #555555; }
</style>

</head>
<body>
<?=$data['loanModel']?>
<?=$data['calculatorModel']?>

<header id="Header">
		<div class="col-sm-4">
			<div class="logo"><a class="ScrollAnimate"><img src="<?=$data["header"]["public"]?>img/logo.png" /></a></div>
		</div>

		<div class="col-sm-8 text-right">
			<div class="HeaderDiv">
				<div class="HeaderMenu">
				    <?=$data['navigationModel']?>
					<div class="HeaderTel"><?=strip_tags($data['selectInfo']['phone'])?></div>		

					<div class="HeaderCalcCur">
						<a class="CalcIcon waves-effect waves-teal OpenModalClick" href="#CalculatorPopup"></a>
						<div class="Currency waves-effect waves-teal" id="ShowCurrency"></div>
						<div class="CurrencyDiv" style="display:none;">
							<div class="TitleDiv">ვალუტის კურსი </div>	
							<div class="CurrencyContent">
								<div class="col-sm-12 CurrencyItemDiv">
									<div class="text-left"><img src="<?=$data["header"]["public"]?>img/usd.png"/> USD </div>
									<div class="pull-right">1.00 $</div>	
									<br/><br/>
										<div class="CurrentRefresh"></div>
									<div class="text-left"><img src="<?=$data["header"]["public"]?>img/gel.png"/> GEL </div>
									<div class="pull-right">
										<?=printf("%.02lf", (float)$data['currency']['usd'])?>
									</div>									
								</div>
								<div class="col-sm-12 CurrencyItemDiv">
									<div class="text-left"><img src="<?=$data["header"]["public"]?>img/eur.png"/> EUR </div>
									<div class="pull-right">1.00 &euro;</div>
									<br/><br/>
										<div class="CurrentRefresh"></div>
									<div class="text-left"><img src="<?=$data["header"]["public"]?>img/gel.png"/> GEL </div>
									<div class="pull-right"><?=printf("%.02lf", (float)$data['currency']['eur'])?></div>									
								</div>
							</div>					
						</div>	
					</div>

				</div>
			</div>
			

		</div>
</header>

		<?=$data['aditionalNavigationModel']?>

<div id="fullpage">
	
	<?php
	$i = 1;
	foreach ($data['sideNavigation'] as $val) {
		$active = ($i==1) ? " active" : "";
		$bg = "";
		if(isset($data['pictures']['photos'][$val['idx']][0]['path'])){
			$bg = $data["header"]["website_"].$data['pictures']['photos'][$val['idx']][0]['path'];
		}
		?>
		<div class="section<?=$active?>" id="section<?=$i?>">
	        <section id="HomePage" class="height100 " style="background:url('<?=$bg?>');">  
				
	        	<div class="SliderContent">
			  		<div class="SlideNumber">0<?=$i?></div>
			  		<div class="Title"><?=$val['title']?></div>
			  		<div class="Content">
			  			<?=$val['text']?>
			  		</div>
			  		<div class="BlueButton waves-effect waves-orange OpenModalClick" href="#ApplicationModal" onclick="$('#loan-type').val('<?=$val['title']?>');">შეავსე განაცხადი</div>
			  	</div> 
			</section>
	    </div>
		<?php
		$i++;
	}
	?>
    
    





    <div class="section" id="section5">
        <section id="AboutPage" class="height100">
			<div class="container-fluid">
				<div class="ABoutTitle"><?=strip_tags($data['navigationDB'][1]['description'])?></div>
				<div class="AboutContent">
					<?=strip_tags($data['navigationDB'][1]['text'])?>
				</div>
				<div class="BlueButton waves-effect waves-orange">გაიგე კაპექს კრედიტის შესახებ</div>
			</div>
		</section>
    </div>

    <div class="section" id="section6">
        <section id="ContactPage" class="height100">
			<div class="container-fluid">
				<div class="ContactTitle">ჩვენი ფილიალები და კონტაქტი</div>
				<div class="COntactContent">
					<div class="col-sm-8">
						<div class="ContactGoogleMap">
							<div id="map"></div>
						</div>
					</div>
					<div class="col-sm-4 padding_0">
						<div class="ContactList">
							<?=$data['selectInfo']['contact1']?>
						</div>
						<div class="ContactList">
							<?=$data['selectInfo']['contact2']?>
						</div>
					</div>
				</div>
			</div>			
		</section>
    </div>
</div>

 
<script type="text/javascript">
function initMap() {

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 10,
    center: {lat: 41.7072608, lng: 45.0963375},
    scrollwheel: false
  });

  var beaches = [
  	<?php
  	$branchCount = count($data['selectBranches']);
  	$x = 1;
  	foreach ($data['selectBranches'] as $branch) {
  		if($branchCount==$x){
  			echo strip_tags($branch['description']);
  		}else{
  			echo strip_tags($branch['description']).", ";
  		}
  		$x++;
  	}
  	?> 
  ];

  setMarkers(map, beaches);
}  


if (document.documentElement.clientWidth < 900) { 
	$('.bxslider').bxSlider({
		 mode: 'fade', 
	 	 pagerCustom: '#bx-pager',
	 	 auto: false,
	 	 adaptiveHeight:true,
	 	 adaptiveHeightSpeed:500

	});
}

if (document.documentElement.clientWidth > 900) {

	$('.bxslider').bxSlider({
		 mode: 'vertical', 
	 	 pagerCustom: '#bx-pager',
	 	 auto: false,
	 	 adaptiveHeight:true,
	 	 adaptiveHeightSpeed:500

	});
	$(document).ready(function() {
	    $('#fullpage').fullpage({
	        anchors: ['Home','Home2','Home3','Home4','Home5', 'About', 'Contact'],
	        menu: '#menu',
	        css3: true,
	        scrollingSpeed: 1000,
	    });
	});
	
}    

if (document.documentElement.clientWidth < 900) {
	$(document).ready(function() {
	    $('#fullpage').fullpage({
	        anchors: ['Home','Home2','Home3','Home4','Home5', 'About', 'Contact'],
	        menu: '#menu', 
	        autoScrolling: false,
	        fitToSection: false
	    });
	});
}

</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAt9-cvNNqWdw_li7Kn4-3XdFRxicO1S3w&callback=initMap"></script> 


</body>
</html>
