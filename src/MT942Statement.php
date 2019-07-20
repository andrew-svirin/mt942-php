<?php

namespace Ukrinsoft\MT942;

/**
 * MT942 Statement class.
 */
class MT942Statement
{

    /**
     * Operation.
     * @var string 
     */
    public $op;

    /**
     * Type.
     * @var string 
     */
    public $type;

    /**
     * Amount.
     * @var integer 
     */
    public $amount;

    /**
     * Date.
     * @var date 
     */
    public $date;

    /**
     * Name.
     * @var string
     */
    public $name;

    /**
     * Bank details.
     * @var array 
     */
    public $bankDetails = [];

    /**
     * Payer details
     * @var array 
     */
    public $payerDetails = [];

    /**
     * Convert from string
     * @param string $lineStr
     * @param string $descStr
     */
    public static function fromString($lineStr, $descStr)
    {
        $statement = new MT942Statement();

        $line = preg_split('/(.{2})(.{2})(.{2})([C|D])(.*),(.*)/s', $lineStr, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        $statement->date = "20{$line[0]}-{$line[1]}-{$line[2]}";
        $statement->type = $line[3];
        $statement->amount = (int) $line[4];
        $statement->op = $line[5];
        $descRows = preg_split('/[\r|\n|\r\n]/s', $descStr, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        foreach ($descRows as $row) {
            $rowData = preg_split('/[^\?]*\?(.{2})(.*)/s', $row, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
            $key = $rowData[0];
            $value = $rowData[1];
            switch ($key) {
                case '00':
                    $statement->name = $value;
                    break;
                case '20':
                case '21':
                case '22':
                case '23':
                case '24':
                    $statement->bankDetails[] = $value;
                    break;
                case '30':
                case '31':
                case '32':
                case '33':
                case '34':
                    $statement->payerDetails[] = $value;
                    break;
            }
        }

        return $statement;
    }

}
