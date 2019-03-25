<?php

/**
 * Helps to setup new theme
 *
 * @package    tools
 * @copyright  &copy; 2016 CG Kineo {@link http://www.kineo.com}
 * @author     kaushtuv.gurung
 * @version    1.0
 */


require_once ('config.php');
require_once ('lib.php');

if (php_sapi_name() == "cli") {
    $arg = $argv;
    $project = $arg[1];
    $base_themename = $arg[2];
    $new_themename = $arg[3];

} else {
    // if in browser mode
    $base_themename = $_GET['basename'];
    $new_themename = $_GET['newname'];
    $project = $_GET['project'];
}

init($base_themename, $new_themename, $project);

function init($base_themename, $new_themename, $project) {
    global $config;
    $plugin_name = $new_themename;
    $plugin_type = 'theme';
    $plugin_path = $config->projectpath .'/'. $project.'/trunk/'.$plugin_type;
    $source = $plugin_path .'/'. $base_themename;
    $dest = $plugin_path .'/'. $new_themename;
    $placeholders = get_base_placeholders($plugin_type, $plugin_name);

    copy_theme($source, $dest);
    initTheme($dest, $base_themename, $new_themename);
    // add custom settings such as custom css files
    // but first delete the lib file
    //unlink ($dest . '/lib.php' );
//    $files = array(
//        'lib' => array('templatepath' => 'templates/'.$plugin_type.'/lib.txt', 'filepath' => $dest.'/lib.php'),
//        'settings' => array('templatepath' => 'templates/'.$plugin_type.'/settings.txt', 'filepath' => $dest.'/settings.php'),
//        'settings_css' => array('templatepath' => 'templates/'.$plugin_type.'/settings_css.txt', 'filepath' => $dest.'/style/settings.css')
//    );
    // init settings files
    //init_files($plugin_type, $plugin_name, $plugin_path, $placeholders, $files);
    // apply change to theme config.php
    //      $THEME->rendererfactory = 'theme_overridden_renderer_factory';
    //      $THEME->csspostprocess = 'theme_cgkineoframework_process_css';
    // Add settings.css to the $THEME->sheets = array('client','settings');

    // update config.php file
    $config = $dest.'/config.php';
    $current = file_get_contents($config);

    $new_config = str_replace('$THEME->sheets = array(\'client\')', '$THEME->sheets = array(\'client\',\'settings\')', $current);
    file_put_contents($config, $new_config);

    // update lang file
//    $lang = $dest.'/lang/en/theme_'.$plugin_name.'.php';
//    $current_lang = file_get_contents($lang);
//    $new_lang = '
//$string[\'customsetting\'] = \'Custom settings\';
//$string[\'customcss\'] = \'Custom CSS\';
//$string[\'customcssdesc\'] = \'Any CSS you enter here will be added to every page allowing your to easily customise this theme.\';
//$string[\'hidecourseicon_multiselect\'] = \'Hide multiselect course icon\';
//$string[\'hidecourseicon_multiselectdesc\'] = \'If checked, this settings will hide the course icons on multiselect checkboxes while editing a course\';';
//     file_put_contents($lang, $current_lang . $new_lang);
}