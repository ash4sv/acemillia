<?php

namespace App\Enums;

enum WalletTransactionEnum: string
{
    case SALE          = 'SALE';
    case REFUND        = 'REFUND';
    case WITHDRAW      = 'WITHDRAW';
    case MANUAL_CREDIT = 'MANUAL_CREDIT';
    case MANUAL_DEBIT  = 'MANUAL_DEBIT';
}
