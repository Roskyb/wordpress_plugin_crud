<?php

class Comentarios_Widget extends WP_Widget
{
    public function __construct()
    {
        $widget_options = array(
            'classname' => 'Comentarios_Widget',
            'description' => 'Gestion de comentarios'
        );
        parent::__construct('Comentarios_Widget', 'Gestion de comentarios', $widget_options);
    }


    public function widget($args, $instance)
    {

        $data = $this->getCommentCounts();
        $total = $data[0];
        $unapproved = $data[1];
?>
        <ul <?php
            $bg = get_option('_comentarios_bg_color');
            echo "  style='background-color: $bg; 
                            border-radius: 25px; 
                            list-style:none; padding: 2%;
                            color: white;'";
            ?>>
            <li style="padding: 2%;">Comentarios</li>
            <li style="padding: 2%;">Comentarios(total): <?php echo $total ?>.</li>
            <li style="padding: 2%;">Comentarios(sin aprobar):<?php echo  $unapproved ?>.</li>
        </ul>
<?php
    }

    public function getCommentCounts()
    {
        global $wpdb;
        $tablename = $wpdb->prefix . "comments";
        $query1 = "select count(*) as total from $tablename";
        $query2 = "select count(*) as total from $tablename where comment_approved = 0";
        $results = [
            $wpdb->get_var($query1),
            $wpdb->get_var($query2),
        ];
        return $results;
    }
}

function gc_register_widget()
{
    register_widget('Comentarios_Widget');
}
