<?php


namespace Deployer\Cloudflare\Endpoint;


use Deployer\Cloudflare\Adapter\AdapterInterface;
use Deployer\Cloudflare\Auth\AuthInterface;

/**
 * Class Account
 * @package Deployer\Cloudflare\Endpoint
 */
class Account extends Endpoint
{

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * Account constructor.
     * @param AuthInterface $auth
     * @param AdapterInterface $adapter
     */
    public function __construct(AuthInterface $auth, AdapterInterface $adapter)
    {
        parent::__construct($auth, $adapter);
        $this->baseUrl = parent::getApiUrl('accounts');
    }

    /**
     * @link https://api.cloudflare.com/#accounts-list-accounts
     * @param int $page
     * @param int $perPage
     * @param string $direction
     * @return array
     */
    public function search($page = 1, $perPage = 20, $direction = 'ASC')
    {
        $params = [
            'page' => (int)$page,
            'per_page' => (int)$perPage,
            'direction' => (string)$direction,
        ];
        return $this->adapter->get($this->baseUrl, ['headers' => $this->getHeaders(), 'query' => $params]);
    }

    /**
     * @link https://api.cloudflare.com/#accounts-account-details
     * @param string $identifier
     * @return array
     */
    public function detail($identifier)
    {
        return $this->adapter->get($this->baseUrl . '/' . $identifier, ['headers' => $this->getHeaders()]);
    }

    /**
     * @link https://api.cloudflare.com/#accounts-update-account
     * @param string $identifier
     * @param array $optional
     * @return array
     */
    public function update($identifier, array $optional = [])
    {
        return $this->adapter->put($this->baseUrl . '/' . $identifier, ['headers' => $this->getHeaders(), 'json' => $optional]);
    }
}
