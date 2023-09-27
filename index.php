<?php

use GmoPaymentGateway\GMOPGClient;

$gmopg = new GMOPGClient();

$gmopg->creditCard->changeTran();
