<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ExcelWorker;

class ProccessExcel extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    public $worker;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ExcelWorker $worker)
    {
        $this->worker = $worker;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ExcelWorker $worker)
    {
        $this->worker->proccess();
    }
}
