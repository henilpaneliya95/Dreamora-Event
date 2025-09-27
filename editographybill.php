<?php
include("header.php");

$sqlpaymentdet = "SELECT * FROM payment WHERE paymentid='$_GET[billid]'";
$qsqlpaymentdet = mysqli_query($con,$sqlpaymentdet);
$rspaymentdet  = mysqli_fetch_array($qsqlpaymentdet);

$sqlpayment = "SELECT * FROM payment LEFT JOIN customer ON payment.customer_id=customer.customer_id LEFT JOIN editography_order ON editography_order.billno=payment.editographyorderid LEFT JOIN editography ON editography.editography_id=editography_order.editography_id WHERE payment.paymentid='$_GET[billid]'";
$qsqlpayment = mysqli_query($con,$sqlpayment);
$rspayment = mysqli_fetch_array($qsqlpayment);

$sqltotalamt = "SELECT SUM(editography_order.cost * editography_order.qty) FROM editography_order LEFT JOIN employee ON editography_order.employee_id=employee.employee_id LEFT JOIN customer ON editography_order.customer_id=customer.customer_id LEFT JOIN editography ON editography_order.editography_id=editography.editography_id WHERE editography_order.billno='$rspaymentdet[editographyorderid]'";
$qsqltotalamt = mysqli_query($con,$sqltotalamt);
$rstotalamt = mysqli_fetch_array($qsqltotalamt);

$sqlpaidamt = "select SUM(paid_amt) FROM payment WHERE editographyorderid='$rspaymentdet[editographyorderid]' ";
$qsqlpaidamt = mysqli_query($con,$sqlpaidamt);
$rspaidamt = mysqli_fetch_array($qsqlpaidamt);
?>
<!-- start contact -->
<section id="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="wow bounceIn" data-wow-offset="50" data-wow-delay="0.3s">Editography Receipt</h2>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 wow fadeInLeft" data-wow-offset="50" data-wow-delay="0.9s">

                <!-- container -->
                <div class="container">
                    <div class="about-info">
                        <center>
                            <h3>Payment Receipt</h3>
                        </center>
                    </div>
                    <div class="about-top-grids">
                        <div class="col-md-12 about-top-grid">

                            <p>
                            <div id="divprint">
                                <style>
                                    @media print {
                                        body * {
                                            visibility: hidden;
                                        }

                                        #divprint,
                                        #divprint * {
                                            visibility: visible;
                                        }

                                        #divprint {
                                            position: absolute;
                                            left: 0;
                                            top: 0;
                                            width: 100%;
                                        }

                                        table {
                                            border-collapse: collapse;
                                            width: 100%;
                                        }

                                        th,
                                        td {
                                            border: 1px solid black;
                                            padding: 8px;
                                            text-align: left;
                                        }
                                    }
                                </style>
                                <table id="datatable" class="table table-bordered" cellspacing="0" width="100%">
                                    <tr>
                                        <th colspan=6>
                                            <center>
                                                <h2>Event Planner</h2>
                                            </center>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td colspan=6>
                                            <center>Trinity Complex,N.G Road,Attavara,Mangalore.</center>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan=4>
                                            <b>Customer Name:</b>
                                            <?php echo $rspayment['customer_name']; ?>
                                        </td>
                                        <td><b>Date :</b>
                                            <?php echo date("d-m-Y",strtotime($rspayment['paymentdate'])); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan=4><b>Address: </b>
                                            <?php echo $rspayment['address']; ?>
                                        </td>
                                        <td><b>Bill No :</b>
                                            <?php echo $rspayment['editographyorderid']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan=4><b>Contact No :</b>
                                            <?php echo $rspayment['contactno']; ?>
                                        </td>
                                        <td colspan=4><b>Total Amount :</b> Rs.
                                            <?php echo $rstotalamt[0]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan=4><b>Payment type : </b>
                                            <?php echo $rspayment['transactiontype']; ?>
                                        </td>
                                        <td><b>Paid amount :</b> Rs.
                                            <?php echo $rspaidamt[0]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan=4><b>Request date: </b>
                                            <?php echo date("d-m-Y",strtotime($rspayment['reqdate'])); ?>
                                        </td>
                                        <td><b>Balance Amount :</b> Rs.
                                            <?php echo $rstotalamt[0]- $rspaidamt[0]; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan=4></td>
                                        <td>
                                            <?php
if($rspayment['deliverydate'] != "0000-00-00")
{
?>
                                            <b>Delivery Date :</b>
                                            <?php 
echo $rspayment['deliverydate']; ?>
                                            <?php
}
?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>SL.NO</th>
                                        <th>Description</th>
                                        <th>cost</th>
                                        <th>qty</th>
                                        <th>Sub Total</th>
                                    </tr>

                                    <?php
		$slno=1;
		$sqleditography_order1 = "SELECT * FROM editography_order LEFT JOIN employee ON editography_order.employee_id=employee.employee_id LEFT JOIN customer ON editography_order.customer_id=customer.customer_id LEFT JOIN editography ON editography_order.editography_id=editography.editography_id WHERE editography_order.billno='$rspaymentdet[editographyorderid]' ";
		$qsqlditography_order1 = mysqli_query($con,$sqleditography_order1);
		$totalamt = 0;
		while($rsditography_order1 = mysqli_fetch_array($qsqlditography_order1))
		{
			echo "<tr>
				<td>$slno</td>
				<td><b>$rsditography_order1[editography_type]</b><br> $rsditography_order1[7]</td>
				<td>$rsditography_order1[5]</td>
				<td>$rsditography_order1[qty]</td>
				<td>".  $rsditography_order1['cost']*$rsditography_order1['qty'] ."</td>
			</tr>";
			$slno++;
			$totalamt = $totalamt + $rsditography_order1['cost']*$rsditography_order1['qty'];
		}
		?>

                                    <tr rowspan="6" style="background-color:grey;">
                                        <th> </th>
                                        <th></th>
                                        <th></th>
                                        <th><b>Total:</b></th>
                                        <th>Rs.
                                            <?php echo $totalamt; ?>
                                        </th>
                                    </tr>
                                </table>
                            </div>

                            <center>
                                <input type="button" name="btnprint" value="Print Receipt" style="color: black;"
                                    onclick="PrintElem('divprint')">
                                <br><br>
                                <h5><a href="vieweditographypayment.php" style='color: black;'>Back..</a></h5>
                            </center>

                            </p>
                        </div>
                        <div class="clearfix"> </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
</section>
<!-- end contact -->
<?php
include("footer.php");
?>

<script>
    /* Replace existing print functions with versions that print the visible "section#contact"
       (heading + receipt table). They open a popup, inject HTML+styles and trigger print. */

    function buildPrintWindow(htmlContent) {
        var mywindow = window.open('', 'PRINT', 'height=800,width=900,scrollbars=yes,resizable=yes');
        if (!mywindow) {
            alert('Pop-up blocked! Please allow pop-ups for this site and try again.');
            return null;
        }

        mywindow.document.write('<!doctype html><html><head><title>Payment Receipt</title>');
        mywindow.document.write('<meta charset="utf-8">');
        mywindow.document.write('<style>');
        mywindow.document.write('body { font-family: Arial, sans-serif; color: #000; margin: 10mm; }');
        mywindow.document.write('h2, h3 { margin: 0 0 8px 0; }');
        mywindow.document.write('table { border-collapse: collapse; width: 100%; margin-top: 10px; }');
        mywindow.document.write('th, td { border: 1px solid #000; padding: 6px 8px; text-align: left; }');
        mywindow.document.write('th { background: #f2f2f2; }');
        mywindow.document.write('.no-border { border: none !important; }');
        mywindow.document.write('@media print { @page { margin: 10mm; } body { margin: 0; } }');
        mywindow.document.write('</style>');
        mywindow.document.write('</head><body>');
        mywindow.document.write(htmlContent);
        mywindow.document.write('</body></html>');
        mywindow.document.close();
        return mywindow;
    }

    function PrintElem(elemId) {
        try {
            // Prefer printing the whole visible section if present
            var section = document.getElementById('contact');
            var content = section ? section.innerHTML : (document.getElementById(elemId) ? document.getElementById(elemId).innerHTML : '');
            if (!content) {
                alert('Print content not found!');
                return false;
            }

            var mywindow = buildPrintWindow(content);
            if (!mywindow) return false;

            // wait for popup to render then print
            mywindow.onload = function () {
                try {
                    mywindow.focus();
                    mywindow.print();
                    // do not auto-close immediately to allow user to choose PDF; close after small delay
                    setTimeout(function () { try { mywindow.close(); } catch (e) { } }, 500);
                } catch (err) {
                    alert('Print error: ' + err.message);
                }
            };
            // fallback timeout if onload doesn't fire
            setTimeout(function () {
                try {
                    mywindow.focus();
                    mywindow.print();
                } catch (err) { }
            }, 800);

            return true;
        } catch (e) {
            alert('Print error: ' + e.message);
            return false;
        }
    }

    function printDiv() {
        try {
            // Print same content as PrintElem (section#contact) so both buttons behave identically
            var section = document.getElementById('contact');
            var content = section ? section.innerHTML : (document.getElementById('divprint') ? document.getElementById('divprint').innerHTML : '');
            if (!content) {
                alert('Print content not found!');
                return false;
            }

            var mywindow = buildPrintWindow(content);
            if (!mywindow) return false;

            mywindow.onload = function () {
                try {
                    mywindow.focus();
                    mywindow.print();
                    setTimeout(function () { try { mywindow.close(); } catch (e) { } }, 500);
                } catch (err) {
                    alert('Print error: ' + err.message);
                }
            };

            setTimeout(function () {
                try {
                    mywindow.focus();
                    mywindow.print();
                } catch (err) { }
            }, 800);

            return true;
        } catch (e) {
            alert('Print error: ' + e.message);
            return false;
        }
    }

    // Test function to check if element exists
    function testPrint() {
        var elem = document.getElementById('divprint');
        if (elem) {
            alert('Element found, attempting to print...');
            PrintElem('divprint');
        } else {
            alert('Print element not found!');
        }
    }
</script>