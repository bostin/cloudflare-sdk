<?php


namespace Deployer\Cloudflare\Auth;


/**
 * Interface AuthInterface
 * @package Deployer\Cloudflare\Auth
 * @link https://api.cloudflare.com/#getting-started-requests
 */
interface AuthInterface
{
    /**
     * @return array
     */
    public function getHeader();
}
