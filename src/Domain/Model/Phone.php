<?php

namespace Pdo\Domain\Model;

class Phone
{
    private ?int $id;
    private string $areaCode;
    private string $number;

    public function __construct(?int $id, string $areaCode, string $number)
    {
        $this->id = $id;
        $this->areaCode = $areaCode;
        $this->number = $number;
    }

    public function getFormatedNumber(): string
    {
        return "+55 {$this->areaCode} {$this->number}";
    }
}
