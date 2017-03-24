<?php
	function execute_command($CMD, ...$params) {
		if (isset($params)) {
			foreach ($params as $key => $value) {
				$params[$key] = escapeshellarg($value);
			}
		}
		exec(escapeshellcmd($CMD), $out, $ret);
		if ($ret == 0) {
			return $out;
		} else {
	  	throw new Exception("An error occured: ".$ret);
	  }
  }

	//require_once('jobs.php');
	require_once('partitions.php');
?>
