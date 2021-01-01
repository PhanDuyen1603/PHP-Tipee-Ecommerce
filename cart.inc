<?php
if (!isset($_SESSION["cart"])) {
	$_SESSION["cart"] = array();
}

function add_item($MaSP, $q) {
	if (array_key_exists($MaSP, $_SESSION["cart"])) {
		$_SESSION["cart"][$MaSP] += $q;
	} else {
		$_SESSION["cart"][$MaSP] = $q;
	} 
}

function delete_item($MaSP) {
	unset($_SESSION["cart"][$MaSP]);
}

function update_item($MaSP, $q) {
	$_SESSION["cart"][$MaSP] = $q;
}

function get_total_items() {
	$total = 0;
	foreach ($_SESSION["cart"] as $MaSP => $q) {
            if ($MaSP) {
                $total += $q;
            } else {
                unset($_SESSION["cart"][$MaSP]);
            }
		
	}
	return $total;
}