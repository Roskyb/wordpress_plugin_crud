<?php


class Comentarios{
    // this could be a constructor but this is clearer
    public function run(){
        add_action('admin_menu', [$this, 'comentarios_menu_page']);
        add_action('admin_init',[$this, 'gc_save_options_changes']);
        add_action( 'admin_enqueue_scripts', [$this, 'color_picker_assets'] );
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
            'dashicons-admin-generic' // Icon in the menu page 
        );
    }

    public function gc_menu_page_content(){
                $actual_color = get_option('_comentarios_bg_color');
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
                    <input type="text" name="_comentarios_bg_color" class="my-color-field"
                        <?php echo "value='$actual_color'" ?>
                    >
                    <br>
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

    // set the shortcode
    public function gc_shortcode() {
        require plugin_dir_path( __FILE__ ) . 'class-shortcode.php'; 
        new Comentarios_shortcode();
    }
    // set the widget
    public function gc_widget(){
        require plugin_dir_path( __FILE__ ) . 'class-widget.php'; 
        add_action('widgets_init', 'gc_register_widget');
    }
    

    // Function to use color picker in admin page
    public function color_picker_assets($hook_suffix) {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'my-script-handle', plugins_url('js/my-script.js', __DIR__ ), array( 'wp-color-picker' ), false, true );
     }
     

}