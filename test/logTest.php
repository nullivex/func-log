<?php
require_once(dirname(__DIR__).'/vendor/autoload.php');
require('boot.php');
ld('config','func/log');
define('LOG_QUIET',true);

class FuncLogTest extends PHPUNIT_Framework_TestCase {

	public function testDolog(){
		global $_log_fh;
		$tmpfile = tempnam('/tmp','LTS');
		if(file_exists($tmpfile)) unlink($tmpfile);
		$config = null;
		if(is_object(Config::$inst)) $config = clone Config::$inst;
		Config::set('log','file',$tmpfile);
		Config::set('log','level',LOG_INFO);
		Config::set('log','date_format','mdY');
		Config::set('log','format','[%s] %s - %s');
		dolog('test info',LOG_INFO);
		_closelog();
		$log = file_get_contents($tmpfile);
		$this->assertEquals(18,strpos($log,'test info'));
		unlink($tmpfile);
		//restore original config
		if(is_object($config)) Config::$inst = $config;
		$_log_fh = false;
	}

}
