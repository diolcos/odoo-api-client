<?php

namespace OdooApiClient\Entities;

use OdooApiClient\XmlRpcApiWrapper;

/**
 * Class SaleOrders
 * @package OdooApiClient\Entities
 */
class SaleOrderLines extends BaseEntity {

    /**
     * @var array : Required for create.
     */
    protected  $required = [
        "customer_lead",
        "name",
        "order_id",
        "price_unit",
        "product_uom_qty"
    ];

    public function __construct(XmlRpcApiWrapper $wrapper) {
        parent::__construct(
            $wrapper,
            'sale.order.line'
        );
    }
}
