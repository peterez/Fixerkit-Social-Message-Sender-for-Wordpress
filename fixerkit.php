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

if (is_admin()) {

  define('fixerkit_dir', __DIR__ . '/');
  define('fixerkit_plugin_dir', plugin_dir_url(__FILE__));
  $lang=get_option('fixerkit_lang');
  if ($lang=="tr") {
    require_once fixerkit_dir . "lang/trTR.php";
  } else {
    require_once fixerkit_dir . "lang/enEN.php";
  }
  require_once fixerkit_dir . "/fixedVar.php";

  function fixerkit_flushCookie() {
    $array=array("getGroups", "myLimit", "getAccounts", "listMessages");
    foreach ($array as $method) {
      $sesKey="fixerkit_ses_" . $method;
      delete_user_meta(1, $sesKey);
    }
  }

  function connectFixerkit($method) {
    global $lang;
    if ($lang=="") {
      $lang="en";
    }

<<<<<<< HEAD
    $key   =get_option('fixerkit_access_token');
    $link  ="http://" . $lang . ".fixerkit.com/developer/social/" . $method . "?access_token=" . $key;
    $sesKey="fixerkit_ses_" . $method;

    if ($_COOKIE[$sesKey]!="") {
      $ses=get_user_meta(1, $sesKey, true);
    } else {
      fixerkit_flushCookie();
    }
=======
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
>>>>>>> origin/master

    if ($ses!="") {
      return json_decode(base64_decode($ses));
    }

    if (trim($key)!="") {
      $req =wp_remote_get($link);
      $json=$req['body'];

      delete_user_meta("1", $sesKey);
      add_user_meta("1", $sesKey, base64_encode($json));
      setcookie($sesKey, "1", time()+300, COOKIEPATH, COOKIE_DOMAIN);

      return json_decode($json);
    } else {
      return false;
    }
  }

  function fixerkit_menu_page() {
    add_menu_page(__('Fixerkit', 'textdomain'), 'Fixerkit ' . settings, 'manage_options', 'setting', 'settingsPage', plugin_dir_url(__FILE__) . 'assets/icon.png', 6);

    add_submenu_page('setting', listSocialMessage, listSocialMessage, 'manage_options', 'history', 'historyPage');

    add_submenu_page('setting', socialNetworks, socialNetworks, 'manage_options', 'account', 'getAccountsPage');

    add_submenu_page('setting', sendSocialMessage, sendSocialMessage, 'manage_options', 'send', 'sendPage');
  }

  function fixerkit_custom_meta_box_markup() {

<<<<<<< HEAD
    $currentGroupId=get_option('fixerkit_groups');
    $getMyGroups   =connectFixerkit("getGroups");
    $currentGroupId=$_GET['action']=="edit"?"-":$currentGroupId;

    ?>
    <select name="selected_fixerkit_group" id="fixerkit_group" class="defaultIS">
      <option value="-" <?php if ($currentGroupId=="0") {
        echo "selected";
      } ?>><?php echo dontSend ?></option>
      <option value="0" <?php if ($currentGroupId=="0") {
        echo "selected";
      } ?>><?php echo all ?></option>
      <?php if (is_object($getMyGroups)) {
        foreach ($getMyGroups as $item) {
          ?>
          <option value="<?php echo $item->id ?>" <?php if ($currentGroupId==$item->id) {
            echo "selected";
          } ?>><?php echo $item->title ?></option>
        <?php
        }
      } ?>
    </select>
  <?php
  }
=======
$fixerkit_lang = get_option('fixerkit_lang');

if ($fixerkit_lang == "tr") {
    require_once  fixerkit_dir."lang/trTR.php";
} else {
    require_once  fixerkit_dir."lang/enEN.php";
}
>>>>>>> origin/master

  function fixerkit_add_custom_meta_box() {
    add_meta_box("fixerkit-meta-box", myGroups, "fixerkit_custom_meta_box_markup", "post", "side", "high", null);
  }

  function fixerkitMenu() {
    ?>
    <div class="sol menu">
      <br>
      <ul class="tabHead">
        <li><a class="item setting <?php echo $_GET['page']=="setting"?"colored":"" ?>"
               href="admin.php?page=setting"><?php echo settings ?></a></li>

        <li><a class="item history <?php echo $_GET['page']=="history"?"colored":"" ?>"
               href="admin.php?page=history"><?php echo listSocialMessage ?></a></li>
        <li><a class="item account <?php echo $_GET['page']=="account"?"colored":"" ?>"
               href="admin.php?page=account"><?php echo socialNetworks ?></a></li>
        <li><a style="border: 0px;" class="item send <?php echo $_GET['page']=="send"?"colored":"" ?>"
               href="admin.php?page=send"><?php echo sendSocialMessage ?></a></li>

      </ul>
    </div>
  <?php
  }

  function fixerkitAss() {
    wp_register_style('fixerkit_css', plugins_url('', __FILE__) . '/assets/reset.css', false, '1.0.0');
    wp_enqueue_style('fixerkit_css');

<<<<<<< HEAD
    wp_register_style('fixerkit_css2', plugins_url('', __FILE__) . '/assets/anastil.css', false, '1.0.0');
    wp_enqueue_style('fixerkit_css2');
=======
function fixerkit_fixDate($format,$originalDate,$hesapla="") {
  if($hesapla !="") { return date($format,strtotime($hesapla,strtotime($originalDate))); }
  else              { return date($format,strtotime($originalDate)); }
}
>>>>>>> origin/master

    wp_register_style('fixerkit_css3', plugins_url('', __FILE__) . '/assets/apprise.css', false, '1.0.0');
    wp_enqueue_style('fixerkit_css3');

<<<<<<< HEAD
    wp_register_style('fixerkit_js', plugins_url('', __FILE__) . '/assets/apprise-1.5.full.js', false, '1.0.0');
    wp_enqueue_style('fixerkit_js');

    wp_register_style('fixerkit_js2', plugins_url('', __FILE__) . '/assets/alert.js', false, '1.0.0');
    wp_enqueue_style('fixerkit_js2');

    global $lang;
    $key=get_option('fixerkit_access_token');
    ?>
    <div style="display:none" class="forJs">
      <div class="wrong"><?php echo wrong ?></div>
      <div class="key"><?php echo $key ?></div>
      <div class="success"><?php echo success ?></div>
    </div>
  <?php

  }

  function filter_handler($data, $postarr) {

    global $lastMess;

    if ($postarr['guid']!="" and $postarr['post_status']=="publish" and $postarr['post_type']=="post") {
      $st="true";
    }

    if ($lastMess==$postarr['post_title']) {
      $st="false";
    }

    if (get_post_status($postarr['ID'])=="draft" and $postarr['post_status']=="publish") {
      $st="true";
    }

    if ($postarr['selected_fixerkit_group']=="-") {
      $st="false";
    }

    if ($st=="true") {
      $key=get_option('fixerkit_access_token');
      $img=wp_get_attachment_image_src($postarr['_thumbnail_id'], 'full');

      $perma=get_permalink($postarr['ID']);
=======
>>>>>>> origin/master

      if ($perma!="") {
        $postarr['guid']=$perma;
      }

<<<<<<< HEAD
      $post=array(
         'title'      =>$postarr['post_title'],
         'image'      =>$img[0],
         'description'=>strip_tags($postarr['post_content']),
         'link'       =>$postarr['guid'],
         'group_id'   =>$postarr['selected_fixerkit_group'],
         'api_uniq'   =>$postarr['ID']
      );
=======
function fixerkit_current_group_html()
{
>>>>>>> origin/master

      $isSended = get_post_meta($postarr['ID'], "fixerkit_sended_id",true);

      if($isSended !="") {
      $return =   wp_remote_post("http://fixerkit.com/developer/social/edit/".$isSended."?access_token=" . $key, array('body'=>$post));
      } else {
        $return =   wp_remote_post("http://fixerkit.com/developer/social/send?access_token=" . $key, array('body'=>$post));
      }

      $return = json_decode($return['body']);

      if($return->result =="ok") {
         delete_post_meta($postarr['ID'], "fixerkit_sended_id");
         add_post_meta($postarr['ID'], "fixerkit_sended_id", $return->id);
       }



      fixerkit_flushCookie();
    }
    $lastMess=$postarr['post_title'];

    return $data;

  }

  function fixerkit_access_token() {
    ?>
    <input type="text" name="fixerkit_access_token" id="fixerkit_access_token" class="defaultIS width300"
           value="<?php echo get_option('fixerkit_access_token'); ?>"/>
  <?php
  }

  function fixerkit_groups() {
    $currentGroupId=get_option('fixerkit_groups');

    $getMyGroups=connectFixerkit("getGroups");

    ?>
    <select name="fixerkit_groups" id="fixerkit_groups" class="defaultIS">
      <option value="0"><?php echo all ?></option>
      <?php if (is_object($getMyGroups)) {
        foreach ($getMyGroups as $item) {
          ?>
          <option value="<?php echo $item->id ?>" <?php if ($currentGroupId==$item->id) {
            echo "selected";
          } ?> ><?php echo $item->title ?></option>
        <?php
        }
      } ?>
    </select>
  <?php
  }

<<<<<<< HEAD
  function fixerkit_lang() {
    global $langs;
    $lang=get_option('fixerkit_lang');
    ?>
    <select name="fixerkit_lang" id="fixerkit_lang" class="defaultIS">
      <?php foreach ($langs as $key=>$value) { ?>
        <option value="<?php echo $key ?>" <?php echo $lang==$key?"selected":"" ?>><?php echo $value ?></option>
      <?php } ?>
    </select>
  <?php
  }

  function display_theme_panel_fields() {
    add_settings_section("section", "", null, "fixerkit-options");
=======
function fixerkit_add_current_group_html()
{
    add_meta_box("fixerkit-meta-box", myGroups, "fixerkit_current_group_html", "post", "side", "high", null);
}

add_action("add_meta_boxes", "fixerkit_add_current_group_html");
>>>>>>> origin/master

    add_settings_field("fixerkit_access_token", accessToken, "fixerkit_access_token", "fixerkit-options", "section");
    add_settings_field("fixerkit_groups", myGroups, "fixerkit_groups", "fixerkit-options", "section");
    add_settings_field("fixerkit_lang", language, "fixerkit_lang", "fixerkit-options", "section");

    register_setting("section", "fixerkit_access_token");
    register_setting("section", "fixerkit_groups");
    register_setting("section", "fixerkit_lang");

  }

  function settingsPage() {
    $myLimit=connectFixerkit("myLimit");


    ?>
    <div class="bgWhite padding10">
      <div class="header">
        <div class="sol mr20">
          <img src="<?php echo plugins_url('', __FILE__); ?>/assets/logo.png"/>
        </div>

        <?php fixerkitMenu() ?>

<<<<<<< HEAD
        <div class="sil"></div>
=======
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
>>>>>>> origin/master

      </div>
      <div class="padding10 tabContent">
        <div class="mt20"></div>
        <h1 class="h2"><?php echo settings ?></h1>

        <div class="mt20"></div>


        Erişim Anahtarı için <a href="http://fixerkit.com">fixerkit.com</a>'a <a
           href="http://fixerkit.com/register">üye olunuz</a>
        <br> <br> <br>

        <form method="post" action="options.php">
          <?php
          settings_fields("section");
          do_settings_sections("fixerkit-options");
          submit_button();
          ?>
        </form>

        <? if ($myLimit!="") { ?>

          <div class="mt20"></div>
          <h1 class="h2"><?php echo myLimits ?></h1>

          <div class="mt20"></div>
          <div class="sol">
            <div class="sol width150"><?php echo socialShare ?></div>
            <div class="sol width150"> : <?php echo $myLimit->social_share ?></div>
            <div class="sil mt10"></div>
            <div class="sol width150"><?php echo socialLimit ?></div>
            <div class="sol width150"> : <?php echo $myLimit->social_limit ?></div>
            <div class="sil mt10"></div>
          </div>
          <div class="sol ml50">
            <div class="sol width150"><?php echo projectLimit ?></div>
            <div class="sol width150"> : <?php echo $myLimit->project_limit ?></div>
            <div class="sil mt10"></div>
            <div class="sol width150"><?php echo keywordLimit ?></div>
            <div class="sol width150"> : <?php echo $myLimit->keyword_limit ?></div>
            <div class="sil mt10"></div>
          </div>
          <div class="sil"></div>
        <? } ?>
      </div>

    </div>
  <?php
  }

  function getAccountsPage() {

    $getAccounts=connectFixerkit("getAccounts");
    ?>


    <div class="bgWhite padding10">
      <div class="header">
        <div class="sol mr20">
          <img src="<?php echo plugins_url('', __FILE__); ?>/assets/logo.png"/>
        </div>

<<<<<<< HEAD
        <?php fixerkitMenu() ?>
=======
  global $fixerkit_lang;
  $key= get_option('fixerkit_access_token');
?>
>>>>>>> origin/master

        <div class="sil"></div>

      </div>


      <div class="padding10 tabContent">

<<<<<<< HEAD
        <div class="mt20"></div>
        <h1 class="h2"><?php echo socialNetworks ?></h1>
=======
function fixerkit_filter_handler( $data , $postarr ) {
>>>>>>> origin/master

        <div class="mt20"></div>


        <table class="wp-list-table widefat fixed striped posts">
          <thead>
          <tr>
            <th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
              &nbsp; Başlık
            </th>
            <th scope="col" id="categories" class="manage-column column-categories">Sosyal Medya</th>
            <th scope="col" id="date" class="manage-column column-date sortable asc">
              Tarih ve Durum
            </th>
          </tr>
          </thead>

          <tbody id="the-list">


          Sosyal hesap ekleyebilmek için fixerkit.com panelindeki <a
             href="http://fixerkit.com/login">Sosyal Ağlar</a> alanından sosyal medya hesabınızı ekleyin
          <br> <br> <br>
          <?php
          $networks=unserialize($getAccounts->socialNetworks);
          if (is_object($getAccounts->account)) {
            foreach ($getAccounts->account as $network) {
              foreach ($network as $item) {

                ?>

                <tr id="post-<?php echo $item->id ?>"
                    class="iedit author-self level-0li_<?php echo $item->id ?> type-post status-publish format-standard hentry category-genel">

                  <td class="title column-title has-row-actions column-primary page-title" data-colname="Başlık">

                    <strong><a class="row-title"
                               href="<? if ($item->api_uniq!="") { ?>post.php?post=<?= $item->api_uniq ?>&action=edit<? } else { ?>#<? } ?>"><?php echo $item->name ?></a></strong>

                  </td>

                  <td class="categories column-categories"
                      data-colname="Kategoriler"> <?php echo $networks[$item->social_network_id] ?> </td>
                  <td class="date column-date" data-colname="Tarih">
                    <abbr><?= date_i18n(__('F j, Y') . ' ' . __('g:i a'), strtotime($item->date)) ?></abbr></td>
                </tr>


              <?php } ?>
            <?php
            }
          } ?>


          </tbody>

        </table>

<<<<<<< HEAD
=======
add_filter( 'wp_insert_post_data', 'fixerkit_filter_handler', '99', 2 );
>>>>>>> origin/master

      </div>


      <div class="padding10">

        <a href="http://fixerkit.com/login" target="_blank"
           class="linkButton butonBlue"><?= addNew ?></a>

<<<<<<< HEAD
      </div>
=======
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
>>>>>>> origin/master

    </div>
  <?php
  }

<<<<<<< HEAD
  function historyPage() {
    $listMessages=connectFixerkit("listMessages");
    ?>
=======
    function fixerkit__panel_fields2html()
    {
        add_settings_section("section", "", null, "fixerkit-options");
>>>>>>> origin/master

    <div class="bgWhite padding10">
      <div class="header">
        <div class="sol mr20">
          <img src="<?php echo plugins_url('', __FILE__); ?>/assets/logo.png"/>
        </div>

        <?php fixerkitMenu() ?>

        <div class="sil"></div>

<<<<<<< HEAD
      </div>
      <div class="padding10 tabContent">
        <div class="mt20"></div>
        <h1 class="h2"><?php echo listSocialMessage ?></h1>
=======
    add_action("admin_init", "fixerkit__panel_fields2html");
>>>>>>> origin/master

        <div class="mt20"></div>


<<<<<<< HEAD
        <table class="wp-list-table widefat fixed striped posts">
          <thead>
          <tr>
            <th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
              &nbsp; Başlık
            </th>
            <th scope="col" id="categories" class="manage-column column-categories">Grup</th>
            <th scope="col" id="date" class="manage-column column-date sortable asc">
              Tarih ve Durum
            </th>
          </tr>
          </thead>

          <tbody id="the-list">
=======
    function fixerkit_settingsPage()
    {
        $myLimit = connectFixerkit("myLimit");

        if($myLimit->social_share =="" and $myLimit->social_limit =="" and $myLimit->project_limit =="" and  $myLimit->keyword_limit =="" and get_option('fixerkit_access_token') !="" ) {
            ?>
            <script>alert('Yanlış Erişim Anahtarı');</script>
            <?
        }
>>>>>>> origin/master

          <?php
          $status=unserialize($listMessages->status);
          $statused=unserialize($listMessages->statused);
          foreach ($listMessages->message as $itemId=>$item) {

            $title=mb_substr(($item->title . " " . $item->description . " " . $item->image . " " . $item->video), 0, 50, 'UTF-8');
            ?>
            <tr id="post-<?php echo $item->id ?>"
                class="iedit author-self level-0li_<?php echo $item->id ?> type-post status-publish format-standard hentry category-genel">

              <td class="title column-title has-row-actions column-primary page-title" data-colname="Başlık">

                <strong><a class="row-title"
                           href="<? if ($item->api_uniq!="") { ?>post.php?post=<?= $item->api_uniq ?>&action=edit<? } else { ?>#<? } ?>"><?= $title ?></a></strong>

                <div class="row-actions">
                  <? if ($item->api_uniq!="") { ?>
                    <span class="edit"><a href="/post.php?post=<?= $item->api_uniq ?>&action=edit">Yazıyı Düzenle</a> | </span>
                  <? } ?>

<<<<<<< HEAD
                  <? if ($item->link!="") { ?>
                    <span class="view"><a href="<?= $item->link ?>" target="_blank">Görüntüle</a></span>
                  <? } ?>
=======
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
>>>>>>> origin/master
                </div>
                <button type="button" class="toggle-row"><span class="screen-reader-text">Daha fazla detay göster</span>
                </button>
              </td>

              <td class="categories column-categories" data-colname="Kategoriler"> <?= $item->group_name ?> </td>
              <td class="date column-date" data-colname="Tarih">
                <?php echo $statused[$item->status] ?><br>
                <abbr><?= date_i18n(__('F j, Y') . ' ' . __('g:i a'), strtotime($item->send_date)) ?></abbr>


              </td>
            </tr>
          <?php } ?>

<<<<<<< HEAD
          </tbody>
=======
    function fixerkit_getAccountsPage()
    {
>>>>>>> origin/master

        </table>

      </div>
    </div>

  <?php
  }

  function sendPage() {

    $delayedTimes=array(
       "1" =>_1hoursLater,
       "2" =>_3hoursLater,
       "3" =>_6hoursLater,
       "4" =>_10hoursLater,
       "5" =>_12hoursLater,
       "6" =>_18hoursLater,
       "7" =>_1dayLater,
       "8" =>_2dayLater,
       "9" =>_on6,
       "10"=>_on9,
       "11"=>_on12,
       "12"=>_on15,
       "13"=>_on18,
       "14"=>_on21,
       "15"=>_on24
    );

    $delayedTimeValues=array(
       "1" =>"+1 hours",
       "2" =>"+3 hours",
       "3" =>"+6 hours",
       "4" =>"+10 hours",
       "5" =>"+12 hours",
       "6" =>"+18 hours",
       "7" =>"+1 days",
       "8" =>"+2 days",
       "9" =>"on 06",
       "10"=>"on 09",
       "11"=>"on 12",
       "12"=>"on 15",
       "13"=>"on 18",
       "14"=>"on 21",
       "15"=>"on 24"
    );

    $getMyGroups=connectFixerkit("getGroups");
    ?>
    <div class="bgWhite padding10">
      <div class="header">
        <div class="sol mr20">
          <img src="<?php echo plugins_url('', __FILE__); ?>/assets/logo.png"/>
        </div>

        <?php fixerkitMenu() ?>

        <div class="sil"></div>

      </div>

      <div class="padding10">

        <div class="mt20"></div>
        <h1 class="h2"><?php echo sendSocialMessage ?></h1>

        <div class="mt20"></div>

        <div class="padding10">
          <form id="fixerkit_form" onsubmit="return validate(this);">

            <div class="block">
              <div class="sol per-width15 textRight colTitle"><?= group ?> :</div>
              <div class="sol per-width85 colTitle">
                <select name="group_id" class="defaultIS">
                  <option value="0"><?php echo all ?></option>
                  <?php if (is_object($getMyGroups)) {
                    foreach ($getMyGroups as $item) {
                      ?>
                      <option value="<?php echo $item->id ?>"><?php echo $item->title ?></option>
                    <?php
                    }
                  } ?>
                </select>
              </div>
              <div class="sil mt0"></div>
            </div>

            <div class="mt10 hideElementOnMobile"></div>

<<<<<<< HEAD
            <div class="socialLink">
              <div class="sol per-width15 textRight colTitle"><?= link ?> :</div>
              <div class="sol per-width85 colTitle ">
                <input name="link" placeholder="http://fixerkit.com" class="defaultIS per-width70 linkVal"/>
=======
    function fixerkit_historyPage()
    {
        $listMessages = connectFixerkit("listMessages");
        ?>
>>>>>>> origin/master

              </div>
              <div class="sil mt0"></div>


            </div>

            <div class="mt10 hideElementOnMobile"></div>


            <div class=" socialImg">
              <div class="sol per-width15 textRight colTitle "><?= imageLink ?> :</div>
              <div class="sol per-width85 colTitle">
                <input name="image" class="defaultIS  imgVal"/>
              </div>
              <div class="sil"></div>
            </div>
<<<<<<< HEAD

            <div class="mt10 hideElementOnMobile"></div>


            <div>
              <div class="sol per-width15 textRight colTitle"><?= timing ?> :</div>
              <div class="sol per-width85 colTitle">
                <select name="delayed" class="defaultIS">
                  <option value="0"><?= choose ?></option>
                  <? foreach ($delayedTimes as $key=>$times) {
                    $textTime=$delayedTimeValues[$key];
                    ?>
                    <? if (strstr($textTime, "+")) { ?>
                      <option value="<?= $key ?>"><?= $times ?></option>
                    <? } ?>
                    <?if (strstr($textTime, "on")) {
                      $replace    =str_replace("on ", "", $textTime);
                      $currentTime=date("Y-m-d H:i:s", strtotime(date("Y-m-d") . " " . $replace . ":00:00"));
                      if ($currentTime>date("Y-m-d H:i:s")) {
                        ?>
                        <option
                           value="<?= $key ?>"><?= $times ?> ( <?= date_i18n(__('F j, Y') . ' ' . __('g:i a'), strtotime($currentTime)) ?> )
                        </option>
                      <?
                      }
                    } ?>
                  <? } ?>
                </select>
              </div>
              <div class="sil mt0"></div>
=======
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
>>>>>>> origin/master
            </div>

            <div class="mt10 hideElementOnMobile"></div>

<<<<<<< HEAD
=======
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
>>>>>>> origin/master

            <div class="socialTitle">
              <div class="sol per-width15 textRight  colTitle"><?= title ?> :</div>
              <div class="sol per-width85 colTitle">
                <input name="title" class="defaultIS "/>
              </div>
              <div class="sil mt0"></div>
            </div>

            <div class="mt10 hideElementOnMobile"></div>

            <div class="socialDescription">
              <div class="sol per-width15 textRight colTitle"><?= description ?> :</div>

              <div class="sol ew75 colTitle">
                <textarea name="description" uyari="1" message="<?php echo emptyInput ?>"
                          class="ew100 height130"></textarea>
              </div>
              <div class="sil mt0"></div>
            </div>

            <div class="mt10 hideElementOnMobile"></div>

<<<<<<< HEAD
            <div class="inline-block">
              <div class="sol per-width15 textRight colTitle">&nbsp; </div>
              <div class="sol per-width85 colTitle">
                <input type="button" name="sendSocialMessage" onclick="sendM()" class="butonBlue pointer inputButton"
                       value=" <?= send ?> ">
=======
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

>>>>>>> origin/master
              </div>
              <div class="sil mt0"></div>
            </div>
          </form>

        </div>
      </div>

    </div>
  <?php
  }

  add_action('admin_menu', 'fixerkit_menu_page');
  add_action("add_meta_boxes", "fixerkit_add_custom_meta_box");
  add_action('admin_enqueue_scripts', 'fixerkitAss');
  add_filter('wp_insert_post_data', 'filter_handler', '99', 2);
  add_action("admin_init", "display_theme_panel_fields");

}

?>