/**
	Grant rights for stats_csp DB to statscsp user.

	-- Creating user might be something like:
	CREATE USER statscsp WITH PASSWORD 'your_password_here';
*/

-- Grant CONNECT privilege on the database
GRANT CONNECT ON DATABASE stats_csp TO statscsp;

-- Grant SELECT, INSERT, UPDATE, and DELETE privileges on all existing and future tables
GRANT SELECT, INSERT, UPDATE, DELETE ON ALL TABLES IN SCHEMA public TO statscsp;

-- Optionally, grant any other privileges as needed
-- For example, to grant USAGE on all sequences in the public schema
GRANT USAGE ON ALL SEQUENCES IN SCHEMA public TO statscsp;
