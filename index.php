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

        echo "welcome guest! please login \n \n";
        loginbutton(); //login button
    
    }  else {
        include ('steamauth/userInfo.php');
    
        //Protected content
        echo "Welcome back " . $steamprofile['personaname'] . "</br>";
        echo "here is your avatar: </br>" . '<img src="'.$steamprofile['avatarfull'].'" title="" alt="" />'; // Display their avatar!
        
        
        

        // set our url with curl_setopt()
        
        curl_setopt($curl, CURLOPT_URL, "http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?appid=440&key=116E3328E9DBE297AE7B0CFC27C8B5E0&steamid=".$steamprofile['steamid']);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);


        $jsonout=json_decode(curl_exec($curl),true);
        var_dump( $jsonout['response']['games']);

        
        




        curl_close($curl);
        logoutbutton();
    }    
?>


</body>
</html>