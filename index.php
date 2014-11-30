<?php
include_once ('core/connections.php');
include_once ('core/func/schedule.php');
$schedule = New Schedule;
$schedules = $schedule->fetch_all();
include_once ('core/func/time.php');
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
	<div id="wrapper">
			<div id="addTable">
				<table>
					<form class="form-horizontal" role="form" method="GET">
						<tr>
							<td>
								<input id="group" name="group" type="text" placeholder="grupė" autocomplete="off"/><br/>
								<input id="staff" name="staff" type="text" placeholder="dėstytojas" autocomplete="off"/><br/>
								<input type="date" /><br/>
								<input type="submit" name="Pateikti" /><input type="reset" value="Atšaukti">
							</td>
							<td>
								<select id="pickTime" name="time" multiple>
									<?php
										foreach ($times as $time => $v) {
											echo "<option value=$time>".$v[1]."</option>";
										}
									?>
								</select>
								<input id="hiddenGroup" class="hidden" /><input id="hiddenStaff" class="hidden" />
							</td>
					</form>
				</table>
			</div>
		<table class="scheduleTable">
			<thead><tr><th>Laikas</th><th>Paskaita</th><th>Kabinetas</th></tr></thead>
			<tbody>
				<?php
				foreach ($schedules as $schedule) {
					$text = ($schedule['s_prefixText'] !== "") ? "<b>".$schedule['s_prefixText']."</b><br/>" : "";
					$text .= $schedule['course_title'];
					$text .= "<br/>(";
					$text .= ($schedule['staff_prefix'] !== "") ? $schedule['staff_prefix']." " : "";
					$text .= $schedule['staff_firstName'] . " " . $schedule['staff_lastName'];
					$text .= ")<br/>" . $schedule['s_postfixText'];
				?>
				<tr>
					<td><?=$schedule['time_time'];?></td>
					<td><?=$text;?></td>
					<td><?=$schedule['class_class'];?></td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>
	<script src="js/jquery-2.1.1.min.js"></script>
	<script src="js/javascript.js"></script>
    <script src="js/jquery-ui-1.10.4.custom.autocomplete.min.js"></script>
</body>
</html>