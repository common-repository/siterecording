<?php
namespace siterecordingplugin;
class Siterecording
{
    public static $class = __CLASS__;
    /**
     * @param $action_id
     */
    public static function appContent($action_id){
        global $settings_siterecording;
        if ($action_id == 'SiteRecording') {
            $websitename_value = get_bloginfo('name');
            $websiteurl_value = get_site_url();
            $results = array();
            $results = json_decode(get_option('siterecording_website'), true);
            $script_value = $results['website_installscript'];
            if(empty($script_value)){
                $script_value = "false";
            }
            $verified_value = $results['website_verify'];
            if(empty($verified_value)){
                $verified_value = "false";
            }
            $siterecording_url = "https://infinity.500apps.com/siterecording?a=s&menu=false";
            include 'siterecording_content.php';
        }
    }
    public static function action_1(){
        self::appContent('SiteRecording');
    }
    public static function action_2(){
        self::appContent('Othersiterecording');
    }
    public static function init()
    {
        add_action('admin_menu', array(__CLASS__, 'register_menu_siterecording'),10,0);
    }
    public static function register_menu_siterecording()
    {
        global $settings_siterecording;
        add_menu_page($settings_siterecording['menus']['menu'], $settings_siterecording['menus']['menu'], 'manage_options', __FILE__, array(__CLASS__, 'action_1'),plugin_dir_url( __FILE__ ) . 'images/siterecording_icon.png');
        add_submenu_page(__FILE__, $settings_siterecording['menus']['sub_menu_title_1'], $settings_siterecording['menus']['sub_menu_title_1'], 'manage_options', $settings_siterecording['menus']['sub_menu_url_1'], array(__CLASS__, 'action_2'));
    }
}