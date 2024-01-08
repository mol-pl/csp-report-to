-- Tworzenie bazy danych
/*
CREATE DATABASE stats_csp;

-- Używanie utworzonej bazy danych
\c stats_csp;
*/

-- Tworzenie tabeli do przechowywania raportów CSP
-- DROP TABLE IF EXISTS csp_reports;
CREATE TABLE IF NOT EXISTS csp_reports (
    id SERIAL PRIMARY KEY,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    blocked_uri VARCHAR(255),
    disposition VARCHAR(50),
    document_uri VARCHAR(255),
    effective_directive VARCHAR(50),
    original_policy TEXT,
    referrer VARCHAR(255),
    status_code INTEGER,
    violated_directive VARCHAR(50)
);
