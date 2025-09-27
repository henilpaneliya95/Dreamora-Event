<?php
include("header.php");
?>

    	<!-- start team -->
    	<section id="team " class="py-5">
    		<div class="container">
    			<div class="row">
    				<div class="col-md-12">
    					<h2 class="wow bounceIn" data-wow-offset="50" data-wow-delay="0.3s"><span>PHOTOGRAPHER</span> </h2>
    				</div>
					
<?php
$sql ="SELECT * FROM employee where status='Active' AND employeetype='Photographer'";					
$qsql = mysqli_query($con,$sql);
while($rs = mysqli_fetch_array($qsql))
{
	if($rs['empimage'] == "")
	{
		$img = "images/photo.jpg";
	}
	else if(file_exists("imgemp/".$rs['empimage']))
	{
		$img = "imgemp/".$rs['empimage'];
	}
	else
	{
		$img = "images/photo.jpg";
	}
?>
	<div class="col-md-4 col-sm-6 col-xs-12 mb-4" data-wow-offset="50" data-wow-delay="1.3s"  onclick="window.location='photographerprofile.php?photographerid=<?php echo $rs[0]; ?>&locationid=<?php echo $_GET['locationid']; ?>'">
		<div class="card">
			<img src="<?php echo $img; ?>" class="img-responsive" style="height: 250px;width: 100%;">
				<div class="card-body">
					<h4><?php echo $rs['employeename']; ?></h4>
					<p><?php echo $rs['empprofile']; ?></p>
    				<span>₹<?php echo $rs['photographycost']; ?> per day</span>
				</div>
		</div>
	<hr>
	</div>
<?php
}
?>
					
				</div>
    		</div>
    	</section>
    	<!-- end team -->

<style>
     .row {
  display: flex;
  flex-wrap: wrap;
  align-items: stretch;  /* badha cards ni height equal */

}

.card {
    display: flex;
    flex-direction: column;   /* content upar thi niche align */
    justify-content: space-between; /* button/price niche fix rahe */
    height: 100%;  
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-bottom: 20px;
    padding: 20px;
	
}

.card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    cursor: pointer;
}

.card img {
    height: 250px;
    width: 100%;
    object-fit: cover; /* image crop thai ne equal size ma dekhase */
}


</style>

<?php
include("footer.php");
?>