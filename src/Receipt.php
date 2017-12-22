<?php

namespace Lexty\Robokassa;

use Lexty\Robokassa\Exception\InvalidSnoException;
use Lexty\Robokassa\ReceiptItem;

class Receipt
{
    /**
     * the total ST
     */
    const SNO_OSN = 'osn';
    /**
     * a simplified ST (income)
     */
    const SNO_USN_INCOME = 'usn_income';
    /**
     * a simplified ST (income minus costs)
     */
    const SNO_USN_INCOME_OUTCOME = 'usn_income_outcome';
    /**
     * a single tax on imputed income
     */
    const SNO_ENVD = 'envd';
    /**
     * a single agricultural tax
     */
    const SNO_ESN = 'esn';
    /**
     * a patent ST
     */
    const SNO_PATENT = 'patent';
    /**
     * @var string
     */
    protected $sno;
    /**
     * @var array
     */
    protected $items = [];

    public function __construct($sno = '')
    {
        $sno = strtolower($sno);
        if ($sno && ! in_array($sno, [self::SNO_OSN, self::SNO_USN_INCOME, self::SNO_USN_INCOME_OUTCOME, self::SNO_ENVD, self::SNO_ESN, self::SNO_PATENT])) {
            throw new InvalidSnoException(sprintf('Unsupported system of taxation "%s".', $sno));
        }
        $this->sno = $sno;
    }

    /**
     * @return arrat
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param array $items
     *
     * @return Receipt
     */
    public function setItems(array $items)
    {
        foreach ($items as $item) {
            if (! $item instanceof ReceiptItem) {
                throw new InvalidReceiptItemException();
            }
        }

        $this->items = $items;

        return $this;
    }

    public function addItem(ReceiptItem $item)
    {
        array_push($this->items, $item);

        return $this;
    }

    public function toArray()
    {
        if (! empty($this->items)) {
            $items = [];
            foreach ($this->items as $item) {
                array_push($items, $item->toArray());
            }
        }

        return [
            'sno' => $this->sno,
            'items' => $items ?? [],
        ];
    }

    public function __toString()
    {
        return urlencode(json_encode($this->toArray()));
    }
}