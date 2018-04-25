<?php

  if (isset($_POST['submitpost'])) {
    $header="MIME-Version: 1.0\r\n";
    $header.='From:"Bet4Gifts"<noreply@bet4gifts.web-edu.fr>'."\n";
    $header.='Content-Type:text/html; charset="uft-8"'."\n";
    $header.='Content-Transfer-Encoding: 8bit';
    $message='
    <html>
       <body style="margin: 0; padding: 0; background-color:#2c3e50;">
          <div align="center"><img src="https://bet4gifts.web-edu.fr/images/favicon.png" alt="" width="100" height="100"></div>

          <div align="center">
             <a href="https://bet4gifts.web-edu.fr/confirmation.php?pseudo='.urlencode($pseudo).'&key='.$key.'">Confirmez votre compte !</a>
          </div>
       </body>
    </html>
    ';
    mail("pomier.mathys@outlook.fr", "test mail", $message, $header);
  }
 ?>

 <!DOCTYPE html>
 <html lang="fr" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>test</title>
   </head>
   <body>

     <form class="" method="post">

       <input type="submit" name="submitpost" value="Envoyer mail !">

     </form>

   </body>
 </html>
