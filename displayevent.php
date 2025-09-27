<?php
include("header.php");
?>

    	<!-- start team -->
    	<section id="team" class="py-5">
    		<div class="container">
    			<div class="row">
    				<div class="col-md-12">
    					<h2 class="wow bounceIn" data-wow-offset="50" data-wow-delay="0.3s"><span>EVENT</span> Types</h2>
    				</div>
					
<?php
$sql ="SELECT * FROM eventtype where status='Active'";					
$qsql = mysqli_query($con,$sql);
while($rs = mysqli_fetch_array($qsql))
{
	if(file_exists("imgevent/".$rs['eventimg']))
	{
		$img = "imgevent/".$rs['eventimg'];
	}
	else
	{
		$img = "images/event.png";
	}
?>
	<div class="col-md-4 col-sm-6 col-xs-12 mb-4 " data-wow-offset="50" data-wow-delay="1.3s"  onclick="window.location='displaypackage.php?locationid=<?php echo $_GET['locationid']; ?>&eventtypeid=<?php echo $rs[0]; ?>';" >
		<div class="card ">
			<img src="<?php echo $img; ?>" class="card-img-top" alt="team img 1">
				<div class="card-body ">
					<h4 class="card-title"><?php echo $rs['eventtype']; ?></h4>
					<p class="card-text text-muted flex-grow-1"><?php echo $rs['eventdescription']; ?></p>
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

.card {
    height: 100%;  
    border-radius: 12px;
    overflow: hidden; /* image card box andar proper fit thase */
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
	margin-bottom: 20px;
	padding: 10px;
}
.card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
	cursor: pointer;
}
.card-img-top {
    height: 210px;       /* fix image height */
    width: 100%;         /* full card width */
    object-fit: cover;   /* crop thai ne fit thase */
    display: block;
	padding: 0;
}

.card-title {
    font-size: 20px;
    font-weight: 600;
}
.card-text {
    font-size: 14px;
    color: #555;
}
</style>

<?php
include("footer.php");
?>