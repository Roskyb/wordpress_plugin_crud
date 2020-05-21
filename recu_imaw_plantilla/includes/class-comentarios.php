<?php


class Comentarios{

    public function run(){
        add_action('admin_menu', [$this, 'comentarios_menu_page']);
        add_action('admin_init',[$this, 'gc_save_options_changes']);
        $this->gc_shortcode();
        $this->gc_widget();
    }

    public function comentarios_menu_page(){
        $page_tittle = "Ajustes Gestion de comentarios";
        $menu_text = "Ajustes Gestion de comentarios";
        $view_target = "administrator";
        $option_page_id = "gestion-comentarios-configuracion";
        // if u prefer the page apear in the settings menu change the function to:
        // add_options_page() 
        // else add_menu_page()
        add_menu_page(
            $page_tittle, 
            $menu_text, 
            $view_target, 
            $option_page_id, 
            [$this, 'gc_menu_page_content'], // Function that draw the page
            'dashicons-admin-generic' // Icon in the menu page );
        );
    }

    public function gc_menu_page_content(){
                ?>
                <div class="wrap">
                    <h1>Gestion de comentarios</h1>
                    <p>Zona de administración de opciones.</p>
                    <h2>Elige el color de fondo</h2>
                    <form action="options.php" method="post">
                    <?php 
                        // Set a name for get the data later
                        settings_fields('gestion-comentarios-configuracion');
                    ?>
                    <input type="text" name="_comentarios_bg_color"  placeholder="el color que tu quieras papi">
                    <input type="text" name="_comentarios_size"  placeholder="Tamaño de letra">
                    <?php submit_button()?>
                    </form>
                </div>
                <?php
    }


    public function gc_save_options_changes(){
        // if the option does not exits it will create a new one
        register_setting('gestion-comentarios-configuracion', '_comentarios_bg_color');
        register_setting('gestion-comentarios-configuracion', '_comentarios_size');
    }

    public function gc_shortcode() {
        require plugin_dir_path( __FILE__ ) . 'class-shortcode.php'; 
        new Comentarios_shortcode();
    }

    public function gc_widget(){
        require plugin_dir_path( __FILE__ ) . 'class-widget.php'; 
        add_action('widgets_init', 'gc_register_widget');
    }

}