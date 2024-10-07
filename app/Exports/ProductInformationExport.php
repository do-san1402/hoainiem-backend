<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Modules\Product\Entities\ProductInformation;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ProductInformationExport implements FromCollection , WithHeadings, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        //Exporting only certain columns.
        return ProductInformation::select('brand_id','category_id','sub_category_id','supplier_id','product_name','product_code','barcode_qrcode','price','cost','m_total_price','unit','tax','serial_no','product_vat','product_model','warranty','product_details','image','multi_products_info','is_multi','tax0','tax1','hsn_code','is_saleable','is_expirable','is_serviceable','status')->get();
        //return ProductInformation::all();
    }

    public function headings(): array
    {
        return [
            'brand_id',
            'category_id',
            'sub_category_id',
            'supplier_id',
            'product_name',
            'product_code',
            'barcode_qrcode',
            'price',
            'cost',
            'm_total_price',
            'unit',
            'tax',
            'serial_no',
            'product_vat',
            'product_model',
            'warranty',
            'product_details',
            'image',
            'multi_products_info',
            'is_multi',
            'tax0',
            'tax1',
            'hsn_code',
            'is_saleable',
            'is_expirable',
            'is_serviceable',
            'status',
        ];
    }
}

