<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     outputfilter.tidyrepairhtml.php
 * Type:     outputfilter
 * Name:     tidyrepairhtml
 * Version:  1.0
 * Date:     Sept. 20, 2003
 * Purpose:  Uses the tidy extension to repair a mailformed HTML
 *           template before displaying it
 * Install:  Drop into the plugin directory, call 
 *           $smarty->load_filter('output','tidyrepairhtml');
 *           from application.
 * Author:   John Coggeshall <john@php.net>
 * -------------------------------------------------------------
 */
 function smarty_outputfilter_tidyrepairhtml ($source, &$smarty)
 {
    if(extension_loaded('tidy')) {
        tidy_parse_string($source);
        tidy_clean_repair();
        return  tidy_get_output();
    } 
    return $source; 
 }

?>