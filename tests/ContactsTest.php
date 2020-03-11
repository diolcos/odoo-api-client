<?php
namespace OdooApiClient;

use OdooApiClient\XmlRpcApiWrapper as OdooXmlRpcApiWrapper;
use OdooApiClient\Entities\Contacts;

use PHPUnit\Framework\TestCase;

/**
 * Tests for {@see \OdooApiClient\Entities\Contacts}
 *
 * @covers \OdooApiClient\Entities\Contacts
 * @covers \OdooApiClient\Entities\Partners
 */
class ContactsTest extends TestCase {

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
        $this->odooEntity = new Contacts($this->odooApiWrapper);

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

    public function testContact() {
        // Create new Contact and read it back.
        $contact_id = $this->odooEntity->create([["name" => "name1"]]);
        $contact_data = $this->odooEntity->read([$contact_id], ["name"]);
        $this->assertEquals(1, count($contact_data));

        $this->assertEquals($contact_data[0]["name"], "name1");

        // Test list.
        $contact_list = $this->odooEntity->list( [ [ ['name', '=', "name1"], ] ]);
        $this->assertNotCount(0, $contact_list);

        // Delete it.
        $contact_deleted = $this->odooEntity->delete($contact_id);
        $this->assertEquals(true, $contact_deleted);
    }

    public function testContactFields() {

        $fields = array_keys($this->testdata);

        // Create new Contact and read it back.
        $contact_id = $this->odooEntity->create(
            [
               $this->testdata
            ]
        );

        $this->assertEquals(true, is_int($contact_id));

        $contact_data = $this->odooEntity->read([$contact_id], $fields);

        $this->assertEquals(count($contact_data), 1);
        foreach ($this->testdata as $k => $v) {
            $this->assertEquals($contact_data[0][$k], $v);
        }

        // Delete it.
        $contact_deleted = $this->odooEntity->delete($contact_id);
        $this->assertEquals(true, $contact_deleted);
    }

    public function testContactFieldsUpdate() {

        $fields = array_keys($this->testdata);

        // Create new Contact and read it back.
        $contact_id = $this->odooEntity->create([
            [
                "name" => $this->testdata["name"]
            ]
        ]);

        $this->assertEquals(true, is_int($contact_id));

        $update_response = $this->odooEntity->update($contact_id, [
            "website" => $this->testdata["website"],
            "email" => $this->testdata["email"],
            "phone" => $this->testdata["phone"],
//            "display_name" => $this->testdata["display_name"],
//            "title" => $this->testdata["title"],
        ]);
        $this->assertEquals(true, $update_response);

        $contact_data = $this->odooEntity->read([$contact_id], $fields);
        $this->assertEquals(count($contact_data), 1);

        foreach ($this->testdata as $k => $v) {
            $this->assertEquals($contact_data[0][$k], $v);
        }

        // Delete it.
        $contact_deleted = $this->odooEntity->delete($contact_id);
        $this->assertEquals(true, $contact_deleted);
    }
}
