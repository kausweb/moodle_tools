<?php

/**
 * Init block templates
 * 
 * creates
 *  - db
 *   - install.xml
 *   - access.php
 *   - install.php
 *  - lang
 *    - en
 *     - block_$blockname.php
 *  - block_$blockname.php
 *  - version.phps
 * 
 * 
 * @param string $blockname
 */

require_once ('config.php');
require_once ('lib.php');

function init_block($plugin_name, $project) {
    global $config;
    $plugin_type = 'block';
    $plugin_path = $config->projectpath .'/'. $project.'/trunk/blocks/'.$plugin_name;
    $directories = array('db','lang/en','classes');
    // placeholders
    $placeholders = get_base_placeholders($plugin_type, $plugin_name);
    // init dir
    init_dirs($plugin_path, $directories);
    // init version
    init_version($plugin_type, $plugin_name, $plugin_path);
    
    // set plugin base files
    $files = array('base','access','install','lang','renderer');
    // init files
    init_files($plugin_type, $plugin_name, $plugin_path, $placeholders, $files);
}

