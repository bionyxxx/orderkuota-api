<?php
require 'src/OrderKuota.php';

use bionyxxx\OrderKuota;

$username = '';
$token = '123456:abcdefghi...........';
$orderkuota = new OrderKuota($username, $token);

//Get All History Transaction QRIS
echo $orderkuota->getTransactionQris();
