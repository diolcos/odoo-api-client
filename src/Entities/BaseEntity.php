<?php


namespace OdooApiClient\Entities;


use InvalidArgumentException;
use OdooApiClient\XmlRpcApiWrapper;

class BaseEntity implements EntityInterface {

    private $wrapper;
    private $resource;

    public function __construct(XmlRpcApiWrapper $wrapper, string $resource) {
        if (!isset($resource)) {
            throw new InvalidArgumentException('Resource missing.');
        }
        $this->wrapper = $wrapper;
        $this->resource = $resource;
    }

    /**
     * Read one or more entities {@this->resource} by id.
     * @param array $ids : Ids of the entities to read.
     * @param array $fields : The fields to return.
     * @return array
     */
    public function read(array $ids=[], array $fields=[]): array {
        return $this->wrapper->readRecord($this->resource, $ids, $fields);
    }

    /**
     * Create a new entity.
     * @param string $data : Example: [ ['name' => 'test name', 'phone' => '1234'] ]
     * @return mixed : The id of the created entity.
     */
    public function create(array $data=[]) {
        return $this->wrapper->createRecord($this->resource, $data);
    }

    /**
     * Update existing entity.
     * @param int $id
     * @param array $data : Example: ['name' => 'test name', 'phone' => '1234']
     * @return mixed
     */
    public function update(int $id, array $data=[]) {
        return $this->wrapper->updateRecord($this->resource, $id, $data);
    }

    /**.
     * List all entities.
     * @param array $filter_data : [ ['is_company', '=', false], ]
     * @return array
     */
    public function list(array $filter_data=[]): array {
        return $this->wrapper->listRecords($this->resource, $filter_data);
    }

    /**
     * Delete entity by id.
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool {
        return $this->wrapper->deleteRecord($this->resource, $id);
    }

    /**
     * Get available of entity fields.
     * @return array
     */
    public function listFields(): array {
        return $this->wrapper->listRecordFields($this->resource);
    }
}