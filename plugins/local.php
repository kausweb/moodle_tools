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

    // set plugin base files
    $files = array('lang','index','lib');
    // init files
    init_files($plugin_type, $plugin_name, $plugin_path, $placeholders, $files);
}

