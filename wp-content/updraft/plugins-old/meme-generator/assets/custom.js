
jQuery(document).ready(function( $ ){
  jQuery('.sharebtnOuter').hide();
   jQuery('#export').hide();
   jQuery('#export').click(function(){
     	var getsrc = jQuery('.finalimg').attr('src');
     	//var link = document.createElement('a');
        //link.href = getsrc;
        //link.download = 'Meme.png';
        //document.body.appendChild(link)
;
        //link.click();
        //document.body.removeChild(link)
;
       imgWindow = window.open(getsrc, 'imgWindow');
   });
   jQuery(document).on('input change', '#vol', function() {
     var size = jQuery(this).val();
     //alert(size);
     if(size >100){
         var extra = size - 100;
         var finalval = extra/2;
          jQuery('.mainimage').attr('style','width:'+size+'%;height:'+size+'%;left:-'+finalval+'%;top:-'+finalval+'%;');
     }
     else{
        jQuery('.mainimage').attr('style','width:'+size+'%;height:'+size+'%;');
     }
    
    //jQuery('#slider_value').html( jQuery(this).val() );
});
    jQuery('.rightsidesection .borderimage').click(function(){
      	var savethis = jQuery(this);
       jQuery('.rightsidesection .borderimage').removeClass('active');
       savethis.addClass('active');
       var getimgsrc = jQuery(this).attr('src');
     // alert(getimgsrc);
      	jQuery('.imageCanvasInner .borderImage').attr('src',getimgsrc);
   		var checkbordertype = jQuery(this).attr('data-type');
      if(checkbordertype == 'border1'){
       	jQuery('.imageCanvasInner').removeClass('changecanvastext');
      }
      else{
        jQuery('.imageCanvasInner').addClass('changecanvastext');
      }
       //reader.readAsDataURL(getimgsrc);
     });
  	jQuery('#textBottom').keyup(function() {
      var dInput = this.value;
      console.log(dInput);
      
       var getradiovalue = jQuery(".box-input input[type='radio']:checked").val();
      if(getradiovalue == undefined){
        jQuery(".canvasText").html(dInput);
      }
      else{
        jQuery(".canvasText").html(getradiovalue+' '+dInput);
      }
      
  	});
    /*jQuery('#textonmeme').keyup(function() {
      alert('here');
      var dInput = this.value;
      console.log(dInput);
      
      //var getradiovalue = jQuery(".box-input input[type='radio']:checked").val();
      //if(getradiovalue == undefined){
        jQuery(".canvasText").html(dInput);
      //}
      //else{
      //  jQuery(".canvasText").html(getradiovalue+' '+dInput);
      //}
      
    });*/
   jQuery(".box-input input[type='radio']").click(function(){
      //alert('You clicked radio!');
      var getvalue = jQuery(this).val();
       var gettextfieldvalue = jQuery('#textBottom').val();
      var finaltext = getvalue+' '+gettextfieldvalue;
      jQuery(".canvasText").html(finaltext);
  });
	// jQuery(".box-input input[value='Missing You']").prop("checked", true);
  jQuery(".box-input:first-child input[type='radio']").trigger('click');
  jQuery("#sharefb").click(function(e){
    var checkcreated = jQuery('img.finalimg').attr('data-updated');
    if(checkcreated != ''){
     var u=jQuery('img.finalimg').attr('src');
      var  t='';
          
    		window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;
    }
  		
   });
  jQuery("#shareTW").click(function(e){
    var checkcreated = jQuery('img.finalimg').attr('data-updated');
    if(checkcreated != ''){
      var url=jQuery('img.finalimg').attr('src');
          
			var text = "";
		window.open('http://twitter.com/share?url='+encodeURIComponent(url)+'&text='+encodeURIComponent(text), '', 'left=0,top=0,width=550,height=450,personalbar=0,toolbar=0,scrollbars=0,resizable=0');

    }
  		
   });
  jQuery("#shareemail").click(function(e){
    var checkcreated = jQuery('img.finalimg').attr('data-updated');
    if(checkcreated != ''){
      var url=jQuery('img.finalimg').attr('src');
          
			var email = 'test@theearth.com';
    var subject = 'Circle Around';
    var emailBody = '<img src="'+url+'" />';
    window.location = 'mailto:' + + '?subject=' + + '&body=' +   url;

    }
  		
   });
   jQuery("#createimage").click(function(e){
     e.preventDefault();
     jQuery(this).addClass("loading");
     jQuery('.sharebtnOuter').hide();
     jQuery('#export').hide();
     html2canvas(document.querySelector("#imageCanves")).then(canvas => {
       document.body.appendChild(canvas);
       var can = document.getElementsByTagName("canvas");
       var imagenew  = canvas.toDataURL();
       var image = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");  // here is the most important part because if you dont replace you will get a DOM 18 exception.
	

    var ajaxurl = jQuery(this).attr('data-ajax');
      jQuery.ajax({
        type : "post",
        url : ajaxurl,
        data : {action: "upload_image_to_server",pid: image},
        success: function(response) {
         
          jQuery('img.finalimg').attr('src',response);
          jQuery('img.finalimg').attr('data-updated','yes');
        
          jQuery('.sharebtnOuter').show();
           jQuery('#export').show();
           jQuery("#createimage").removeClass("loading");
        }
  });
        
     });
     return false;
   });
                                                             
                                             
  
   });
function readURL(input) {
     if (input.files && input.files[0]) {
       var reader = new FileReader();

       reader.onload = function (e) {
         jQuery('.imageCanvasInner .mainimage')
           .attr('src', e.target.result);
       };

       reader.readAsDataURL(input.files[0]);
     }
   }
