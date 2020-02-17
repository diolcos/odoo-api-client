<?php


namespace OdooApiClient\Entities;


use OdooApiClient\XmlRpcApiWrapper;

class Contacts implements EntityInterface {

    private $wrapper;

    public function __construct(XmlRpcApiWrapper $wrapper) {
        $this->wrapper = $wrapper;
    }

    /**
     * Read one or more contacts by id.
     * @param array $ids : Ids of the contacts to read.
     * @param array $fields : The fields to return.
     * @return array
     */
    public function read(array $ids=[], array $fields=[]): array {
        return $this->wrapper->readRecord('res.partner', $ids, $fields);
    }

    /**
     * Create a new contact.
     * @param string $data : Example: [ ['name' => 'test name', 'phone' => '1234'] ]
     * @return mixed : The id of the created contact.
     */
    public function create(array $data=[]) {
        return $this->wrapper->createRecord('res.partner', $data);
    }

    /**
     * Update existing contact.
     * @param int $id
     * @param array $data : Example: ['name' => 'test name', 'phone' => '1234']
     * @return mixed
     */
    public function update(int $id, array $data=[]) {
        return $this->wrapper->updateRecord('res.partner', $id, $data);
    }

    /**.
     * List all contacts.
     * @param array $filter_data : [ [ ['is_company', '=', false], ] ]
     * @return array
     */
    public function list(array $filter_data=[]): array {
        return $this->wrapper->listRecords('res.partner', $filter_data);
    }

    /**
     * Delete contact by id.
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool {
        return $this->wrapper->deleteRecord('res.partner', $id);
    }

    /**
     * Get available of contact fields.
     * @return array
     */
    public function listFields(): array {
        return $this->wrapper->listRecordFields('res.partner');
    }
}