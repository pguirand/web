<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty lower modifier plugin
 *
 * Type:     modifier<br>
 * Name:     host<br>
 * Purpose:  returns the host of an URL
 * @author   Jerome Loisel <loisel.jerome@gmail.com>
 * @param string
 * @return string
 */
function smarty_modifier_host($string)
{
	$parsed_url = parse_url($string);
	
    return $parsed_url['host'];
}

?>
