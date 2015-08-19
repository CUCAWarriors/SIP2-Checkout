<?php
include("header.checkout.php");
$_SESSION['page'] = 'process';
$_SESSION['prev_page'] = 'checkout';
$patronID = $_SESSION['patronID'];
$patronName = $_SESSION['patronName'];
$patronFines = $_SESSION['patronFines'];
$patronLoans = xmlToArray(file_get_contents("$opacURL/cgi-bin/koha/ilsdi.pl?service=GetPatronInfo&patron_id=$patronID&show_fines=0&show_loans=1&show_contact=0"));
$patronLoans = $patronLoans["loans"];

?>

<div class="container">
    <div class="row profile">
		<div class="col-md-3">
			<div class="profile-sidebar">
				<!-- SIDEBAR USERPIC -->
				<div class="profile-userpic">
					<img src="<?php echo $adminURL ?>/cgi-bin/koha/members/patronimage.pl?borrowernumber=<?php echo $patronID ?>" class="img-responsive" alt="">
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
						<?php echo $patronName ?>
					</div>

				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR BUTTONS -->
				<div class="profile-userbuttons">
				<?php if ($patronFines < $maxFine and !isset($_SESSION['patronDebarred'])) {?>
				<form method="post">
					<input type="hidden" name="cko_action" value="finish" />
					<button type="submit" class="btn btn-success btn-lg">Finish</button>
				</form>
				<form method="post">
					<input type="hidden" name="cko_action" value="reciept" />
					<button type="submit" class="btn btn-danger btn-lg">With Reciept</button>
				</form>
					<?php }
					else {
						?>
						<form method="post">
							<input type="hidden" name="cko_action" value="finish" />
							<button type="submit" class="btn btn-danger btn-lg">Logout</button>
						</form>
						<?php } ?>
				</div>
				<!-- END SIDEBAR BUTTONS -->
				<!-- SIDEBAR MENU -->
				<div class="profile-usermenu">
					<ul class="nav">
						<li>
							<a href="#">
							<i class="glyphicon glyphicon-usd"></i>
							Fines: $<?php echo $patronFines?> </a>
						</li>
				
						
						
					</ul>
				</div>
				<!-- END MENU -->
			</div>
		</div>
		<div class="col-md-9">
            <div class="profile-content">
	            <?php 
	            $msg->display();
	            if ($patronFines < $maxFine and !isset($_SESSION['patronDebarred'])) { ?>
	            <form class="form-inline" method="post" action="">
					  <div class="form-group">
					    <div class="input-group">
					      <input type="hidden" name="cko_action" value="run_checkout" />
					      <input type="text" class="form-control" name="bookBarcode" id="" placeholder="Barcode" autofocus	>
					    </div>
					  </div>
					  <button type="submit" class="btn btn-primary">Checkout</button>
					</form>	
					<?php } ?>
			  	<table class="table table-condensed">
  					<thead>
  						<tr>
  							<th>Book Title</th>
  							<th>Author</th>
  							<th>Barcode</th>
  							<th>Due Date</th>
  							<th>Renew</th>
  						</tr>
  					</thead>
  					<?php
  					if ($patronLoans['loan']['cardnumber'] == $_SESSION['patronCard']) {
  					foreach ($patronLoans as $loan) {
  						$itemBarcode = $loan['barcode'];
  						$itemTitle = $loan['title'];
  						$itemDue = strtok($loan['date_due'],' ');
  						$itemAuthor = $loan['author'];
  						echo  <<<END
  						<tr>
  							<td>$itemTitle</td>
  							<td>$itemAuthor</td>
  							<td>$itemBarcode</td>
  							<td>$itemDue</td>
  							<td><button type="submit" value=class="btn btn-primary">Renew</button></td>
  						</tr>

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
  						<tr>
  							<td>$itemTitle</td>
  							<td>$itemAuthor</td>
  							<td>$itemBarcode</td>
  							<td>$itemDue</td>
  							<td><button type="submit" value=class="btn btn-primary">Renew</button></td>
  						</tr>

END;
  					}
  				}
  				
  					?>
				</table>
				
            </div>
		</div>
	</div>
</div>
