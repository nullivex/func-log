<?php
/**
 *  OpenLSS - Lighter Smarter Simpler
 *
 *	This file is part of OpenLSS.
 *
 *	OpenLSS is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU Lesser General Public License as
 *	published by the Free Software Foundation, either version 3 of
 *	the License, or (at your option) any later version.
 *
 *	OpenLSS is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU Lesser General Public License for more details.
 *
 *	You should have received a copy of the 
 *	GNU Lesser General Public License along with OpenLSS.
 *	If not, see <http://www.gnu.org/licenses/>.
 */
use \LSS\Config;

if(!defined('LOG_DEBUG')) define('LOG_DEBUG',7);
if(!defined('LOG_INFO')) define('LOG_INFO',6);
if(!defined('LOG_NOTICE')) define('LOG_NOTICE',5);
if(!defined('LOG_WARN')) define('LOG_WARN',1);
if(!defined('LOG_ERROR')) define('LOG_ERROR',0);

function dolog($msg,$level=LOG_INFO){
	global $_log_fh;
	if($level > Config::get('log','level')) return null;
	if(!$_log_fh){
		$file = Config::get('log','file');
		if($file === false) return null; //assume logging is off
		$_log_fh = fopen($file,'a');
		if(!$_log_fh) throw new Exception('Could not open log: '.$file);
		register_shutdown_function('_closelog');
	}
	switch($level){
		case LOG_DEBUG:
			$lword = 'DEBUG';
			break;
		case LOG_INFO:
			$lword = 'INFO';
			break;
		case LOG_NOTICE:
			$lword = 'NOTICE';
			break;
		case LOG_WARN:
			$lword = 'WARNING';
			break;
		case LOG_ERROR:
			$lword = 'ERROR';
			break;
		default:
			$lword = 'UNKNOWN';
			break;
	}
	$date = date(Config::get('log','date_format'));
	//we dont want newlines in output, let the output wrap naturally
	//$msg = str_replace("\n",' ',$msg);
	$fmtd_msg = sprintf(Config::get('log','format'),$lword,$date,$msg).PHP_EOL;
	if(php_sapi_name() == 'cli' && !defined('LOG_QUIET'))
		if(strlen($fmtd_msg) < 1024)
			echo $fmtd_msg;
		else
			echo substr($fmtd_msg,0,1024)."<SNIP>\n";
	return fwrite($_log_fh,$fmtd_msg);
}

function _closelog(){
	global $_log_fh;
	if(is_resource($_log_fh)) return fclose($_log_fh);
	return false;
}

