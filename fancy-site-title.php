<?php
/*
Plugin Name:  Fancy Website Title
Plugin URI: http://hasnath.net/wordpress-fancy-title-plugin.php
Description: This plugin lets the site title animate, and offers a shortcode to use it in any content on your page. Enjoy!
Version: 1.0
Author: Shamim Hasnath
Author URI: http://hasnath.net

*/

$wp_fancy_titleops = get_option('wp_fancy_title');


add_action('wp_footer', 'addToFooterFST');

add_action('wp_head', 'add_fanscripthead');

add_action('admin_menu', 'adding_option_pageFST');

function adding_option_pageFST(){
    add_options_page('Fancy Site Title', 'Fancy Site Title', 'manage_options', 'fancy-site-title', 'option_pageFST');
    add_action('admin_init', 'register_settingsFST');
}

function register_settingsFST() {  
    register_setting('fancy-title-option-grp', 'wp_fancy_title'); 
}

///wp_enqueue_script('fancy_title', WP_PLUGIN_URL.'/fancy-site-title/fancy_title.js', array('jquery'),'',true);
// wp_enqueue creates a problem, so,
function add_fanscripthead(){
	echo "<script type='text/javascript' src='".WP_PLUGIN_URL."/fancy-site-title/wp-fancy.js'></script>";

}
function addToFooterFST(){
    
    $ops = get_option('wp_fancy_title');
    if( $ops['disable'] != 'on'){
	if($ops['disloop'] != 'on') $loopy = 1; else $loopy = 0;
	if(strlen($ops['speed']) < 1) $speedy = 120; else $speedy = $ops['speed'];
		echo "<script> fancyTitle($loopy, $speedy); </script> ";
	
	} 
}
function option_pageFST() {

    ?>
   <style type='text/css'>
h3 { padding: 10px;  }
.fbds {padding: 5px 0 15px 15px; }
.in1{ width: 300px; }
.in2{width: 150px; }
label { font-weight: bold; margin: 15px 0 0 0; }
input { margin-top: 15px; }
.copr { font-weight: bold; line-height: 15px }
.note { color: #B93217; }
</style>
    <div class='wrap'>
    <?php
    /* =======================================
    //      Settings
    //======================================== */ ?>
        <div class='postbox'>
            <h3>Global Settings</h3>
            <div class='fbds'>
           
        <form method="post" action="options.php"> 
                    <?php settings_fields('fancy-title-option-grp'); ?>
                    <?php $ops = get_option('wp_fancy_title'); ?>
           <input  type='checkbox' id='wp_fancy_title[disable]'  name='wp_fancy_title[disable]' <?php checked($ops['disable'], 'on'); ?> />
         <label for='wp_fancy_title[disable]'>Disable Animating Website Title</label> (If you don't want this plugin to work for your website title, select this)<br/>
	<input  type='checkbox' id='wp_fancy_title[disloop]'  name='wp_fancy_title[disloop]' <?php checked($ops['disloop'], 'on'); ?> />
         <label for='wp_fancy_title[disloop]'>Disable Continuous Running</label> (to animate one time only)<br/>
	Speed: <input type='text' name='wp_fancy_title[speed]' value='<?php if(strlen($ops['speed']) == 0) echo "120"; else echo $ops['speed']; ?>'/>	(the speed of running, in miliseconds, 1sec = 1000 mili second)
          
           <br/><br/><br/>
        <input type="submit" class="button-primary" value="<?php _e('Update Options'); ?>" />
    
    </form>
    <br/><br/>
    </div>
         </div> <!-- postbox -->
         <div class='postbox'>
            <div class='copr fbds'>
      <span class='note'>You can do more with this plugin, there's a shortcode <code>[fancy]</code> which you can use in your posts<br/>
to learn more visit <a href="http://hasnath.net/wordpress-fancy-title-plugin.php">Official Plugins Page</a>     </span><br/><br/><br/>
            
                Developer: Shamim Hasnath<br/>
                Email: shamim@hasnath.net<br/>
                Web: www.hasnath.net<br/>
                <br/>
                visit www.hasnath.net if you have any question regarding this plugin<br/>
                finally, cordial thanks to you for using this plugin<br/>
<?php 
//========================
//= Donation Link
//========================= ?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_donations">
<input type="hidden" name="business" value="sha404@ymail.com">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="item_name" value="Hasnath.net">
<input type="hidden" name="no_note" value="0">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

             </div>
       </div>
    </div>
 <?php
 
 }
 //==================short code==================
 
function fancy_shortcode($atts){
        extract(shortcode_atts( array(
               'it' => 'title',
               'speed' => 120,
               'loop' => 0,
               'pos' => 0,
               'class' => 0,
               'tag' => 0,
               'id' => 0
               ), $atts ));
               
        $ret = "<script> ";
	
	if($loop = 'true') $loop = 1; else if($loop = 'false') $loop = 0;
               
       if($class != 0){
                $ret .= "fancyClass($class, $pos, $loop, $speed); </script>";
                return $ret;
        }
        else if($id !=0 ){
                $ret .= "fancyIt('id', $id, $loop, $speed); </script>";
                return $ret;
          }
         else if($tag !=0 ) {
                $ret .= "fancyTag($tag, $pos, $loop, $speed); </script>";
                return $ret;
          }
          else if($it == 'post'){
                    $ret .= "fancyClass('entry-content', 0, $loop, $speed); </script>";
                    return $ret;
           }
          else
                $ret .= "fancyClass('entry-title', 0, $loop, $speed); </script>";
                return $ret;
 
}

add_shortcode('fancy', 'fancy_shortcode');

?>
