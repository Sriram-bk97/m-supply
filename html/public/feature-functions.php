<?php
	// Function to call to perform stock query. Returns resultant message to send.
	function stock($stock_parameters) {
		$vendor_id = substr($stock_parameters, 0, 6);
		$item_name = substr($stock_parameters, 7);
		$item_id = get_item_id($item_name);
		
		$vendor_item = make_get_call("vendor_ID/" . $vendor_id . "/items/" . $item_id);
		
		$outgoing = "";
		
		if ($vendor_item->{"has"}) {
			$outgoing .= "Yes, " . $vendor_id . " has " . $item_name . " in stock.";
		} else {
			$outgoing .= "No, " . $vendor_id . " does not have " . $item_name . " in stock.";
		}
		
		return $outgoing;
	}
	
	// Function to update vendor item stock. Returns resultant message to respond with.
	function update($update_parameters) {
		$vendor_id = substr($update_parameters, 0, 6);
		$update_parameters = substr($update_parameters, 7);
		$message = substr($update_parameters, strpos($update_parameters, "-") + 2);
		$update_parameters = substr($update_parameters, 0, strpos($update_parameters, "-") - 1);
		$has = substr($update_parameters, strrpos($update_parameters, " "));
		$item_name = substr($update_parameters, 0, strrpos($update_parameters, " "));
		
		$item_id = get_item_id($item_name);
		if($has == "yes") $has = TRUE;
		else $has = FALSE;
		
		$values = ["has" => $has, "message" => $message];
		$response = make_put_call("vendor_ID/" . $vendor_id . "/items/" . $item_id, $values);
		
		$outgoing = "Successfully updated stock of " . $item_name . ".";
		
		return $outgoing;
	}
?>