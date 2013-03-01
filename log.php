<?php

if(!defined('LOG_DEBUG')) define('LOG_DEBUG',7);
if(!defined('LOG_INFO')) define('LOG_INFO',6);
if(!defined('LOG_NOTICE')) define('LOG_NOTICE',5);
if(!defined('LOG_WARN')) define('LOG_WARN',1);
if(!defined('LOG_ERROR')) define('LOG_ERROR',0);

function dolog($msg,$level=LOG_INFO){
	global $_log_fh;
	if($level > Config::get('log','level')) return null;
	if(!$_log_fh){
		$_log_fh = fopen(Config::get('log','file'),'a');
		if(!$_log_fh) throw new Exception('Could not open log: '.Config::get('log','file'));
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
	$fmtd_msg = sprintf(Config::get('log','format'),$lword,$date,$msg).PHP_EOL;
	if(php_sapi_name() == 'cli' && !defined('LOG_QUIET')) echo $fmtd_msg;
	return fwrite($_log_fh,$fmtd_msg);
}

function _closelog(){
	global $_log_fh;
	if(is_resource($_log_fh)) return fclose($_log_fh);
	return false;
}

