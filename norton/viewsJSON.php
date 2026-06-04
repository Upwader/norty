<?php
	class ViewsJSON extends Views {
		private $views;

		public function __construct() {
			$file = @file_get_contents(cwd."/views.json");
			if($file !== false) {
				$this->views = json_decode($file, true);
			} else {
				$this->views = [];
			}
		}

		private function commit() {
			$file = fopen(cwd."/norty.json", "w");

			// flock locks a file and disallows other php scripts from writing to it, if it's locked it'll return false.
			if(flock($file, LOCK_EX)) {
				$new = json_encode($this->views, JSON_PRETTY_PRINT);
				ftruncate($file, 0);
				rewind($file);
				fwrite($file, $new, strlen($new));
				flock($file, LOCK_UN);
			} else {
				sleep(1);
				write();
			}
		}

		private function ensure($name) {
			// Ensures that year, month and user exists in the JSON file by checking it thrice

			if(!isset($this->views[currentYear])) {
				$this->views[currentYear] = [];
			}
			if(!isset($this->views[currentYear][currentMonth])) {
				$this->views[currentYear][currentMonth] = [];
			}
			if(!isset($this->views[currentYear][currentMonth][$name])) {
				$this->views[currentYear][currentMonth][$name] = [
					"code" => $name,
					"referrer" => $_SERVER["HTTP_REFERER"] ?? null,
					"count" => 0,
					"lastvisited" => null,
					"created" => date("Y-m-d H:i:s"),
				];
			}
		}

		public function getViews($name): int {
			$this->ensure($name);
			return $this->views[currentYear][currentMonth][$name]["count"];
		}

		public function inc($name): void {
			$this->ensure($name);
			$page = $this->views[currentYear][currentMonth][$name];
			$this->views[currentYear][currentMonth][$name] = [
				...$page,
				"count" => $page["count"] + 1,
				"referrer" => $_SERVER["HTTP_REFERER"] ?? null,
				"lastvisited" => date("Y-m-d H:i:s"),
			];
			$this->commit();
		}
	}