<?php
require('../includes/config.php'); 

include_once ('../includes/functions.php');
$staff = New Staff;
$staffs = $staff->fetch_all();

//make sure user is logged in, function will redirect use if not logged in
login_required();

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo SITETITLE;?></title>
	<link href="<?php echo DIR;?>css/style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo DIR;?>js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="<?php echo DIR;?>js/jquery.tablesorter.js"></script>
</head>
<body>
	<div id="wrapper">
		<?php
			$currentPage = "staff"; /**/
			require('navigation.php');
		?>
		<table id="myTable" align="center" class="sortable tablesorter">
			<thead>
				<tr>
					<th>Pilnas vardas</th>
					<th>priešdėlis</th>
					<th>Vardas</th>
					<th>Pavardė</th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach ($staffs as $staff) {
					echo "<tr data-line=\"{$staff['staff_id']}\">";
					echo "<td>".$staff['staff_displayName']."</td>";
					echo "<td>".$staff['staff_prefix']."</td>";
					echo "<td>".$staff['staff_firstName']."</td>";
					echo "<td>".$staff['staff_lastName']."</td>";
					echo "</tr>";
				}
			?>
			</tbody>
		</table>
	</div>
	<script type="text/javascript">
		//initialize table sorter script
		$(document).ready(function() 
			{
				$("#myTable").tablesorter();
			}
		);
	</script>
</body>
</html>