<?php
	class ViewsSQLite extends Views {
		private $db;

		public function __construct() {
			$this->db = new SQLite3(cwd."/norty.db");
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

		public function getViews($name): int {
			$statement = $this->db->prepare("SELECT * FROM websites WHERE code = :code AND `month` = :month AND `year` = :year");
			$statement->bindValue("code", $name);
			$statement->bindValue("month", currentMonth);
			$statement->bindValue("year", currentYear);

			$result = $statement->execute()->fetchArray();

			if($result === false) {
				return 0;
			}

			return $result["count"];
		}

		private function exists($name) {
			$statement = $this->db->prepare("SELECT * FROM websites WHERE code = :code AND `month` = :month AND `year` = :year");
			$statement->bindValue("code", $name);
			$statement->bindValue("month", currentMonth);
			$statement->bindValue("year", currentYear);

			return is_array($statement->execute()->fetchArray());
		}

		private function create($name, $views = 0) {
			$statement = $this->db->prepare("INSERT INTO websites (code, referrer, count, `month`, `year`) VALUES (:code, :referrer, :views, :month, :year)");
			$statement->bindValue("code", $name);
			$statement->bindValue("referrer", $_SERVER["HTTP_REFERER"] ?? null);
			$statement->bindValue("views", $views);
			$statement->bindValue("month", currentMonth);
			$statement->bindValue("year", currentYear);

			$statement->execute();
		}

		public function inc($name): void {
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