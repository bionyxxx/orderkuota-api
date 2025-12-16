<?php
require 'src/OrderKuota.php';

use bionyxxx\OrderKuota;

$username = 'your_username';
$token = 'your_token_here';
$orderkuota = new OrderKuota($username, $token);

//echo $orderkuota->loginRequest('pakche12345');

//echo $orderkuota->getAuthTokenRequest('94066');

//echo $orderkuota->createQrisAjaib(10000);

//echo $orderkuota->getTransactionQrisAjaib();

//echo $orderkuota->createQrisMerchant(10000);

//echo $orderkuota->getTransactionQrisMerchant();