<?php
declare(strict_types = 1);

namespace GetText
{
    use GetText\Exceptions\GetTextFileException;

    /**
     * POParser parses only following States: msgid, msgstr
     * and creates a new array with the Values, msgid as $key, msgstr as $value
     */
    class PoParser
    {
        /**
         * @var array
         */
        private $data = [];

        /**
         * @var string
         */
        private $filePath;

        /**
         * @var string
         */
        private $msgId;

        public function __construct(string $filePath)
        {
            $this->filePath = $filePath;
        }

        public function parse() : array
        {
            $handle = $this->load($this->filePath);

            if ($handle) {
                while (!feof($handle)) {
                    $line = fgets($handle);

                    if ($line != '' && $line[0] === 'm') {
                        if ($this->isProcessable($line)) {
                            $this->processLine(trim($line));
                        }
                    }
                }
                fclose($handle);
            }

            return $this->data;
        }

        private function load($filePath)
        {
            if (empty($filePath)) {
                throw new GetTextFileException('Input file not defined.');
            } elseif (!file_exists($filePath)) {
                throw new GetTextFileException('File does not exist' . $filePath);
            } elseif (substr($filePath, strrpos($filePath, '.')) !== '.po') {
                throw new GetTextFileException('The specified file is not a PO file.');
            }

            $handle = fopen($filePath, 'r');

            if ($handle === false) {
                throw new GetTextFileException('Unable to open file for reading: ' . $filePath);
            }

            return $handle;
        }

        private function processLine($line)
        {
            $state = 'msgid';

            if (substr($line, 0, 6) === 'msgstr') {
                $state = 'msgstr';
            }

            $value = str_replace($state . ' ', '', $line);
            $value = $this->deQuote($value);

            if ($value === '') {
                return;
            }

            if ($state === 'msgstr') {
                $this->addToData($value);
            } else {
                $this->msgId = $value;
            }
        }

        private function addToData($value)
        {
            $this->data[$this->msgId] = $value;
        }

        private function deQuote($str) : string
        {
            return substr($str, 1, -1);
        }

        private function replaceUnderlines($str) : string
        {
            return str_replace('_', ' ', $str);
        }

        private function isProcessable($line) : bool
        {
            /**
             * Regex Explanation
             * \s = any whitespace character
             * / = start and ending delimiters
             */
            $split = preg_split('/\s/', $line, 2);
            $key = $split[0];

            /**
             * allow only lines with State: msgid and msgstr
             */
            if ($key === 'msgid' || $key === 'msgstr') {
                return true;
            }

            return false;
        }

        public function getPoData() : array
        {
            return $this->data;
        }

        public function printPoData()
        {
            foreach ($this->data as $key => $value) {
                printf("msgId:  %s\n", $this->replaceUnderlines($key));
                printf("msgStr: %s\n\n", $value);
            }
        }
    }
}
