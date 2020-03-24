# Cloudflare SDK

## [Cloudflare API](https://api.cloudflare.com/)

## Endpoints
- [x] Account
- [x] DNS
- [x] PageRules
- [x] Zone
- [x] ZoneSettings

## Quick Start
```php
$apiToken = '';
$auth = new \Bostin\CloudflareSDK\Auth\ApiToken($apiToken);
$adapter = new \Bostin\CloudflareSDK\Adapter\Guzzle();
$zone = new \Bostin\CloudflareSDK\Endpoint\Zone($auth, $adapter);
```
