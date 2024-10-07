<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Modules\HumanResource\Entities\Attendance;
use Modules\HumanResource\Entities\AttnCheckinCheckout;
use Modules\HumanResource\Entities\AttnUserInfo;
use Modules\HumanResource\Entities\Employee;
use Modules\Setting\Entities\Zkt;
use Rats\Zkteco\Lib\ZKTeco;

class ImportAttnData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:attendance-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $credZkt = Zkt::where('status', 1)->get();
        if ($credZkt->count() > 0) {
            foreach ($credZkt as $key => $zkt) {
                $zk = new ZKTeco($zkt->ip_address); //'203.202.247.206'
                $zk_connect = $zk->connect();

                dd('yre');
                dd(Log::info('Attendance data imported failed'));

                if ($zk_connect) {
                    Log::info('Device Connected');

                    $users = $zk->getUser();
                    foreach ($users as $key => $user) {
                        AttnUserInfo::updateOrCreate([
                            'uid' => $user['uid'],
                            'user_id' => $user['user_id'],
                        ], $user);
                    }

                    $attendances = $zk->getAttendance();
                    foreach ($attendances as $key => $attn) {
                        $attn_checkin_checkout = new AttnCheckinCheckout();
                        $attn_checkin_checkout->uid = $attn['uid'];
                        $attn_checkin_checkout->user_id = $attn['id'];
                        $attn_checkin_checkout->state = $attn['state'];
                        $attn_checkin_checkout->timestamp = $attn['timestamp'];
                        $attn_checkin_checkout->type = $attn['type'];
                        $attn_checkin_checkout->save();

                        $employee_device_id = $attn_checkin_checkout->attn_user?->user_id;
                        $employee = Employee::where('employee_device_id', $employee_device_id)->first();
                        if ($employee) {
                            $emp_attn = new Attendance();
                            $emp_attn->employee_id = $employee->id;
                            $emp_attn->time = $attn['timestamp'];
                            $emp_attn->machine_id = $zkt->employee_device_id;
                            $emp_attn->machine_state = $attn['state'];
                            $emp_attn->save();
                        }
                    }

                    // clear the device attendance
                    $zk->clearAttendance();
                    Log::info('Device Connected & Attendance data imported successfully');

                    return $this->info('Attendance data imported successfully');
                } else {
                    return $this->error('Zkt Device Not Connected');
                }
            }
        } else {
            Log::info('Please Setup the device IP first');

            return $this->error('Please Setup the device IP first');
        }
    }
}
