<?php

#update_trans_stats("CAHNGED", 12);
function update_trans_stats($status, $block_count){
	require "_connect__lala_wazi_master_/connector_d_fusion_.php";
	$stmt = $connect->prepare("UPDATE `block_trans` SET `status`=? WHERE `count`=?;");
	$stmt->bind_param("si", $status, $block_count);
	$stmt->execute();
	//$result = $stmt->get_result();
	if(!$stmt){
		return false;
	}else{
		//$row = $result->fetch_assoc();
		return true;
	}
	$stmt->close();
}

function update_trans_confirms($current_confirmed, $block_count){
	require "_connect__lala_wazi_master_/connector_d_fusion_.php";
	$current_confirmed = $current_confirmed + 1;
	$stmt = $connect->prepare("UPDATE `block_trans` SET `confirmations`=? WHERE `count`=?;");
	$stmt->bind_param("ii", $current_confirmed, $block_count);
	$stmt->execute();
	//$result = $stmt->get_result();
	if(!$stmt){
		return false;
	}else{
		//$row = $result->fetch_assoc();
		return true;
	}
	$stmt->close();
}

/*$previous_hash = "QZmR0InqgvbdeE7X0xECYr5eDpfsOlm#WAZIRI#xECYr\
	5eDpfsOlm";
miner_reward("Zuri00400330819f300d06092a864886f70d010101050003818d0030818902818100b6a7c3e6f961e0ffde8f099516b5822ce56c538888395524fbfeb72f8b20560716220d53ccb4596dc9b337e5362a680bef92751e1293c41dec708a59bd0a4db639319a58f3b5490a40a44484e925af8f458404efb1e44a2522f935713e559eba7ed95f8c16851e66663042c929a065260045005281a49c17b1ef944e6373f8b10203010001", $previous_hash );*/

function miner_reward($miner_address, $previous_hash, $mined_block){
	include "_connect__lala_wazi_master_/connector_d_fusion_.php";
	#require "get_previous_hash.php";
	#include "waziri_gettor_d_trans.php";
	#$sender_address = $block_count;
	$sender_address = "";
	$amount = 100;
	#$previous_hash = "";
	$difficulty = 0;
	$transaction = "";
	$confirmations = 10;
	$status = "MINED";
	$date_time = date('Y-m-d H:i:s');

	/*$hased_b4 = "";
	if (strpos($previous_hash, "#WAZIRI#") >= 0){
		$last_hash = explode("#WAZIRI#", $previous_hash);
		$hased_b4 = $last_hash[1];
	}
*/	

	/*$here = json_decode(_previous_details_getter_());
	if ($here->transaction == null){
		$hased_b4 = "";
	}else{
		$hased_b4 = $here->transaction->transaction;
	}

	$here = json_decode(_previous_details_getter_());
	if ($here->transaction == null){
		$previous_hash = "";
	}else{
		$previous_hash = $here->transaction->transaction;
	}

	$previous_hash = $previous_hash."#WAZIRI#".$hased_b4;*/

	


	$trans_detail_b_ = _trans_by_Amountprevious($previous_hash, $status, $transaction);
	#$transaction = _ss_cytptor($transaction . $hased_b4);
	#print(json_encode($trans_detail_b_));
	if ($trans_detail_b_ == null){
		 $inserter = $connect->prepare("INSERT INTO `block_trans`(`count`, `sender_address`, `receiver_address`, `amount`, `previous_hash`, `difficulty`, `transaction`, `confirmations`, `status`, `date`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

		$inserter->bind_param("ssdsisiss", $sender_address, $miner_address, $amount, $previous_hash, $difficulty, $transaction, $confirmations, $status, $date_time );
		$inserter->execute();

		if (!$inserter){
			$array = ["status"=>"false", "msg"=>" Could not add the Transaction. "];
			//echo "Could not register users";
		}else{
			//echo "inserted and done man";
			$trans_details = _transa_exist($transaction, $previous_hash);
			#print(json_encode($trans_details));
			if(is_array($trans_details) and $trans_details != Null){			

				$array = ["status"=>"true", "transaction"=>$trans_details, "msg"=>"Transaction initiated Successfully"];
			}else{
				$array = ["status"=>"false", "msg"=>"We had some issues with initializing this transaction"];
			}
		}

	}else{
		$array = ["status"=>"false", "msg"=>"Already Mined"];
	}

	
	#print(json_encode($array));
}


function _ss_cytptor($password){
	$password =  "Waziri".$password;
	$password = password_hash($password, PASSWORD_BCRYPT);
	return $password;
}


function _trans_by_Amountprevious($previous_hash, $status, $transaction){
	require "_connect__lala_wazi_master_/connector_d_fusion_.php";
	$stmt = $connect->prepare("SELECT * FROM `block_trans` WHERE `previous_hash`=? AND `status` = ? AND `transaction`=? ;");
	$stmt->bind_param("sss", $previous_hash, $status, $transaction);
	$stmt->execute();
	$result = $stmt->get_result();
	if(!$stmt){
		return array();
	}else{
		$row = $result->fetch_assoc();
		return $row;
	}
	$stmt->close();
}

?>