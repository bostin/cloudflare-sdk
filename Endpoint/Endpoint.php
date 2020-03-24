<?php


namespace Deployer\Cloudflare\Endpoint;

use Deployer\Cloudflare\Adapter\AdapterInterface;
use Deployer\Cloudflare\Auth\AuthInterface;

/**
 * Class Endpoint
 * @package Deployer\Cloudflare\Endpoint
 */
abstract class Endpoint
{
    /**
     * @var AuthInterface
     */
    protected $auth;

    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * @var string
     */
    private $baseUri = 'https://api.cloudflare.com/client/v4';

    /**
     * Endpoint constructor.
     * @param AuthInterface $auth
     * @param AdapterInterface $adapter
     */
    public function __construct(AuthInterface $auth, AdapterInterface $adapter)
    {
        $this->auth = $auth;
        $this->adapter = $adapter;
    }

    /**
     * @param string $uri
     * @return string
     */
    public function getApiUrl($uri)
    {
        return sprintf('%s/%s', $this->getBaseUri(), trim($uri, '/'));
    }

    /**
     * @return string
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * @param string $baseUri
     * @return $this
     */
    public function setBaseUri($baseUri)
    {
        $this->baseUri = $baseUri;
        return $this;
    }

    /**
     * @param array $optional
     * @return array
     */
    public function getHeaders(array $optional = []) {
        return $this->auth->getHeader() + ['Content-Type' => 'application/json'] + $optional;
    }

    /**
     * @return AuthInterface
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }
}
