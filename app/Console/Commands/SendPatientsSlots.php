<?php

namespace App\Console\Commands;

use App\Models\Doctor;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use DateTime;

class SendPatientsSlots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:patients';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $doctors = Doctor::all();
        for($i=0;$i<6;$i++)
        {
            $day = 'next monday '.$i.' days';
            $dayOfWeek = new DateTime($day);
            foreach ($doctors as $doctor) {
                $end = strtotime($doctor->end);
                $time =strtotime($doctor->begin);
                $endSlots = strtotime('+30 minutes', $time);
                while ($endSlots <= $end)
                {
                    DB::table('slots')->insert(['doctor_id' => $doctor->id,
                        'slot_time' => date('H:i:s',$time),
                        'slot_date' => date('Y-m-d',strtotime($dayOfWeek->format('Y-m-d')))]);
                    $time = $endSlots;
                    $endSlots = strtotime('+30 minutes', $time);
                }
            }
        }
        $this->info('The command was successful!');
    }
}
