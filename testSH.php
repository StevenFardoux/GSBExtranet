<?php
    $token ="ok";
    $mailtest ="testmco@yopmail.com";
	$sujet = "testv2";
    $text = "<a href='http://127.0.0.10/index.php?uc=connexion&action=validationToken&token=".$token."'>Valider le mail</a>";
    if(mail($mailtest,$sujet,$text, 'Content-type: text/html; charset=utf-8')){
        echo "email envoyer";
    }
    else{
        echo "email non envoyer";
    }
?>
