<?php

function _already_public($public){
		require "_connect__lala_wazi_master_/connector_d_fusion_.php";
		$stmt = $connect->prepare("SELECT * FROM `waziri_warslet_` WHERE `public_key`=?;");
		$stmt->bind_param("s", $public);
		$stmt->execute();
		$result = $stmt->get_result();
		if(!$stmt){
			//echo "could not get the results";
			return array();
		}else{
			$row = $result->fetch_assoc();
			return $row;
	}
		$stmt->close();
}


?>