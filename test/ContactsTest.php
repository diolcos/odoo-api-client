<?php
namespace OdooApiClient;

use OdooApiClient\XmlRpcApiWrapper as OdooXmlRpcApiWrapper;
use OdooApiClient\Entities\Contacts as OdooContacts;

use PHPUnit\Framework\TestCase;

class ContactsTest extends TestCase {

    private $odooApiWrapper;
    private $odooContacts;
    private $testdata;

    protected function setUp()
    {
        $this->odooApiWrapper = new OdooXmlRpcApiWrapper([
            'url'       => $GLOBALS['ODOO_API_URL'],
            'db'        => $GLOBALS['ODOO_API_DB'],
            'username'  => $GLOBALS['ODOO_API_USERNAME'],
            'password'  => $GLOBALS['ODOO_API_PASSWORD'],
        ]);
        $this->odooContacts = new OdooContacts($this->odooApiWrapper);

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
        $contact_id = $this->odooContacts->create([["name" => "name1"]]);
        $contact_data = $this->odooContacts->read([$contact_id], ["name"]);
        $this->assertEquals(count($contact_data), 1);
        $this->assertEquals($contact_data[0]["name"], "name1");

        // Test list.
        $contact_list = $this->odooContacts->list( [ [ ['name', '=', "name1"], ] ]);
        $this->assertEquals(count($contact_list), 1);

        // Delete it.
        $contact_deleted = $this->odooContacts->delete($contact_id);
        $this->assertEquals($contact_deleted, true);
    }

    public function testContactFields() {

        $fields = array_keys($this->testdata);

        // Create new Contact and read it back.
        $contact_id = $this->odooContacts->create(
            [
               $this->testdata
            ]
        );

        $this->assertEquals(is_int($contact_id), true, var_dump($contact_id));

        $contact_data = $this->odooContacts->read([$contact_id], $fields);

        $this->assertEquals(count($contact_data), 1);
        foreach ($this->testdata as $k => $v) {
            $this->assertEquals($contact_data[0][$k], $v);
        }

        // Delete it.
        $contact_deleted = $this->odooContacts->delete($contact_id);
        $this->assertEquals($contact_deleted, true);
    }

    public function testContactFieldsUpdate() {

        $fields = array_keys($this->testdata);

        // Create new Contact and read it back.
        echo "Creating contact with id...";
        $contact_id = $this->odooContacts->create([
            [
                "name" => $this->testdata["name"]
            ]
        ]);

        $this->assertEquals(is_int($contact_id), true);

        echo "Updating contact with id: {$contact_id}\n";
        $update_response = $this->odooContacts->update($contact_id, [
            "website" => $this->testdata["website"],
            "email" => $this->testdata["email"],
            "phone" => $this->testdata["phone"],
//            "display_name" => $this->testdata["display_name"],
//            "title" => $this->testdata["title"],
        ]);
        $this->assertEquals($update_response, true);

        echo "Reading contact with id: {$contact_id}\n";
        $contact_data = $this->odooContacts->read([$contact_id], $fields);
        $this->assertEquals(count($contact_data), 1);

        foreach ($this->testdata as $k => $v) {
            $this->assertEquals($contact_data[0][$k], $v);
        }

        // Delete it.
        $contact_deleted = $this->odooContacts->delete($contact_id);
        $this->assertEquals($contact_deleted, true);
    }
}
