<?php
mysql_connect ('localhost', 'root', '');
mysql_select_db('syren');

$do = $_GET['do'];
switch($do) {
    case 'check_NUM_NIF_exists':
        if(get_magic_quotes_gpc()) {
            $NUM_NIF = $_GET['NUM_NIF'];
        }else{
            $NUM_NIF = addslashes($_GET['NUM_NIF']);
        }
        $count = mysql_num_rows(mysql_query("SELECT * FROM `individu` WHERE `NUM_NIF`='".$NUM_NIF."'"));
        header('Content-Type: text/xml');
        header('Pragma: no-cache');
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<result>';
        if($count > 0) {
            echo 'Ce NIF existe déjà, veuillez en choisir un autre.';
        }else{
            echo 'NIF disponible.';
        }
        echo '</result>';
    break;
    default:
        echo 'Error, invalid action';
    break;
}
?> 