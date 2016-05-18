<?php
error_reporting(-1);
/**
 * In cli mode
 * $arg = array(
 *              0 => 'script name' - always has the script name
 *              1 => 'plugin type'
 *              2 => 'plugin name'
 *              3 => 'project' - eg nspc_dev
 *          );
 */
if (php_sapi_name() == "cli") {
    $arg = $argv;
    // get the plugin type
    // eg blocks, local 
    $plugin_type = $arg[1];
    $plugin_name = $arg[2];
    $project = $arg[3];
} else {
    // if in browser mode
    $plugin_name = $_GET['name'];
    $plugin_type = $_GET['type'];
    $project = $_GET['project'];
}


// check plugin file exists
// check function init exists 
// call init function
if(file_exists('plugins/'.$plugin_type.'.php')) {
    require_once ('plugins/'.$plugin_type.'.php');
    if(function_exists('init_'.$plugin_type)) {
        call_user_func('init_'.$plugin_type, $plugin_name, $project);
    }
}