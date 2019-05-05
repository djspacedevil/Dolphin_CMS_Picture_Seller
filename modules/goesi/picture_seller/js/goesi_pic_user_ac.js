 $(document).ready(function(){

//////Anfang
		
		$.post(PostDir,{
				delfolder: 'DELALL'
			}, function(data) {
				if (data == 'del-true') {}
			});
			
	if (Paypal == "yespaypal" && $('.whoalbum').val() != '') {
	$("#forward").css('background-color', '#5BB75B').css('background-image', '-moz-linear-gradient(center top , #62C462,#51A351)');
	}
	//Vorlauf
	$("#forward").live('click', function(){
	//Anfang Schritt 1
		if ($(this).attr('name') == 'Step1' && $('.whoalbum').val() != '') {
			
					$('.Step1').slideUp('slow');
					$('.Step2').slideDown('slow');
					$('.check1').toggle("slow", function() {
						$('.check1').attr('src', Bilderpfad+'../ok.png').toggle("slow");
					});
					$('.check2').toggle("slow");
				
			
		}
	// Ende Schritt 1
	
	//Anfang Schritt 2
		else if ($(this).attr('name') == 'Step2' && $('.setalbum').val() != '') {
			$('.load-album').toggle("slow");
			$.post(PostDir,{ 
							createalbum: $('.whoalbum').val(), 
							albumTitle: $('.albumTitle').val(), 
							albumDesc: $('.albumDesc').val(), 
							albumCat: $('#albumCat').val(),
							albumLand: $('#albumLand').val(), 
							albumKeywords: $('.albumKeywords').val(), 
							seenby: $('#seenby').val()
							},
            function(data){
				if (data != '') {
					$('.load-album').toggle("slow");
					$('.Step2').slideUp('slow');
					$('.Step3').slideDown('slow');
					$('.check2').toggle("slow", function() {
						$('.check2').attr('src', Bilderpfad+'../ok.png').toggle("slow");
					});
					$('.check3').toggle("slow");
					$('.newalbumID').val(data);
				} else {
					$('.load-album').toggle("slow", function() {
					$('.load-album').attr('src', Bilderpfad+'../error_album.png').attr('title', 'Cannot create a album, Database error.').toggle("slow");
					});
				}
			});
			
		}
	// Ende Schritt 2
	
	// Anfang Schritt 3
	else if ($(this).attr('name') == 'Step3' && $('.shopprice').val() != '' && $('#shop_cate').val() != '') {
			$('.Step3').slideUp('slow');
			$('.container').slideDown('slow');
			$('.check3').toggle("slow", function() {
						$('.check3').attr('src', Bilderpfad+'../ok.png').toggle("slow");
					});
					$('.check4').toggle("slow");
	}
	// Ende Schritt 3
	
	// Anfang Schritt 4
	else if ($(this).attr('name') == 'Step4') {
			$('.container').slideUp('slow');
			$('.Step5').slideDown('slow');
			$('.check4').toggle("slow", function() {
						$('.check4').attr('src', Bilderpfad+'../ok.png').toggle("slow");
						$.post(PostDir,{
							ListALL: 'ListALL',
							AlbumID : $('.newalbumID').val()
						}, function(data) {
							$('.pic_liste').html(data);
						});
					});
					$('.check5').toggle("slow");
	}
	// Ende Schritt 4
		else {
			alert(missingfields);
		}
	});
	//Rücklauf
	$("#backward").live('click', function(){
	//Anfang Schritt 1
		if ($(this).attr('name') == 'Step1') {
			$('.Step1').slideDown('slow');
			$('.Step2').slideUp('slow');
			$('.check1').toggle("slow", function() {
			$('.check1').attr('src', Bilderpfad+'../wait.gif').toggle("slow");
			});
			$('.check2').toggle("slow");
		} 
	// Ende Schritt 1
	//Anfang Schritt 1
		else if ($(this).attr('name') == 'Step2') {
			$('.Step2').slideDown('slow');
			$('.Step3').slideUp('slow');
			$('.check2').toggle("slow", function() {
			$('.check2').attr('src', Bilderpfad+'../wait.gif').toggle("slow");
			});
			$('.check3').toggle("slow");
		} 
	// Ende Schritt 1	
	// Anfang Schritt 2	
		else if ($(this).attr('name') == 'Step3') {
			$('.Step3').slideDown('slow');
			$('.container').slideUp('slow');
			$('.check3').toggle("slow", function() {
			$('.check3').attr('src', Bilderpfad+'../wait.gif').toggle("slow");
			});
			$('.check4').toggle("slow");
		}
	// Ende Schritt 2
	// Anfang Schritt 3
		else if ($(this).attr('name') == 'Step4') {
			$('.container').slideDown('slow');
			$('.Step5').slideUp('slow');
			$('.check4').toggle("slow", function() {
			$('.check4').attr('src', Bilderpfad+'../wait.gif').toggle("slow");
			});
			$('.check5').toggle("slow");
		}
	// Ende Schritt 3
	// Ende Schritt 1	
		else {
		alert("Wrong parameters");
		}
	});
	
	// Anfang Select Schritt 1
	$('#albums').live('change', function() {
		$('.whoalbum').val($(this).val());
		if($('.whoalbum').val() != '') {
			$("#forward").css('background-color', '#5BB75B').css('background-image', '-moz-linear-gradient(center top , #62C462,#51A351)');
		} else {
			$("#forward").css('background-color', '#778899').css('background-image', '-moz-linear-gradient(center top , #B0C4DE,#778899)');
		}
		if ($('.whoalbum').val() == 'art-shop') {
			$('#Albkategorie').slideDown("slow");
		} else {
			$('#Albkategorie').slideUp("slow");
		}
	});
	//Ende Select Schritt 1
	
	//Anfang Check Titel Beschreibung Land, Stichwörter
	$('.albumTitle').live('keyup', function() {
	checkalbumfields();
		if ($(this).val().length > 3) {
			$(this).css('background-color', '#98Fb98');
		} else {
			$(this).css('background-color', '#f08080');
		}
	});
	$('.albumDesc').live('keyup', function() {
	checkalbumfields();
		if ($(this).val().length > 20) {
			$(this).css('background-color', '#98Fb98');
		} else {
			$(this).css('background-color', '#f08080');
		}
	});
	$('#albumCat').live('change', function() {
	checkalbumfields();
		if ($(this).val() != '') {
			$(this).css('background-color', '#98Fb98');
		} else {
			$(this).css('background-color', '#f08080');
		}
	});
	$('#albumLand').live('change', function() {
	checkalbumfields();
		if ($(this).val() != '') {
			$(this).css('background-color', '#98Fb98');
		} else {
			$(this).css('background-color', '#f08080');
		}
	});
	$('#seenby').live('change', function() {
	checkalbumfields();
		if ($(this).val() != '') {
			$(this).css('background-color', '#98Fb98');
		} else {
			$(this).css('background-color', '#f08080');
		}
	});
	$('.albumKeywords').live('keyup', function() {
	checkalbumfields();
		if ($(this).val().length > 3) {
			$(this).css('background-color', '#98Fb98');
		} else {
			$(this).css('background-color', '#f08080');
		}
	});
	//Ende Check Titel Beschreibung Land, Stichwörter
	
	//Anfang Check if all Ablums right
	function checkalbumfields() {
		if ($('.albumTitle').val().length > 3 && 
		    $('.albumDesc').val().length > 20 && 
			$('#albumLand').val() != '' &&
			$('#seenby').val() != '' &&
			$('.albumKeywords').val().length > 3) {
			$('div[id="forward"][name="Step2"]').css('background-color', '#5BB75B').css('background-image', '-moz-linear-gradient(center top , #62C462,#51A351)');
			$('.setalbum').val('progress');
		} else {
			$('div[id="forward"][name="Step2"]').css('background-color', '#778899').css('background-image', '-moz-linear-gradient(center top , #B0C4DE,#778899)');
			$('.setalbum').val('');
		}
	
	}
	//Ende Check if all Ablums right
	
	//Anfang Check if all Shop field right
	function checkshopfields() {
	var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
	var price = $('.shopprice').val();
		if (numberRegex.test(price) && price >= '1' && $('#shop_cate').val() != '') {
		$('div[id="forward"][name="Step3"]').css('background-color', '#5BB75B').css('background-image', '-moz-linear-gradient(center top , #62C462,#51A351)');
		} else {
		$('div[id="forward"][name="Step3"]').css('background-color', '#778899').css('background-image', '-moz-linear-gradient(center top , #B0C4DE,#778899)');
		}
	}
	//Ende Check if all Shop field right

	//Anfang Check Price
	$('.shopprice').live('keyup', function() {
	var price = $(this).val();
	var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
		if(numberRegex.test(price) && price >= '1') {
			$(this).css('background-color', '#98Fb98');
			$(this).val(parseFloat(price).toFixed(2));
			
		} else {
			$(this).css('background-color', '#f08080');
		}
		checkshopfields();
	});
	//Ende Check Price
	
	//Anfang Shop Kategorie
	$('#shop_cate').live('change', function() {
		if ($(this).val() != '') {
			$(this).css('background-color', '#98Fb98');
		} else {
			$(this).css('background-color', '#f08080');
		}
		checkshopfields();
	});
	//Ende Shop Kategorie
	
	//Anfang Alle Bilder Speichern
	$('#accept').live('click', function() {
		$('.pic_liste').toggle("slow");
		$('#loading_accept').toggle("slow");
		$('.finish').toggle("slow");
		$('#rulz').toggle("slow");
		$('div[id="accept"][name="accept"]').toggle("slow");
		$('div[id="backward"][name="Step4"]').toggle("slow");
		updateTotal();
		
	});

	//
	var updateTotal = function(){
		if ($('#piclist_wait_loading').attr('class') != 'finish') {
			$('#piclist_wait_loading').attr('src', Bilderpfad+'../wait.gif');
			$.post(PostDir,{
				Saveall: 'SaveALL',
				whoAlbum: $('.whoalbum').val(),
				AlbumID : $('.newalbumID').val(),
				PicPrice: $('.shopprice').val(),
				ShopCate: $('#shop_cate').val(),
				albumTitle: $('.albumTitle').val(),
				albumDesc: $('.albumDesc').val(),
				albumKeywords: $('.albumKeywords').val(),
				seenby: $('#seenby').val(),
				singleImage: $('#piclist_wait_loading').attr('class')
			}, function(data) {
				if (data == 'check') {
				$('#piclist_wait_loading').toggle("slow", function() {
					$('#piclist_wait_loading').attr('src', Bilderpfad+'../ok.png').toggle("slow");
					$('#piclist_wait_loading').attr('id', 'ok');
					updateTotal();
				});		
				
				} else {
				$('#piclist_wait_loading').toggle("slow", function() {
					$('#piclist_wait_loading').attr('src', Bilderpfad+'../error.png').toggle("slow");
					$('#piclist_wait_loading').attr('id', 'failed');
					updateTotal();
				});
				}

			});
		} else if ($('#piclist_wait_loading').attr('class') == 'finish') {
			$('.check5').toggle("slow", function() {
						$('.check5').attr('src', Bilderpfad+'../ok.png').toggle("slow");
					});
			$('#loading_accept').toggle("slow", function() {
						$('#loading_accept').attr('src', Bilderpfad+'../ok.png').toggle("slow");
						$('#loading_accept').attr('title', 'finish');
						$('.finish').html('FINISH');
					});
			$('.pic_liste').toggle("slow");
		}
	}
	//
	
});