<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Localize\Entities\Langstrval;

class LanguageValueImport implements ToModel, WithHeadingRow
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $conditions =  Langstrval::findOrFail($row['id']);

        if($conditions && $row['phrase_value']){
            $conditions->phrase_value = $row['phrase_value'];
            $conditions->save();
            return $conditions;
        };
    }

    public function rules(): array
    {
        return [
            'id'                =>'required',
            'langstring_id'     =>'required',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Please enter the id',
            'langstring_id.required' => 'Please enter the language Phrase',
        ];
    }
}
