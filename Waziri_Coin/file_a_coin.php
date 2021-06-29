<?php

include "_connect__lala_wazi_master_/connector_d_fusion_.php";
require "waziri_gettor_d_trans.php";
require "get_previous_hash.php";
require "amounts_la_checks.php";
require "miner_verify_trans.php";


if( isset($_GET["sender_address"]) and isset($_GET["previous_hash"]) and isset($_GET["transaction"]) and isset($_GET["amount"]) ){
	$sender_address = b_cleaner($_GET["sender_address"]);
	#$receiver_address = b_cleaner($_GET["receiver_address"]);
	$previous_hash = b_cleaner($_GET["previous_hash"]);
	#echo $previous_hash;
	$amount = b_cleaner($_GET["amount"]);
	$transaction = b_cleaner($_GET["transaction"]);
	$difficulty = isset($_GET["difficulty"]) ? b_cleaner($_GET["difficulty"]) : 3 ;
	$status = "FILED";
	$confirmations = 0;

	$hased_b4 = "";
	$here = json_decode(_previous_details_getter_());
	if ($here->transaction == null){
		$hased_b4 = "";
	}else{
		$hased_b4 = $here->transaction->transaction;
	}
	$previous_hash = $previous_hash . "#WAZIRI#" . $hased_b4;
	$transaction = pass_cytptor($transaction . $hased_b4);


	$smallLetter = array(1 => 'a', 2 => 'b', 3 => 'c', 4 => 'd', 5 => 'e', 6 => 'f', 7 => 'g', 8 => 'h', 9 => 'i', 10 => 'j', 11 => 'k', 12 => 'l', 13 => 'm', 14 => 'n', 15 => 'o', 16 => 'p', 17 => 'q', 18 => 'r', 19 => 's', 20 => 't', 21 => 'u', 22 => 'v', 23 => 'w', 24 => 'x', 25 => 'y', 26 => 'z', );

	$ApsLetter = array(1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I', 10 => 'J', 11 => 'K', 12 => 'L', 13 => 'M', 14 => 'N', 15 => 'O', 16 => 'P', 17 => 'Q', 18 => 'R', 19 => 'S', 20 => 'T', 21 => 'U', 22 => 'V', 23 => 'W', 24 => 'X', 25 => 'Y', 26 => 'Z', );

	$nums = array(0 => '0', 1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6', 7 => '7', 8 => '8', 9 => '9',   );

	$hash_len = 16;
	$hash_value = "";
	for ($i=0; $i < $hash_len; $i++) {
		$i1 = $smallLetter[random_int(1, count($smallLetter)-1)];
		$i2 = $ApsLetter[random_int(1, count($ApsLetter)-1)];
		$i3 = $nums[random_int(0, count($nums)-1)];

		$hash_value .= $i1 . $i2 . $i3;
		# code...
	}

	$randmtor = random_int(1, 200);
	$hash_1 = file_cytptor($hash_value.$randmtor);
	$receiver_address = $hash_1;
	

	//check to make sure that the user details gotten are correct and already recorded before.
	//$sender_has_money = 
	//move money....

	//check if the sender has enough money to send to receiver if transaction fee is added...
	/*if (_sender_owns_something($sender_address)){

	}*/

	//check the sender and reciver address...
	if ( strstr($sender_address, "Zuri") ){
		if ( strlen($sender_address) > 10 ) {
			echo "Correct Wallet Address";
		}
	}

	$detailer = address_balance($sender_address, "VALID");
	if ($detailer["amount"] < $amount){
		$array = ["status"=>"false", "msg"=>" Insufficient funds for filing."];
		//exit();
	}else{
		$date_time = date('Y-m-d H:i:s');
		$array = array();
		$filed_already = array();

		$filed_already = _transa_exist($transaction, $previous_hash);

		if( sizeof($filed_already) >= 1){
			$array = ["status"=>"false", "msg"=>"This Transaction already exist."];
		}else if(sizeof($filed_already) == 0){

			 $inserter = $connect->prepare("INSERT INTO `block_trans`(`count`, `sender_address`, `receiver_address`, `amount`, `previous_hash`, `difficulty`, `transaction`, `confirmations`, `status`, `date`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

			$inserter->bind_param("ssdsisiss", $sender_address, $receiver_address, $amount, $previous_hash, $difficulty, $transaction, $confirmations, $status, $date_time );
			$inserter->execute();

			if (!$inserter){
				$array = ["status"=>"false", "msg"=>" Could not add the Transaction. "];
				//echo "Could not register users";
			}else{
				//echo "inserted and done man";
				$trans_details = _transa_exist($transaction, $previous_hash);
				if(sizeof($trans_details) > 0){
					//this is where we would update the senders account....
					$array = ["status"=>"true", "transaction"=>$trans_details, "collector_value"=>$hash_value.$randmtor,  "msg"=>"Filed Successfully"];
				}else{
					$array = ["status"=>"false", "msg"=>"We had some issues with initializing this filine process"];
				}
			}
		}else{
			$array = ["status"=>"false", "msg"=>" Facing some issues with the Internet."];
		}
		
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

function file_cytptor($file_hash){
	$file_hash =  "Waziri".$file_hash."FILED";
	$file_hash = password_hash($file_hash, PASSWORD_BCRYPT);
	return $file_hash;
}

function pass_cytptor($password){
	$password =  "Waziri".$password;
	$password = password_hash($password, PASSWORD_BCRYPT);
	return $password;
}

?>