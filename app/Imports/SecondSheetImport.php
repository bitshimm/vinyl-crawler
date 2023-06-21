<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class SecondSheetImport implements ToArray, WithCalculatedFormulas
{
    public function array($row)
    {
        return $row;
    }
}
