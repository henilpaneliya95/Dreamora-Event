<?php
// start session if not already started (prevents using $_SESSION before session_start)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("header.php");

// --- NEW: helper + handler to insert invoice safely ---
function insert_invoice($con, $event_booking_id, $invoicetype, $invoiceamt, $invoicedate) {
    $sql = "INSERT INTO invoice (event_booking_id, invoicetype, invoiceamt, invoicedate) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) return false;
    // types: i = integer, s = string, d = double
    mysqli_stmt_bind_param($stmt, "isds", $event_booking_id, $invoicetype, $invoiceamt, $invoicedate);
    $ok = mysqli_stmt_execute($stmt);
    if (!$ok) { mysqli_stmt_close($stmt); return false; }
    $new_id = mysqli_insert_id($con);
    mysqli_stmt_close($stmt);
    return $new_id;
}

$invoice_msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_invoice'])) {
    // check one-time token to prevent duplicate inserts on refresh
    if (isset($_POST['invoice_token'], $_SESSION['invoice_token']) && hash_equals($_SESSION['invoice_token'], $_POST['invoice_token'])) {
        // consume token immediately
        unset($_SESSION['invoice_token']);

        $event_booking_id = (int)$_POST['event_booking_id'];
        $invoicetype = mysqli_real_escape_string($con, trim($_POST['invoicetype']));
        $invoiceamt = (float)$_POST['invoiceamt'];
        $invoicedate = date('Y-m-d');
        $newId = insert_invoice($con, $event_booking_id, $invoicetype, $invoiceamt, $invoicedate);
        if ($newId !== false) {
            $invoice_msg = "Invoice created (ID: $newId)";
        } else {
            $invoice_msg = "Invoice creation failed";
        }
    } else {
        // token missing or already used (likely a refresh/resubmit) — prevent duplicate insert
        $invoice_msg = "Duplicate or invalid submission. Invoice was not created again.";
    }
}
// generate a fresh token for the form if not present
if (empty($_SESSION['invoice_token'])) {
    try {
        $_SESSION['invoice_token'] = bin2hex(random_bytes(16));
    } catch (Exception $e) {
        // fallback if random_bytes not available
        $_SESSION['invoice_token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }
}
// --- end new code ---

?>
    	<!-- start team -->
    	<section id="team" style="background: white;">
    		<div class="container">
    			<div class="row">
    				<div class="col-md-12">
    					<h2 class="wow bounceIn" data-wow-offset="50" data-wow-delay="0.3s">---<span>Customer Account</span>---</h2>
    				</div>					
					
	<div class="col-md-6 col-sm-6 col-xs-12 wow fadeIn" class="mod_backcolor" data-wow-offset="50" data-wow-delay="1.3s" onclick="window.location='vieweventbookingrecord.php'">
		<div class="team-wrapper">
			<img src="images/eventbook.jpg" class="img-responsive" style="height:200px;width:100%;">
				<div class="team-des">
					<h4>Event Booking</h4>
					<span>Number of Bookings</span>
					<p>
<?php
$sql = "SELECT * FROM event_booking where customer_id='$_SESSION[customer_id]'";
$qsql = mysqli_query($con,$sql);
echo mysqli_error($con);
echo mysqli_num_rows($qsql) ." bookings";
?>									
					</p>
				</div>
		</div>
	</div>
					
					
					
	<div class="col-md-6 col-sm-6 col-xs-12 wow fadeIn" data-wow-offset="50" data-wow-delay="1.6s" onclick="window.location='viewphotographybooking.php'">
		<div class="team-wrapper">
			<img src="images/photography.jpg" class="img-responsive" style="height:200px;width:100%;">
				<div class="team-des">
					<h4>PHOTOGRAPHER</h4>
					<span> Number of photographers booked</span>
					<p>
				<?php
				$sql = "SELECT * FROM photography_booking where customer_id='$_SESSION[customer_id]'";
				$qsql = mysqli_query($con,$sql);
				echo mysqli_num_rows($qsql)." Photographers booked";
				?>
					</p>
				</div>
		</div>
	</div>
					
    				<div class="col-md-6 col-sm-6 col-xs-12 wow fadeIn" data-wow-offset="50" data-wow-delay="1.3s">
    					<div class="team-wrapper">
    						<img src="images/dueamount.jpg" class="img-responsive" style="height:200px;width:100%;">
    							<div class="team-des">
    								<h4>Event Booking Balance Amount</h4>
    								<p>
<?php
	$sqlevent_booking = "SELECT * FROM event_booking WHERE customer_id='$_SESSION[customer_id]'";
	$qsqlevent_booking = mysqli_query($con,$sqlevent_booking);
	echo mysqli_error($con);
	$rsevent_booking = mysqli_fetch_array($qsqlevent_booking);
	if(mysqli_num_rows($qsqlevent_booking) != 0) {

		$bookingfdate = date_create($rsevent_booking['bookingfdate']);
		$bookingtdate = date_create($rsevent_booking['bookingtdate']);
	
		//difference between two dates
		$diff = date_diff($bookingfdate,$bookingtdate);
	
		//count days
		$nodays = $diff->format("%a")+1;
	
		//Total cost
		$totalcost = $rsevent_booking['booking_cost'] * $nodays;
		
		$sqlpayment ="SELECT sum(paid_amt) FROM payment WHERE eventbookingid='$rsevent_booking[event_booking_id]' AND photographybookingid!='0' AND editographyorderid!='0'";
		$qsqlpayment = mysqli_query($con,$sqlpayment);
		echo mysqli_error($con);
		$rspayment = mysqli_fetch_array($qsqlpayment);
		$paidamt = $rspayment[0]; 
		$balanceamt= $totalcost - $paidamt;
		$qsql = mysqli_query($con,$sql);
		echo mysqli_error($con);
		echo " ₹ ".$balanceamt;
	}
	else {
		echo " ₹ 0";
	}
?>	
									</p>
    							</div>
    					</div>
    				</div>
					
					<div class="col-md-6 col-sm-6 col-xs-12 wow fadeIn" data-wow-offset="50" data-wow-delay="1.3s">
    					<div class="team-wrapper">
    						<img src="images/invoice.jpg" class="img-responsive" style="height:200px;width:100%;">
    							<div class="team-des">
    								<h4>Total Balance Invoice</h4>
    								<p>
<?php
// existing invoice summary (count + total)
$sql = "
    SELECT
        COUNT(i.invoiceid) AS invoice_count,
        COALESCE(SUM(i.invoiceamt),0) AS invoice_total
    FROM invoice i
    JOIN event_booking eb ON i.event_booking_id = eb.event_booking_id
    WHERE eb.customer_id = '" . mysqli_real_escape_string($con, $_SESSION['customer_id']) . "'
";
$qsql = mysqli_query($con, $sql);
echo mysqli_error($con);
$row = mysqli_fetch_assoc($qsql);
$invoiceCount = (int)$row['invoice_count'];
$invoiceTotal = number_format((float)$row['invoice_total'], 2);
echo $invoiceCount . " invoices — Total: ₹ " . $invoiceTotal;

// show any message from insert action
if (!empty($invoice_msg)) {
    echo "<br><strong style='color:green;'>".htmlspecialchars($invoice_msg)."</strong>";
}

// provide a simple form to create an invoice for the latest booking
$latestSql = "SELECT * FROM event_booking WHERE customer_id='" . mysqli_real_escape_string($con, $_SESSION['customer_id']) . "' ORDER BY event_booking_id DESC LIMIT 1";
$qlatest = mysqli_query($con, $latestSql);
if ($qlatest && mysqli_num_rows($qlatest) > 0) {
    $latest = mysqli_fetch_assoc($qlatest);
    // calculate total cost similar to existing logic (days * booking_cost)
    $date1 = date_create($latest['bookingfdate']);
    $date2 = date_create($latest['bookingtdate']);
    $diff = date_diff($date1, $date2);
    $nodays = $diff->format("%a") + 1;
    $totalcost = $nodays * (float)$latest['booking_cost'];
    // show small form
    ?>
    <form method="post" style="margin-top:8px;">
        <input type="hidden" name="event_booking_id" value="<?php echo (int)$latest['event_booking_id']; ?>">
        <input type="hidden" name="invoiceamt" value="<?php echo htmlspecialchars($totalcost); ?>">
        <!-- one-time token to prevent duplicate submission on refresh -->
        <input type="hidden" name="invoice_token" value="<?php echo htmlspecialchars($_SESSION['invoice_token']); ?>">
        <label style="display:block;margin-bottom:4px;">Create invoice for latest booking (<?php echo htmlspecialchars($latest['event_booking_id']); ?>) — Amount: ₹ <?php echo number_format($totalcost,2); ?></label>
        <select name="invoicetype" class="form-control" style="width:160px;display:inline-block;margin-right:8px;">
            <option value="Final">Final</option>
            <option value="Advance">Advance</option>
        </select>
        <button type="submit" name="create_invoice" class="btn btn-primary">Create Invoice</button>
    </form>
    <?php
} else {
    echo "<br>No bookings found to create invoice.";
}
?>
									</p>
    							</div>
    					</div>
    				</div>
				
				
				
    			</div>
    		</div>
    	</section>
    	<!-- end team -->

<?php
// welcome message (session already started above)
if (!empty($_SESSION['customer_name'])) {
    echo "Welcome, " . htmlspecialchars($_SESSION['customer_name']);
}
?>

<?php
include("footer.php");
?>