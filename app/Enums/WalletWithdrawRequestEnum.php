<?php

namespace App\Enums;

enum WalletWithdrawRequestEnum: string
{
    case PENDING  = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
