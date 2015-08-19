<?php
include("header.checkout.php");
$patronID = $_SESSION['patronID'];
$patronName = $_SESSION['patronName'];
$patronFines = $_SESSION['patronFines'];
?>


<div class="container">
    <div class="row profile">
		<div class="col-md-3">
			<div class="profile-sidebar">
				<!-- SIDEBAR USERPIC -->
				<div class="profile-userpic">
					<img src="$adminURL/cgi-bin/koha/members/patronimage.pl?borrowernumber=<?php echo $patronID ?>" class="img-responsive" alt="">
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
					<button type="button" class="btn btn-success btn-sm">Follow</button>
					<button type="button" class="btn btn-danger btn-sm">Message</button>
				</div>
				<!-- END SIDEBAR BUTTONS -->
				<!-- SIDEBAR MENU -->
				<div class="profile-usermenu">
					<ul class="nav">
						<li>
							<a href="#">
							<i class="glyphicon glyphicon-money"></i>
							Fines: $<?php echo $patronFines?> </a>
						</li>
					
						<li>
							<a href="?finishnor" target="_blank">
							<i class="glyphicon glyphicon-ok"></i>Finish: No Reciept
							 </a>
						</li>
						<li>
							<a href="?finishwr">
							<i class="glyphicon glyphicon-flag"></i>Finish: Print Reciept
							 </a>
						</li>
					</ul>
				</div>
				<!-- END MENU -->
			</div>
		</div>
		<div class="col-md-9">
            <div class="profile-content">
			  Checkout Stuff
            </div>
		</div>
	</div>
</div>
