<?php
	class Schedule{
		public function fetch_all() {
			global $pdo;
			$query = $pdo->prepare("
				SELECT *
				FROM schedule s
				LEFT JOIN classrooms class
					ON s.i_classroom = class.class_id
				LEFT JOIN class_times time
					ON s.i_time = time.time_id
				LEFT JOIN courses_names course
					ON s.i_course = course.course_id
				LEFT JOIN staff
					ON s.i_staff = staff.staff_id
				ORDER BY s.d_date
				");
			$query->execute();
			return $query->fetchall();
		}
	}
?>