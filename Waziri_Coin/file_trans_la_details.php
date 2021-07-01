<?php

function update_file_trans($status, $receiver_address, $transaction, $block_count){
	require "_connect__lala_wazi_master_/connector_d_fusion_.php";
	$stmt = $connect->prepare("UPDATE `block_trans` SET `status`=? , `receiver_address` = ? , `transaction` = ? WHERE `count`=?;");
	$stmt->bind_param("sssi", $status, $receiver_address, $transaction, $block_count);
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

?>