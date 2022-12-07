<?php
mysql_connect ('localhost', 'root', '');
mysql_select_db('syren');

$do = $_GET['do'];
switch($do) {
    case 'check_NUM_PASSPORT_exists':
        if(get_magic_quotes_gpc()) {
            $NUM_PASSPORT = $_GET['NUM_PASSPORT'];
        }else{
            $NUM_PASSPORT = addslashes($_GET['NUM_PASSPORT']);
        }
        $count = mysql_num_rows(mysql_query("SELECT * FROM `individu` WHERE `NUM_PASSPORT`='".$NUM_PASSPORT."'"));
        header('Content-Type: text/xml');
        header('Pragma: no-cache');
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<result>';
        if($count > 0) {
            echo 'Ce Numéro de passeport à déjà été utilisé, veuillez en choisir un autre.';
        }else{
            echo 'Numéro de passeport disponible.';
        }
        echo '</result>';
    break;
    default:
        echo 'Error, invalid action';
    break;
}
?> 