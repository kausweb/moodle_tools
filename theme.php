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
    $plugin_type = 'theme';
    $plugin_path = $config->projectpath .'/'. $project.'/trunk/'.$plugin_type;
    $source = $plugin_path .'/'. $base_themename;
    $dest = $plugin_path .'/'. $new_themename;

    copy_theme($source, $dest);
    initTheme($dest, $base_themename, $new_themename);
}

function copy_theme($source, $dest) {
    mkdir($dest, 0755);
    foreach (
        $iterator = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
        \RecursiveIteratorIterator::SELF_FIRST) as $item
        ) {
            if ($item->isDir()) {
                mkdir($dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
            } else {
                copy($item, $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
            }
    }
}

function initTheme($source, $search, $replace){
	foreach (
        $iterator = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
        \RecursiveIteratorIterator::SELF_FIRST) as $item
        ) {
            if (!$item->isDir()) {
                $file = $item->getPathname();
                $file_content = file_get_contents($file);
                $file_contents = str_replace($search,$replace,$file_content);
                file_put_contents($file, $file_contents);
            }
    }

    // rename lang file
    $lang_old = $source . '/lang/en/theme_' . $search . '.php';
    $lang_new = $source . '/lang/en/theme_' . $replace . '.php';
    rename($lang_old, $lang_new);
}

function add_custom_css() {
    
}