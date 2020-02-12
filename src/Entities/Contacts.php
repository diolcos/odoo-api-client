<?php


namespace OdooApiClient\Entities;


use OdooApiClient\XmlRpcApiWrapper;

class Contacts implements EntityInterface {

    private $wrapper;

    public function __construct(XmlRpcApiWrapper $wrapper) {
        $this->wrapper = $wrapper;
    }

    /**
     * Create a new contact.
     * @param string $name
     * @return mixed
     */
    public function create(string $name="New Contact"): bool {
        return $this->wrapper->createRecord('res.partner', [
            ['name' => $name]
        ]);
    }

    /**
     * Update existing contact.
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data=[]): bool {
        return $this->wrapper->updateRecord('res.partner', $id, $data);
    }

    /**.
     * List all contacts.
     * @param array $filter_data
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
}