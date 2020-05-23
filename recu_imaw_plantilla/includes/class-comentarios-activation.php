<?php


// In this class we define the things that we need to occur in 
// the moment when the plugin is activated in wordpress

class Comentarios_Activation
{

    public static function activation()
    {
        Comentarios_Activation::set_plugin_backgroud_color();
        Comentarios_Activation::upload_images();
    }

    public static function set_plugin_backgroud_color()
    {
        $option_name = '_comentarios_bg_color';
        $value = '#ad34e5';
        update_option($option_name, $value);
    }

    // not optimal implementation but xd
    public static function delete_plugin_options()
    {
        delete_option('_comentarios_bg_color');
        delete_option('approve_img');
        delete_option('delete_img');
    }

    public static function upload_images()
    {
        update_option('approve_img', "approve.png");
        update_option('delete_img', "delete.png");
    }
}
