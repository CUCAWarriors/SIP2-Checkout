<?php

if (isset($_POST["patronid"])) {
    $cardNum = $_POST["patronid"];
    //Get the Patron's Internal ID
    $patronLookup =  xmlToArray(file_get_contents("$opacURL/cgi-bin/koha/ilsdi.pl?service=LookupPatron&id=$cardNum&id_type=cardnumber"));
   //Does the patron even exist...
  if (isset($patronLookup["id"]))
   
   {
      # var_dump($patronLookup);
       
      $patronID = $patronLookup["id"];
      //Lets get the lowdown on the user
      $patronInfo = xmlToArray(file_get_contents("$opacURL/cgi-bin/koha/ilsdi.pl?service=GetPatronInfo&patron_id=$patronID&show_fines=1&show_loans=1&show_contact=0"));
      #var_dump($patronInfo);
      if (isset($patronInfo["debarred"]))
      {
         $msg->add('d', "There is a restriction on your account preventing you from checking out books, please see the Circulation Desk to remove the restriction");
                    $_SESSION["patronDebarred"] = true;
      }
      
      if ($patronInfo["charges"] > 0) {
          $owes = $patronInfo["charges"];
         
          if ($patronInfo["charges"] >= $maxFine)
            {
                 $msg->add('d', "You owe $$owes and cannot checkout books, please see the Circulation Desk for more infomation and to pay your fine");
                  
                
            } // if ($patronInfo["charges"] >= $maxFine)
            else {
                
                $msg->add('w', "You owe $$owes, please see a the Circulation Desk for more infomation and to pay your fine");  
                
            }
      } //if ($patronInfo["charges"] > 0)
      $_SESSION['patronName'] =  $patronInfo["firstname"] . ' ' . $patronInfo["surname"];
      $_SESSION['patronID'] = $patronID;
      $_SESSION['patronCard'] = $cardNum;
      if (isset($owes))
        $_SESSION['patronFines'] = $owes;
      else
        $_SESSION['patronFines'] = 0;
      //set the next page
      $_SESSION['page'] = 'checkout';

      #echo 'it worked';
      header("Location: index.php");
      
      
      
       
       
       
   }
   
   //Something got messed up to get us here...
   else 
   {
     $msg->add('d', 'We were unable to find you, please try again');
        $_SESSION['page'] = 'start';
        #var_dump($patronLookup);
        header("Location: index.php");
        
   }
        #$_SESSION['page'] = 'start';
   #echo "sumpin happened!";
}
elseif (isset($_POST['cko_action']))
{
  $action = $_POST['cko_action'];
  if ($action == 'finish') {
      session_destroy();
      unset($_SESSION);
      header("Location: index.php");

  }
  elseif ($action == 'receipt')
  {
          $_SESSION['page'] = 'receipt';
          #var_dump($patronLookup);
          header("Location: index.php");
          

    }
    elseif ($action == 'run_checkout' and isset($_POST['bookBarcode']))
    {
      $cko = runCheckout($_SESSION['patronCard'], $_POST['bookBarcode'], $sipHost, $sipPort, $sipUser, $sipPassword);
      if (!$cko) {
        $msg->add('d', 'We were unable to checkout your selection, please try again');
        $_SESSION['page'] = 'checkout';
        #var_dump($cko);
        header("Location: index.php");
      }
      elseif ($cko)
        {
        $msg->add('s', 'Book Checked Out!');
        $_SESSION['page'] = 'checkout';
        #var_dump($cko);
        header("Location: index.php");
      }
      else {
        $msg->add('d', 'We were unable to checkout your selection due to an unknown issue, please try again');
        #var_dump($cko);
        $_SESSION['page'] = 'checkout';
        header("Location: index.php");
      }
    }

  }
  elseif (isset($_SESSION['prev_page']))
  {
    $_SESSION['page'] = $_SESSION['prev_page'];
    unset($_SESSION['prev_page']);
    header("Location: index.php");
  }
  else
  {
    $_SESSION['page'] = 'start';
    header("Location: index.php");
  }

  if (isset($_POST["patronid"])) {
      $cardNum = $_POST["patronid"];
      //Get the Patron's Internal ID
      $patronLookup =  xmlToArray(file_get_contents("$opacURL/cgi-bin/koha/ilsdi.pl?service=LookupPatron&id=$cardNum&id_type=cardnumber"));
     //Does the patron even exist...
    if (isset($patronLookup["id"]))
     
     {
        # var_dump($patronLookup);
         
        $patronID = $patronLookup["id"];
        //Lets get the lowdown on the user
        $patronInfo = xmlToArray(file_get_contents("$opacURL/cgi-bin/koha/ilsdi.pl?service=GetPatronInfo&patron_id=$patronID&show_fines=1&show_loans=1&show_contact=0"));
        #var_dump($patronInfo);
        if (isset($patronInfo["debarred"]))
        {
           $msg->add('d', "There is a restriction on your account preventing you from checking out books, please see the Circulation Desk to remove the restriction");
                      $_SESSION["patronDebarred"] = true;
        }
        
        if ($patronInfo["charges"] > 0) {
            $owes = $patronInfo["charges"];
           
            if ($patronInfo["charges"] >= $maxFine)
              {
                   $msg->add('d', "You owe $$owes and cannot checkout books, please see the Circulation Desk for more infomation and to pay your fine");
                    
                  
              } // if ($patronInfo["charges"] >= $maxFine)
              else {
                  
                  $msg->add('w', "You owe $$owes, please see a the Circulation Desk for more infomation and to pay your fine");  
                  
              }
        } //if ($patronInfo["charges"] > 0)
        $_SESSION['patronName'] =  $patronInfo["firstname"] . ' ' . $patronInfo["surname"];
        $_SESSION['patronID'] = $patronID;
        $_SESSION['patronCard'] = $cardNum;
        if (isset($owes))
          $_SESSION['patronFines'] = $owes;
        else
          $_SESSION['patronFines'] = 0;
        //set the next page
        $_SESSION['page'] = 'checkout';

        #echo 'it worked';
        header("Location: index.php");
        
        
        
         
         
         
     }
     
     //Something got messed up to get us here...
     else 
     {
       $msg->add('d', 'We were unable to find you, please try again');
          $_SESSION['page'] = 'start';
          #var_dump($patronLookup);
          header("Location: index.php");
          
     }
          #$_SESSION['page'] = 'start';
     #echo "sumpin happened!";
  }
  elseif (isset($_POST['cko_action']))
  {
    $action = $_POST['cko_action'];
    if ($action == 'finish') {
        session_destroy();
        unset($_SESSION);
        header("Location: index.php");

    }
    elseif ($action == 'reciept')
    {
          $_SESSION['page'] = 'reciept';
          #var_dump($patronLookup);
          #echo 'test';
          header("Location: index.php");
          

  }
  elseif ($action == 'run_checkout' and isset($_POST['bookBarcode']))
  {
    $cko = runCheckout($_SESSION['patronCard'], $_POST['bookBarcode'], $sipHost, $sipPort, $sipUser, $sipPassword);
    if (!$cko) {
      $msg->add('d', var_dump($cko));
      $_SESSION['page'] = 'checkout';
      var_dump($cko);
      #header("Location: index.php");
    }
    elseif ($cko)
      {
      $msg->add('s', var_dump($cko));
      $_SESSION['page'] = 'checkout';
      var_dump($cko);
      #header("Location: index.php");
    }
    else {
      $msg->add('d', var_dump($cko));
      var_dump($cko);
      $_SESSION['page'] = 'checkout';
      #header("Location: index.php");
    }
  }

}
elseif (isset($_SESSION['prev_page']))
{
  $_SESSION['page'] = $_SESSION['prev_page'];
  unset($_SESSION['prev_page']);
  header("Location: index.php");
}
else
{
  $_SESSION['page'] = 'start';
  header("Location: index.php");
}