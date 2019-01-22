<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Object;

/**
 * Interface ReceiptSno
 * @package SSitdikov\ATOL\Object
 */
interface ReceiptSno
{
    public const RECEIPT_SNO_OSN = 'osn';
    public const RECEIPT_SNO_USN_INCOME = 'usn_income';
    public const RECEIPT_SNO_USN_INCOME_OUTCOME = 'usn_income_outcome';
    public const RECEIPT_SNO_ENVD = 'envd';
    public const RECEIPT_SNO_ESN = 'esn';
    public const RECEIPT_SNO_PATENT = 'patent';
}
