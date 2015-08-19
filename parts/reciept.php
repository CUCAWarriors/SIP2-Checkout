<?php
$patronName = $_SESSION['patronName'];
$patronCard = $_SESSION['patronCard'];
$patronID = $_SESSION['patronID'];
$patronLoans = xmlToArray(file_get_contents("$opacURL/cgi-bin/koha/ilsdi.pl?service=GetPatronInfo&patron_id=$patronID&show_fines=0&show_loans=1&show_contact=0"));
$patronLoans = $patronLoans["loans"];
?>
<h3><?php echo $libraryName ?></h3>
Checked out to <?php echo $patronName ?><br />
(<?php echo $patronCard ?> ) <br />
<br />
<hr>
<h4>Checked Out</h4>	
<?php
if ($patronLoans['loan']['cardnumber'] == $_SESSION['patronCard']) {
  					foreach ($patronLoans as $loan) {
  						$itemBarcode = $loan['barcode'];
  						$itemTitle = $loan['title'];
  						$itemDue = strtok($loan['date_due'],' ');
  						$itemAuthor = $loan['author'];
  						echo  <<<END
      						    <p>
                      $itemTitle <br />
                      Barcode: $itemBarcode<br />
                      Date due: $itemDue<br />
                      </p>

END;
  					}
  				}
  				else {
  						foreach ($patronLoans['loan'] as $loan) {
  						$itemBarcode = $loan['barcode'];
  						$itemTitle = $loan['title'];
  						$itemDue = strtok($loan['date_due'],' ');
  						$itemAuthor = $loan['author'];
  						echo  <<<END
  						       <p>
                      $itemTitle <br />
                      Barcode: $itemBarcode<br />
                      Date due: $itemDue<br />
                      </p>
  						
END;
  					}
  				}

	?>
	<hr>
<h4>Overdues</h4>
<?php
if ($patronLoans['loan']['cardnumber'] == $_SESSION['patronCard']) {
  					foreach ($patronLoans as $loan) {
  						$itemBarcode = $loan['barcode'];
  						$itemTitle = $loan['title'];
  						$itemDue = strtok($loan['date_due'],' ');
  						$itemAuthor = $loan['author'];
  						if (time() > strtotime($itemDue)) 
  						{
  							
  						echo  <<<END
  						       <p>
                      $itemTitle <br />
                      Barcode: $itemBarcode<br />
                      Date due: $itemDue<br />
                      </p>
  						
END;
}
  					}
  				}
  				else {
  						foreach ($patronLoans['loan'] as $loan) {

  						$itemBarcode = $loan['barcode'];
  						$itemTitle = $loan['title'];
  						$itemDue = strtok($loan['date_due'],' ');
  						$itemAuthor = $loan['author'];
  						
  						if (time() > strtotime($itemDue)) {
  						echo  <<<END
  						       <p>
                      $itemTitle <br />
                      Barcode: $itemBarcode<br />
                      Date due: $itemDue<br />
                      </p>
  						
END;
}
  					}
  				}
  				?>

<hr>
You Owe <b>$<?php echo $_SESSION['patronFines'];?></b> in fines and fees
<hr>
<i>Visit us online at<br>
<?php echo $webAddress ?></i>