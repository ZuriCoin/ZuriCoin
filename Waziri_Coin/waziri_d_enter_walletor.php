<?php

include "wallet_getter_checks.php";
include "_connect__lala_wazi_master_/connector_d_fusion_.php";
if( isset($_GET["pub"]) and isset($_GET["private"]) and isset($_GET["access"]) ){
	$public_key = b_cleaner($_GET["pub"]);
	$private_key = b_cleaner($_GET["private"]);
	$access_key = b_cleaner($_GET["access"]);
	$add_on = isset($_GET["addon"]) ? b_cleaner($_GET["addon"]) : "";

	$date_time = date('Y-m-d H:i:s');

	$array = array();
	$user_already = array();

	$user_already = _already_public($public_key);


	if(is_array($user_already) and count($user_already) >= 1){
		$array = ["status"=>"false", "msg"=>"This Wallet is already in existance."];
	}else if(count($user_already) == 0){
 
		 $inserter = $connect->prepare("INSERT INTO `waziri_warslet_`(`id`, `public_key`, `private_key`, `access_key`, `addon`, `date_time`) VALUES (NULL, ?, ?, ?, ?, ?)");
		$inserter->bind_param("sssss", $public_key, $private_key, $access_key, $add_on, $date_time );
		$inserter->execute();

		if (!$inserter){
			$array = ["status"=>"false", "msg"=>"Could not Insert Wallet."];
		}else{
			$user_existance = _already_public($public_key);
			if(sizeof($user_existance) > 0){
				
				$user_id = $user_existance["id"];
				//$code = $user_existance["unique_co"];
				$array = ["status"=>"true", "user"=>$user_existance, "msg"=>"Wallet Created Successfully"];
			}else{
				$array = ["status"=>"false", "msg"=>"We had some issues with computing your details"];
			}
		}
	}else{
		$array = ["status"=>"false", "msg"=>"You may have entered invalid details."];
	}
	
	echo json_encode($array);
}


function b_cleaner($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = strip_tags($data);
	$data = htmlspecialchars($data);
	return $data;
}

function pass_cytptor($password){
	$password =  "Waziri".$password;
	$password = password_hash($password, PASSWORD_BCRYPT);
	return $password;
}

?>