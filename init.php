<?php

require_once ('config.php');
require_once ('lib.php');

/**
 * $arg = array(
 *              0 => 'script name' - always has the script name
 *              1 => 'plugin type'
 *              2 => 'plugin name'
 *              3 => 'project' - eg nspc_dev
 *          );
 */
$arg = var_dump($argv);

// get the plugin type
// eg blocks, local 
$plugin_type = $arg[1];
$plugin_name = $arg[2];
$project = $arg[3];


init_.$plugin_type($plugin_name, $project);

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

function init_block($plugin_name, $project) {
    $plugin_type = 'block';
    $plugin_path = $config->projectpath .'/'. $project.'/blocks';
    $directories = array(
        $plugin_name, 'db','lang/en','classes'  
    );
    // placeholders
    $placeholders = array(
        'plugin_name' => $plugin_name,
        'plugin_type' => $plugin_type,
        'plugin_display_name' => get_plugin_display_name($plugin_name)
    );
    // init dir
    init_dirs($plugin_path, $directories);
    // init version
    init_version($plugin_type, $plugin_name, $plugin_path);
    // init base class
    init_base($plugin_type, $plugin_path, $plugin_path, $placeholders);
    // init access
    init_access($plugin_type, $plugin_path, $plugin_path, $placeholders);
    // init install
    init_install($plugin_type, $plugin_path, $plugin_path, $placeholders);
    // init lang 
    init_lang($plugin_type, $plugin_path, $plugin_path, $placeholders);
    // inin renderer
    init_renderer($plugin_type, $plugin_path, $plugin_path, $placeholders);
}