<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>Sua página do Steam Time</title>
</head>
<body>
    
<div class="wrapper1">
<?php
require('steamauth/steamauth.php');
include('steamauth/userInfo.php');
logoutbutton();

?>
<div class="wrapper2">

<?php 
$curl = curl_init();

    if(isset($_SESSION['steam_steamid'])) {

        echo "<h2>Bem-vindo novamente " . $steamprofile['personaname'] . "</h2></br>";
        echo "<img class='contimg' src=".$steamprofile['avatarfull']."/>"; 




        // set our url with curl_setopt()

        curl_setopt($curl, CURLOPT_URL, "http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?appid=440&key=116E3328E9DBE297AE7B0CFC27C8B5E0&steamid=".$steamprofile['steamid']);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);


        $jsonout=json_decode(curl_exec($curl),true);
        //var_dump( $jsonout['response']['games']);

        curl_close($curl);
        $curl=curl_init();

        curl_setopt($curl, CURLOPT_URL, "http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=116E3328E9DBE297AE7B0CFC27C8B5E0&include_appinfo=true&appid=440&format=json&steamid=".$steamprofile['steamid']);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);

        $jsonout2=json_decode(curl_exec($curl),true);
        $horastotal=0;

        foreach ($jsonout2['response']['games'] as $key => $value) {
            $horas=$jsonout2['response']['games'][$key]['playtime_forever']/60;
            $horastotal+=$horas;
        }

        $horacheck="SELECT horas FROM users WHERE steamid={$_SESSION['steamid']}";
        $horasquery=mysqli_query($conn,$horacheck);
        $array=array();
		while(($row=mysqli_fetch_assoc($horasquery))){
        		array_push($array, [
				"horas" => $row['horas'],
			]);
		}
        $dif=$horastotal-$horas;
        $formatdif=number_format($dif,2,',','.');
        echo "<br>";
        if(!$horastotal==$array[0]['horas']){
            echo "Você jogou ".$formatdif." horas a mais desde a última visita ao Steam Time!";
            echo "<br>";
        }else{
            echo 'Você não jogou desde a última visita ao Steam Time!';
            echo "<br>";
        }

        $alterhoras="UPDATE users SET horas={$horastotal} WHERE steamid={$_SESSION['steamid']}";
        $alterhorasquery=mysqli_query($conn,$alterhoras);

        foreach ($jsonout2['response']['games'] as $key => $value) {
            echo '<br>';
            $icon=$jsonout2['response']['games'][$key]['img_logo_url'];
            $appid=$jsonout2['response']['games'][$key]['appid'];
            $appname=$jsonout2['response']['games'][$key]['name']; 
            if(!$icon==""){
                echo "<img class='contimg' src=http://media.steampowered.com/steamcommunity/public/images/apps/{$appid}/{$icon}.jpg>";
            }else{
                echo "<img class='contimg' src=simg.png>";
            }
            echo "<br>";
            echo $appname . ': ';
            $horas=$jsonout2['response']['games'][$key]['playtime_forever']/60;
            $horasb=number_format($horas,2,',','.');
            echo  $horasb . ' horas';
            echo "<br>";
            
            $horastotal+=$horas;
        }
        echo "<br>";

        


        curl_close($curl);
        
    }  


?>

</div>
</div>
</body>
</html>
