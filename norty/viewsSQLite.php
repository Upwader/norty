<?php
	
	// Didn't comment over most of this code because I feel like it's really really simple

	class ViewsSQLite extends Views {
		private $db;

		public function __construct() {
			if(file_exists(cwd."/norty.db")) {
				// 05/06/2026: move files into subfolders
				rename(cwd."/norty.db", cwd."/database/norty.db");
			}

			$this->db = new SQLite3(cwd."/database/norty.db");
			$this->db->exec("
				CREATE TABLE IF NOT EXISTS `websites` (
					`id` INTEGER PRIMARY KEY AUTOINCREMENT,
					`code` TEXT NOT NULL,
					`referrer` TEXT NULL,
					`count` INT NOT NULL,
					`month` INT NOT NULL,
					`year` INT NOT NULL,
					`lastvisited` TIMESTAMP NULL DEFAULT NULL,
					`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
				)");
		}

		public function getViews(string $name): int {
			$statement = $this->db->prepare("SELECT * FROM websites WHERE code = :code AND `month` = :month AND `year` = :year");
			$statement->bindValue("code", $name);
			$statement->bindValue("month", currentMonth);
			$statement->bindValue("year", currentYear);

			$result = $statement->execute()->fetchArray();

			// fetchArray returns false if no rows
			if($result === false) {
				return 0;
			}

			return $result["count"];
		}

		private function exists(string $name): bool {
			$statement = $this->db->prepare("SELECT * FROM websites WHERE code = :code AND `month` = :month AND `year` = :year");
			$statement->bindValue("code", $name);
			$statement->bindValue("month", currentMonth);
			$statement->bindValue("year", currentYear);

			// fetchArray returns false if no rows and an array if there are rows so we can just return is_array 
			return is_array($statement->execute()->fetchArray());
		}

		private function create(string $name, int $views = 0): void {
			$statement = $this->db->prepare("INSERT INTO websites (code, referrer, count, `month`, `year`) VALUES (:code, :referrer, :views, :month, :year)");
			$statement->bindValue("code", $name);
			$statement->bindValue("referrer", $_SERVER["HTTP_REFERER"] ?? null);
			$statement->bindValue("views", $views);
			$statement->bindValue("month", currentMonth);
			$statement->bindValue("year", currentYear);

			$statement->execute();
		}

		public function inc(string $name): void {
			if(!$this->exists($name)) {
				$this->create($name, 1);
				return;
			}
			$statement = $this->db->prepare("UPDATE websites SET count = count + 1, referrer = :referrer, lastvisited = CURRENT_TIMESTAMP
											WHERE code = :code AND `month` = :month AND `year` = :year");
			$statement->bindValue("referrer", $_SERVER["HTTP_REFERER"] ?? null);
			$statement->bindValue("code", $name);
			$statement->bindValue("month", currentMonth);
			$statement->bindValue("year", currentYear);
			$statement->execute();

		}
}