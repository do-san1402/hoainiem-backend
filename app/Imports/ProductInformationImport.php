<?php

namespace App\Imports;

use Modules\Product\Entities\Brand;
use Modules\Product\Entities\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Modules\Product\Entities\SubCategory;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\CustomerSupplier\Entities\Supplier;
use Modules\Product\Entities\ProductInformation;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ProductInformationImport implements ToModel, WithHeadingRow,SkipsEmptyRows, WithStrictNullComparison
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $brand = Brand::where('code', $row['brand_code'])->first();
        $row['brand_id'] = $brand->id;
        $category = Category::where('code', $row['category_code'])->first();
        $row['category_id'] = $category->id;
        $sub_category = SubCategory::where('code', $row['sub_category_code'])->first();
        $row['sub_category_id'] = $sub_category->id;
        $supplier = Supplier::where('code', $row['supplier_code'])->first();
        $row['supplier_id'] = $supplier->id;

        return new ProductInformation(
            [
                'brand_id'              => $row['brand_id'] ?? null,
                'category_id'           => $row['category_id'] ?? null,
                'sub_category_id'       => $row['sub_category_id'] ?? null,
                'supplier_id'           => $row['supplier_id'] ?? null,

                'product_name'          => $row['product_name'],
                'price'                 => $row['price'],
                'cost'                  => $row['cost'],
                'unit'                  => $row['unit'],
                'product_model'         => $row['product_model'],
                'product_details'       => $row['product_details'],
                'hsn_code'              => $row['hsn_code'],
                'is_saleable'           => $row['is_salable'],
                'status'                => $row['status'],
                'barcode_qrcode'        => $this->generateBarcodeNumber(),


                'image'                 => null,
                'm_total_price'         => null,
                'tax'                   => 0,
                'serial_no'             => null,
                'product_vat'           => null,
                'warranty'              => null,
                'multi_products_info'   => null,
                'is_multi'              => 0,
                'tax0'                  => null,
                'tax1'                  => null,
                'is_expirable'          => 0,
                'is_serviceable'        => 0,
            ]
        );
    }

    public function headingRow(): int
    {
        return 1;
    }


    private function generateBarcodeNumber(): int
    {
        $number = mt_rand(10000000, 99999999);

        if ($this->barcodeNumberExists($number)) {
            return $this->generateBarcodeNumber();
        }

        return $number;
    }

    private function barcodeNumberExists($number)
    {
        return ProductInformation::where('barcode_qrcode', $number)->exists();
    }
}
