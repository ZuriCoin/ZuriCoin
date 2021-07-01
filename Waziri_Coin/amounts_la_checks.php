<?php

/*print(json_encode(address_balance("Zuri03400130819f300d06092a864886f70d010101050003818d0030818902818100b6a7c3e6f961e0ffde8f099516b5822ce56c538888395524fbfeb72f8b20560716220d53ccb4596dc9b337e5362a680bef92751e1293c41dec708a59bd0a4db639319a58f3b5490a40a44484e925af8f458404efb1e44a2522f935713e559eba7ed95f8c16851e66663042c929a065260045005281a49c17b1ef944e6373f8b10203010001", "VALID")));*/

function address_sent_amount($sender_address, $status){
		$address_balance = 0;
		$result = array("status"=>"false", "amount"=>$address_balance, "msg"=>"Failure in getting transactions");

		include "_connect__lala_wazi_master_/connector_d_fusion_.php";
		$stmt = $connect->prepare("SELECT `amount` FROM `block_trans` WHERE `sender_address` = ? and `status` =?");
		$stmt->bind_param("ss", $sender_address, $status);
		$stmt->execute();
		$stmt->bind_result($amount);

		if(!$stmt){
			$result = array("status"=>"false", "msg"=>"Could not get the coins symbols.");
		}elseif($stmt){
			while ($stmt->fetch()) {
				$address_balance = $address_balance + $amount;
				$result = ["status"=>"true", "amount"=>$address_balance, "msg"=>"Sent amount retrieved Successfully"];
				#print($address_balance);
			}
		}
	
	$stmt->close();
	return $result;
}

function address_received_amount($receiver_address, $status){
		$address_balance = 0;
		$result = array("status"=>"false", "amount"=>$address_balance, "msg"=>"Failure in getting transactions");
		include "_connect__lala_wazi_master_/connector_d_fusion_.php";
		$stmt = $connect->prepare("SELECT `amount` FROM `block_trans` WHERE `receiver_address` = ? and`status` =? ");
		$stmt->bind_param("ss", $receiver_address, $status);
		$stmt->execute();
		$stmt->bind_result($amount);

		if(!$stmt){
			$result = array("status"=>"false", "msg"=>"Could not get the coins symbols.");
		}elseif($stmt){
			while ($stmt->fetch()) {
				$address_balance = $address_balance + $amount;
				$result = ["status"=>"true", "amount"=>$address_balance, "msg"=>"Received amount retrieved Successfully"];
				//print($address_balance);
			}
		}
	
	$stmt->close();
	return $result;
}

function address_balance($wallet_address, $type){
	$result = array();
	$sender_address = $wallet_address;
	$receiver_address = $wallet_address;
	$address_balance = 0;
	$detail_collected = address_received_amount($receiver_address, $type);
	$detail_used = address_sent_amount($sender_address, $type);

	$amount_collected = ($detail_collected["amount"] == null) ? 0 : $detail_collected["amount"];
	$amount_used = ($detail_used["amount"] == null) ? 0 : $detail_used["amount"];
	#print(json_encode($detail_collected)) . "<br/>";
	#print(json_encode($detail_used));

	
	if ($amount_collected >= 0 and $amount_used >= 0){
		$address_balance = doubleval($amount_collected) - doubleval($amount_used);
		$result = ["status"=>"true", "amount"=>$address_balance, "msg"=>"Successful. Wallet Address Balance"];
	}else{
		$result = ["status"=>"false", "amount"=>'None', "msg"=>"Could not get a balance detail of address"];
	}
	#print(json_encode($result));
	return $result;

}

/*function address_sent_amount($sender_address){
		$result = array();
		include "_connect__lala_wazi_master_/connector_d_fusion_.php";
		$stmt = $connect->prepare("SELECT `count`, `sender_address`, `receiver_address`, `amount`, `previous_hash`, `difficulty`, `transaction`, `confirmations`, `status`, `date` FROM `block_trans` ");
		#$stmt->bind_param("s", $para);
		$stmt->execute();
		$stmt->bind_result($count, $sender_address, $receiver_address, $amount, $previous_hash, $difficulty, $transaction, $confirmations, $status, $date );

		if(!$stmt){
			$result = array("status"=>"false", "msg"=>"Could not get the coins symbols.");
		}elseif($stmt){
			while ($stmt->fetch()) {
				array_push($result, array( "count"=>$count, "sender_address"=>$sender_address, "receiver_address"=>$receiver_address, "amount"=>$amount, "previous_hash"=>$previous_hash, "difficulty"=>$difficulty, "transaction"=>$transaction, "confirmations"=>$confirmations, "status"=>$status, "date"=>$date ));
			}
		}
	
	$stmt->close();
	return $result;
}*/

?>