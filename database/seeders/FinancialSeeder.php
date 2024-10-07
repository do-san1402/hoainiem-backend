<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Accounts\Entities\FinancialYear;

class FinancialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currentYear = Carbon::now()->year;
        $yearStartDate = Carbon::create($currentYear, 1, 1, 0, 0, 0);
        $yearEndDate = Carbon::create($currentYear, 12, 31, 23, 59, 59);

        // Format the dates if needed
        $formattedStartDate = $yearStartDate->format('Y-m-d');
        $formattedEndDate = $yearEndDate->format('Y-m-d');

        
        FinancialYear::create([
            'financial_year' => date('Y'),
            'start_date' => $formattedStartDate,
            'end_date' => $formattedEndDate,
            'status'    => 1,
            'is_close' => 0,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
}
