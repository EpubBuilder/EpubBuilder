<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// |                            Artisan Smarty                            |
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright 2004-2005 ARTISAN PROJECT All rights reserved.             |
// +----------------------------------------------------------------------+
// | Authors: Akito<akito-artisan@five-foxes.com>                         |
// +----------------------------------------------------------------------+
//
/**
 * ArtisanSmarty plugin
 * @package ArtisanSmarty
 * @subpackage plugins
 */

/**
 * ArtisanSmarty <%cycle%> function plugin
 *
 * Type:     function<br>
 * Name:     cycle<br>
 * Date:     2005/06/10 23:54<br>
 * Purpose:  cycle through given values<br>
 * Input:
 *         - name = name of cycle (optional)
 *         - values = comma separated list of values to cycle,
 *                    or an array of values to cycle
 *                    (this can be left out for subsequent calls)
 *         - reset = boolean - resets given var to true
 *         - print = boolean - print var or not. default is true
 *         - advance = boolean - whether or not to advance the cycle
 *         - delimiter = the value delimiter, default is ","
 *         - assign = boolean, assigns to template var instead of
 *                    printed.
 *
 * Examples:<br>
 * <pre>
 * {cycle values="#eeeeee,#d0d0d0d"}
 * {cycle name=row values="one,two,three" reset=true}
 * {cycle name=row}
 * </pre>
 * @link http://smarty.php.net/manual/en/language.function.cycle.php {cycle}
 *       (Smarty online manual)
 * @author Monte Ohrt <monte at ohrt dot com>
 * @author credit to Mark Priatel <mpriatel@rogers.com>
 * @author credit to Gerard <gerard@interfold.com>
 * @author credit to Jason Sweat <jsweat_php@yahoo.com>
 * @author Akito<akito-artisan@five-foxes.com>
 * @since 2005/06/10 23:54
 * @version 1.3
 * @param array
 * @param Smarty
 * @return string|null
 */
function smarty_function_cycle($params, &$smarty)
{
    static $cycle_vars;
    
    $name = (empty($params['name'])) ? 'default' : $params['name'];
    $print = (isset($params['print'])) ? (bool)$params['print'] : true;
    $advance = (isset($params['advance'])) ? (bool)$params['advance'] : true;
    $reset = (isset($params['reset'])) ? (bool)$params['reset'] : false;
            
    if (!in_array('values', array_keys($params))) {
        if(!isset($cycle_vars[$name]['values'])) {
            $smarty->trigger_error("cycle: missing 'values' parameter");
            return;
        }
    } else {
        if(isset($cycle_vars[$name]['values'])
            && $cycle_vars[$name]['values'] != $params['values'] ) {
            $cycle_vars[$name]['index'] = 0;
        }
        $cycle_vars[$name]['values'] = $params['values'];
    }

    $cycle_vars[$name]['delimiter'] = (isset($params['delimiter'])) ? $params['delimiter'] : ',';
    
    if(is_array($cycle_vars[$name]['values'])) {
        $cycle_array = $cycle_vars[$name]['values'];
    } else {
        $cycle_array = explode($cycle_vars[$name]['delimiter'],$cycle_vars[$name]['values']);
    }
    
    if(!isset($cycle_vars[$name]['index']) || $reset ) {
        $cycle_vars[$name]['index'] = 0;
    }
    
    if (isset($params['assign'])) {
        $print = false;
        $smarty->assign($params['assign'], $cycle_array[$cycle_vars[$name]['index']]);
    }
        
    if($print) {
        $retval = $cycle_array[$cycle_vars[$name]['index']];
    } else {
        $retval = null;
    }

    if($advance) {
        if ( $cycle_vars[$name]['index'] >= count($cycle_array) -1 ) {
            $cycle_vars[$name]['index'] = 0;
        } else {
            $cycle_vars[$name]['index']++;
        }
    }
    
    return $retval;
}

/* vim: set expandtab: */

?>