<?php
ob_start();
session_start();
include_once('conexao.php');

function logoutbutton() {
	echo "<form action='' method='get'><button name='logout' type='submit'>Logout</button></form>"; //logout button
}

function loginbutton($buttonstyle = "square") {
	$button['rectangle'] = "01";
	$button['square'] = "02";
	$button = "<a href='?login'><img src='https://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_".$button[$buttonstyle].".png'></a>";
	
	echo $button;
}

if (isset($_GET['login'])){
	require 'openid.php';
	try {
		require 'SteamConfig.php';
		$openid = new LightOpenID($steamauth['domainname']);
		
		if(!$openid->mode) {
			$openid->identity = 'https://steamcommunity.com/openid';
			header('Location: ' . $openid->authUrl());
		} elseif ($openid->mode == 'cancel') {
			echo 'O usuário cancelou o Login!';
		} else {
			if($openid->validate()) { 
				$id = $openid->identity;
				$ptn = "/^https?:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
				preg_match($ptn, $id, $matches);
				
				$_SESSION['steamid'] = $matches[1];
				if (!headers_sent()) {
					$resultado="SELECT steamid FROM users";
					$resultadoquery=mysqli_query($conn, $resultado);
					$array=array();
					while(($row=mysqli_fetch_assoc($resultadoquery))){
						array_push($array, [
							"steamid" => $row['steamid'],
						]);
					}
				
					$tem=false;
					foreach ($array as $key => $value) {
						if($array[$key]==$_SESSION['steamid']){
							$tem=true;
							header('Location: restrita.php');
							exit;
						}
					}
					if(!$tem){
						$add="INSERT INTO users(`steamid`,`horas`) VALUES ({$_SESSION['steamid']},0);";
						$addquery=mysqli_query($conn,$add);
						header('Location: restrita.php');
						exit;
					}
			
				} else {
					?>
					<script type="text/javascript">
						window.location.href="<?=$steamauth['loginpage']?>";
					</script>
					<noscript>
						<meta http-equiv="refresh" content="0;url=<?=$steamauth['loginpage']?>" />
					</noscript>
					<?php
					exit;
				}
			
				
			} else {
				echo "Usuário não está logado\n";
				logoutbutton();

			}
		}
	
	} catch(ErrorException $e) {
		echo $e->getMessage();
	
    }
}


if (isset($_GET['logout'])){
	require 'SteamConfig.php';
	session_unset();
	session_destroy();
	header('Location: index.php');
	exit;
}

if (isset($_GET['update'])){
	unset($_SESSION['steam_uptodate']);
	require 'userInfo.php';
	header('Location: '.$_SERVER['PHP_SELF']);
	exit;
}

// Version 4.0

?>
