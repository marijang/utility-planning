<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ExcelWorker;

class GenerateXls extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    protected $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    //public function __construct(User $user)
    public function __construct()
    {
        //
        //$this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ExcelWorker $worker)
    {
         $worker->demo();
         if ($this->attempts() > 3) {
            $this->release(10);
         }
    }
}
