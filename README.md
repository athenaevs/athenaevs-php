# Oveview
Athena EVS helps verifies the validity and deliverability of an email address. We ensure that email addresses in your list are accurate and active, which helps improve email marketing campaigns, reduce bounce rates, and maintain a clean email list.

Here are the key functions of Athena EVS:

- **Syntax Check**: Validates the format of an email address according to standard email syntax rules.
- **Domain Check**: Verifies that the domain of the email address (e.g., gmail.com) exists and can receive emails.
- **MX Record Check**: Checks the Mail Exchange (MX) records of the domain to ensure it is set up to receive emails.
- **Disposable Email Detection**: Identifies temporary or disposable email addresses often used for short-term purposes.
- **Role-based Account Detection**: Identifies addresses associated with roles (e.g., info@, support@) which are not typically linked to a specific person.
- **Spam Trap Detection**: Detects known spam traps to help avoid blacklisting and other deliverability issues.
- **Email Ping/SMTP Check**: Pings the email address or initiates an SMTP handshake to check if the mailbox exists and is active, without sending an actual email.

Athena from Japan helps individuals and organizations maintain their sender reputation, increase email campaign effectiveness, and ensure compliance with anti-spam regulations.
# Installation
Install from Composer:
```php
composer require athenaevs/athenaevs-php
composer install
```
# Single email address verification
Once the SDK is installed, you can use it to verify a single email address like this
```php
use AthenaEvs\Client;

$client = new Client($api = 'Your API Key');
$response = $client->verify('hello@example.jp');

print_r( $response ); // something like [ 'success' => true, 'result' => 'deliverable' ]
```
See [our API Documentation](https://www.google.com) for the details of request / response format.

# Batch verification
You can also verify a batch of multiple emails address within a single API request as follows
```php
use AthenaEvs\Client;

$client = new Client($api = 'Your API Key');
$response = $client->batchVerify([ 'addr01@example.jp', 'addr02@example.com', ...]);

print_r( $response ); // something like [ 'success' => true, 'batch_id' => '100093' ]
```
The batch verify API returns a batch ID. You can use this batch ID to query the verification progress
```php
$client->checkProgress( 100093 )
```
