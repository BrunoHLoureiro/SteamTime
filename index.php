<?php
require('steamauth/steamauth.php');
// create & initialize a curl session
$curl = curl_init();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
    if(!isset($_SESSION['steamid'])) {

        echo "Bem vindo! Por favor entre em sua conta! \n \n";
        loginbutton();
    
    }  
?>


</body>
</html>