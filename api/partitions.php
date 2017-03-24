<?php
	class Partition implements JsonSerializable {
		private name = "";
		private values = null;

		function __construct($name) {
			if (!is_string($name)) { throw new Exception("Not a String"); }
			if (!in_array($name, list_partitions())) { throw new Exception("Nost an existing partition!"); }
			$this->name = $name;
			$this->values = array();
			$this->values = $this->get_values();
		}

		function get_values() {
			return execute_command('scontrol --oneliner show partition '.$this->name);
		}

		public function jsonSerialize() {
			return json_encode($this->$values);
		}

		static function list_partitions() {
			$sinfo = execute_command('sinfo --noheader --format=%R') or die('Failure');
			echo $sinfo;
		}
	}
?>
