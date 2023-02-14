<?php
   /*
   Plugin Name: Meme Generator
   */

   function wpb_demo_shortcode() { 
    $plugin_dir = plugin_dir_url( __FILE__ );
    $ajaxurl = admin_url('admin-ajax.php');
      // Things that you want to do. 
     $message = '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <script src="'.$plugin_dir.'assets/canvas.js"></script>
     <script src="'.$plugin_dir.'assets/meme.js"></script>
     <script src="'.$plugin_dir.'assets/dom-to-image.js"></script>
     <script src="'.$plugin_dir.'assets/html2canvas.js"></script>
     <script src="'.$plugin_dir.'assets/custom.js"></script>
     <link rel="stylesheet" href="'.$plugin_dir.'assets/font-awesome-4.7.0/css/font-awesome.min.css">

        
    
<div class="wholesection">
  <div class="wholebox">
    <div class="leftsection">
	<div class="m-border m-show">
	<h3></i>SELECT PROMPT</h3>
      <div class="box">
        <div class="box-image">
          <img class="borderimage active" data-type="border1" src="'.$plugin_dir.'images/border1.png" />
          <img class="borderimage" data-type="border2" src="'.$plugin_dir.'images/border2.png" />

          
        </div>
      </div>
	  </div>
      <div id="imageCanves">
        <div class="imageCanvasInner">
        <!--<div class="imageOuter"><img class="mainimage" src=""></div>-->
        <img class="borderImage" src="'.$plugin_dir.'images/border1.png">
     <div class="canvasText"></div>
      </div>
      </div>

      <!-- <div id="canvasWrapper">
    
      </div> -->
      
      
    </div> 
    <div class="rightsidesection">
    <!--<h5>Create your own shareable graaphic in 5 easy steps:</h5>
    <ol>
    <li>Select your border color</li>
    <li>Choose with or without text</li>
    <li>Uploadd your image (you can also resize it)</li>
    <li>Press the "create" button</li>
    <li>Downlaod the image andd share on social media with the hashtags #DemandNline #EquityForEveryone</li>
    </ol>-->
    
      <h3 class="m-hide"></i>SELECT PROMPT</h3>
      <div class="box m-hide">
        <div class="box-image">
          <img class="borderimage active" data-type="border1" src="'.$plugin_dir.'images/border1.png" />
          <img class="borderimage" data-type="border2" src="'.$plugin_dir.'images/border2.png" />

          
        </div>
      </div>
      <h3></h3>
      <div class="box">
        <!--<div class="box-input">
          <input type="radio" name="choosefrom" value="EQUITY FOR EVERYONE">
          <label for="Missing You">EQUITY FOR EVERYONE</label>
        </div>
        <div class="box-input">
          <input type="radio" name="choosefrom" value="">
          <label for="Missing You">LEAVE BLANK</label>
        </div>-->
        <div class="box-input">
            <p>WRITE YOUR LETTER</p>
            <input id="textonmeme" style="width: 100%;" class="block" placeholder="Drop a note"  maxlength = "133"/>
        </div>
        
       
      </div>
      <div class="memeInputs">
      <div class="box hidethis">
        <div class="hidethis">
          <p>From URL</p>
          <input id="imgURL" class="block" type="text" placeholder="Link to image" />
        </div>
      </div>
      <h3 class="hidethis">Name</h3>
      <div class="box hidethis">
        <div class="hidethis">
          <p>Top Text</p>
          <input id="textTop" type="text" class="block" placeholder="Top text" />
        </div>
        <div >
            <input id="textBottom" type="text" class="block" placeholder="" />
        </div>
      </div>
      <h3 class="hidethis"><i class="fa fa-text-height fa-fw" aria-hidden="true"></i>Text Size</h3>
      <div class="box hidethis">
        <div>
          <p>Top Text: <span id="textSizeTopOut">10</span></p>
          <input id="textSizeTop" type="range" min="2" max="50" step="2" />
        </div>
      <div>
      <p>Bottom Text: <span id="textSizeBottomOut">10</span></p>
      <input id="textSizeBottom" type="range" min="2" max="50" step="2" />
    </div>
  </div>
</div>
  <div class="box hidethis">
    <div>
      <h3><i class="fa fa-eye fa-fw" aria-hidden="true"></i>Preview Size</h3>
      <input id="trueSize" type="checkbox"/>
      <label for="trueSize"><span>Show true size</span></label>
    </div>
  <div>
  <h3><i class="fa fa-download fa-fw" aria-hidden="true"></i>Export</h3>
  
</div>
</div>
<img src="" class="hidethis finalimg" data-updated="" />
<button id="createimage" style="margin-top: 10px;" data-ajax="'.$ajaxurl.'">Create<i class="fa fa-spinner fa-pulse fa-fw"></i></button>

<div class="sharebtnOuter">
<label>Share on:</label>
<button id="sharefb" class="sharebutton" style="margin-top: 10px;"><i class="fa fa-facebook"></i></button>
<button id="shareTW" class="sharebutton"style="margin-top: 10px;"><i class="fa fa-twitter"></i></button>
<button id="shareemail" class="sharebutton" style="margin-top: 10px;"><i class="fa fa-envelope"></i></button>
<button id="export" class="sharebutton" style="margin-top: 10px;"><i class="fa fa-download"></i></button>
</div>
</div>
</div>
</div>
<style>
@import url("https://fonts.googleapis.com/css2?family=Lobster&display=swap");
@font-face { font-family: Noway-Medium; src: url("'.$plugin_dir.'font/Noway-Medium.otf");  }
</style>
<style>#meme {
  // border: 2px solid #333;
}
body canvas{
	display:none;
}
.box-input label, .canvasText {
    font-family: "Lobster", cursive;
}
.canvasText.canvasText {
    font-size: 30px;
    font-family: "Noway-medium", san-serif;
}
.sharebutton .fa-facebook, .sharebutton .fa-twitter {font-weight: 400 !important;font-family: "Font Awesome 5 Brands";}
button#createimage .fa {
    position: absolute;
    right: 11px;
    font-size: 20px;
    top: 12px;
    display: none;
}
.rightsidesection .box .box-image {
    height: 110px
;
}
button#createimage.loading .fa {
    display: block;
}
.fullwidth {
  width: 100%;
  max-width: 500px;
  max-height: 800px;
}

#imgFile {
  display: none;
}
.sharebtnOuter {
    margin-top: 15px;
}

.sharebtnOuter label {
    display: block;
}
button#createimage:hover {
    background: #000;
    color: #fff;
}
button#export.sharebutton {
    border-radius: 50%;
    padding: 0;
    font-size:22px;
}

.uploadImage:hover, button#export:hover {
    background: #002352;
}

.rangerimageslider {
    margin-top: 15px;
}


.wholesection h1 {
    background: #77b699;
    color: #fff;
    padding: 25px 20px;
    text-align: center;
    font-family: "staatliches-regular";
    font-weight: 200;
    font-size: 45px;
    margin-bottom: 60px;
}
.memeInputs input {
    max-width: 260px;
    font-size:28px;
    background: transparent;
}
.imageCanvasInner, .rightsidesection .box .box-image img {
    background: #fff;
}
.page-id-6294 main#lqd-site-content {
    background: #e8e9db;
}
.sharebutton {
    border: 0;
    background: #3b5998;
    width: 44px;
    height: 44px;
    font-size: 20px;
    border-radius: 50%;
    color: #fff;
    margin-bottom: 0;
    margin-top: 0 !important;
    text-align: center;
}


.uploadImage:hover, button#export:hover {
    background: #002352;
}
button#shareTW {
    background: #1da1f2;
}

button#shareemail {
    background: #EB0D8C;
}


h3 > i.fa {
  margin-right: .2em;
}.hidethis{ display:none;} 
/* meme */
.wholebox {
display: flex;
       max-width: 900px;
    margin: 70px auto;
}
.box-input label {
    font-size: 24px;
    margin: 6px 0;
}

.leftsection {
  width: 65%;
}

.rightsidesection {
    width: 35%;
    padding-left: 5%;
}

div#canvasWrapper canvas {
    position: absolute;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
    margin: 0;
    max-width: initial;
    max-height: initial;
}

div#canvasWrapper {
    width: 100%;
    height: 0;
    padding-bottom: 100%;
    position: relative;
}

.rightsidesection .box .box-image,
.m-border .box .box-image{
    display: flex;
}

.rightsidesection .box .box-image img,
.m-border .box .box-image img{
    max-width: 120px;
    margin-right: 20px;
    width: 40%
}

.rightsidesection h3, .m-border h3, .box-input p {
    font-family: "Noway Italic", san-serif;
    font-weight: 500;
    text-transform: uppercase;
    color: #0AD2F1;
    font-size: 24px;
    line-height: 1.4;
    letter-spacing: 0px;
}
.m-border{
margin-bottom: 20px;
}
.rightsidesection .box .box-image img.active,
.m-border .box .box-image img.active{
    box-shadow: 0px 0px 0px 2px #063a6c;
}
.memeInputs input {
    padding: 5px 10px;
    border: 1px solid #063a6c;
}
div#imageCanves {
    height: 0;
    padding-bottom: 100%;
    position: relative;
}

.imageCanvasInner {
    position: absolute;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
    overflow: hidden;
}

.imageCanvasInner img {
    width: 100%;
    height: 100%;
    position: absolute;
    object-fit: contain;
}
.imageOuter {
    text-align: center;
}
.imageCanvasInner img.mainimage {
    max-width: initial;
    object-fit: initial;
    height: auto;
    position: relative;

}
.imageCanvasInner {
    display: flex;
    align-items: center;
    justify-content: center;
}

.imageCanvasInner {}

.imageCanvasInner img.borderImage {
    z-index: 0;
}
.uploadImage, button#export {
    background: #EB0D8C;
    color: #fff;
    font-weight: normal;
    font-size: 14px;
    padding: 10px 20px;
    border-radius: 5px;
    margin-top: 30px;
    border: 0;
    cursor: pointer;
}
/*.canvasText {
    position: absolute;
   
    left: 18%;
    width: 63%;
    z-index: 2;
    padding: 8% 0px;
    font-size: 20px;
    align-items: center;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
    text-align: center;
    top: 40%;
    color:#fff;
}*/
.canvasText{
    position: absolute;
    left: 0;
    width: 100%;
    z-index: 2;
    padding: 0% 10%;
    font-size: 20px;
    align-items: center;
    /* white-space: nowrap; */
    /* text-overflow: ellipsis; */
    overflow: hidden;
    text-align: center;
    top: 50%;
    color: #fff;
    transform: translateY(-20%);
    max-height: 30%;
}
button#createimage {
	width: 100%;
    position: relative;
    -webkit-transition: all 0.25s ease;
    -moz-transition: all 0.25s ease;
    -ms-transition: all 0.25s ease;
    -o-transition: all 0.25s ease;
    transition: all 0.25s ease;
    display: inline-block;
    background-color: #EB0D8C;
    border: 2px solid #EB0D8C;
    color: #fff;
    padding: 10px 25px;
    border-radius: 0;
    font-family: "Noway Italic", san-serif;
    text-transform: uppercase;
    font-weight: 700;
}
button#createimage:hover {
    background-color: #fff;
    border: 2px solid #EB0D8C;
    color: #EB0D8C;
    text-decoration: none;
}
.changecanvastext .canvasText{
    bottom:9% !important;
}
.leftsection {
    margin-bottom: 60px;
}
button#export {
    font-size: 18px !important;
}
.m-show{
display: none;
}
button#shareemail:hover,button#export:hover {
    color: #EB0D8C;
    background: white;
    border: 1px solid #EB0D8C;
}

@media all and (max-width: 767px){
.m-hide{
display: none;
}
.m-show{
display: block;
}
}
@media all and (max-width: 700px){
  .wholebox{
        flex-direction: column;
    align-items: center;
    margin-bottom: 50px !important;
  }
  .leftsection, .rightsidesection {
    width: 100%;
    padding: 0;
}
button#export.sharebutton, .sharebutton {
    font-size: 24px !important;
}
}
@media all and (max-width: 768px){
    .canvasText.canvasText {
    font-size: 22px;
}

}
@media all and (max-width: 600px){
    .canvasText.canvasText {
    font-size: 28px;
}

@media all and (max-width: 400px){
    .canvasText.canvasText {
    font-size: 18px;
}

}
@media all and (max-width: 360px){
    .canvasText.canvasText {
    font-size: 18px;
}

}
</style>

<script type="text/javascript">
    jQuery(document).ready(function(){
        

        jQuery("#textonmeme").keyup(function() {
           
           var dInput = this.value;
           console.log(dInput);
           jQuery(".canvasText").html(dInput);    
          
        });
    });
</script>'; 

      return $message;
   }

   add_shortcode('meme_code', 'wpb_demo_shortcode');

add_action("wp_ajax_upload_image_to_server", "upload_image_to_server");
add_action("wp_ajax_nopriv_upload_image_to_server", "upload_image_to_server");
// define the function to be fired for logged in users
function upload_image_to_server() {
    $base64_img = $_POST['pid'];
    if($base64_img){
      //echo $base64_img;

    }else{
     // echo "hi";
    }
    $title = 'meme-image';
        //HANDLE UPLOADED FILE
    $upload_dir = wp_upload_dir();
    $upload_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;
    $image_parts = explode(";base64,",$_POST['pid']);
    $decoded = base64_decode($image_parts[1]);
    $filename = 'Meme.png';
    $hashed_filename = md5( $filename . microtime() ) . '_' . $filename;
    $image_upload = file_put_contents( $upload_path . $hashed_filename, $decoded ); 
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');


        // Without that I'm getting a debug error!?




        $file             = array();
        $file['error']    = '';
        $file['tmp_name'] = $upload_path . $hashed_filename;
        $file['name']     = $hashed_filename;
        $file['type']     = 'image/png';
        $file['size']     = filesize( $upload_path . $hashed_filename );
        // upload file to server

        // use $file instead of $image_upload
        $file_return = wp_handle_sideload( $file, array( 'test_form' => false ) );
        $filename = $file_return['file'];
        $attachment = array(
                                             'post_mime_type' => $file_return['type'],
                                             'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                                             'post_content' => '',
                                             'post_status' => 'inherit',
                                             'guid' => $wp_upload_dir['url'] . '/' . basename($filename)
                                             );



         $attach_id = wp_insert_attachment( $attachment, $filename );
        /// generate thumbnails of newly uploaded image



    $URL = wp_get_attachment_url($attach_id);
    echo $URL;
    die();
}

?>