<?php
declare(strict_types = 1);

namespace Cart
{
    interface CartItemInterface
    {
        public function getName();
        public function getPrice();
        public function getUnitPrice();
        public function getQuantity();
    }
}
