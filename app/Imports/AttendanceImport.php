<?php

namespace App\Imports;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Modules\HumanResource\Entities\Attendance;
use Maatwebsite\Excel\Concerns\WithChunkReading;


class AttendanceImport implements ToModel, WithChunkReading, WithValidation, SkipsEmptyRows, WithHeadingRow
{
    use Importable;

    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Log the row data for debugging
        Log::info('Importing row: ', $row);

        // Check if the required fields are present in the row
        if (!isset($row['employee_id']) || !isset($row['date']) || !isset($row['in_time']) || !isset($row['out_time'])) {
            Log::error('Missing required fields in row: ', $row);
            return null; // Skip this row
        }

        if (is_numeric($row['in_time'])) {
            $row['in_time'] = $this->excelTimeToTimeString($row['in_time']);
        }

        if (is_numeric($row['out_time'])) {
            $row['out_time'] = $this->excelTimeToTimeString($row['out_time']);
        }

        try {
            // Insert the in_time attendance record
            Attendance::create([
                'employee_id' => $row['employee_id'],
                'time' => Carbon::parse($row['date'] . ' ' . $row['in_time']),
            ]);

            // Insert the out_time attendance record
            Attendance::create([
                'employee_id' => $row['employee_id'],
                'time' => Carbon::parse($row['date'] . ' ' . $row['out_time']),
            ]);
        } catch (\Exception $e) {
            // Log the exception and the problematic row
            Log::error('Error parsing date/time for row: ', $row);
            Log::error('Exception message: ' . $e->getMessage());
            return null; // Skip this row
        }

        // Return null as we are handling the insertion manually
        return null;
    }

    public function chunkSize(): int
    {
        return 1000; // Adjust chunk size as needed
    }

    public function rules(): array
    {
        return [
            '*.employee_id' => 'required|numeric', // Validation rule for the first column
            '*.date' => 'required|date_format:Y-m-d', // Validation rule for the second column
            '*.in_time' => 'required', // Validation rule for the third column
            '*.out_time' => 'required', // Validation rule for the fourth column
        ];
    }

    public function messages(): array
    {
        return [
            '*.employee_id.required' => 'Please enter the employee ID',
            '*.employee_id.numeric' => 'Please enter a valid employee number',
            '*.date.required' => 'Please enter the date',
            '*.date.date_format' => 'Please enter the date in the correct format (Y-m-d)',
            '*.in_time.required' => 'Please enter the in time',
            '*.out_time.required' => 'Please enter the out time',
        ];
    }

    // Function to convert Excel time to a proper time format
    function excelTimeToTimeString($excelTime)
    {
        $phpDateTime = Date::excelToDateTimeObject($excelTime);
        return $phpDateTime->format('H:i:s');
    }
}
