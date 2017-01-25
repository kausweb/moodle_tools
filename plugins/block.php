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
    // init lang
    init_lang($plugin_type, $plugin_name, $plugin_path, $placeholders);

    // set plugin base files
    $files = array(
        'base' => array('templatepath' => 'templates/'.$plugin_type.'/base.txt','filepath' => $plugin_path.'/'.$plugin_type.'_'.$plugin_name.'.php'),
        'access' => array('templatepath' => 'templates/'.$plugin_type.'/access.txt', 'filepath' => $plugin_path.'/db/access.php'),
        'install' => array('templatepath' => 'templates/install.txt', 'filepath' => $plugin_path.'/db/install.php'),
        'renderer' => array('templatepath' => 'templates/renderer.txt', 'filepath' => $plugin_path.'/classes/renderer.php'),
    );
    // init files
    init_files($plugin_type, $plugin_name, $plugin_path, $placeholders, $files);
}

