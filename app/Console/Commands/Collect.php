<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Facades\Collect as CollectService;

class Collect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'collect {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collect Data From eol.cn';

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
     * @return mixed
     */
    public function handle()
    {
        //
        echo 'start at:' . date('Y-m-d H:i:s');
        $method = $this->argument('name');
        try {
            $abc = CollectService::{$method}();
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
        echo 'completed at:' . date('Y-m-d H:i:s');
    }
}
