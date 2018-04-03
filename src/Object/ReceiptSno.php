<?php

declare(strict_types=1);

namespace SSitdikov\ATOL\Object;

/**
 * Interface ReceiptSno
 * @package SSitdikov\ATOL\Object
 */
interface ReceiptSno
{
    const RECEIPT_SNO_OSN = 'osn';
    const RECEIPT_SNO_USN_INCOME = 'usn_income';
    const RECEIPT_SNO_USN_INCOME_OUTCOME = 'usn_income_outcome';
    const RECEIPT_SNO_ENVD = 'envd';
    const RECEIPT_SNO_ESN = 'esn';
    const RECEIPT_SNO_PATENT = 'patent';
}
