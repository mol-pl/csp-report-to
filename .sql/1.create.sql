-- Creating the database
/*
CREATE USER statscsp WITH PASSWORD 'some pass abc1!';

-- simple db creation:
CREATE DATABASE stats_csp;

-- advanced
CREATE DATABASE stats_csp
    WITH
    OWNER = statscsp
    ENCODING = 'UTF8'
    LC_COLLATE = 'pl_PL.UTF-8'
    LC_CTYPE = 'pl_PL.UTF-8'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1
    TEMPLATE template0;

-- Using the created database
\c stats_csp;
*/

-- Creating a table to store CSP reports
-- DROP TABLE IF EXISTS csp_reports;
CREATE TABLE IF NOT EXISTS csp_reports (
	id SERIAL PRIMARY KEY,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

	document_uri VARCHAR(255),
	effective_directive VARCHAR(50),
	violated_directive VARCHAR(50),

	disposition VARCHAR(50),
	status_code INTEGER,
	blocked_uri VARCHAR(255),
	original_policy TEXT,
	referrer VARCHAR(255)
);
