<?php


namespace Deployer\Cloudflare\Endpoint;


use Deployer\Cloudflare\Adapter\AdapterInterface;
use Deployer\Cloudflare\Auth\AuthInterface;
use Exception;

/**
 * Class Zone
 * @package Deployer\Cloudflare\Endpoint
 */
class Zone extends Endpoint
{
    const TYPE_FULL = 'full';
    const TYPE_PARTIAL = 'partial';

    const NAME_PATTERN = '^([a-zA-Z0-9][\-a-zA-Z0-9]*\.)+[\-a-zA-Z0-9]{2,20}$';
    const NAME_MAX_LENGTH = 253;

        /**
         * @var string
         */
        protected $baseUrl;

    /**
     * @var array
     */
    protected $validTypes = [self::TYPE_FULL, self::TYPE_PARTIAL];

    /**
     * Zone constructor.
     * @param AuthInterface $auth
     * @param AdapterInterface $adapter
     */
    public function __construct(AuthInterface $auth, AdapterInterface $adapter)
    {
        parent::__construct($auth, $adapter);
        $this->baseUrl = parent::getApiUrl('zones');
    }

    /**
     * @link https://api.cloudflare.com/#zone-create-zone
     * @param string $name
     * @param string $account
     * @param bool $jumpStart
     * @param string $type
     * @return array
     * @throws Exception
     */
    public function create($name, $account, $jumpStart = false, $type = 'full')
    {
        $params = [
            'name' => (string) $this->validName($name),
            'account' => ['id' => (string) $account],
            'jump_start' => (bool) $jumpStart,
            'type' => (string) $this->validType($type),
        ];
        return $this->adapter->post($this->baseUrl, ['headers' => $this->getHeaders(), 'json' => $params]);
    }

    /**
     * @link https://api.cloudflare.com/#zone-list-zones
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
        return $this->adapter->get($this->baseUrl, ['headers' => $this->getHeaders(), 'query' => $params]);
    }

    /**
     * @link https://api.cloudflare.com/#zone-zone-details
     * @param string $identifier
     * @return array
     */
    public function detail($identifier)
    {
        return $this->adapter->get($this->baseUrl . '/' . $identifier, ['headers' => $this->getHeaders()]);
    }

    /**
     * @link https://api.cloudflare.com/#zone-edit-zone
     * @param string $identifier
     * @param array $optional
     * @return array
     */
    public function update($identifier, array $optional = [])
    {
        return $this->adapter->patch($this->baseUrl . '/' . $identifier, ['headers' => $this->getHeaders(), 'json' => $optional]);
    }

    /**
     * @link https://api.cloudflare.com/#zone-delete-zone
     * @param string $identifier
     *
     * @return array
     */
    public function delete($identifier)
    {
        return $this->adapter->delete($this->baseUrl . '/' . $identifier, ['headers' => $this->getHeaders()]);
    }

    /**
     * @link https://api.cloudflare.com/#zone-zone-activation-check
     * @param string $identifier
     *
     * @return array
     */
    public function activationCheck($identifier)
    {
        return $this->adapter->put($this->baseUrl . '/' . $identifier . '/activation_check', ['headers' => $this->getHeaders()]);
    }

    /**
     * @param string $type
     * @return string
     * @throws Exception
     */
    private function validType($type)
    {
        $type = strtolower($type);
        if (!in_array($type, $this->validTypes)) {
            throw new Exception('Invalid type: ' . $type);
        }
        return $type;
    }

    /**
     * @param string $name
     * @return string
     * @throws Exception
     */
    private function validName($name)
    {
        if (!preg_match('/'. self::NAME_PATTERN .'/', $name)) {
            throw new Exception('Invalid name: ' . $name);
        }
        if (strlen($name) > self::NAME_MAX_LENGTH) {
            throw new Exception('name\'s max length is: ' . self::NAME_MAX_LENGTH);
        }
        return $name;
    }
}
