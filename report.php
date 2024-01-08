<?php
/**
 * Receive report from CSP rules.
 */
require_once 'config.php';

// CSP data
$data = file_get_contents("php://input");
$report = json_decode($data, true);

// connect
$pdo = new PDO("pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}", $config['user'], $config['password']);

// query
$sql = "INSERT INTO csp_reports (blocked_uri, disposition, document_uri, effective_directive, original_policy, referrer, status_code, violated_directive)
        VALUES (:blocked_uri, :disposition, :document_uri, :effective_directive, :original_policy, :referrer, :status_code, :violated_directive)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':blocked_uri', $report['blocked-uri']);
$stmt->bindParam(':disposition', $report['disposition']);
$stmt->bindParam(':document_uri', $report['document-uri']);
$stmt->bindParam(':effective_directive', $report['effective-directive']);
$stmt->bindParam(':original_policy', $report['original-policy']);
$stmt->bindParam(':referrer', $report['referrer']);
$stmt->bindParam(':status_code', $report['status-code']);
$stmt->bindParam(':violated_directive', $report['violated-directive']);
$stmt->execute();

// close connection
$pdo = null;
