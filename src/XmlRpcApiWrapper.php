<?php
namespace OdooApiClient;
use \Ripcord\Ripcord as ripcord;

Class XmlRpcApiWrapper {

    private $info;
    private $uid;
    private $models;

    /**
     * XmlRpcApiWrapper constructor.
     * @param array|null $info : Array with connection info, eg:
     *     [
     *         'url'       => "***",
     *         'db'        => "***",
     *         'username'  => "***",
     *         'password'  => "***",
     *     ]
     */
    public function __construct(array $info) {
        $this->info = $info;

        $common = ripcord::client("{$this->info['url']}/xmlrpc/2/common");
        //$common->version();

        $this->uid = $common->authenticate($this->info['db'], $this->info['username'], $this->info['password'], array());
        $this->models = ripcord::client("{$this->info['url']}/xmlrpc/2/object");
    }

    /**
     * @param string $model : String e.g.: 'res.partner'.
     * @param array $ids : Array of ids of the records to be read, e.g.: [1,2,3]
     * @param array $fields : Field names to return, e.g.: ['name', 'country_id', 'comment']. Even if the id field is
     * not requested, it is always returned.
     * @return mixed
     */
    public function readRecord(string $model, array $ids, array $fields): array {
        return $this->models->execute_kw($this->info['db'], $this->uid, $this->info['password'],
            'res.partner', 'read',
            [$ids],
            ['fields' => $fields]
        );
    }

    /**
     * @param string $model : String eg: 'res.partner'.
     * @param array $data : [['name'=>'Name'], etc]
     * @return mixed
     */
    public function createRecord(string $model, array $data) {
        return $this->models->execute_kw($this->info['db'], $this->uid, $this->info['password'],
            $model, 'create', $data
        );
    }

    /**
     *
     * @param string $model
     * @param int $id
     * @param array $data : E.g.: ['name'=>"Newer partner"]
     * @return mixed
     */
    public function updateRecord(string $model, int $id, array $data=[]) {

        return $this->models->execute_kw($this->info['db'], $this->uid, $this->info['password'],
            $model, 'write',
            [
                [$id],
                $data
            ]
        );
    }

    /**
     * Check access rights to a model.
     * @param string $model
     * @param bool $raise_exception : Default false.
     * @return mixed
     */
    public function checkAccessRights(string $model, bool $raise_exception=false) {
        return $this->models->execute_kw($this->info['db'], $this->uid, $this->info['password'],
            $model, 'check_access_rights',
            ['read'], ['raise_exception' => $raise_exception]
        );
    }

    /**
     * @param string $model
     * @param int $id
     * @return bool
     */
    public function deleteRecord(string $model, int $id): bool {
        return $this->models->execute_kw($this->info['db'], $this->uid, $this->info['password'],
            $model, 'unlink',
            [[$id]]
        );
    }

    /**
     * List record fields.
     * @param string $model
     * @return array
     */
    public function listRecordFields(string $model): array {
        $this->models->execute_kw($this->info['db'], $this->uid, $this->info['password'],
            $model, 'fields_get',
            [], ['attributes' => ['string', 'help', 'type']]
        );
    }

    /**
     * List record ids.
     * @param string $model
     * @param array $filter_data : [ [ ['is_company', '=', false], ] ]
     * @return array
     */
    public function listRecords(string $model, array $filter_data): array {
        return $this->models->execute_kw($this->info['db'], $this->uid, $this->info['password'],
            $model, 'search', $filter_data
        );
    }
}