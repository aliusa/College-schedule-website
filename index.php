<?php
include_once ('core/connections.php');
include_once ('core/func/schedule.php'); //Schedule class
$schedule = New Schedule;
$schedules = $schedule->fetch_all();
include_once ('core/func/time.php'); //Time class
$time = New Time;
$times = $time->fetch_all();
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/jquery-ui-1.10.4.custom.css">
	<link rel="stylesheet" href="css/autocomplete.css">
    <script src="js/jquery-ui-1.8.19.dialog.min.js"></script>
</head>
<body>
<!--
	<div id="wrapper">
			<a href="#" id="AddNewSchedule">Pridėti</a>
			<div id="addTable">
				<table>
					<form class="form" role="form" method="GET">
						<tr>
							<td>
								<input id="course" name="course" type="text" placeholder="dalykas" autocomplete="off" />
								<input id="staff" name="staff" type="text" placeholder="dėstytojas" autocomplete="off" /><br/>
								<input id="group" name="group" type="text" placeholder="grupė" autocomplete="off" />
								<input type="date" /><br/>
								<input type="submit" name="Pateikti" /><input type="reset" value="Atšaukti" />
							</td>
							<td>
								<select id="pickTime" name="time" multiple> <?php // for easier/faster managing user can select multiple times at once ?>
									<?php
										foreach ($times as $time => $v) {
											echo "<option value=$time>".$v[1]."</option>"; //0-id, 1-time
										}
									?>
								</select>
								<input id="hiddenCourse" class="hidden" placeholder="course" />
								<input id="hiddenStaff" class="hidden" placeholder="staff" />
								<input id="hiddenGroup" class="hidden" placeholder="group" />
							</td>
					</form>
				</table>
			</div>
		<table class="scheduleTable">
			<thead><tr><th>Laikas</th><th>Paskaita</th><th>Kabinetas</th></tr></thead>
			<tbody>
				<?php
				foreach ($schedules as $schedule) {
					//if s_prefixText exists, then display it
					$text = ($schedule['s_prefixText'] !== "") ? "<b>".$schedule['s_prefixText']."</b><br/>" : "";
					$text .= $schedule['course_title'] . "<br/>(" . $schedule['staff_displayName'] . ")";
					//if s_postfixText exists, then display it
					$text .= ($schedule['s_postfixText'] !== "") ? "<br/>".$schedule['s_postfixText'] : "";
					
					//display row
					echo "<tr>";
					echo "<td>" . $schedule['time_time'] . "</td>";
					echo "<td>" . $text . "</td>";
					echo "<td>" . $schedule['class_class'] . "</td>";
					echo "</tr>";
				}
				?>
			</tbody>
		</table>
	</div>
	<script src="js/jquery-2.1.1.min.js"></script>
	<script src="js/javascript.js"></script>
    <script src="js/jquery-ui-1.10.4.custom.autocomplete.min.js"></script>
-->
</body>
</html>