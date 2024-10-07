<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\HumanResource\Entities\ManualAttendance;

class ManualAttendanceImport implements ToModel, WithHeadingRow
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new ManualAttendance([
            'employee_id' => $row['employee_id'],
            'time' => $row['time'],
        ]);
    }

    public function rules(): array
    {
        return [
            'employee_id' => 'required', // Validation rule for the first column
            'time' => 'required|date_format:Y-m-d H:i:s', // Validation rule for the second column
            // Add more validation rules for other columns
        ];
    }

    public function messages(): array
    {
        return [
            'employee_id.required' => 'Please enter the employee',
            'time.required' => 'Please enter the time',
            'time.date_format' => 'Please enter the time in the correct format',
            // Add more validation messages for other columns
        ];
    }
}
