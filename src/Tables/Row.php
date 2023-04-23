<?php

namespace App\Tables;

abstract class Row
{
    private array $all;

    public function __construct(array $data)
    {
        foreach ($data as $name => $variable) {
            $this->$name = $variable;
        }

        $this->all = $data;
    }

    public function toArray(): array
    {
        return $this->all;
    }
}