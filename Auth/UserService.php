<?php


namespace Deployer\Cloudflare\Auth;

/**
 * Class UserService
 * @package Deployer\Cloudflare\Auth
 */
class UserService implements AuthInterface
{
    /**
     * @var string
     */
    protected $key;

    /**
     * UserService constructor.
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @return array
     */
    public function getHeader()
    {
        return [
            'X-Auth-User-Service-Key' => $this->key,
        ];
    }
}
