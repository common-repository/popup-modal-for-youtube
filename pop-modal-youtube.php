<?php
/**
 * Plugin Name: Popup Modal For Youtube
 * Plugin URI: https://troplr.com/
 * Description: Show youtube video in a modal when posts/page loads.
 * Version: 1.0.1
 * Author: Troplr
 * Author URI: https://troplr.com
 * Requires at least: 4.5
 * Tested up to: 4.7
 *
 * Text Domain: troplr
 *
 */

require_once('titan-framework/titan-framework-embedder.php');

/*
 function ytc_jquery(){
wp_enqueue_script('jquery', false, array(), false, false);
}
add_filter('wp_enqueue_scripts','ytc_jquery',1);*/



function ytccss_dep() {

wp_register_style( 'ytcmodal-css', plugins_url('script/ytcmodal.css', __FILE__) );
 wp_enqueue_style( 'ytcmodal-css' );
}
add_action( 'wp_enqueue_scripts', 'ytccss_dep' );

function ytcjs_dep() {
  wp_register_script( 'ytcmodal-js', plugins_url('script/ytcmodal.js', __FILE__),false, '1.0', true );
   wp_enqueue_script( 'ytcmodal-js' );
}
add_action('wp_enqueue_scripts', 'ytcjs_dep');



add_action( 'tf_create_options', 'pmy_metabox_options' );
 function pmy_metabox_options() {
 
    // Initialize Titan with your theme name.
    $titan = TitanFramework::getInstance( 'vtc-opts' );
 
    /**
     * First metabox.
     */
 
    $aa_metbox = $titan->createMetaBox( array(
        'name'      => 'Youtube Video in Modal', // Name the options menu.
        'post_type' => array( 'page', 'post' ) // Can be a string or array.
    ) );

    $aa_metbox->createOption( array(
    'id'   => 'youtube_url', // The id which will be used to get the value of this option.
    'type' => 'text', // Type of option we are creating.
    'name' => 'Insert Youtube URL', // Name of the option which will be displayed in the admin panel.
    'desc' => 'E.X: https://www.youtube.com/watch?v=yo4pmauhugo' // Description of the option which will be displayed in the admin panel.
) );
 
}


add_action( 'tf_create_options', 'ytc_opt' );
function ytc_opt() {
// Initialize Titan & options here

 $titan = TitanFramework::getInstance( 'vtc-opt' );


//add_action( 'tf_create_options', 'pmy_metabox_options' );
 


 $panel = $titan->createAdminPanel( array(
'name' => 'Popup Modal Youtube',
) );

$generalTab = $panel->createTab( array(
'name' => 'Settings',
) );

$generalTab->createOption(  array(
'name' => 'Youtube API KEY',
'id' => 'api_key',
'type' => 'text',
'desc' => 'E.G: AIzaSyBwsfcnP28bAgjA5ERlZ4xdoBqAsEJaS-M. <a target="_blank" href="https://elfsight.com/blog/2016/12/how-to-get-youtube-api-key-tutorial/">How To Get API Key</a>'
) );

$generalTab->createOption(  array(
'name' => 'Video Width',
'id' => 'video_width',
'type' => 'text',
'desc' => 'E.G: 500'
) );

$generalTab->createOption(  array(
'name' => 'Video Height',
'id' => 'video_height',
'type' => 'text',
'desc' => 'E.G: 400'
) );

$generalTab->createOption(  array(
'name' => 'Popup Background',
'id' => 'pop_bg',
'type' => 'color',
'alpha' => true,

) );

$generalTab->createOption(  array(
'name' => 'AutoClose Popup Modal',
'id' => 'auto_close',
'type' => 'select',
'options' => array(    //An array of value-label pairs which appears as options
 
                        '1' => 'Yes',
 
                        '0' => 'No',
                            
                    ),
 
        'default' => '1',
        'desc' => 'AutoClose the popup modal after video is finished playing.',
) );


$generalTab->createOption(  array(
'name' => 'Autoplay On Page Load',
'id' => 'auto_play',
'type' => 'select',
'options' => array(    //An array of value-label pairs which appears as options
 
                        '1' => 'Yes',
 
                        '0' => 'No',
                            
                    ),
 
        'default' => '1',
) );

$generalTab->createOption(  array(
'name' => 'Show Youtube Controls',
'id' => 'ycontrols',
'type' => 'select',
'options' => array(    //An array of value-label pairs which appears as options
 
                        '1' => 'Yes',
 
                        '0' => 'No',
                            
                    ),
 
        'default' => '1',
) );

$generalTab->createOption(  array(
'name' => 'Hide Close Button',
'id' => 'h_closebutton',
'type' => 'select',
'options' => array(    //An array of value-label pairs which appears as options
 
                        '1' => 'Yes',
 
                        '0' => 'No',
                            
                    ),
 
        'default' => '1',
'desc' => 'Hides close button while the video is playing'
) );

$generalTab->createOption(  array(
'name' => 'Close Button Background',
'id' => 'ytc_close_sty',
'type' => 'color',
'alpha' => true,

) );

$generalTab->createOption(  array(
'name' => 'Close Button Text Color',
'id' => 'ytc_close_sty_text',
'type' => 'color',
'alpha' => true,

) );

$generalTab->createOption(  array(
'name' => 'Enable Cookies',
'id' => 'enable_cookie',
'type' => 'text',
'default' => '0',
'desc' => 'In Days.'

) );



$generalTab->createOption( array(
'type' => 'save'
) );

$generalTab->createOption( array(
'name' => '',
'id' => 'pmypay',
'type' => 'note',
'desc' => 'Thankyou for using <b>Popup Modal For Youtube</b>.<br>You may want to support my development: <a target="_blank" href="https://paypal.me/sandeeptete">Paypal me a tip</a>'
) );

$generalTab->createOption(  array(
'name' => '',
'id' => 'pmy_message_grid',
'type' => 'note',
'desc' => 'You may find other plugins from us to be useful below.<br><div class="autowide">
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/categories-gallery/">Bootstrap Categories Gallery</a></b></p>
  </div>
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/custom-scroll-bar-designer/">Custom Scrollbar Designer</a></b></p>
  </div>
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/custom-text-selection-colors/">Custom Text Selection Colors</a></b></p>
  </div>
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/disable-image-right-click/">Disable Image Right Click</a></b></p>
  </div>
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/easy-gallery-slideshow/">Easy Gallery Slideshow</a></b></p>
  </div>
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/exit-popup-show/">Exit Popup Show</a></b></p>
  </div>
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/popup-modal-for-youtube/">Popup Modal For Youtube</a></b></p>
  </div>
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/woo-availability-date/">Product Limited Time Availability Date for woocommerce</a></b></p>
  </div>
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/email-my-posts/">Share Posts To Email</a></b></p>
  </div>
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/custom-scroll-bar-designer/">Share Woocommerce to Email</a></b></p>
  </div>
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/share-woocommerce-email/">Custom Scrollbar Designer</a></b></p>
  </div>
  <div class="module">
    <p><b><a href="https://wordpress.org/plugins/total-sales-for-woocommerce/">Total Sales For Woocommerce</a></b></p>
  </div>
</div>'
) );
}

function pmy_customcss()
{
  $pmycss = '<style>.autowide {
  margin: 0 auto;
  width: 98%;
}
.autowide img {
  float: left;
  margin: 0 .75rem 0 0;
}
.autowide .module {
  xbackground-color: lightgrey;
  border-radius: .25rem;
  margin-bottom: 1rem;
  color: #0f8cbb;
}
.autowide .module p {
  padding: 4px 0px;
}

/* 2 columns: 600px */
@media only screen and (min-width: 600px) {
  .autowide .module {
    float: left;
    margin-right: 2.564102564102564%;
    width: 48.717948717948715%;
  }
  .autowide .module:nth-child(2n+0) {
    margin-right: 0;
  }
}

/* 3 columns: 768px */
@media only screen and (min-width: 768px) {
  .autowide .module {
    width: 31.623931623931625%;
  }
  .autowide .module:nth-child(2n+0) {
    margin-right: 2.564102564102564%;
  }
  .autowide .module:nth-child(3n+0) {
    margin-right: 0;
  }
}

/* 4 columns: 992px and up */
@media only screen and (min-width: 992px) {
  .autowide .module {
    width: 23.076923076923077%;
  }
  .autowide .module:nth-child(3n+0) {
    margin-right: 2.564102564102564%;
  }
  .autowide .module:nth-child(4n+0) {
    margin-right: 0;
  }
}</style>';
echo $pmycss;

}
add_action('admin_head','pmy_customcss');


function ytc_youtube_id_from_url() {
  if ( !class_exists('TitanFramework') ) {
return false;
}
  $titan = TitanFramework::getInstance( 'vtc-opts' );
$youtube_url = $titan->getOption( 'youtube_url',get_the_ID() );
            $pattern = 
                '%^# Match any youtube URL
                (?:https?://)?  # Optional scheme. Either http or https
                (?:www\.)?      # Optional www subdomain
                (?:             # Group host alternatives
                  youtu\.be/    # Either youtu.be,
                | youtube\.com  # or youtube.com
                  (?:           # Group path alternatives
                    /embed/     # Either /embed/
                  | /v/         # or /v/
                  | /watch\?v=  # or /watch\?v=
                  )             # End path alternatives.
                )               # End host alternatives.
                ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
                $%x'
                ;
            $result = preg_match($pattern, $youtube_url, $matches);
            if ($result) {
                return $matches[1];
                //$ids = $matches[1];
            }
            return false;

        }


//add_action('wp_footer','ytc_get_result');
function ytc_get_result(){
  if ( !class_exists('TitanFramework') ) {
return false;
}
$titan = TitanFramework::getInstance( 'vtc-opt' );
$api_key = $titan->getOption( 'api_key' );
 // do conditional stuff here
$data = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id=".ytc_youtube_id_from_url()."&key=".$api_key."&part=snippet,contentDetails,statistics,status");
$result = json_decode($data, true);

//print_r($result);
foreach ($result['items'] as $vidTime) {
    $vTime= $vidTime['contentDetails']['duration'];
}
//return $vTime;
$vidtimeformat = $vTime;


$totaltime = new DateInterval($vTime);
$totaltime->format('%H:%i:%s');

$vseconds = $totaltime->h*3600 
           + $totaltime->i*60 + $totaltime->s;

$vmilliseconds = $vseconds * 1000+7000;

           return $vmilliseconds;

//echo "SECCCC".$vTime;


}

add_action('wp_head','ytc_pophead');
function ytc_pophead(){
  ?>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript">

       $(document).ready(function(){
        //Examples of how to assign the Colorbox event to elements
        $(".group1").colorbox({rel:'group1'});
        $(".group2").colorbox({rel:'group2', transition:"fade"});
        $(".group3").colorbox({rel:'group3', transition:"none", width:"75%", height:"75%"});
        $(".group4").colorbox({rel:'group4', slideshow:true});
        $(".ajax").colorbox();
        $(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
        $(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
        $(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
        $(".inline").colorbox({inline:true, width:"50%"});
        $(".callbacks").colorbox({
          onOpen:function(){ alert('onOpen: colorbox is about to open'); },
          onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
          onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
          onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
          onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
        });

        $('.non-retina').colorbox({rel:'group5', transition:'none'})
        $('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});
        
        //Example of preserving a JavaScript event for inline calls.
        $("#click").click(function(){ 
          $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
          return false;
        });
      });

  </script> 
<?php
}



//add_action('wp_head','ytc_vid_show');
function ytc_vid_show()
{
  if ( !class_exists('TitanFramework') ) {
return false;
}
  $titan = TitanFramework::getInstance( 'vtc-opt' );
  $ywidth = $titan->getOption( 'video_width');
  $yheight = $titan->getOption( 'video_height');
  $ytcc = ytc_youtube_id_from_url();
  $auto_play = $titan->getOption( 'auto_play');
  $enable_cookie = $titan->getOption( 'enable_cookie');
  if ($auto_play == 1){
    $aushow = "1";
  }
  elseif($auto_play == 0){
    $aushow = "0"; 

  }
  $ycontrols = $titan->getOption( 'ycontrols');
  if ($ycontrols == 1){
    $contr = "1";
  }
  elseif($ycontrols == 0){
    $contr = "0"; 

  }
  $ncookie = $enable_cookie;
  ?>
    <script type="text/javascript">
        $(document).ready(function(){
         var ytcc = "<?php echo $ytcc; ?>";
         var ywidth = "<?php echo $ywidth;?>";
         var yheight = "<?php echo $yheight;?>"; 
         var yautoplay = "<?php echo $aushow;?>"; 
         var contr = "<?php echo $contr;?>";
         var ncookie = "<?php echo $ncookie;?>"; 
         if (document.cookie.indexOf('visited=true') == -1) {
        var fifteenDays = 1000*60*60*24*ncookie;
        var expires = new Date((new Date()).valueOf() + fifteenDays);
        document.cookie = "visited=true;expires=" + expires.toUTCString();
    $.colorbox({iframe:true, href:"https://www.youtube.com/embed/"+ytcc+"?autoplay="+yautoplay+"&controls="+contr+"&rel=0&amp;wmode=transparent",innerWidth: ywidth,
        innerHeight: yheight, 
        fixed: true, 
        overlayClose: false});
  }
});

    </script>
<?php
}

add_action('wp_head','ytc_show_posts');
function ytc_show_posts(){
  if ( !class_exists('TitanFramework') ) {
return false;
}
$titan = TitanFramework::getInstance( 'vtc-opts' ); 
$yurl = $titan->getOption( 'youtube_url', get_the_ID() );

if ( ! empty( $yurl ) ) {
    echo ytc_vid_show();
}

}



add_action('wp_head','ytc_bg');
function ytc_bg(){
  if ( !class_exists('TitanFramework') ) {
return false;
}
  $titan = TitanFramework::getInstance( 'vtc-opt' ); 
$pop_bg = $titan->getOption( 'pop_bg');
 
 $ytc_style = "<style type=text/css>
    #cboxOverlay
    {
          background:".$pop_bg."!important;
    }
  </style>";

echo $ytc_style;
}



function ytc_sec_close(){
  if ( !class_exists('TitanFramework') ) {
return false;
}
  $titan = TitanFramework::getInstance( 'vtc-opt' ); 
      $auto_close = $titan->getOption( 'auto_close');

  $secc = ytc_get_result();

  
  $ytcclose = "<script type='text/javascript'>
  var ysec =".$secc.";
    window.setTimeout(function() {
    $.colorbox.close();
}, ysec);
  </script>";

  echo $ytcclose;

}


add_action('wp_head','ytc_auto_close');
function ytc_auto_close(){
  if ( !class_exists('TitanFramework') ) {
return false;
}
    $titan = TitanFramework::getInstance( 'vtc-opt' ); 
    $auto_close = $titan->getOption( 'auto_close');
    if($auto_close == 1){
  echo ytc_sec_close();
  }
  
}


function ytc_closebutton(){
  if ( !class_exists('TitanFramework') ) {
return false;
}
$titan = TitanFramework::getInstance( 'vtc-opt' ); 
  $secc = ytc_get_result();
$ytc_clb = "<script type='text/javascript'>
var ysec =".$secc.";
$(document).ready(function() {
    $('#cboxClose').hide();
});

setTimeout(function() { 
  $('#cboxClose')
  .show();
   },ysec);
  </script>";

  echo $ytc_clb;

}

add_action('wp_head','ytc_close_btn');
function ytc_close_btn(){
  if ( !class_exists('TitanFramework') ) {
return false;
}
    $titan = TitanFramework::getInstance( 'vtc-opt' ); 
    $h_closebutton = $titan->getOption( 'h_closebutton');
    if($h_closebutton == 1){
  echo ytc_closebutton();
  }
  
}


add_action('wp_head','ytc_close_style');
function ytc_close_style(){
  if ( !class_exists('TitanFramework') ) {
return false;
}
    $titan = TitanFramework::getInstance( 'vtc-opt' ); 
    $ytc_close_sty = $titan->getOption( 'ytc_close_sty');
    $ytc_close_sty_text = $titan->getOption( 'ytc_close_sty_text');
   ?>
   <style type="text/css">
     #cboxClose {
    position: absolute!important;
    top: 0!important;
    right: 0!important;
    display: block!important;
    color: <?php echo $ytc_close_sty_text;?>!important;
    background: <?php echo $ytc_close_sty;?>!important;
    padding: 18px!important;
    border-radius: 6px!important;
    font-weight: bold!important;
    width: 98px!important;
    font-size: 16px;
    height: 66px!important;
    text-indent: 0!important;
}
   </style>
   <?php
  }
  




?>