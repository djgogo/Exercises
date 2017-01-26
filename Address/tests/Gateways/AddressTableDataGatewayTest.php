<?php

namespace Address\Gateways {

    use Address\Entities\Address;
    use Address\Loggers\ErrorLogger;

    /**
     * @covers Address\Gateways\AddressTableDataGateway
     * @uses Address\Loggers\ErrorLogger
     * @uses Address\Entities\Address
     */
    class AddressTableDataGatewayTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var \PDO
         */
        private $pdo;

        /**
         * @var AddressTableDataGateway
         */
        private $gateway;

        /**
         * @var \PHPUnit_Framework_MockObject_MockObject | ErrorLogger
         */
        private $logger;

        protected function setUp()
        {
            $this->logger = $this->getMockBuilder(ErrorLogger::class)->disableOriginalConstructor()->getMock();
            $this->pdo = $this->initDatabase();
            $this->gateway = new AddressTableDataGateway($this->pdo, $this->logger);
        }

        public function testAllAddressesCanBeRetrieved()
        {
            $addresses = $this->gateway->getAllAddresses();
            $this->assertInstanceOf(Address::class, $addresses[0]);
            $this->assertEquals('Obi-Van Kenobi', $addresses[0]->getAddress1());
        }

        public function testSearchedAddressCanBeFound()
        {
            $addresses = $this->gateway->getSearchedAddress('Obi-Van Kenobi');
            $this->assertEquals('Obi-Van Kenobi', $addresses[0]->getAddress1());
        }

        public function testAddressCanBeFoundById()
        {
            $address = $this->gateway->findAddressById(1);
            $this->assertEquals(1, $address->getId());
        }

        public function testAddressesCanBeSortedAscendingByUpdated()
        {
            $addresses = $this->gateway->getAllAddressesOrderedByUpdatedAscending();
            $this->assertEquals(1, $addresses[0]->getId());
        }

        public function testAddressesCanBeSortedDescendingByUpdated()
        {
            $addresses = $this->gateway->getAllAddressesOrderedByUpdatedDescending();
            $this->assertEquals(2, $addresses[0]->getId());
        }

        public function testAddressCanBeUpdated()
        {
            $row = [
                'Id' => 1,
                'address1' => 'changed Name',
                'address2' => 'changed address',
                'city' => 'Galaxy',
                'postalCode' => 1234,
                'updated' => date("Y-m-d H:i:s")
            ];
            $this->assertTrue($this->gateway->update($row));

            $address = $this->gateway->findAddressById(1);
            $this->assertEquals('changed Name', $address->getAddress1());
            $this->assertEquals('changed address', $address->getAddress2());
        }

        private function initDatabase()
        {
            $pdo = new \PDO('sqlite::memory:');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $pdo->query(
                'CREATE TABLE addresses (
                Id INTEGER PRIMARY KEY AUTOINCREMENT,
                address1 VARCHAR(255) NOT NULL,
                address2 VARCHAR(255) NOT NULL,
                city VARCHAR(255) NOT NULL,
                postalCode INT(11) NOT NULL,
                created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated DATETIME NOT NULL)'
            );

            // Insert First Row
            $address11 = 'Obi-Van Kenobi';
            $address21 = 'Milky Way';
            $city1 = 'Galaxy';
            $postalCode1 = 1234;
            $created1 = '2017-01-26 12:00:00';
            $updated1 = date("Y-m-d H:i:s");

            $stmt = $pdo->prepare(
                'INSERT INTO addresses (address1, address2, city, postalCode, created, updated) 
                VALUES (:address1, :address2, :city, :postalCode, :created, :updated)'
            );

            $stmt->bindParam(':address1', $address11, \PDO::PARAM_STR);
            $stmt->bindParam(':address2', $address21, \PDO::PARAM_STR);
            $stmt->bindParam(':city', $city1, \PDO::PARAM_STR);
            $stmt->bindParam(':postalCode', $postalCode1, \PDO::PARAM_INT);
            $stmt->bindParam(':created', $created1, \PDO::PARAM_STR);
            $stmt->bindParam(':updated', $updated1, \PDO::PARAM_STR);
            $stmt->execute();

            // Insert Second Row
            $address12 = 'Luke Skywalker';
            $address22 = 'Mars Ave.';
            $city2 = 'Naboo';
            $postalCode2 = 5678;
            $created2 = '2017-01-26 12:00:00';
            $updated2 = date("Y-m-d H:i:s");

            $stmt = $pdo->prepare(
                'INSERT INTO addresses (address1, address2, city, postalCode, created, updated) 
                VALUES (:address1, :address2, :city, :postalCode, :created, :updated)'
            );

            $stmt->bindParam(':address1', $address12, \PDO::PARAM_STR);
            $stmt->bindParam(':address2', $address22, \PDO::PARAM_STR);
            $stmt->bindParam(':city', $city2, \PDO::PARAM_STR);
            $stmt->bindParam(':postalCode', $postalCode2, \PDO::PARAM_INT);
            $stmt->bindParam(':created', $created2, \PDO::PARAM_STR);
            $stmt->bindParam(':updated', $updated2, \PDO::PARAM_STR);
            $stmt->execute();

            $query = $pdo->query('SELECT * FROM addresses');
            //$result = $query->fetchAll(\PDO::FETCH_COLUMN);
            $result = $query->fetchAll();
            var_dump($result); exit;
            if (count($result) != 2) {
                throw new \Exception('Database could not be initialized!');
            }

            return $pdo;
        }
    }
}
