<?php

// Kickstart the framework
$f3=require('lib/base.php');

// init.php
require_once('api/init.php');

/*function execute_command($CMD) {
	$tmp = exec(escapeshellcmd($CMD), $out, $ret);
	if ($ret == 0) {
		return $out;
	} else {
		return false;
	}
}*/

$f3->set('DEBUG',1);
if ((float)PCRE_VERSION<7.9)
	trigger_error('PCRE version is out of date');

// Load configuration
$f3->config('config.ini');

// List all partitions
$f3->route('GET /partitions', function() {
	$out = execute_command('sinfo --noheader --format=%R');
	if ($out) {
		echo json_encode($out);
	}
});

// Configuration of a given partition
// TODO
$f3->route('GET /partition/@partition_name', function() {
	echo new Partition($params['partition_name']).jsonSerialize();
});

$f3->run();
