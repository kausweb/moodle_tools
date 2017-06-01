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
 * Generates a basic language file
 *
 * @param string $plugin_type
 * @param string $plugin_name
 * @param string $plugin_path
 * @param array $placeholders
 */

function init_lang($plugin_type, $plugin_name, $plugin_path, $placeholders) {
    $placeholders['pluginname'] = $plugin_name; // this is a string value
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
        $string = file_get_contents($f['templatepath']);
        $file_path = $f['filepath'];
        write_file($file_path, replace_placeholder($string, $placeholders));
    }
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
        if(substr($file_path, -3) != 'php') {
            fwrite($file, $content);
        }else{
            fwrite($file, "<?php \n\n". $content);
        }
        fclose($file);
    }
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
 * Copy theme
 *
 * @param type $source
 * @param type $dest
 */
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

/**
 * Make changes to the copied theme to reflect the new theme name
 *
 * @param type $source
 * @param type $search
 * @param type $replace
 */
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
