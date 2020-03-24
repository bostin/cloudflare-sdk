<?php


namespace Bostin\CloudflareSDK\Auth;

/**
 * Class ApiToken
 * @package Deployer\Cloudflare\Auth
 */
class ApiToken implements AuthInterface
{
    /**
     * @var string
     */
    protected $token;

    /**
     * ApiToken constructor.
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * @return array
     */
    public function getHeader()
    {
        return [
            'Authorization' => 'Bearer ' . $this->token,
        ];
    }
}
