<?php
/**
 * @package Fixerkit
 */
/*
Plugin Name: Fixerkit
Plugin URI: https://github.com/peterez/Fixerkit-Social-Message-Sender-for-Wordpress
Description: Fixerkit Social Share Plugin
Version: 1.0
Author: Fixerkit
Author URI: http://fixerkit.com
Text Domain: fixerkit
*/





/**
 * Register a custom menu page.
 */
 
 

 
function fixerkit_menu_page()
{
    add_menu_page(
        __('Fixerkit', 'textdomain'),
        'Fixerkit '.settings,
        'manage_options',
        'setting',
        'fixerkit_settingsPage',
        plugin_dir_url( __FILE__ ) .'assets/icon.png',
        6
    );

    add_submenu_page(
        'setting',
        listSocialMessage,
        listSocialMessage,
        'manage_options',
        'history',
        'fixerkit_historyPage');

    add_submenu_page(
        'setting',
        socialNetworks,
        socialNetworks,
        'manage_options',
        'account',
        'fixerkit_getAccountsPage');

    add_submenu_page(
        'setting',
        sendSocialMessage,
        sendSocialMessage,
        'manage_options',
        'send',
        'fixerkit_sendPage');
}


add_action('admin_menu', 'fixerkit_menu_page');




/**
 * pages options
 */

if (is_admin()) {
	
	
	
	 define( 'fixerkit_dir', __DIR__.'/' );
	 define( 'fixerkit_plugin_dir', plugin_dir_url( __FILE__ ) );
	



$fixerkit_lang = get_option('fixerkit_lang');

if ($fixerkit_lang == "tr") {
    require_once  fixerkit_dir."lang/trTR.php";
} else {
    require_once  fixerkit_dir."lang/enEN.php";
}


require_once fixerkit_dir . "/fixedVar.php";


function fixerkit_fixDate($format,$originalDate,$hesapla="") {
  if($hesapla !="") { return date($format,strtotime($hesapla,strtotime($originalDate))); }
  else              { return date($format,strtotime($originalDate)); }
}




function fixerkit_current_group_html()
{

    $currentGroupId = get_option('fixerkit_groups');
    $getMyGroups = connectFixerkit("getGroups");

  $currentGroupId =  $_GET['action']=="edit"?"-":$currentGroupId;

    ?>
    <select name="selected_fixerkit_group" id="fixerkit_group" class="defaultIS">
        <option value="-" <?php if ($currentGroupId == "0") {
                    echo  "selected";
                } ?>><?php echo dontSend?></option>
        <option value="0" <?php if ($currentGroupId == "0") {
            echo  "selected";
        } ?>><?php echo all?></option>
        <?php if (is_object($getMyGroups)) {
            foreach ($getMyGroups as $item) { ?>
                <option value="<?php echo  $item->id ?>" <?php if ($currentGroupId == $item->id) {
                    echo  "selected";
                } ?>><?php echo  $item->title ?></option>
            <?php }
        } ?>
    </select>
<?php
}

function fixerkit_add_current_group_html()
{
    add_meta_box("fixerkit-meta-box", myGroups, "fixerkit_current_group_html", "post", "side", "high", null);
}

add_action("add_meta_boxes", "fixerkit_add_current_group_html");






function  fixerkitMenu()
{
    ?>
    <div class="sol menu">
        <ul class="tabHead">
            <li><a class="item setting <?php echo  $_GET['page'] == "setting" ? "colored" : "" ?>"
                   href="admin.php?page=setting"><?php echo  settings?></a></li>

            <li><a class="item history <?php echo  $_GET['page'] == "history" ? "colored" : "" ?>"
                   href="admin.php?page=history"><?php echo  listSocialMessage?></a></li>
            <li><a class="item account <?php echo  $_GET['page'] == "account" ? "colored" : "" ?>"
                   href="admin.php?page=account"><?php echo  socialNetworks?></a></li>
            <li ><a style="border: 0px;" class="item send <?php echo  $_GET['page'] == "send" ? "colored" : "" ?>"
                   href="admin.php?page=send"><?php echo  sendSocialMessage?></a></li>

        </ul>
    </div>
<?php
}


function connectFixerkit($method)
{
    $key = get_option('fixerkit_access_token');
    global $fixerkit_lang;
    if ($fixerkit_lang == "") {
        $fixerkit_lang = "en";
    }
    if (trim($key) != "") {
        return json_decode(file_get_contents("http://" . $fixerkit_lang . ".fixerkit.com/developer/social/" . $method . "?access_token=" . $key));
    } else {
        return false;
    }
}





function fixerkitAss() {
        wp_register_style( 'fixerkit_css',  plugins_url('', __FILE__) .'/assets/reset.css', false, '1.0.0' );
        wp_enqueue_style( 'fixerkit_css' );

        wp_register_style( 'fixerkit_css2',  plugins_url('', __FILE__) .'/assets/anastil.css', false, '1.0.0' );
        wp_enqueue_style( 'fixerkit_css2' );

        wp_register_style( 'fixerkit_css3',  plugins_url('', __FILE__) .'/assets/apprise.css', false, '1.0.0' );
        wp_enqueue_style( 'fixerkit_css3' );


       wp_register_style( 'fixerkit_js',  plugins_url('', __FILE__) .'/assets/apprise-1.5.full.js', false, '1.0.0' );
       wp_enqueue_style( 'fixerkit_js' );

        wp_register_style( 'fixerkit_js2',  plugins_url('', __FILE__) .'/assets/alert.js', false, '1.0.0' );
       wp_enqueue_style( 'fixerkit_js2' );

  global $fixerkit_lang;
  $key= get_option('fixerkit_access_token');
?>

<div style="display:none" class="forJs">
  <div class="wrong"><?php echo wrong?></div>
  <div class="key"><?php echo $key?></div>
  <div class="success"><?php echo success?></div>
</div>
<?php

}
add_action( 'admin_enqueue_scripts', 'fixerkitAss' );



function fixerkit_filter_handler( $data , $postarr ) {

    global $lastMess;



    if($postarr['guid'] !="" and $postarr['post_status'] =="publish" and $postarr['post_type'] =="post") {
        $st ="true";
    }


    $ex =  explode("&",$postarr['_wp_http_referer']);

    if($lastMess == $postarr['post_title']) {
        $st ="false";
    }

    if(get_post_status( $postarr['ID'] ) =="draft" and  $postarr['post_status'] =="publish") {
        $st ="true";
    }


    if($postarr['selected_fixerkit_group'] =="-") {
        $st ="false";
    }

    if($st =="true") {
    $key= get_option('fixerkit_access_token');
    $group_id= get_option('fixerkit_get_groups');

    $img = (wp_get_attachment_image_src( get_post_thumbnail_id( $postarr['ID'] )));

    $post = array(
        'title' => $postarr['post_title'],
        'image' => $img[0],
        'description'   => strip_tags($postarr['post_content']),
        'link' => $postarr['guid'],
        'group_id' => $group_id
    );

    $ch = curl_init("http://fixerkit.com/developer/social/send?access_token=".$key);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    $response = curl_exec($ch);

    curl_close($ch);
    }
    $lastMess = $postarr['post_title'];
    return $data;

}

add_filter( 'wp_insert_post_data', 'fixerkit_filter_handler', '99', 2 );

	


    function fixerkit_access_token()
    {
        ?>
        <input type="text" name="fixerkit_access_token" id="fixerkit_access_token" class="defaultIS width300"
               value="<?php echo  get_option('fixerkit_access_token'); ?>"/>
    <?php
    }

    function fixerkit_groups()
    {
        $currentGroupId = get_option('fixerkit_groups');


        $getMyGroups = connectFixerkit("getGroups");

        ?>
        <select name="fixerkit_groups" id="fixerkit_groups" class="defaultIS">
            <option value="0"><?php echo  all?></option>
            <?php if (is_object($getMyGroups)) {
                foreach ($getMyGroups as $item) { ?>
                    <option value="<?php echo  $item->id ?>" <?php if ($currentGroupId == $item->id) {
                        echo  "selected";
                    } ?> ><?php echo  $item->title ?></option>
                <?php }
            } ?>
        </select>
    <?php
    }

    function fixerkit_lang()
    {
        global $fixerkit_langs;
        $fixerkit_lang = get_option('fixerkit_lang');
        ?>
        <select name="fixerkit_lang" id="fixerkit_lang" class="defaultIS">
            <?php foreach ($fixerkit_langs as $key => $value) { ?>
                <option value="<?php echo  $key ?>" <?php echo  $fixerkit_lang == $key ? "selected" : "" ?>><?php echo  $value ?></option>
            <?php } ?>
        </select>
    <?php
    }


    function fixerkit__panel_fields2html()
    {
        add_settings_section("section", "", null, "fixerkit-options");

        add_settings_field("fixerkit_access_token", accessToken, "fixerkit_access_token", "fixerkit-options", "section");
        add_settings_field("fixerkit_groups", myGroups, "fixerkit_groups", "fixerkit-options", "section");
        add_settings_field("fixerkit_lang", language, "fixerkit_lang", "fixerkit-options", "section");

        register_setting("section", "fixerkit_access_token");
        register_setting("section", "fixerkit_groups");
        register_setting("section", "fixerkit_lang");

    }

    add_action("admin_init", "fixerkit__panel_fields2html");


    /**
     * pages functions
     */

    function fixerkit_settingsPage()
    {
        $myLimit = connectFixerkit("myLimit");

        if($myLimit->social_share =="" and $myLimit->social_limit =="" and $myLimit->project_limit =="" and  $myLimit->keyword_limit =="" and get_option('fixerkit_access_token') !="" ) {
            ?>
            <script>alert('Yanlış Erişim Anahtarı');</script>
            <?
        }

        ?>
      <div class="bgWhite padding10" >
            <div class="header">
                <div class="sol mr20">
                    <img src="<?php echo  plugins_url('', __FILE__); ?>/assets/logo.png"/>
                </div>

                <?php fixerkitMenu() ?>

                <div class="sil"></div>

            </div>
            <div class="padding10 tabContent">
                <div class="mt20"></div>
                <h1 class="h2"><?php echo  settings?></h1>
                <div class="mt20"></div>


              Erişim Anahtarı için <a href="http://fixerkit.com">fixerkit.com</a>'a <a href="http://fixerkit.com/register">üye olunuz</a>
              <br> <br> <br>
                <form method="post" action="options.php">
                    <?php
                    settings_fields("section");
                    do_settings_sections("fixerkit-options");
                    submit_button();
                    ?>
                </form>

              <div class="mt20"></div>
             <h1 class="h2"><?php echo  myLimits?></h1>

                <div class="mt20"></div>
                <div class="sol">
                <div class="sol width150"><?php echo  socialShare?></div>
                <div class="sol width150"> : <?php echo  $myLimit->social_share ?></div>
                <div class="sil mt10"></div>
                <div class="sol width150"><?php echo  socialLimit?></div>
                <div class="sol width150"> : <?php echo  $myLimit->social_limit ?></div>
                <div class="sil mt10"></div>
                </div>
                <div class="sol ml50">
                <div class="sol width150"><?php echo  projectLimit?></div>
                <div class="sol width150"> : <?php echo  $myLimit->project_limit ?></div>
                <div class="sil mt10"></div>
                <div class="sol width150"><?php echo  keywordLimit?></div>
                <div class="sol width150"> : <?php echo  $myLimit->keyword_limit ?></div>
                <div class="sil mt10"></div>
                </div>
                <div class="sil"></div>

            </div>

        </div>
    <?php
    }


    function fixerkit_getAccountsPage()
    {

        $getAccounts = connectFixerkit("getAccounts");
        ?>


      <div class="bgWhite padding10" >
            <div class="header">
                <div class="sol mr20">
                    <img src="<?php echo  plugins_url('', __FILE__); ?>/assets/logo.png"/>
                </div>

                <?php fixerkitMenu() ?>

                <div class="sil"></div>

            </div>
            <div class="padding10 tabContent">
                <div class="mt20"></div>
                <h1 class="h2"><?php echo  socialNetworks?></h1>
                <div class="mt20"></div>


              Sosyal hesap ekleyebilmek için fixerkit.com panelindeki <a href="http://fixerkit.com/panel/socialNetworks">Sosyal Ağlar</a> alanından sosyal medya hesabınızı ekleyin
        <br> <br> <br>
                <?php
                $networks = unserialize($getAccounts->socialNetworks);
            if(is_object($getAccounts->account)) {
                foreach ($getAccounts->account as $network) {
                    foreach ($network as $item) {
                        ?>
                        <div class="listItem">
                            <div class="sol width150"><?php echo  $networks[$item->social_network_id] ?></div>
                            <div class="sol"> : <?php echo  $item->name ?></div>
                            <div class="sil"></div>
                        </div>
                    <?php } ?>
                <?php } } ?>
            </div>

        <div class="padding10">

          <a href="http://fixerkit.com/panel/socialNetworks" target="_blank" class="linkButton butonBlue"><?=addNew?></a>

        </div>

        </div>
    <?php
    }


    function fixerkit_historyPage()
    {
        $listMessages = connectFixerkit("listMessages");
        ?>

      <div class="bgWhite padding10" >
            <div class="header">
                <div class="sol mr20">
                    <img src="<?php echo  plugins_url('', __FILE__); ?>/assets/logo.png"/>
                </div>

                <?php fixerkitMenu() ?>

                <div class="sil"></div>

            </div>
            <div class="padding10 tabContent">
                <div class="mt20"></div>
                <h1 class="h2"><?php echo  listSocialMessage?></h1>
                <div class="mt20"></div>
                <?php
                $status = unserialize($listMessages->status);
                $statused = unserialize($listMessages->statused);
                if(is_object($listMessages->message)) {
                foreach ($listMessages->message as $item) {
                    ?>
                    <div class="listItem li_<?php echo  $item->id ?>">
                        <div class="sol width400"><?php echo  $item->title ?></div>
                        <div class="sol ml30"><?php echo  ($item->send_date) ?></div>
                        <div class="sag mr10"><?php echo  $statused[$item->status] ?></div>

                        <div class="sil"></div>
                    </div>
                <?php }} ?>
            </div>
        </div>
    <?php
    }


    function fixerkit_sendPage()
    {


$delayedTimes = array( "1" => _1hoursLater,
                   "2" => _3hoursLater,
                   "3" => _6hoursLater,
                   "4" => _10hoursLater,
                   "5" => _12hoursLater,
                   "6" => _18hoursLater,
                   "7" => _1dayLater,
                   "8" => _2dayLater,
                   "9" => _on6,
                   "10" => _on9,
                   "11" => _on12,
                   "12" => _on15,
                   "13" => _on18,
                   "14" => _on21,
                   "15" => _on24
);


$delayedTimeValues = array( "1" => "+1 hours",
                   "2" => "+3 hours",
                   "3" => "+6 hours",
                   "4" => "+10 hours",
                   "5" => "+12 hours",
                   "6" => "+18 hours",
                   "7" => "+1 days",
                   "8" => "+2 days",
                   "9" => "on 06",
                   "10" => "on 09",
                   "11" => "on 12",
                   "12" => "on 15",
                   "13" => "on 18",
                   "14" => "on 21",
                   "15" => "on 24"
);


        $getMyGroups = connectFixerkit("getGroups");
        ?>
       <div class="bgWhite padding10">
            <div class="header">
                <div class="sol mr20">
                    <img src="<?php echo  plugins_url('', __FILE__); ?>/assets/logo.png"/>
                </div>

                <?php fixerkitMenu() ?>

                <div class="sil"></div>

            </div>


            <div class=" padding10" >

              <div class="mt20"></div>
                  <h1 class="h2"><?php echo  sendSocialMessage?></h1>
                  <div class="mt20"></div>

              <div class="padding10">
                  <form id="fixerkit_form" onsubmit="return validate(this);">


           <div class="inline-block  ew50">
           <div class="sol per-width25 textRight colTitle"><?=group?> : </div>
           <div class="sol per-width75 colTitle">
             <select name="group_id" class="defaultIS">
               <option value="0"><?php echo  all?></option>
                                 <?php if (is_object($getMyGroups)) {
                                     foreach ($getMyGroups as $item) { ?>
                                         <option value="<?php echo  $item->id ?>"><?php echo  $item->title ?></option>
                                     <?php }
                                 } ?>
                   </select>
           </div>
           <div class="sil mt0"></div>
           </div>

           <div class="mt10 hideElementOnMobile"></div>

                    <div class="inline-block socialLink ew50">
                    <div class="sol per-width25 textRight colTitle"><?=link?> : </div>
                    <div class="sol per-width75 colTitle ">
                      <input   name="link" class="defaultIS per-width70 linkVal"/>
                      <div class="sil"></div>
                        <small class="smallText">http://fixerkit.com</small>
                    </div>
                    <div class="sil mt0"></div>


                    </div>

                    <div class="mt10 hideElementOnMobile"></div>


                    <div class="inline-block socialImg ew50">
                       <div class="sol per-width25 textRight colTitle "><?=imageLink?> : </div>
                       <div class="sol per-width75 colTitle">
                         <input name="image" class="defaultIS  imgVal"/>
                       </div>
                       <div class="sil"></div>
                       </div>

                       <div class="mt10 hideElementOnMobile"></div>


                    <div class="inline-block  ew50">
                    <div class="sol per-width25 textRight colTitle"><?=timing?> : </div>
                    <div class="sol per-width75 colTitle">
                      <select name="delayed" class="defaultIS">
                         <option value="0"><?=choose?></option>
                     <? foreach($delayedTimes as $key => $times) {
                       $textTime = $delayedTimeValues[$key];
                       ?>
                        <?if(strstr($textTime,"+")) {?>
                       <option value="<?=$key?>"><?=$times?></option>
                       <?} ?>
                       <?if(strstr($textTime,"on")) {
                         $replace = str_replace("on ","",$textTime);
                         $currentTime =  fixerkit_fixDate("Y-m-d H:i:s",date("Y-m-d")." ".$replace.":00:00");
                         if($currentTime>date("Y-m-d H:i:s")) {
                         ?>
                        <option value="<?=$key?>"><?=$times?> ( <?=($currentTime)?> )</option>
                        <?} } ?>
                     <?} ?>
                       </select>
                    </div>
                    <div class="sil mt0"></div>
                    </div>

                    <div class="mt10 hideElementOnMobile"></div>


                    <div class="inline-block socialTitle ew50">
                    <div class="sol per-width25 textRight  colTitle"><?=title?> : </div>
                    <div class="sol per-width75 colTitle">
                      <input  name="title" class="defaultIS "/>
                    </div>
                    <div class="sil mt0"></div>
                    </div>

                    <div class="mt10 hideElementOnMobile"></div>

                    <div class="inline-block socialDescription ew50">
                     <div class="sol per-width25 textRight colTitle"><?=description?> : </div>

                     <div class="sol ew75 colTitle">
                       <textarea name="description" uyari="1" message="<?php echo  emptyInput?>" class="ew100 height130" ></textarea>
                     </div>
                     <div class="sil mt0"></div>
                     </div>

                     <div class="mt10 hideElementOnMobile"></div>

                    <div class="inline-block  ew50">
                    <div class="sol per-width25 textRight colTitle">&nbsp; </div>
                    <div class="sol per-width75 colTitle">
                      <input type="button" name="sendSocialMessage" onclick="sendM()" class="butonBlue pointer inputButton" value=" <?=send?> ">
                    </div>
                    <div class="sil mt0"></div>
                    </div>
          </form>

              </div>
            </div>

        </div>
    <?php
    }

}

?>