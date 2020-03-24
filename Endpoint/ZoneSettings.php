<?php


namespace Bostin\CloudflareSDK\Endpoint;


use Bostin\CloudflareSDK\Adapter\AdapterInterface;
use Bostin\CloudflareSDK\Auth\AuthInterface;

/**
 * Class ZoneSettings
 * @package Deployer\Cloudflare\Endpoint
 */
class ZoneSettings extends Endpoint
{
    const SSL_OFF = 'off';
    const SSL_FLEXIBLE = 'flexible';
    const SSL_FULL = 'full';
    const SSL_STRICT = 'strict';

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * ZoneSettings constructor.
     * @param AuthInterface $auth
     * @param AdapterInterface $adapter
     * @param string $zoneIdentifier
     */
    public function __construct(AuthInterface $auth, AdapterInterface $adapter, $zoneIdentifier)
    {
        parent::__construct($auth, $adapter);
        $this->baseUrl = parent::getApiUrl(sprintf('zones/%s/settings', $zoneIdentifier));
    }

    /**
     * @link https://api.cloudflare.com/#zone-settings-get-ssl-setting
     * @return array
     */
    public function getSSL()
    {
        return $this->adapter->get($this->baseUrl . '/ssl', ['headers' => $this->getHeaders()]);
    }

    /**
     * @link https://api.cloudflare.com/#zone-settings-change-ssl-setting
     * @param string $value
     * @return array
     */
    public function setSSL($value = 'off')
    {
        $data = ['value' => $value];
        return $this->adapter->patch($this->baseUrl . '/ssl', ['headers' => $this->getHeaders(), 'json' => $data]);
    }
}
