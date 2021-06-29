<?php

$the_para = (isset($_GET["status"])) ? the_cleaner($_GET["status"]) : "PENDING";
echo json_encode( get_all_transactions($the_para));

function get_all_transactions($para){
	$result = array();
		//$id = intval($id);
		include "_connect__lala_wazi_master_/connector_d_fusion_.php";
		$stmt = $connect->prepare("SELECT `count`, `sender_address`, `receiver_address`, `amount`, `previous_hash`, `difficulty`, `transaction`, `confirmations`, `status`, `date` FROM `block_trans` WHERE `status`=? ");
		$stmt->bind_param("s", $para);
		$stmt->execute();
		$stmt->bind_result($count, $sender_address, $receiver_address, $amount, $previous_hash, $difficulty, $transaction, $confirmations, $status, $date );

		if(!$stmt){
			$result = array("status"=>"false", "msg"=>"Could not get the coins symbols.");
		}elseif($stmt){
			while ($stmt->fetch()) {
				array_push($result, array( "count"=>$count, "sender_address"=>$sender_address, "receiver_address"=>$receiver_address, "amount"=>$amount, "previous_hash"=>$previous_hash, "difficulty"=>$difficulty, "transaction"=>$transaction, "confirmations"=>$confirmations, "status"=>$status, "date"=>$date ) );
			}
	}
	
	$stmt->close();
	return $result;
}

function the_cleaner($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = strip_tags($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>