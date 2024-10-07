<?php

namespace App\Services;

use Modules\User\Entities\Student;
use Modules\Academic\Entities\AcSemester;
use Modules\Accounts\Entities\FinancialYear;
use Modules\Academic\Entities\ClassSchedule;
use Modules\Admission\Entities\EnrollmentProgram;

class ClassRoutineService {

    public function generateCalendarData($weekDays, $lessons) {         

        $calendarData = [];
        $timeRange    = (new TimeService())->generateTimeRange(config('academic.class_times.start_time'), config('academic.class_times.end_time'));

        foreach ($timeRange as $time) {
            $timeText = $time['start'] . ' - ' . $time['end'];

            $calendarData[$timeText] = [];

            foreach ($weekDays as $index => $day) {
                $lesson = $lessons->where('day_of_week', $index)->where('start_time', $time['start'])->first();

                if ($lesson) {
                    array_push($calendarData[$timeText], [
                        'class_name'   => $lesson->course?->course_name,
                        'teacher_name' => $lesson->teacher?->full_name,
                        'room_no'      => $lesson->room?->room_no,
                        'rowspan'      => $lesson->difference / 60 ?? '',
                    ]);
                } else
                if (!$lessons->where('day_of_week', $index)->where('start_time', '<', $time['start'])->where('end_time', '>=', $time['end'])->count()) {
                    array_push($calendarData[$timeText], 1);
                } else {
                    array_push($calendarData[$timeText], 0);
                }

            }

        }

        return $calendarData;
    }

}