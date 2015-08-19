<?php include("parts/header.signin.php"); ?>
    <div class="container">
<?php $msg->display();?>
      <form class="form-signin" action="" method="post">
        <h2 class="form-signin-heading">Self Checkout Sign In</h2>
        <label for="inputEmail" class="sr-only">Staff/Student ID</label>
        <input type="text" name="patronid" id="inputEmail" class="form-control" placeholder="123456789" required autofocus>
        <input type="hidden" name="action" value="process"/>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Start</button>
        <?php $_SESSION['page'] = 'process'; ?>
      </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  