<?php
/**
 * Receive report from CSP rules.
 */
require_once '.config.php';
require_once './inc/Logging.php';
require_once './inc/varia.php';

// some error report
$errorLog = new Logging('.reports/', 'error.log');

// CSP json
$json = file_get_contents("php://input");
// test report
$is_test = false;
if (php_sapi_name() === 'cli') {
	$is_test = true;
	$json =  "{\"csp-report\":{\"document-uri\":\"http://localhost/_test/CSP-policy-report/\",\"referrer\":\"\",\"violated-directive\":\"frame-src\",\"effective-directive\":\"frame-src\",\"original-policy\":\"frame-ancestors 'self'\\t; script-src-elem 'self' 'unsafe-inline' 'unsafe-eval' \\t\\thttps://*.lib.mol.pl https://*.molnet.mol.pl \\t\\thttps://www.googletagmanager.com/ \\t; script-src-attr 'none'\\t; style-src 'self' 'unsafe-inline' \\t\\thttps://*.lib.mol.pl https://*.molnet.mol.pl\\t\\thttps://fonts.googleapis.com https://fonts.gstatic.com \\t; connect-src *\\t; font-src 'self' \\t\\thttps://fonts.googleapis.com https://fonts.gstatic.com\\t; img-src * data:\\t; frame-src 'none'\\t; worker-src 'self'\\t; object-src 'none'\\t; report-uri /_test/csp-report-to/\",\"disposition\":\"enforce\",\"blocked-uri\":\"http://localhost/_test/CSP-policy-report/assets/report.pdf\",\"line-number\":69,\"source-file\":\"http://localhost/_test/CSP-policy-report/\",\"status-code\":200,\"script-sample\":\"\"}}";
}
if (empty($json)) {
	die('{}');
}
$data = json_decode($json, true);
if (empty($data)) {
	die('{}');
}
// log JSON
$reportsLog = new Logging('.reports/', 'report.js');
if (!$is_test) {
	$reportsLog->append($json);
}
// final validation
if (empty($data['csp-report'])) {
	die('{}');
	error_log('[WARNING] invalid CSP report, missing expected, main property.');
}
$report = $data['csp-report'];

// connect
$pdo = new PDO("pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}", $config['user'], $config['password']);

// query
$sql = "INSERT INTO csp_reports (blocked_uri, disposition, document_uri, effective_directive, original_policy, referrer, status_code, violated_directive)
        VALUES (:blocked_uri, :disposition, :document_uri, :effective_directive, :original_policy, :referrer, :status_code, :violated_directive)";
$stmt = $pdo->prepare($sql);
if (!$stmt) {
	sqlErrorInfo($pdo, 'Prepare failed', $errorLog);
}
$stmt->bindParam(':blocked_uri', $report['blocked-uri']);
$stmt->bindParam(':disposition', $report['disposition']);
$stmt->bindParam(':document_uri', $report['document-uri']);
$stmt->bindParam(':effective_directive', $report['effective-directive']);
$stmt->bindParam(':original_policy', $report['original-policy']);
$stmt->bindParam(':referrer', $report['referrer']);
$stmt->bindParam(':status_code', $report['status-code']);
$stmt->bindParam(':violated_directive', $report['violated-directive']);
$result = $stmt->execute();
if (!$result) {
	sqlErrorInfo($stmt, 'Execute failed', $errorLog);
}

// close connection
$pdo = null;
