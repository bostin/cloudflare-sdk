<?php


namespace Bostin\CloudflareSDK\Adapter;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Guzzle
 * @package Deployer\Cloudflare\Adapter
 */
class Guzzle implements AdapterInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Guzzle constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $config = array_merge(['http_errors' => false], $config);
        $this->client = new Client($config);
    }

    /**
     * @param string $url
     * @param array $options
     * @return array
     */
    public function get($url, array $options = [])
    {
        return $this->proxy('get', $url, $options);
    }

    /**
     * @param string $url
     * @param array $options
     * @return array
     */
    public function post($url, array $options = [])
    {
        return $this->proxy('post', $url, $options);
    }

    /**
     * @param string $url
     * @param array $options
     * @return array
     */
    public function put($url, array $options = [])
    {
        return $this->proxy('put', $url, $options);
    }

    /**
     * @param string $url
     * @param array $options
     * @return array
     */
    public function delete($url, array $options = [])
    {
        return $this->proxy('delete', $url, $options);
    }

    /**
     * @param string $url
     * @param array $options
     * @return array
     */
    public function patch($url, array $options = [])
    {
        return $this->proxy('patch', $url, $options);
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $options
     * @return array
     */
    protected function proxy($method, $url, $options = [])
    {
        /**
         * @var ResponseInterface $response
         */
        $response = $this->client->{$method}($url, $options);
        $body = (string) $response->getBody();
        return json_decode($body, true);
    }
}
