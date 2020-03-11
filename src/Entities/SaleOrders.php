<?php

namespace OdooApiClient\Entities;

use OdooApiClient\XmlRpcApiWrapper;
use OdooApiClient\Entities\SaleOrderLines;

/**
 * Class SaleOrders
 * @package OdooApiClient\Entities
 */
class SaleOrders extends BaseEntity {

    /**
     * @var array : Required for create.
     */
    protected  $required = [
            "company_id",
            "currency_id",
            "date_order",
            "name",
            "partner_id",
            "partner_invoice_id",
            "partner_shipping_id",
            "pricelist_id",
    ];

    public function __construct(XmlRpcApiWrapper $wrapper) {
        parent::__construct(
            $wrapper,
            'sale.order'
        );
    }

    /**
     * Delete entity by id.
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool {
        $response = parent::delete($id);

        if (!$response) {
            $this->update($id, ['']);
            $response = parent::delete($id);
        }
        return $response;
    }

}
