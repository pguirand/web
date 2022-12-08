<?php
mysql_connect ('localhost', 'root', '');
mysql_select_db('syren');

$do = $_GET['do'];
switch($do) {
    case 'check_NUM_CIF_exists':
        if(get_magic_quotes_gpc()) {
            $NUM_CIF = $_GET['NUM_CIF'];
        }else{
            $NUM_CIF = addslashes($_GET['NUM_CIF']);
        }
        $count = mysql_num_rows(mysql_query("SELECT * FROM `individu` WHERE `NUM_CIF`='".$NUM_CIF."'"));
        header('Content-Type: text/xml');
        header('Pragma: no-cache');
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<result>';
        if($count > 0) {
            echo 'Ce CIN existe déjà, veuiller en choisir un autre.';
        }else{
            echo 'CIN disponible.';
        }
        echo '</result>';
    break;
    default:
        echo 'Error, invalid action';
    break;
}
?> 