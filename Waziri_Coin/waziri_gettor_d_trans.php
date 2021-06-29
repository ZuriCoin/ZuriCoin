<?php

function _transa_exist_file($transaction_hash, $amount){
	require "_connect__lala_wazi_master_/connector_d_fusion_.php";
	$stmt = $connect->prepare("SELECT * FROM `block_trans` WHERE `transaction`=? AND `amount` = ? ;");
	$stmt->bind_param("sd", $transaction_hash, $amount);
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

function _transa_exist($transaction_hash, $previous_hash){
	require "_connect__lala_wazi_master_/connector_d_fusion_.php";
	$stmt = $connect->prepare("SELECT * FROM `block_trans` WHERE `transaction`=? AND `previous_hash` = ? ;");
	$stmt->bind_param("ss", $transaction_hash, $previous_hash);
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


function _get_trans_by_count($block_count){
	require "_connect__lala_wazi_master_/connector_d_fusion_.php";
	$stmt = $connect->prepare("SELECT * FROM `block_trans` WHERE `count`=?;");
	$stmt->bind_param("i", $block_count);
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


function _sender_owns_something($sender){
	require "_connect__lala_wazi_master_/connector_d_fusion_.php";
	$stmt = $connect->prepare("SELECT * FROM `block_trans` WHERE `sender_address`=? ;");
	$stmt->bind_param("s", $sender);
	$stmt->execute();
	$result = $stmt->get_result();
	if(!$stmt){
		return false;
	}else{
		$row = $result->fetch_assoc();
		if (is_null($row)) {
			return false;
		}else{return true;}
		
	}
	/*if(!$stmt){
		return array();
	}else{
		$row = $result->fetch_assoc();
		return $row;
	}*/
	$stmt->close();
}


?>