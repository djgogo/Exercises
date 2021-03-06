<?php
declare(strict_types = 1);

class ISBN
{
    /**
     * @var string
     */
    private $isbn;

    public function __construct(string $isbn)
    {
        $this->ensureValid($isbn);
    }

    private function ensureValid(string $isbn)
    {
        $this->ensureRightPrefix($isbn);
        $splittedIsbn = $this->splitIsbn($isbn);
        $this->ensureRightNumberOfGroups($splittedIsbn);
        $this->ensureRightGroupNumber($splittedIsbn);
        $this->isbn = $isbn;
    }

    private function ensureRightPrefix(string $isbn)
    {
        $prefix = substr($isbn, 0, 3);
        if (!($prefix == '978' || $prefix == '979')) {
            throw new \InvalidIsbnException("Ungültiges Prefix: $prefix übergeben");
        }
    }

    private function ensureRightNumberOfGroups(array $splittedIsbn)
    {
        if (count($splittedIsbn) < 5) {
            throw new \InvalidIsbnException("Ungültiges Länge der ISBN Nummer übergeben");
        }
    }

    private function ensureRightGroupNumber(array $splittedIsbn)
    {
        if ($splittedIsbn[0] === '978') {

            switch (strlen($splittedIsbn[1])) {
                case 1:
                    if ($splittedIsbn[1] === '7') {
                        break;
                    }
                    if ($splittedIsbn[1] < '0' || $splittedIsbn[1] > '5') {
                        throw new InvalidIsbnException("Ungültige Gruppen Nummer: $splittedIsbn[1] übergeben");
                    }
                    break;
                case 2:
                    if ($splittedIsbn[1] < '80' || $splittedIsbn[1] > '94') {
                        throw new InvalidIsbnException("Ungültige Gruppen Nummer: $splittedIsbn[1] übergeben");
                    }
                    break;
                case 3:
                    if ($splittedIsbn[1] >= '600' && $splittedIsbn[1] <= '649') {
                        break;
                    }
                    if ($splittedIsbn[1] < '950' || $splittedIsbn[1] > '989') {
                        throw new InvalidIsbnException("Ungültige Gruppen Nummer: $splittedIsbn[1] übergeben");
                    }
                    break;
                case 4:
                    if ($splittedIsbn[1] < '9900' || $splittedIsbn[1] > '9989') {
                        throw new InvalidIsbnException("Ungültige Gruppen Nummer: $splittedIsbn[1] übergeben");
                    }
                    break;
                case 5:
                    if ($splittedIsbn[1] < '99900' || $splittedIsbn[1] > '99999') {
                        throw new InvalidIsbnException("Ungültige Gruppen Nummer: $splittedIsbn[1] übergeben");
                    }
                    break;
                default:
                    throw new InvalidIsbnException("Ungültige Gruppen Nummer: $splittedIsbn[1] übergeben");
            }

        } elseif ($splittedIsbn[0] === '979') {
            if ($splittedIsbn[1] < 10 || $splittedIsbn[1] > 12) {
                throw new InvalidIsbnException("Ungültige Gruppen Nummer: $splittedIsbn[1] übergeben");
            }
        }
    }

    /**
     * @param $isbn
     * @return array
     *  array(5) {
     *    [0] => prefix(3)      978
     *    [1] => groupNo(1)     3
     *    [2] => publisherNo(5) 86680
     *    [3] => titelNo(3)     192
     *    [4] => checkSum(1)    9
     *    }
     */
    private function splitIsbn(string $isbn) : array
    {
        return preg_split("/[-\040]+/", $isbn);
    }

    private function addHyphens(string $isbn) : string
    {
        return str_replace(' ', '-', $isbn);
    }

    public function __toString() : string
    {
        if (!strpos($this->isbn, ' ') === false) {
            return $this->addHyphens($this->isbn);
        }
        return $this->isbn;
    }

}
