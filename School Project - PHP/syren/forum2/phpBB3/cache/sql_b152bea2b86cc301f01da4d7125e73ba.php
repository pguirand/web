<?php
if (!defined('IN_PHPBB')) exit;

/* SELECT forum_id, forum_name, parent_id, forum_type, left_id, right_id FROM phpbb_forums ORDER BY left_id ASC */

$expired = (time() > 1253370071) ? true : false;
if ($expired) { return; }

$this->sql_rowset[$query_id] = unserialize('a:2:{i:0;a:6:{s:8:"forum_id";s:1:"1";s:10:"forum_name";s:26:"Votre première catégorie";s:9:"parent_id";s:1:"0";s:10:"forum_type";s:1:"0";s:7:"left_id";s:1:"1";s:8:"right_id";s:1:"4";}i:1;a:6:{s:8:"forum_id";s:1:"2";s:10:"forum_name";s:19:"Votre premier forum";s:9:"parent_id";s:1:"1";s:10:"forum_type";s:1:"1";s:7:"left_id";s:1:"2";s:8:"right_id";s:1:"3";}}');

?>