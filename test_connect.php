<?php
/**
 * Test DB connection for CSP-R.
 */
require_once '.config.php';
require_once './inc/Logging.php';
require_once './inc/varia.php';

// some error report
$errorLog = new Logging('.reports/', 'error.log');

header("Content-Type: text/plain");

// connect
echo "Connect\n";
try {
    $pdo = new PDO("pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}", $config['user'], $config['password']);
} catch (PDOException $e) {
	$errorLog->append("Connection failed: " . $e->getMessage());
    echo "Connection failed\n";
    exit;
}
// disable throwing exceptions
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);	

// query
$sql = "SELECT COUNT(*) AS num FROM csp_reports";
$stmt = $pdo->prepare($sql);
if (!$stmt) {
    echo "Prepare failed\n";
    sqlErrorInfo($pdo, 'Prepare failed', $errorLog);
    exit;
}
if ($stmt->execute()) {
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	$num_reports = $result['num'];
	echo "Number of CSP reports: " . $num_reports;
} else {
	echo "Execute failed\n";
	sqlErrorInfo($stmt, 'Execute failed', $errorLog);
	exit;
}

// close connection
$pdo = null;

echo "\nDone\n";