<?php
/*!
* Fib Php Trace v0.0.1
* A simple php script that you can include in your project to obtain 
* a simple and useful trace of your code.
*  
* Copyright 2011, Fabio Sfuncia aka fiblan
* Dual licensed under the MIT or GPL Version 2 licenses.
*
* Instructions
* 1. Copy fib_php_trace.php in directory of your project
* 2. include fibphp_trace at top of your index.php (or your main file)
* 3. that's all. You obtain the trace at the end of your page 
* 
*/


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$all_trace = array();

function fib_trace(){
	global $all_trace,$files_trace,$count;
 	$count++;
	if (!isset( $all_trace ))
        	$all_trace=array();
    	if (!isset( $files_trace ))
		$files_trace=array();
    	$current_trace = debug_backtrace();
	//TODO: correct object...
    	if (!isset( $current_trace[1]["file"] ) && isset( $current_trace[1]["object"] ) ){
		$current_trace[1]["file"]="object";//$current_trace[1]["object"];
		$current_trace[1]["line"]="0";
	}
	if ( !isset( $files_trace[$current_trace[1]["file"]] ) )
        	$files_trace[$current_trace[1]["file"]]="0";
    	if ( isset($current_trace[1]["args"] ) )
		if ( $files_trace[$current_trace[1]["file"]]!=$current_trace[1]["line"] ){
        		$files_trace[$current_trace[1]["file"]]=$current_trace[1]["line"];
        		$last_point = $current_trace[1]["file"]." ".$current_trace[1]["line"].":   \n\t".$current_trace[1]["function"]."(".(empty($current_trace[1]["args"])?"":var_export($current_trace[1]["args"],TRUE)).")";//?"":implode(",",$current_trace[1]["args"])).")";
        		if ( $last_point!=end( $all_trace ) )
            			$all_trace[]=$last_point;
    		}
	}

function fib_trace_show(){
	global $all_trace;
	foreach ($all_trace as $n=>$s)
		$trace_line[]= "$n >>".htmlspecialchars($s);    
	echo "<ul><li>".join( "<li></li>",$trace_line )."</li></ul>";    
}

register_tick_function( "fib_trace" );

register_shutdown_function( "fib_trace_show" );

declare( ticks = 1 );

?>
