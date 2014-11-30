<?php
	class Time{
		public function fetch_all() {
			global $pdo;
			$query = $pdo->prepare("
				SELECT *
				FROM class_times
				");
			$query->execute();
			return $query->fetchall();
		}
	}
?>