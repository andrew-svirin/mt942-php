<?php

namespace AndriySvirin\MT942;

use AndriySvirin\MT942\MT942Statement;

/**
 * Payment class.
 */
class MT942Payment
{

    /**
     * Transaction Reference Number
     * @var string 
     */
    public $trn;

    /**
     * Account identification.
     * @var string 
     */
    public $accountId;

    /**
     * Sequence number
     * @var string
     */
    public $sequenceNum;

    /**
     * Floor limit indicator credit 
     * @var string
     */
    public $flIndicator;

    /**
     * Date/time indicator
     * @var string
     */
    public $dtIndicator;

    /**
     * Numbers and sum of debit entries
     * @var string
     */
    public $debit;

    /**
     * Numbers and sum of credit entries
     * @var string
     */
    public $credit;

    /**
     * Statements.
     * @var MT942Statement[] 
     */
    public $statements = [];

    /**
     * Convert from string.
     * @param string $str
     * @return MT942Payment
     */
    public static function fromString($str)
    {
        $mt942Payment = new MT942Payment();
        $rows = preg_split('/[\r|\n|\r\n](:.*[^\?])/', $str, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        $stLine = [];
        $stDesc = [];
        foreach ($rows as $row) {
            $rowData = preg_split('/^:([^:]+):(((.*),$)|((.*),\n+$)|((.*)\n+$)|(.*$))/s', $row, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
            $key = $rowData[0];
            $value = rtrim(trim($rowData[1]), ',');
            switch ($key) {
                case '20':
                    $mt942Payment->trn = $value;
                    break;
                case '25':
                    $mt942Payment->accountId = $value;
                    break;
                case '28C':
                    $mt942Payment->sequenceNum = $value;
                    break;
                case '34F':
                    $mt942Payment->flIndicator = $value;
                    break;
                case '13':
                    $dateTime = preg_split('/^(.{2})(.{2})(.{2})(.{2})(.{2})$/s', $value, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
                    $mt942Payment->dtIndicator = "20{$dateTime[0]}-{$dateTime[1]}-{$dateTime[2]} {$dateTime[3]}:{$dateTime[4]}";
                    break;
                case '61':
                    $stLine[] = $value;
                    break;
                case '86':
                    $stDesc[] = $value;
                    break;
                case '90D':
                    $mt942Payment->debit = $value;
                    break;
                case '90C':
                    $mt942Payment->credit = $value;
                    break;
            }
        }
        foreach ($stLine as $i => $sl) {
            $mt942Payment->statements[] = MT942Statement::fromString($sl, $stDesc[$i]);
        }

        return $mt942Payment;
    }

}
