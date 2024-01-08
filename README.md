# csp-report-to

**csp-report-to** is a simple PHP application designed to handle Content Security Policy (CSP) violation reports sent through the `report-uri` rule or the `report-to` rule/header.

Content Security Policy (CSP) is a web security standard that helps prevent various types of attacks such as Cross-Site Scripting (XSS). When a CSP policy is violated, the browser sends a report to a specified endpoint, and `csp-report-to` serves as an endpoint for handling these reports.

## Usage

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/your-username/csp-report-to.git
   cd csp-report-to
   ```

2. **Configure Database:**
   - Create a PostgreSQL database.
   - Update the `.config.php` file with your database connection details.

3. **Run the Application:**
   - Deploy the `csp-report-to` PHP application on a web server with PHP support.

4. **Set Up `report-uri` or `report-to` Header in Your Application:**
   - Update your CSP header to include the `report-uri` or `report-to` directive, pointing to the `csp-report-to` endpoint.

   Example with `report-uri`:
   ```html
   Content-Security-Policy: default-src 'self'; report-uri /csp-report-to
   ```

   Example with `report-to`:
   ```html
   Report-To: {"group":"csp-endpoint","max_age":31536000,"endpoints":[{"url":"/csp-report-to"}],"include_subdomains":true}
   ```

## Configuration

### PHP conf

PHP7+ should work fine. You'll just need to enable PDO for Postgres:
```
extension=pdo_pgsql
```

### This script

Modify the `.config.php` file to set up your PostgreSQL database connection details:

```php
<?php
$config = [
    'host' => 'your_database_host',
    'port' => 'your_database_port',
    'dbname' => 'your_database_name',
    'user' => 'your_database_user',
    'password' => 'your_database_password',
];
```
