<?php

include "_connect__lala_wazi_master_/connector_d_fusion_.php";
require "waziri_gettor_d_trans.php";
require "get_previous_hash.php";


if( isset($_GET["sender_address"]) and isset($_GET["receiver_address"]) and isset($_GET["previous_hash"]) and isset($_GET["transaction"]) and isset($_GET["amount"]) ){
	$sender_address = b_cleaner($_GET["sender_address"]);
	$receiver_address = b_cleaner($_GET["receiver_address"]);
	$previous_hash = b_cleaner($_GET["previous_hash"]);
	#echo $previous_hash;
	$amount = b_cleaner($_GET["amount"]);
	$transaction = b_cleaner($_GET["transaction"]);
	$difficulty = isset($_GET["difficulty"]) ? b_cleaner($_GET["difficulty"]) : 3 ;
	$status = "PENDING";
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

	//check to make sure that the user details gotten are correct and already recorded before.
	//$sender_has_money = 
	//move money....

	//check if the sender has enough money to send to receiver if transaction fee is added...
	/*if (_sender_owns_something($sender_address)){

	}*/

	//check the sender and reciver address...
	if ( strstr($sender_address, "Zuri") and  strstr($receiver_address, "Zuri")  ){
		if ( strlen($sender_address) > 10 and strlen($receiver_address) > 10 ) {
			echo "Correct Wallet Address";
		}
	}


	$date_time = date('Y-m-d H:i:s');
	$array = array();
	$user_already = array();

	$user_already = _transa_exist($transaction, $previous_hash);

	if( sizeof($user_already) >= 1){
		$array = ["status"=>"false", "msg"=>"This Transaction already exist."];
	}else if(sizeof($user_already) == 0){
 		/*SELECT `count`, `sender_address`, `receiver_address`, `amount`, `previous_hash`, `difficulty`, `transaction`, `confirmations`, `status`, `date` FROM `block_trans` WHERE 1*/

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

				$array = ["status"=>"true", "transaction"=>$trans_details, "msg"=>"Transaction initiated Successfully"];
			}else{
				$array = ["status"=>"false", "msg"=>"We had some issues with initializing this transaction"];
			}
		}
	}else{
		$array = ["status"=>"false", "msg"=>" Facing some issues with this Transaction."];
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