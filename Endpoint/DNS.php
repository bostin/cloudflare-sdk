<?php


namespace Deployer\Cloudflare\Endpoint;


use Deployer\Cloudflare\Adapter\AdapterInterface;
use Deployer\Cloudflare\Auth\AuthInterface;
use Exception;

/**
 * Class DNS
 * @package Deployer\Cloudflare\Endpoint
 */
class DNS extends Endpoint
{
    const TYPE_A = 'A';
    const TYPE_AAAA = 'AAAA';
    const TYPE_CNAME = 'CNAME';
    const TYPE_TXT = 'TXT';
    const TYPE_SRV = 'SRV';
    const TYPE_LOC = 'LOC';
    const TYPE_MX = 'MX';
    const TYPE_NS = 'NS';
    const TYPE_SPF = 'SPF';
    const TYPE_CERT = 'CERT';
    const TYPE_DNSKEY = 'DNSKEY';
    const TYPE_DS = 'DS';
    const TYPE_NAPTR = 'NAPTR';
    const TYPE_SMIMEA = 'SMIMEA';
    const TYPE_SSHFP = 'SSHFP';
    const TYPE_TLSA = 'TLSA';
    const TYPE_URI = 'URI';

    const NAME_MAX_LENGTH = 255;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var array
     */
    protected $validTypes = [
        self::TYPE_A, self::TYPE_AAAA, self::TYPE_CNAME, self::TYPE_TXT, self::TYPE_SRV, self::TYPE_LOC,
        self::TYPE_MX, self::TYPE_NS, self::TYPE_SPF, self::TYPE_CERT, self::TYPE_DNSKEY, self::TYPE_DS,
        self::TYPE_NAPTR, self::TYPE_SMIMEA, self::TYPE_SSHFP, self::TYPE_TLSA, self::TYPE_URI,
    ];

    /**
     * DNS constructor.
     * @param AuthInterface $auth
     * @param AdapterInterface $adapter
     * @param string $zoneIdentifier
     */
    public function __construct(AuthInterface $auth, AdapterInterface $adapter, $zoneIdentifier)
    {
        parent::__construct($auth, $adapter);
        $this->baseUrl = parent::getApiUrl(sprintf('zones/%s/dns_records', $zoneIdentifier));
    }

    /**
     * @link https://api.cloudflare.com/#dns-records-for-a-zone-create-dns-record
     *
     * @param string $type
     * @param string $name
     * @param string $content
     * @param array $optional
     *
     * @return array
     * @throws Exception
     */
    public function create($type, $name, $content, array $optional)
    {
        $params = [
            'type' => $this->validType($type),
            'name' => $this->validName($name),
            'content' => $content,
        ] + $optional;

        return $this->adapter->post($this->baseUrl, ['json' => $params, 'headers' => $this->getHeaders()]);
    }

    /**
     * @link https://api.cloudflare.com/#dns-records-for-a-zone-list-dns-records
     * @param array $params
     * @param int $page
     * @param int $perPage
     * @param string $order
     * @param string $direction
     * @return array
     */
    public function search(array $params = [], $page = 1, $perPage = 20, $order = 'id', $direction = 'ASC')
    {
        $params = $params + [
            'page' => (int)$page,
            'per_page' => (int)$perPage,
            'order' => (string)$order,
            'direction' => (string)$direction,
        ];
        return $this->adapter->get($this->baseUrl, ['query' => $params, 'headers' => $this->getHeaders()]);
    }

    /**
     * @link https://api.cloudflare.com/#dns-records-for-a-zone-dns-record-details
     * @param string $identifier
     * @return array
     */
    public function detail($identifier)
    {
        return $this->adapter->get($this->baseUrl . '/' . $identifier, ['headers' => $this->getHeaders()]);
    }

    /**
     * @link https://api.cloudflare.com/#dns-records-for-a-zone-update-dns-record
     * @param string $identifier
     * @param string $type
     * @param string $name
     * @param string $content
     * @param int $ttl
     * @param array $optional
     *
     * @return array
     * @throws Exception
     */
    public function update($identifier, $type, $name, $content, $ttl = 1, array $optional = [])
    {
        $params = [
                'type' => $this->validType($type),
                'name' => $this->validName($name),
                'content' => $content,
                'ttl' => $ttl,
            ] + $optional;
        return $this->adapter->put($this->baseUrl . '/' . $identifier, ['json' => $params, 'headers' => $this->getHeaders()]);
    }

    /**
     * @link https://api.cloudflare.com/#dns-records-for-a-zone-patch-dns-record
     * @param string $identifier
     * @param string $type
     * @param string $name
     * @param string $content
     * @param int $ttl
     * @param bool $proxied
     *
     * @return array
     * @throws Exception
     */
    public function patch($identifier, $type, $name, $content, $ttl = 1, $proxied = false)
    {
        $params = [
            'type' => $this->validType($type),
            'name' => $this->validName($name),
            'content' => $content,
            'ttl' => $ttl,
            'proxied' => $proxied,
        ];
        return $this->adapter->patch($this->baseUrl . '/' . $identifier, ['json' => $params, 'headers' => $this->getHeaders()]);
    }

    /**
     * @link https://api.cloudflare.com/#dns-records-for-a-zone-delete-dns-record
     * @param string $identifier
     *
     * @return array
     */
    public function delete($identifier)
    {
        return $this->adapter->delete($this->baseUrl . '/' . $identifier, ['headers' => $this->getHeaders()]);
    }

    /**
     * @param string $type
     * @return string
     * @throws Exception
     */
    protected function validType($type)
    {
        $type = strtoupper($type);
        if (!in_array($type, $this->validTypes)) {
            throw new Exception('Invalid DNS type: ' . $type);
        }
        return $type;
    }

    /**
     * @param string $name
     * @return string
     * @throws Exception
     */
    protected function validName($name)
    {
        if (strlen($name) > self::NAME_MAX_LENGTH) {
            throw new Exception('name\'s max length is: ' . self::NAME_MAX_LENGTH);
        }
        return $name;
    }
}
