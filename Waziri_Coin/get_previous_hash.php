<?php
//echo "here o <br/>";
if ( isset($_GET["echo"])) {
	if ( _peace_cleaner($_GET["echo"]) == "true" ) {
		echo _previous_details_getter_();
		/*$here = json_decode(_previous_details_getter_());
		if ($here->transaction == null){
			echo "nothing in";
		}else{
			echo $here->transaction->transaction;
		}*/
	}
}


function _previous_details_getter_(){
	require "_connect__lala_wazi_master_/connector_d_fusion_.php";
	$valid = "PENDING";
	$stmt = $connect->prepare("SELECT * FROM `block_trans` WHERE `status` = ? ORDER BY count LIMIT 1 ;");
	$stmt->bind_param("s", $valid);
	$trans_details = array();
	$array = ["status"=>"false", "transaction"=>$trans_details, "msg"=>"Could not access ledger"];
	$stmt->execute();
	$result = $stmt->get_result();
	if(!$stmt){
		$array = ["status"=>"false", "previous_hash"=>$trans_details, "msg"=>"Could not get Previous Hash"];
	}else{
		$row = $result->fetch_assoc();
		$array = ["status"=>"true", "transaction"=>$row, "msg"=>"Transaction initiated Successfully"];
	}
	return json_encode($array);

	$stmt->close();
}


function _peace_cleaner($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = strip_tags($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>