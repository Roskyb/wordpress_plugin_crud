<?php
class Comentarios_shortcode
{
    function __construct()
    {
        add_shortcode('shortcode-comentarios', [$this, 'shortcode_content']);
    }

    public function shortcode_content()
    {
        $this->perfomaceAction();
        $bg_color = get_option('_comentarios_bg_color');
?>
        <table style=" text-align: center;">
            <form action="" method="post">
                <thead <?php echo "style='background-color: $bg_color'"; ?>>
                    <th>USER</th>
                    <th>DATE</th>
                    <th colspan="2"></th>
                </thead>
                <tbody>
                    <?php
                    $comments = $this->getCommentsFromDB();
                    $appr_img = $this->root_path() . "/../images/" . get_option('approve_img');
                    $del_img = $this->root_path() . "/../images/" . get_option('delete_img');
                    foreach ($comments as $comment) {
                    ?>
                        <tr>
                            <td>
                                <?php echo $comment->comment_author ?>
                            </td>
                            <td <?php echo "title='$comment->comment_content'"  ?>>
                                <?php echo $comment->comment_date ?>
                            </td>
                            <td>
                                <?php
                                $com_id = $comment->comment_id;
                                echo "  <button type='submit' name='deleteID' value='$com_id' style='background: none !important; border: none !important;'>
                                            <img src='$del_img' alt='del' width='30'>
                                        </button>";

                                ?>

                            </td>
                            <td>
                                <?php

                                if ($comment->comment_approved == 0) {
                                    echo "  <button type='submit' name='updateID' value='$com_id' style='background: none !important; border: none !important;'>
                                                <img src='$appr_img' alt='app' width='30'>
                                            </button>";
                                } else {
                                    echo "Aprobado";
                                }

                                ?>
                            </td>
                        </tr>

                    <?php
                    }

                    ?>
                </tbody>
            </form>
        </table>
<?php

    }

    public function perfomaceAction()
    {
        // if (isset($_GET['deleteId'])) {
        //     $this->deleteComment($_GET['deleteId']);
        // } else {
        //     if (isset($_GET['updateId'])) {
        //         $this->updateComment($_GET['updateId']);
        //     }
        // }

        if (isset($_POST['deleteID'])) {
            $this->deleteComment($_POST['deleteID']);
        }else{
            if (isset($_POST['updateID'])) {
                $this->updateComment($_POST['updateID']);
            }
        }
    }

    public function updateComment(string $id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "comments";
        // WORDPRESS WAY
        // $wpdb->update(
        //     $table_name, //table
        //     array('comment_approved' => 1), //data
        //     array('comment_id' => $id), //where
        //     array('%s'), //data format
        //     array('%s') //where format
        // );
        
        // RAUL WAY xddddd
        $sql = "UPDATE $table_name SET comment_approved = 1 WHERE comment_id=$id";
        $db = new PDO("mysql:host=localhost;dbname=repaso;", 'root', '');
        $succes = $db->exec($sql);
        if($succes === false){
            echo "Failed!";
        }else{
            echo "Succes!";
        }

    }

    public function deleteComment(string $id)
    {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $query = "delete from " . $prefix . "comments where comment_id=%s";
        $wpdb->query($wpdb->prepare($query, $id));
    }

    public function getCommentsFromDB(): array
    {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $query = "select comment_id, comment_author, comment_date, comment_approved, comment_content from " . $prefix . "comments";
        $results = $wpdb->get_results($query);
        return $results;
    }

    public function root_path()
    {
        $ruta_total = __DIR__;
        $ruta_root = $_SERVER['DOCUMENT_ROOT'];
        $ruta_desde_root = substr($ruta_total, strlen($ruta_root));
        return $ruta_desde_root;
    }
}
