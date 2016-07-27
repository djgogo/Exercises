<?php
declare(strict_types = 1);
require_once __DIR__ . '/bootstrap.php';

$eur = new Currency('EUR');
$usd = new Currency('USD');

$accountPeter = new Account('Peter', 123456, $eur);
$accountAnna = new Account('Anna', 234567, $eur);
$accountSteven = new Account('Steven', 584938, $usd);
$accountValerie = new Account('Valerie', 345334, $usd);

$eur10050 = new EUR(10050);
$eur1000000 = new Money(100000, $eur);
$eur9950 = new Money(9950, $eur);
$eur9050 = new Money(9050, $eur);
$eur1080 = new Money(1080, $eur);
$usd1000 = new USD(1000);
$usd2000 = new Money(2000, $usd);

/**
/* Transactions in EUR
 */
$transaction1 = new Transaction($eur10050, $accountPeter, $accountAnna, new DateTimeImmutable('2016-06-19'), new DateTimeImmutable('2016-06-19'));
printf("\n%s : Transaction of %.2f from %s to %s", $transaction1->getFormattedAccountingDate(),
    $transaction1->getAmount(), $accountPeter, $accountAnna);

$transaction2 = new Transaction($eur9950, $accountPeter, $accountAnna, new DateTimeImmutable('2016-06-19'), new DateTimeImmutable('2016-06-19'));
printf("\n%s : Transaction of %.2f from %s to %s", $transaction2->getFormattedAccountingDate(),
    $transaction2->getAmount(), $accountPeter, $accountAnna);

$transaction3 = new Transaction($eur1080, $accountAnna, $accountPeter, new DateTimeImmutable('2016-06-25'), new DateTimeImmutable('2016-06-25'));
printf("\n%s : Transaction of %.2f from %s to %s", $transaction3->getFormattedAccountingDate(),
    $transaction3->getAmount(), $accountAnna, $accountPeter);

$transaction7 = new Transaction($eur1000000, $accountPeter, $accountAnna, new DateTimeImmutable('2016-06-29'), new DateTimeImmutable('2016-06-29'));
printf("\n%s : Transaction of %.2f from %s to %s", $transaction7->getFormattedAccountingDate(),
    $transaction7->getAmount(), $accountPeter, $accountAnna);

/**
 * Transaction in USD
 */
$transaction4 = new Transaction($usd1000, $accountSteven, $accountValerie, new DateTimeImmutable('2016-06-30'), new DateTimeImmutable('2016-06-30'));
printf("\n%s : Transaction of %.2f from %s to %s\n", $transaction4->getFormattedAccountingDate(),
    $transaction4->getAmount(), $accountSteven, $accountValerie);

/**
 * Transaction from EUR to USD Account - Error!
 */
try {
    $transaction5 = new Transaction($eur10050, $accountPeter, $accountSteven, new DateTimeImmutable('2016-07-10'), new DateTimeImmutable('2016-07-10'));
} catch (InvalidTransactionException $e) {
    printf("\n **> Currency of the receiver Account needs to be the same as the sender Account\n");
}

/**
 * Transaction with an amount in USD from EUR to EUR Account - Error!
 */
try {
    $transaction6 = new Transaction($usd1000, $accountPeter, $accountAnna, new DateTimeImmutable('2016-07-20'), new DateTimeImmutable('2016-07-20'));
} catch (InvalidTransactionException $e) {
    printf("\n **> Receivers Account-Currency needs to be the same as the Senders Transaction Amount-Currency\n");
}

/**
 * Total Balance till today
 */
printf("\n%s Account-Balance: %.2f %s", $accountPeter, $accountPeter->getBalance(), $accountPeter->getCurrency()->getSign());
printf("\n%s Account-Balance: %.2f %s", $accountAnna, $accountAnna->getBalance(), $accountAnna->getCurrency()->getSign());
printf("\n%s Account-Balance: %.2f %s", $accountSteven, $accountSteven->getBalance(), $accountSteven->getCurrency()->getSign());
printf("\n%s Account-Balance: %.2f %s\n", $accountValerie, $accountValerie->getBalance(), $accountValerie->getCurrency()->getSign());

/**
 * Correction of Transaction2 (reverse booking) - new Transaction Correction with 90.50
 */
$transaction2->reverse();
printf("\n%s : Transaction 2 of %.2f from %s to %s REVERSED!", $transaction2->getFormattedAccountingDate(),
    $transaction2->getAmount(), $accountPeter, $accountAnna);

$transactionCorrection1 = new TransactionCorrection($eur9050, $accountPeter, $accountAnna, new DateTimeImmutable(), new DateTimeImmutable('2016-06-19'), $transaction2);
printf("\n%s : Transaction-Correction of %.2f from %s to %s : replacing Transaction2 from %s\n", $transactionCorrection1->getFormattedAccountingDate(),
    $transactionCorrection1->getAmount(), $accountPeter, $accountAnna, $transaction2->getFormattedAccountingDate());

/**
 * Total actual Balance till today
 */
printf("\n%s Account-Balance: %.2f %s", $accountPeter, $accountPeter->getBalance(), $accountPeter->getCurrency()->getSign());
printf("\n%s Account-Balance: %.2f %s\n", $accountAnna, $accountAnna->getBalance(), $accountAnna->getCurrency()->getSign());

/**
 * Balance between Transaction1 and Transaction2 Value-Date
 */
$selectedValueDate = new DateTimeImmutable('2016-06-21');
printf("\n%s Account-Balance until %s: %.2f %s", $accountPeter, $selectedValueDate->format('Y-m-d'),
    $accountPeter->getBalance($selectedValueDate), $accountPeter->getCurrency()->getSign());
printf("\n%s Account-Balance until %s: %.2f %s", $accountAnna, $selectedValueDate->format('Y-m-d'),
    $accountAnna->getBalance($selectedValueDate), $accountAnna->getCurrency()->getSign());

/**
 * Balance between Transaction3 and Transaction4 Value-Date
 */
$selectedValueDate = new DateTimeImmutable('2016-06-27');
printf("\n%s Account-Balance until %s: %.2f %s", $accountPeter, $selectedValueDate->format('Y-m-d'),
    $accountPeter->getBalance($selectedValueDate), $accountPeter->getCurrency()->getSign());
printf("\n%s Account-Balance until %s: %.2f %s\n", $accountAnna, $selectedValueDate->format('Y-m-d'),
    $accountAnna->getBalance($selectedValueDate), $accountAnna->getCurrency()->getSign());
