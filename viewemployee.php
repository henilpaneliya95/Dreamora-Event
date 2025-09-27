<?php
include("header.php");

// read and sanitize emptype; if not provided show all employees
$emptype = isset($_GET['emptype']) ? mysqli_real_escape_string($con, trim($_GET['emptype'])) : '';

if(isset($_GET['delid']))
{
	$sql = "DELETE FROM employee WHERE employee_id='". (int)$_GET['delid'] ."'";
	$qsql = mysqli_query($con,$sql);
	echo mysqli_error($con);
	if(mysqli_affected_rows($con) == 1)
	{
		echo "<script>alert('Employee  record deleted successfully..');</script>";
	}
}
?>
<style>
		label{
		color: white;
	}
	.pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
    z-index: 2;
    color: #fff;
    cursor: default;
    background-color: rgb(175, 148, 83);
    border-color: rgb(175, 148, 83);
}
</style>
    	<!-- start contact -->
    	<section id="contact">
    		<div class="container">
    			<div class="row">
    				<div class="col-md-12">
    					<h2 class="wow bounceIn" data-wow-offset="50" data-wow-delay="0.3s">View <?php echo $emptype ? $emptype : 'Employees'; ?></h2>
    				</div>
    				<div class="col-md-12 col-sm-12 col-xs-12 wow fadeInLeft" data-wow-offset="50" data-wow-delay="0.9s">
					
	<table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%"> 
		<thead>
			<tr>
				<th>Employee Image</th>
				<th>Employee Type</th>
				<th>Employee name</th>
				<th>Login ID</th>
				<th>Employee Profile</th>
				<?php
				if($emptype == "Photographer") {
				?>
				<th>Photography Cost</th>
				<?php } ?>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody style="color:black;">
		<?php
		// choose query based on emptype; show all if not specified
		if($emptype != '') {
		    $sql = "SELECT * FROM employee WHERE employeetype='$emptype'";
		} else {
		    $sql = "SELECT * FROM employee";
		}
		$qsql = mysqli_query($con,$sql);
		while($rs = mysqli_fetch_array($qsql))
		{
			// build URLs preserving emptype so user returns to same filtered view
			$editUrl = "employee.php?editid=" . (int)$rs['employee_id'] . ($emptype ? "&emptype=" . urlencode($emptype) : "");
			$delUrl  = "viewemployee.php?delid=" . (int)$rs['employee_id'] . ($emptype ? "&emptype=" . urlencode($emptype) : "");

			echo "<tr>
				<td><img src='imgemp/". htmlspecialchars($rs['empimage']) ."' style='width:100px;height:75px;' ></td>
				<td>". htmlspecialchars($rs['employeetype']) ."</td>
				<td>". htmlspecialchars($rs['employeename']) ."</td>
				<td>". htmlspecialchars($rs['loginid']) ."</td>
				<td>". htmlspecialchars($rs['empprofile']) ."</td>";
				if($emptype == "Photographer") {
			echo "<td>₹". htmlspecialchars($rs['photographycost']) ."</td>";
				}
			echo "<td>". htmlspecialchars($rs['status']) ."</td>
				<td><a href='$editUrl' class='btn btn-info'> Edit </a> <a href='$delUrl' onclick='return confirmdelete()' class='btn btn-danger'> Delete </a> </td>
			</tr>";
		}
		?>			
		</tbody>
	</table>
				</div>
    			</div>
    		</div>
    	</section>
    	<!-- end contact -->
<?php
include("footer.php");
?>
<script type="text/javascript" language="javascript" class="init">
function confirmdelete()
{
	if(confirm("Are you sure want to delete this record?") == true)
	{
		return true;	
	}
	else
	{
		return false;
	}
}

$(document).ready(function() {
	$('#datatable').DataTable();
} );
</script>