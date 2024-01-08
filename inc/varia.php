<?php
/** Basic error info for both PDO and PDOStatement objects. */
function sqlErrorInfo($pdo_obj, $text, $log) {
	global $is_test;

	$info = $pdo_obj->errorInfo();
	if ($is_test) {
		echo "\n[ERROR] $text; SQL error info:\n";
		var_export($info);
	}
	$json = json_encode($info);
	error_log("[ERROR] $text; SQL failed. info: $json");
	$log->append($json);
}
