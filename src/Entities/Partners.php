<?php

namespace OdooApiClient\Entities;

use OdooApiClient\XmlRpcApiWrapper;

/**
 * Class Partners
 * @package OdooApiClient\Entities
 */
class Partners extends BaseEntity {

    public function __construct(XmlRpcApiWrapper $wrapper) {
        parent::__construct(
            $wrapper,
            'res.partner'
        );
    }
}
