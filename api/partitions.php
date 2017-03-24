<?php
	class Partition implements JsonSerializable {
		private $name = "";
		private $values = null;

		function __construct($name) {
			if (!is_string($name)) { throw new Exception("Not a String"); }
			if (!in_array($name, $this->list_partitions())) { throw new Exception("Nost an existing partition!"); }
			$this->name = $name;
			$this->values = $this->get_values();
		}

		function get_values() {
			try {
				$exec_string = execute_command('scontrol --oneliner show partition '.$this->name);
				$exec_array = explode(' ', $exec_string[0]);
				$return_array = array();
				foreach ($exec_array as $value) {
					$return_array[] = explode('=', $value);
				}
				return $return_array;
			} catch (Exception $e) {
				echo 'Exception: '.$e->getMessage();
			}
		}

		function jsonSerialize() {
			return json_encode($this->values);
		}

		static public function list_partitions() {
			try{
				$sinfo = execute_command('sinfo --noheader --format=%R') or die('Failure');
				return $sinfo;
			} catch (Exception $e) {
				echo 'Exception: '.$e->getMessage();
			}
		}
	}
?>
