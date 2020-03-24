<?php


namespace Bostin\CloudflareSDK\Endpoint;


use Bostin\CloudflareSDK\Adapter\AdapterInterface;
use Bostin\CloudflareSDK\Auth\AuthInterface;

/**
 * Class PageRules
 * @package Deployer\Cloudflare\Endpoint
 */
class PageRules extends Endpoint
{
    const STATUS_ACTIVE = 'active';
    const STATUS_DISABLED = 'disabled';
    const ORDER_PRIORITY = 'priority';
    const ORDER_STATUS = 'status';
    const DIRECTION_ASC = 'asc';
    const DIRECTION_DESC = 'desc';
    const MATCH_ALL = 'all';
    const MATCH_ANY = 'any';

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * PageRules constructor.
     * @param AuthInterface $auth
     * @param AdapterInterface $adapter
     * @param $zoneIdentifier
     */
    public function __construct(AuthInterface $auth, AdapterInterface $adapter, $zoneIdentifier)
    {
        parent::__construct($auth, $adapter);
        $this->baseUrl = parent::getApiUrl(sprintf('zones/%s/pagerules', $zoneIdentifier));
    }

    /**
     * @link https://api.cloudflare.com/#page-rules-for-a-zone-list-page-rules
     * @param string $status
     * @param string $order
     * @param string $direction
     * @param string $match
     * @return array
     */
    public function search($status = self::STATUS_DISABLED, $order = self::ORDER_PRIORITY, $direction = self::DIRECTION_DESC, $match = self::MATCH_ALL)
    {
        $params = [
            'status' => (string)$status,
            'order' => (string)$order,
            'direction' => (string)$direction,
            'match' => (string)$match,
        ];
        return $this->adapter->get($this->baseUrl, ['headers' => $this->getHeaders(), 'query' => $params]);
    }

    /**
     * @link https://api.cloudflare.com/#page-rules-for-a-zone-create-page-rule
     * @param array $targets
     * @param array $actions
     * @param array $optional
     * @return array
     */
    public function create(array $targets, array $actions, array $optional = [])
    {
        $data = ['targets' => $targets, 'actions' => $actions] + $optional;
        return $this->adapter->post($this->baseUrl, ['headers' => $this->getHeaders(), 'json' => $data]);
    }

    /**
     * @link https://api.cloudflare.com/#page-rules-for-a-zone-page-rule-details
     * @param string $identifier
     * @return array
     */
    public function detail($identifier)
    {
        return $this->adapter->get($this->baseUrl . '/' . $identifier, ['headers' => $this->getHeaders()]);
    }

    /**
     * @link https://api.cloudflare.com/#page-rules-for-a-zone-update-page-rule
     * @param string $identifier
     * @param array $targets
     * @param array $actions
     * @param array $optional
     * @return array
     */
    public function update($identifier, array $targets, array $actions, array $optional = [])
    {
        $data = ['targets' => $targets, 'actions' => $actions] + $optional;
        return $this->adapter->put($this->baseUrl . '/' . $identifier, ['headers' => $this->getHeaders(), 'json' => $data]);
    }

    /**
     * @link https://api.cloudflare.com/#page-rules-for-a-zone-edit-page-rule
     * @param string $identifier
     * @param array $optional
     * @return array
     */
    public function edit($identifier, array $optional = [])
    {
        return $this->adapter->patch($this->baseUrl . '/' . $identifier, ['headers' => $this->getHeaders(), 'json' => $optional]);
    }

    /**
     * @link https://api.cloudflare.com/#page-rules-for-a-zone-delete-page-rule
     * @param string $identifier
     * @return array
     */
    public function delete($identifier)
    {
        return $this->adapter->delete($this->baseUrl . '/' . $identifier, ['headers' => $this->getHeaders()]);
    }
}
