<?php 
require('steamauth/steamauth.php');
$curl = curl_init();
include('steamauth/userInfo.php');
    if(isset($_SESSION['steam_steamid'])) {

        //Protected content
        echo "Welcome back " . $steamprofile['personaname'] . "</br>";
        echo "here is your avatar: </br>" . '<img src="'.$steamprofile['avatarfull'].'" title="" alt="" />'; // Display their avatar!




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
        $icon=$jsonout2['response']['games'][0]['img_logo_url'];
        $appid=$jsonout2['response']['games'][0]['appid'];

        echo "<img src=http://media.steampowered.com/steamcommunity/public/images/apps/{$appid}/{$icon}.jpg>";
        echo $jsonout2['response']['games'][0]['playtime_forever'];





        curl_close($curl);
        logoutbutton();
    }  


?>