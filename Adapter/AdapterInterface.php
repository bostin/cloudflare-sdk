<?php


namespace Bostin\CloudflareSDK\Adapter;

/**
 * Interface AdapterInterface
 * @package Deployer\Cloudflare\Adapter
 */
interface AdapterInterface
{
    /**
     * @param string $url
     * @param array $options
     * @return array
     */
    public function get($url, array $options = []);

    /**
     * @param string $url
     * @param array $options
     * @return array
     */
    public function post($url, array $options = []);

    /**
     * @param string $url
     * @param array $options
     * @return array
     */
    public function put($url, array $options = []);

    /**
     * @param string $url
     * @param array $options
     * @return array
     */
    public function delete($url, array $options = []);

    /**
     * @param string $url
     * @param array $options
     * @return array
     */
    public function patch($url, array $options = []);
}
