<?php

namespace App\Services;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class InputImport implements ToArray, WithCalculatedFormulas
{
    public array $rows = [];

    public function array(array $array)
    {
        $this->rows = $array;
    }
}
