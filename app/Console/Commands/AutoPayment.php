<?php

namespace App\Console\Commands;

use App\dreams;
use Illuminate\Console\Command;

class AutoPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Payment of customers';

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
        $dream = new dreams();
        $dream->user_id = 'abcd';
        $dream->dream = 'bbcd';
        $dream->save();
        $this->info('Auto Payment Completed');
    }
}
