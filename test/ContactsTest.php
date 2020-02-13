<?php
namespace OdooApiClient;

use OdooApiClient\XmlRpcApiWrapper as OdooXmlRpcApiWrapper;
use OdooApiClient\Entities\Contacts as OdooContacts;

use PHPUnit\Framework\TestCase;

class ContactsTest extends TestCase {

    public function testContact()
    {
        $odooApiWrapper = new OdooXmlRpcApiWrapper([
            'url'       => $GLOBALS['ODOO_API_URL'],
            'db'        => $GLOBALS['ODOO_API_DB'],
            'username'  => $GLOBALS['ODOO_API_USERNAME'],
            'password'  => $GLOBALS['ODOO_API_PASSWORD'],
        ]);

        $odooContacts = new OdooContacts($odooApiWrapper);

        // Create new Contact and read it back.
        $contact_id = $odooContacts->create([["name" => "name1"]]);
        $contact_data = $odooContacts->read([$contact_id], ["name"]);
        $this->assertEquals(count($contact_data), 1);
        $this->assertEquals($contact_data[0]["name"], "name1");

        // Test list.
        $contact_list = $odooContacts->list( [ [ ['name', '=', "name1"], ] ]);
        $this->assertEquals(count($contact_list), 1);

        // Delete it.
        $contact_deleted = $odooContacts->delete($contact_id);
        $this->assertEquals($contact_deleted, true);
    }
}
