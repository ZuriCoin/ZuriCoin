<?php

include "_connect__lala_wazi_master_/connector_d_fusion_.php";
require "waziri_gettor_d_trans.php";
require "get_previous_hash.php";
require "file_trans_la_details.php";


if(  isset($_GET["ra"]) and isset($_GET["filed_value"]) and  isset($_GET["old_transaction"]) and  isset($_GET["amt"]) ){

	/*$previous_hash = b_cleaner($_GET["previous_hash"]);
	$receiver_address = b_cleaner($_GET["receiver_address"]);
	$amount = b_cleaner($_GET["amount"]);
	$transaction = b_cleaner($_GET["transaction"]);*/
	$receiver_address = b_cleaner($_GET["ra"]);
	$old_transaction = b_cleaner($_GET["old_transaction"]);
	$filed_value = b_cleaner($_GET["filed_value"]);
	$amt = b_cleaner($_GET["amt"]);
	$array = array();

	$trans_already = _transa_exist_file($old_transaction, $amt);

	#print($old_transaction . $filed_value);
	#print(json_encode($trans_already));
	if (is_array($trans_already)){
		$collector_value = $trans_already["receiver_address"];
		$filed_value = file_cytptor($filed_value);
		if( count($trans_already) >= 1){
			if (password_verify($filed_value, $collector_value)) {

				$status = "PENDING";
				$hased_b4 = "";
				$previous_hash = $trans_already["previous_hash"];
				if (strpos($previous_hash, "#WAZIRI#") >= 0){
					$hased_b4 = explode("#WAZIRI#", $previous_hash);
					$hased_b4 = $hased_b4[1];
				}
				$old_transaction = pass_cytptor($old_transaction . $hased_b4);
				#$transaction = $trans_already[""];
				$block_count = $trans_already["count"];

				if (update_file_trans($status, $receiver_address, $old_transaction, $block_count)){
					$array = ["status"=>"true", "msg"=>"Well Done. Collector key is Correct." ];
				}else{
					$array = ["status"=>"false", "msg"=>"Well Done. We are having issues with the transaction." ];
				}
				

			}else{
				$array = ["status"=>"false", "msg"=>"Collector key is not Correct."];
			}
			
		}else if(count($trans_already) == 0){
			$array = ["status"=>"false", "msg"=>"This Transaction has not been filed before"];
		}
	}

	echo json_encode($array);

	

	

	/*$sender_address = b_cleaner($_GET["sender_address"]);
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
 		SELECT `count`, `sender_address`, `receiver_address`, `amount`, `previous_hash`, `difficulty`, `transaction`, `confirmations`, `status`, `date` FROM `block_trans` WHERE 1

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
	
	echo json_encode($array);*/
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

function file_cytptor($file_hash){
	$file_hash =  "Waziri".$file_hash."FILED";
	#$file_hash = password_hash($file_hash, PASSWORD_BCRYPT);
	return $file_hash;
}

?>