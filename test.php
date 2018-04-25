<?php

  if (isset($_POST['submitpost'])) {
    $header="MIME-Version: 1.0\r\n";
    $header.='From:"Bet4Gifts"<noreply@bet4gifts.web-edu.fr>'."\n";
    $header.='Content-Type:text/html; charset="uft-8"'."\n";
    $header.='Content-Transfer-Encoding: 8bit';
    $message='
    <html>
       <body style="margin: 0; padding: 0; background-color:#2c3e50;">
          <br>
          <div style="" align="center"><img src="https://bet4gifts.web-edu.fr/images/favicon.png" alt="" width="200" height="200"></div>
          <br>
          <hr style="width: 25%;">
          <br>
          <div align="center">
            <span style="display: block; color: #FFF; font-size: 20px;">Your account was successfully created!</span>
            <span style="display: block; color: #FFF; font-size: 20px;">You are just one step to confirm your mail !</span>
            <br><br>
            <a style="display: block; width: auto; background-color: #27ae60; border-radius: 20px; padding: 16px 18px; color: #FFF; text-decoration: none; font-size: 15px;" href="https://bet4gifts.web-edu.fr/confirmation.php?pseudo='.urlencode($pseudo).'&key='.$key.'">Confirmez votre compte !</a>
            <br><br>
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
