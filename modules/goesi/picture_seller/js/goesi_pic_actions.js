$(document).ready(function(){
//////Anfang
      
      $('.gruppe').live('click', function() {
      //Gruppe ändern
       $('#loading').attr('src', Bilderpfad+'ajax-loader.gif').css('display', 'inline');
       if ($(this).attr('checked') == 'checked') {
          $.post(PostDir,{ gruppe_checked: 'yes', group_value: $(this).val()},
            function(data){ if (data == 'checked') {
                                      $("#loading").attr('src', Bilderpfad+'ajax-loader-ok.png').fadeOut(1000);
                                   } else {
                                      $("#loading").attr('src', Bilderpfad+'ajax-loader-no.png').fadeOut(2000);
                                   }   
          });
       } else {
        $.post(PostDir,{ gruppe_checked: 'no', group_value: $(this).val()},
            function(data){ if (data == 'unchecked') {
                                      $("#loading").attr('src', Bilderpfad+'ajax-loader-ok.png').fadeOut(1000);
                                   } else {
                                      $("#loading").attr('src', Bilderpfad+'ajax-loader-no.png').fadeOut(2000);
                                   } 

          });
       } 
       
      });
      
      $('#selector').live('change', function() {
      // Auto Freischalten
      $('#loading').attr('src', Bilderpfad+'ajax-loader.gif').css('display', 'inline');
      $.post(PostDir,{ action_selector: $(this).attr('name'), value: $(this).val()},
            function(data){ if (data == 'selected') {
                                    $("#loading").attr('src', Bilderpfad+'ajax-loader-ok.png').fadeOut(1000); 
                                    } else {
                                    $("#loading").attr('src', Bilderpfad+'ajax-loader-no.png').fadeOut(2000);
                                    }
          });
      
      });
      
      $('.watermarks').live('click', function() {
      //wasserzeichen ändern
       $('#loading').attr('src', Bilderpfad+'ajax-loader.gif').css('display', 'inline');
       if ($(this).attr('checked') == 'checked') {
												$('.watermarks').attr('checked', false);
												$(this).attr('checked', true);
                                      
          $.post(PostDir,{ water_checked: 'yes', water_value: $(this).val()},
            function(data){ if (data == 'water_checked') {
                                      $("#loading").attr('src', Bilderpfad+'ajax-loader-ok.png').fadeOut(1000);
                                   } else {
                                      $("#loading").attr('src', Bilderpfad+'ajax-loader-no.png').fadeOut(2000);
                                   }   
          });
       } else {
        $.post(PostDir,{ water_checked: 'no', water_value: $(this).val()},
            function(data){ if (data == 'water_unchecked') {
                                      $("#loading").attr('src', Bilderpfad+'ajax-loader-ok.png').fadeOut(1000);
                                   } else {
                                      $("#loading").attr('src', Bilderpfad+'ajax-loader-no.png').fadeOut(2000);
                                   } 

          });
       } 
       
      });
     
	$('#quality').live('change', function() {
	//transparenz
	$('#loading').attr('src', Bilderpfad+'ajax-loader.gif').css('display', 'inline');
	$.post(PostDir,{ quality_selector: 'changes', value: $(this).val()},
            function(data){ if (data == 'changed') {
                                    $("#loading").attr('src', Bilderpfad+'ajax-loader-ok.png').fadeOut(1000); 
                                    } else {
                                    $("#loading").attr('src', Bilderpfad+'ajax-loader-no.png').fadeOut(2000);
                                    }
          });
	});
	
	$('.reload_pic').live('click', function() {
	//reload picture
	$('#loading').attr('src', Bilderpfad+'ajax-loader.gif').css('display', 'inline');
		$.post(PostDir,{ create_watermark: 'beginn_works', demo_files: 'demo-test'},
            function(data){ if (data == 'watermark_set') {
									var ts = Math.round((new Date()).getTime() / 1000);
                                    $("#loading").attr('src', Bilderpfad+'ajax-loader-ok.png').fadeOut(1000);
									$('.bild').attr('src', Bilderpfad+'../finish_picture.jpg?'+ts);
                                    } else {
                                    $("#loading").attr('src', Bilderpfad+'ajax-loader-no.png').fadeOut(2000);
									$('.bild').attr('src', Bilderpfad+'../demo_file.jpg');
                                    }
          });
	});

////7/Ende
});