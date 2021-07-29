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
    <link rel="stylesheet" href="style.css" />
    <title>Steam Time</title>
</head>
<body>
<div class="wrapper">
<div class="container">

<?php
    if(!isset($_SESSION['steamid'])) {
        echo"<div class='img'>";
        echo "<img class='imagem' src='logo.png'>";
        echo "</div>";
        echo "<p>Bem vindo! Por favor entre em sua conta: </p>";
        loginbutton();
    
    }  
?>
</div>
</div>

</body>
</html>