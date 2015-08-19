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
                    $_SESSION['page'] = 'start';
                    header("Location: /");
      }
      
      if ($patronInfo["charges"] > 0) {
          $owes = $patronInfo["charges"];
         
          if ($patronInfo["charges"] >= $maxFine)
            {
                 $msg->add('d', "You owe $$owes and cannot checkout books, please see the Circulation Desk for more infomation and to pay your fine");
                    $_SESSION['page'] = 'start';
                    header("Location: /");
                
            } // if ($patronInfo["charges"] >= $maxFine)
            else {
                
                $msg->add('w', "You owe $$owes, please see a the Circulation Desk for more infomation and to pay your fine");  
                
            }
      } //if ($patronInfo["charges"] > 0)
      $_SESSION['patronName'] =  $patronInfo["firstname"] . ' ' . $patronInfo["surname"];
      $_SESSION['patronID'] = $patronID;
      if (isset($owes))
      $_SESSION['patronFines'] = $owes;
      //set the next page
      $_SESSION['page'] = 'checkout';
      #echo 'it worked';
      header("Location: /");
      
      
      
       
       
       
   }
   
   //Something got messed up to get us here...
   else 
   {
     $msg->add('d', 'We were unable to find you, please try again');
        $_SESSION['page'] = 'start';
        #var_dump($patronLookup);
        header("Location: /");
        
   }
        $_SESSION['page'] = 'start';
   #echo "sumpin happened!";
}