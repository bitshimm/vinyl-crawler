<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return Product|null
     */
    public function model(array $row)
    {
        // return new Product([
        //     'product_url' => $row[0],
        //     'tilda_uid' => $row[2],
        //     'title' => $row[1],
        return $row;
    }
}
