<?php

/**
 * Helps create basic plugin file structure
 *
 * @package    tools
 * @copyright  &copy; 2016 CG Kineo {@link http://www.kineo.com}
 * @author     kaushtuv.gurung
 * @version    1.0
 */

require_once ('config.php');

/**
 * Creates directories
 *
 * @param type $plugin_path
 * @param type $directories
 */

function init_dirs($plugin_path, $directories) {
    foreach ($directories as $d) {
        $new_dir = $plugin_path .'/'.$d;
        if(!file_exists($new_dir)) {
            mkdir($new_dir, 0777, true);
        }
    }
}


/**
 * Create a basic base class
 *
 * @param string $plugin_type
 * @param string $plugin_name
 * @param string $plugin_path
 * @param array $placeholders
 */
function init_base($plugin_type, $plugin_name, $plugin_path, $placeholders) {
    $string = file_get_contents('templates/'.$plugin_type.'/base.txt');
    // write base class file.
    $file_path = $plugin_path.'/'.$plugin_type.'_'.$plugin_name.'.php';
    write_file($file_path, replace_placeholder($string, $placeholders));
}

/**
 * Create a basic renderer class
 *
 * @param string $plugin_type
 * @param string $plugin_name
 * @param string $plugin_path
 * @param array $placeholders
 */
function init_renderer($plugin_type, $plugin_name, $plugin_path, $placeholders) {
    $string = file_get_contents('templates/renderer.txt');
    // write renderer.php file.
    $file_path = $plugin_path.'/classes/renderer.php';
    write_file($file_path, replace_placeholder($string, $placeholders));
}

/**
 * Create a basic base class
 *
 * @param string $plugin_type
 * @param string $plugin_name
 * @param string $plugin_path
 * @param array $placeholders
 */
function init_edit_form($plugin_type, $plugin_name, $plugin_path, $placeholders) {
    $string = file_get_contents('templates/'.$plugin_type.'/edit_form.txt');
    // write basic edit_form.php file.
    $file_path = $plugin_path.'/edit_form.php';
    write_file($file_path, replace_placeholder($string, $placeholders));
}


/**
 * Generates a basic language file
 *
 * @param string $plugin_type
 * @param string $plugin_name
 * @param string $plugin_path
 * @param array $placeholders
 */

function init_lang($plugin_type, $plugin_name, $plugin_path, $placeholders) {
    $placeholders['pluginname'] = str_replace('_', '', $plugin_name); // this is a string value
    $string = file_get_contents('templates/'.$plugin_type.'/lang.txt');
    // write lang file.
    $file_path = $plugin_path . '/lang/en/'.$plugin_type.'_'.$plugin_name.'.php';
    write_file($file_path, replace_placeholder($string, $placeholders));
}

/**
 * Generates a version file
 *
 * @param string $plugin_type
 * @param string $plugin_name
 * @param string $plugin_path
 */

function init_version($plugin_type, $plugin_name, $plugin_path) {
    global $config;
    $string = file_get_contents('templates/version.txt');
    $placeholders = array(
        'plugin_info' => get_plugin_info($plugin_type, $plugin_name),
        'version' => date('Ymd').'00',
        'requires' => $config->moodleversion,
        'component' => $plugin_type.'_'.$plugin_name,
        'release' => '1'
        );

    // write version.php file.
    $file_path = $plugin_path . '/version.php';
    write_file($file_path, replace_placeholder($string, $placeholders));

}

/**
 * Create a basic access file
 *
 * @param string $plugin_type
 * @param string $plugin_name
 * @param string $plugin_path
 * @param array $placeholders
 */
function init_access($plugin_type, $plugin_name, $plugin_path, $placeholders) {
    $string = file_get_contents('templates/'.$plugin_type.'/access.txt');
    // write access.php file.
    $file_path = $plugin_path.'/db/access.php';
    write_file($file_path, replace_placeholder($string, $placeholders));
}

/**
 * Create a basic install file
 *
 * @param string $plugin_type
 * @param string $plugin_name
 * @param string $plugin_path
 * @param array $placeholders
 */
function init_install($plugin_type, $plugin_name, $plugin_path, $placeholders) {
    $string = file_get_contents('templates/install.txt');
    // write install.php file.
    $file_path = $plugin_path.'/db/install.php';
    write_file($file_path, replace_placeholder($string, $placeholders));
}

/**
 * Create a index.php file
 *
 * @param string $plugin_type
 * @param string $plugin_name
 * @param string $plugin_path
 * @param array $placeholders
 */
function init_index($plugin_type, $plugin_name, $plugin_path, $placeholders) {
    $string = file_get_contents('templates/'.$plugin_type.'/index.txt');
    // write access.php file.
    $file_path = $plugin_path.'/index.php';
    write_file($file_path, replace_placeholder($string, $placeholders));
}

/**
 * Create a lib.php file
 *
 * @param string $plugin_type
 * @param string $plugin_name
 * @param string $plugin_path
 * @param array $placeholders
 */
function init_lib($plugin_type, $plugin_name, $plugin_path, $placeholders) {
    $string = file_get_contents('templates/'.$plugin_type.'/lib.txt');
    // write access.php file.
    $file_path = $plugin_path.'/lib.php';
    write_file($file_path, replace_placeholder($string, $placeholders));
}

/**
 * A common function to write content to a file
 *
 * @param string $file_path
 * @param string $content
 */

function write_file($file_path, $content) {
    if(!file_exists($file_path)){
        $file = fopen($file_path, 'w');
        fwrite($file, "<?php \n\n". $content);
        fclose($file);
    }
}

/**
 * Gets the plugin header info
 *
 * @param type $plugin_type
 * @param type $plugin_name
 * @return string
 */

function get_plugin_info($plugin_type, $plugin_name) {
    global $config;
    $string = file_get_contents('templates/plugin_info.txt');
    $placeholders = array(
        'package' => $plugin_type,
        'subpackage' => $plugin_name,
        'copyright' => $config->copyright,
        'author' => $config->author,
        );
    return replace_placeholder($string, $placeholders);
}

/**
 * Replaces placeholder from the template file
 *
 * @param string $string
 * @param array $placeholders
 * @return type
 */

function replace_placeholder($string, $placeholders) {
    foreach ($placeholders as $key => $val) {
        $string = str_replace('[['.$key.']]', $val, $string);
    }
    return $string;
}

/**
 * Split plugin name to remove underscore and make the first letter of the first
 * word an uppercase
 *
 * @param string $plugin_name
 * @return string plugin name
 */
function get_plugin_display_name($plugin_name) {
    return str_replace('_',' ', ucfirst($plugin_name));

}

/**
 * Returns base placeholders
 *
 * @param string $plugin_type
 * @param string $plugin_name
 * @return array placeholders
 */
function get_base_placeholders($plugin_type, $plugin_name) {
    return array(
        'plugin_info' => get_plugin_info($plugin_type, $plugin_name),
        'plugin_name' => $plugin_name,
        'plugin_type' => $plugin_type,
        'plugin_display_name' => get_plugin_display_name($plugin_name)
    );
}


/**
 * init plugin files
 *
 * @param string $plugin_type
 * @param string $plugin_name
 * @param string $plugin_path
 * @param array $placeholders
 * @param array $files
 */
function init_files($plugin_type, $plugin_name, $plugin_path, $placeholders, $files) {
    // init files
    foreach($files as $f) {
        if(function_exists('init_'.$f)) {
            call_user_func('init_'.$f, $plugin_type, $plugin_name, $plugin_path, $placeholders);
        }
    }
}


