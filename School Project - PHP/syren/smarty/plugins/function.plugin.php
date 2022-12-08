<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

 /*
 *	Example :
 *	<{plugin name='info' call='displayPhpVersion' parameters="foo,bar"}>
 *	calls  plugin named 'info', function 'displayVersion', with an array as parameter : array(0 => foo, 1 => bar)
 *
 *	Note : 
 *	- 'name' is the name of the directory containing the plugin
 *	- 'call' is the name of the function to call
 *	- each parameter in 'parameters' must be separate with delimiter (here it is ',')
 */

/**
 * Smarty {eval} function plugin
 *
 * Type:     function<br>
 * Name:     plugin<br>
 * Purpose:  calls a plugin function within a template and returns its output
 *       (Smarty online manual)
 * @author Jerome Loisel <vanadium@tiscali.fr>
 * @param array
 * @param Smarty
 */

if(!defined("SCRIPT_ROOT_PATH"))
{
	//echo "SCRIPT_ROOT_PATH not define in ".dirname(__FILE__);
	exit();
}

/*
*	builds an array from string parameters
*/
function &makeArray($string, $delimiter=',')
{
	return explode($delimiter, $string);
}

/*
*	Purpose : calls a plugin function with specified parameters if the plugin is active.
*		returns the output of plugin's function
*
*	@param array
*	@param reference on {@object smarty}
*	@return string
*/
function smarty_function_plugin($params, &$smarty)
{
	global $lang;
	$cm =& MyConfigManager::getInstance();
	$CONFIG =& $cm->getConfig();
	// Plugin which is invoked
	$name = isset($params['name']) ? $params['name'] : null;
	// Plugin's function which is invoked
	$call = isset($params['call']) ? $params['call'] : null;
	// plugin inclusions buffer to avoid including several times the same file
	static $inclusion;
	static $plugin_list;
	
    if (!isset($name))
	{
        $smarty->trigger_error("plugin: Plugin name is missing");
        return;
    }
	if(!isset($call))
	{
		$smarty->trigger_error("Plugin: Plugin call is missing");
        return;
	}
	
	
	// Buffering plugin's function output
	if(!isset($inclusion[$name][$call]))
	{
		if(!isset($plugins_list))
		{
			$plugins_root = SCRIPT_ROOT_PATH.'/plugins/';
			$plugins = new plugins($plugins_root);
			$plugins->getPlugins(false);
			$plugins_list = $plugins->getPluginsList();
		}

		// Only load plugin if active
		if(!$plugins_list[$name]['active'])
		{
			$smarty->trigger_error("Plugin: Plugin must be active to allow function call");
			return;
		}
		
		$function_file = SCRIPT_ROOT_PATH.'/plugins/'.$name.'/functions.php';
		if(!file_exists($function_file))
		{
			$smarty->trigger_error("Plugin: Plugin '".$name."' functions.php file does not exists");
			return;
		}
		
		$inclusion[$name][$call] = true;
		require_once($function_file);
	}
	
	// checking if call function isset
	if(!function_exists($call))
	{
		$smarty->trigger_error("Plugin: Plugin call function '".$call."' does not exists");
		return;
	}
	
	// Plugin's function parameters
	$parameters = isset($params['parameters']) ? $params['parameters'] : null;

	// Loading plugin lang file
	$lang_file = SCRIPT_ROOT_PATH.'/plugins/'.$name.'/language/'.$CONFIG['language'].'/lang.php';
	if(file_exists($lang_file))
	{
		require_once($lang_file);
	}
	else
	{
		$smarty->trigger_error("Plugin: Plugin '".$CONFIG['language']."' language file does not exists");
		return;
	}
	
	if(isset($parameters))
	{
		// converting parameters string to array
		$parameters =& makeArray($parameters);
		
		ob_start();
		$call($parameters);
	}
	else
	{	
		// No parameter
		ob_start();
		$call();
	}
	
	$content = ob_get_contents();
	// Cleaning buffer
	 ob_end_clean();
	 
	return $content;
}

?>
