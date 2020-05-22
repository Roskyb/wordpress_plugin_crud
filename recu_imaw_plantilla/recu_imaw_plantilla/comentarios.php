<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Recuperacion IMAW
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       Gestion de comentarios
 * Version:           1.0.0
 * Author:            Jorge Blanco
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gestion-comentarios
 * Domain Path:       /languages
 */


// In this function we call the actions that occur 
// when the plugin is activated in wordpress 

function plugin_activation(){
    require plugin_dir_path( __FILE__ ) . 'includes/class-comentarios-activation.php'; 
    Comentarios_Activation::activation();
}

register_activation_hook(__FILE__, 'plugin_activation');


// Function to run the plugin
function run_plugin(){
    require plugin_dir_path( __FILE__ ) . 'includes/class-comentarios.php'; 
    $root = new Comentarios();
    $root->run();
}

// Calling the functions thats run the plugin
run_plugin();