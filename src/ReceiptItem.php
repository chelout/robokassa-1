<?php

namespace Lexty\Robokassa;

use Lexty\Robokassa\Exception\InvalidReceiptItemException;
use Lexty\Robokassa\Exception\InvalidTaxException;

class ReceiptItem
{
    /**
     * без НДС;
     */
    const TAX_NONE = 'none';

    /**
     * НДС по ставке 0%;
     */
    const TAX_VAT0 = 'vat0';

    /**
     * НДС чека по ставке 10%;
     */
    const TAX_VAT10 = 'vat10';

    /**
     * НДС чека по ставке 18%;
     */
    const TAX_VAT18 = 'vat18';

    /**
     * НДС чека по расчетной ставке 10/110;
     */
    const TAX_VAT110 = 'vat110';

    /**
     * НДС чека по расчетной ставке 18/118.
     */
    const TAX_VAT118 = 'vat118';


    protected $name;
    protected $quantity;
    protected $sum;
    protected $tax = self::TAX_NONE;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (in_array($key, ['name', 'quantity', 'sum', 'tax'])) {
                if ($key === 'tax') {
                    if (in_array($value, [self::TAX_NONE, self::TAX_VAT0, self::TAX_VAT10, self::TAX_VAT18, self::TAX_VAT110, self::TAX_VAT118,])) {
                        $this->tax = $value;
                    } else {
                        throw new InvalidTaxException(sprintf('Unsupported tax "%s".', $sno));
                    }
                } else {
                    $this->$key = $value;
                }
            } else {
                throw new InvalidReceiptItemException(sprintf('Unsupported parametr "%s".', $sno));
            }
        }
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'quantity' => $this->quantity,
            'sum' => $this->sum,
            'tax' => $this->tax,
        ];
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }
}
