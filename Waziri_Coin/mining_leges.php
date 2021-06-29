<?php

include "_connect__lala_wazi_master_/connector_d_fusion_.php";
require "waziri_gettor_d_trans.php";
require "get_previous_hash.php";
require "miner_verify_trans.php";
require "amounts_la_checks.php";


if( isset($_GET["miner_address"]) and isset($_GET["block_count"]) and isset($_GET["nonce"]) and isset($_GET["transaction_py"])  ){

	//check if the sender has enough money to send to receiver if transaction fee is added...
	/*if (_sender_owns_something($sender_address)){

	}*/

	$miner_address = b_cleaner($_GET["miner_address"]);
	$block_count = b_cleaner($_GET["block_count"]);
	$nonce = b_cleaner($_GET["nonce"]);
	$transaction_py = b_cleaner($_GET["transaction_py"]);

	//check the sender and reciver address...
	//strpos(haystack, needle)
	//echo strpos($miner_address, "Zuri");
	/*if ( strpos($miner_address, "Zuri") != 0 OR strlen($miner_address) < 20 ){
		if (update_trans_stats("FAILED", $block_count) ){
			$array = ["status"=>"false", "msg"=>" Nonce is Wrong "];
			exit();
		}
	}*/


	#$date_time = date('Y-m-d H:i:s');
	$array = array();
	$trans_already = array();

	$trans_already = _get_trans_by_count($block_count);
	#print( json_encode($trans_already) );
	#print(sizeof($trans_already));
	if( count($trans_already) >= 1 ){
		#print("here or there");
		//and strstr($trans_already["previous_hash"], "#WAZIRI#") > 0 
		$transaction = $trans_already["transaction"];
		$passed_hashes = $trans_already["previous_hash"];
		$sender_address = $trans_already["sender_address"];
		$last_hash = "";
		$hased_b4 = "";
		$previous_hash = "";
		if ($passed_hashes != "#WAZIRI#"){
			$last_hash = explode("#WAZIRI#", $passed_hashes);
			$hased_b4 = $last_hash[1];
			$previous_hash = $last_hash[0];
		}
		
		

		#pass_cytptor($transaction . $hased_b4);
		/*echo "hashed pass: ".$hased_b4 . "<br/>";
		echo "hashed pass: ".$hased_b4 . "<br/>";*/
		$transaction_py = add_salt($transaction_py . $hased_b4);
		//$transaction = $transaction_py
		$sender_balance = address_balance($sender_address, "VALID");
		if ($sender_balance["status"] == "true" and $sender_balance["amount"] < $trans_already["amount"]){
			if (password_verify($transaction_py, $transaction)) {
				$status_stands = $trans_already["status"];
				$confirmation_stands = $trans_already["confirmations"];
				$miners_average = 2;
				$status = "PENDING";
				if($status_stands == "PENDING" and $confirmation_stands < $miners_average){
					$status = "PENDING";
				}else if($status_stands == "PENDING" and $confirmation_stands >= $miners_average){
					$status = "VALID";
				}
				
				if (update_trans_stats($status, $block_count) and update_trans_confirms($trans_already["confirmations"], $block_count) ){
					miner_reward($miner_address, $hased_b4);
					$array = ["status"=>"true", "msg"=>"Successful, The Transaction is currently in progress"];
				}else{
					$array = ["status"=>"true", "msg"=>"VERIFICATION FAILED, The Transaction is currently in progress"];
				}
		    } 
		    else {
		        $array = ["status"=>"false", "msg"=>" Nonce is Wrong "];
		    }

		}else{
			$array = ["status"=>"false", "msg"=>"Insufficient Funds: Can not have a remainder of less than or equal to zero"];
			if (update_trans_stats("FAILED", $block_count) ){
				exit();
			}
		}
		
	}else if(count($trans_already) == 0){
 		$array = ["status"=>"false", "msg"=>" The existance of this Transaction has not been confirmed. "];
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

function add_salt($password){
	$password =  "Waziri".$password;
	#$password = password_hash($password, PASSWORD_BCRYPT);
	return $password;
}

?>