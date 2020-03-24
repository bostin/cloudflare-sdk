<?php


namespace Deployer\Cloudflare\Auth;

/**
 * Class AuthEmail
 * @package Deployer\Cloudflare\Auth
 */
class AuthEmail implements AuthInterface
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $email;

    /**
     * AuthEmail constructor.
     * @param string $email
     * @param string $key
     */
    public function __construct($email, $key)
    {
        $this->email = $email;
        $this->key = $key;
    }

    /**
     * @return array
     */
    public function getHeader()
    {
        return [
            'X-Auth-Key' => $this->key,
            'X-Auth-Email' => $this->email,
        ];
    }
}
