<?php

/**
 * Init local plugin templates
 *
 * creates
 *  - lang
 *    - en
 *     - local_$blockname.php
 *  - index.php
 *  - version.php
 *
 *
 * @param string $blockname
 */

/**
    set plugin base files
    $files = array(
        'base' => array('templatepath' => 'templates/'.$plugin_type.'/base.txt','filepath' => $plugin_path.'/'.$plugin_type.'_'.$plugin_name.'.php'),
        'access' => array('templatepath' => 'templates/'.$plugin_type.'/access.txt', 'filepath' => $plugin_path.'/db/access.php'),
        'install' => array('templatepath' => 'templates/install.txt', 'filepath' => $plugin_path.'/db/install.php'),
        'renderer' => array('templatepath' => 'templates/renderer.txt', 'filepath' => $plugin_path.'/classes/renderer.php'),
        'edit_form' => array('templatepath' => 'templates/'.$plugin_type.'/edit_form.txt', 'filepath' => $plugin_path.'/edit_form.php'),
        'index' => array('templatepath' => 'templates/'.$plugin_type.'/index.txt', 'filepath' => $plugin_path.'/index.php'),
        'lib' => array('templatepath' => 'templates/'.$plugin_type.'/lib.txt', 'filepath' => $plugin_path.'/lib.php'),
    );
*/

require_once ('config.php');
require_once ('lib.php');

function init_local($plugin_name, $project) {
    global $config;
    $plugin_type = 'local';
    $plugin_path = $config->projectpath .'/'. $project.'/trunk/local/'.$plugin_name;
    $directories = array('lang/en');
    // placeholders
    $placeholders = get_base_placeholders($plugin_type, $plugin_name);
    // init dir
    init_dirs($plugin_path, $directories);
    // init version
    init_version($plugin_type, $plugin_name, $plugin_path);
    // init lang
    init_lang($plugin_type, $plugin_name, $plugin_path, $placeholders);

    // set plugin base files
    $files = array('lang','index','lib');
    $files = array(
        'index' => array('templatepath' => 'templates/'.$plugin_type.'/index.txt', 'filepath' => $plugin_path.'/index.php'),
        'lib' => array('templatepath' => 'templates/'.$plugin_type.'/lib.txt', 'filepath' => $plugin_path.'/lib.php')
    );
    // init files
    init_files($plugin_type, $plugin_name, $plugin_path, $placeholders, $files);
}

