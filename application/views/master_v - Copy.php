<?php error_reporting(E_ALL^E_NOTICE);

?>

<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>Scripts/jquery.dataTables.js"></script>
<style type="text/css" title="currentStyle">

@import "<?php echo base_url(); ?>DataTables-1.9.3 /media/css/jquery.dataTables.css";
</style>
<?php $current_year = date('Y');
	$earliest_year = $current_year - 10;
?>
<script type="text/javascript" charset="utf-8">
	/* Define two custom functions (asc and desc) for string sorting */
	jQuery.fn.dataTableExt.oSort['string-case-asc'] = function(x, y) {
		return ((x < y) ? -1 : ((x > y) ? 1 : 0));
	};

	jQuery.fn.dataTableExt.oSort['string-case-desc'] = function(x, y) {
		return ((x < y) ? 1 : ((x > y) ? -1 : 0));
	};

	$(document).ready(function() {
		/* Build the DataTable with third column using our custom sort functions */
		$('#example').dataTable({
			"bJQueryUI" : true,

			"aaSorting" : [[0, 'asc'], [1, 'asc']],
			"aoColumnDefs" : [{
				"sType" : 'string-case',
				"aTargets" : [2]
			}]
		});
	}); 
</script>



				<div>
					<div style="margin-left: 80%" >
		<a href="<?php echo site_url('report_management/commodity_excel');?>">
			<div class="activity excel"><h2> Download</h2></div>
			</a></div>
				<p>
				<h1 style="text-align: center"><?php echo $this -> uri -> segment(3); ?> Incident Report</h1>
				<table  style="margin-left: 0;" id="example" width="100%">
				<thead>
				<tr>

				<th>Diseases</th>
				<th>Date</th>
				<th>Time</th>
				<th>Sex</th>
				<th>Age</th>
				<th>Old Age</th>
				<th>Old Sex</th>
				<th>Old Status</th>
				<th>MFL</th>
				<th>HF Name</th>
				<th>Incidence Id</th>
				<th>Status</th>
				
				</tr>
				</thead>

				<tbody>
				<?php
				foreach($all as $row):
					if($this->uri->segment(1)=="ebola_Reports"){
						$facility=$row->facility_info;
					}
					else{
						$facility=$row->incident;
					}
				foreach($facility as $d):
				foreach($row->disease_name as $faci):

				?>
				<tr>
				<td><?php echo $faci -> Full_Name; ?></td>
				<td><?php $a = $row->Time; $dt = new DateTime($a); echo $dt->format('j F, Y') ?></td>
				<td><?php $b = $row->Time; $dts = new DateTime($b); echo $dts->format('g:i A') ?></td>
				<td><?php echo $row -> Sex; ?></td>
				<td><?php echo $row -> Age; ?></td>
				<td><?php echo $row -> New_Sex; ?></td>
				<td><?php echo $row -> New_Age; ?></td>
				<td><?php echo $row -> New_Status; ?></td>
				<td><?php echo $row -> Mfl_Code; ?></td>
				<td><?php echo $d -> Facility_name; ?></td>
				<td><?php echo $row -> p_id; ?></td>
				<td><?php
				if ($row -> Status == 'D') {
					echo 'Dead';
				} else {
					echo 'Alive';
				}
				?></td>

			</tr>
			<?php endforeach; ?>
			<?php endforeach; ?>
			<?php endforeach; ?>

			</tbody>

		</table>
		</p>

</div>
