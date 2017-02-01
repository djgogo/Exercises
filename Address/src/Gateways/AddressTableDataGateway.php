<?php

namespace Address\Gateways {

    use Address\Entities\Address;
    use Address\Exceptions\AddressTableGatewayException;
    use Address\Loggers\ErrorLogger;
    use Address\ParameterObjects\AddressParameterObject;

    class AddressTableDataGateway
    {
        /** @var \PDO */
        private $pdo;

        /** @var ErrorLogger */
        private $logger;

        public function __construct(\PDO $pdo, ErrorLogger $logger)
        {
            $this->pdo = $pdo;
            $this->logger = $logger;
        }

        public function getAllAddresses(): array
        {
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM addresses");
                $stmt->execute();
                return $stmt->fetchAll(\PDO::FETCH_CLASS, Address::class);
            } catch (\PDOException $e) {
                $message = 'Fehler beim lesen aller Datensätze der Address Tabelle.';
                $this->logger->log($message, $e);
                throw new AddressTableGatewayException($message);
            }
        }

        public function getAllAddressesOrderedByUpdatedAscending(): array
        {
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM addresses ORDER BY updated ASC");
                $stmt->execute();
                return $stmt->fetchAll(\PDO::FETCH_CLASS, Address::class);
            } catch (\PDOException $e) {
                $message = 'Fehler beim lesen aller Datensätze der Address Tabelle aufsteigend sortiert.';
                $this->logger->log($message, $e);
                throw new AddressTableGatewayException($message);
            }
        }

        public function getAllAddressesOrderedByUpdatedDescending(): array
        {
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM addresses ORDER BY updated DESC");
                $stmt->execute();
                return $stmt->fetchAll(\PDO::FETCH_CLASS, Address::class);
            } catch (\PDOException $e) {
                $message = 'Fehler beim lesen aller Datensätze der Address Tabelle absteigend sortiert.';
                $this->logger->log($message, $e);
                throw new AddressTableGatewayException($message);
            }
        }

        public function getSearchedAddress(string $searchString): array
        {
            try {
                $stmt = $this->pdo->prepare('SELECT * FROM addresses WHERE address1 LIKE :search ');
                $search = '%' . $searchString . '%';
                $stmt->bindParam(':search', $search, \PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(\PDO::FETCH_CLASS, Address::class);
            } catch (\PDOException $e) {
                $message = 'Fehler beim lesen der Address Tabelle mit Search-Parameter.';
                $this->logger->log($message, $e);
                throw new AddressTableGatewayException($message);
            }
        }

        public function findAddressById(int $id): Address
        {
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM addresses WHERE id=:id LIMIT 1");
                $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchObject(Address::class);
                if ($result == false) {
                    throw new \PDOException();
                }
                return $result;
            } catch (\PDOException $e) {
                $message = 'Fehler beim lesen der Address Tabelle mit Id-Parameter.';
                $this->logger->log($message, $e);
                throw new AddressTableGatewayException($message);
            }
        }

        public function update(AddressParameterObject $address): bool
        {
            try {
                $stmt = $this->pdo->prepare(
                    'UPDATE addresses SET address1=:address1, address2=:address2, city=:city, postalCode=:postalCode, updated=:updated WHERE id=:id'
                );

                $stmt->bindParam(':id', $address->getId(), \PDO::PARAM_INT);
                $stmt->bindParam(':address1', $address->getAddress1(), \PDO::PARAM_STR);
                $stmt->bindParam(':address2', $address->getAddress2(), \PDO::PARAM_STR);
                $stmt->bindParam(':city', $address->getCity(), \PDO::PARAM_STR);
                $stmt->bindParam(':postalCode', $address->getPostalCode(), \PDO::PARAM_INT);
                $stmt->bindParam(':updated', $address->getUpdated(), \PDO::PARAM_STR);

                $stmt->execute();
                return true;

            } catch (\PDOException $e) {
                $message = 'Fehler beim ändern eines Datensatzes der Adress Tabelle.';
                $this->logger->log($message, $e);
                throw new AddressTableGatewayException($message);
            }
        }

        public function delete(string $id): bool
        {
            try {
                $stmt = $this->pdo->prepare(
                    'DELETE FROM addresses WHERE id=:id'
                );

                $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
                $stmt->execute();
                return true;

            } catch (\PDOException $e) {
                $message = 'Fehler beim löschen eines Datensatzes der Adress Tabelle.';
                $this->logger->log($message, $e);
                throw new AddressTableGatewayException($message);
            }
        }
    }
}
