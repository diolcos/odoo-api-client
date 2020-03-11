<?php
namespace OdooApiClient;

use OdooApiClient\XmlRpcApiWrapper as OdooXmlRpcApiWrapper;
use OdooApiClient\Entities\SaleOrders;
use OdooApiClient\Entities\SaleOrderLines;

use PHPUnit\Framework\TestCase;

/**
 * Tests for {@see \OdooApiClient\Entities\Contacts}
 *
 * @covers \OdooApiClient\Entities\SaleOrders
 * @covers \OdooApiClient\Entities\SaleOrderLines
 */
class OrderTest extends TestCase {

    private $odooApiWrapper;
    private $odooEntity;
    private $testdata;

    protected function setUp()
    {
        $this->odooApiWrapper = new OdooXmlRpcApiWrapper([
            'url'       => $GLOBALS['ODOO_API_URL'],
            'db'        => $GLOBALS['ODOO_API_DB'],
            'username'  => $GLOBALS['ODOO_API_USERNAME'],
            'password'  => $GLOBALS['ODOO_API_PASSWORD'],
        ]);
        $this->odooEntity = new SaleOrders($this->odooApiWrapper);

        $this->testdata = [
            "name" => "Test Name",
            "website" => "http://test.xyzdomaintest.o.doo",
            "email" => "test@test.test",
            "phone" => "1234567",
//            "display_name" => "Test display_name",
//            "title" => "mtitle"
        ];
    }

    protected function tearDown() {
    }

    public function testOrder() {
        //print_r($this->odooEntity->listFields());
        return;
        $order_data = $this->odooEntity->read([5], ["name"]);

        // Create new Contact and read it back.
        $order_id = $this->odooEntity->create([["name" => "name1"]]);
        $contact_data = $this->odooEntity->read([$contact_id], ["name"]);
        $this->assertEquals(count($contact_data), 1);
        $this->assertEquals($contact_data[0]["name"], "name1");

        // Test list.
        $contact_list = $this->odooEntity->list( [ [ ['name', '=', "name1"], ] ]);
        $this->assertEquals(count($contact_list), 1);

        // Delete it.
        $contact_deleted = $this->odooEntity->delete($contact_id);
        $this->assertEquals($contact_deleted, true);
    }

}
