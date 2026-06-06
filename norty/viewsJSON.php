<?php

	// This Sucks And You Should Not Use It.

	class ViewsJSON extends Views {
		private $views;

		public function __construct() {
			// I fucked up and last commit I accidentally had commit() write to norty.json but this function read from views.json
			// For the literal ghosts who still have views.json I'm doing them a favor and renaming views.json to norty.json
			if(file_exists(cwd."/views.json")) {
				rename(cwd."/views.json", cwd."/database/norty.json");
			}
			if(file_exists(cwd."/norty.json")) {
				// 05/06/2026: move files into subfolders
				rename(cwd."/norty.json", cwd."/database/norty.json");
			}

			$file = @file_get_contents(cwd."/database/norty.json");

			if($file !== false) {
				$this->views = json_decode($file, true);
			} else {
				$this->views = [];
			}
		}

		private function commit(): void {
			$file = fopen(cwd."/norty.json", "w");

			// flock locks a file and disallows other php scripts from writing to it, if it's locked it'll return false.
			if(flock($file, LOCK_EX)) {
				$new = json_encode($this->views, JSON_PRETTY_PRINT);
				// I feel like most people don't use fopen in php anymore so I'm just gonna say exactly what this does:
				// truncates file to 0 length, rewinds file pointer to the start, writes file, and unlocks the file.
				ftruncate($file, 0);
				rewind($file);
				fwrite($file, $new, strlen($new));
				flock($file, LOCK_UN);
			} else {
				// The file is in use, so sleep for 1 second and try again.
				// Is this a good solution? https://youtu.be/xpkV_eXRlKE?t=68
				sleep(1);
				write();
			}
		}

		private function ensure(string $name): void {
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

		public function getViews(string $name): int {
			$this->ensure($name);
			return $this->views[currentYear][currentMonth][$name]["count"];
		}

		public function inc(string $name): void {
			$this->ensure($name);

			// I figure this should work better than setting each value the normal way
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