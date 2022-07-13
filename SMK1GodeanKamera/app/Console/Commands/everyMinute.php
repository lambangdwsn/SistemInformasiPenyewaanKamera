<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class everyMinute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:pesanan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command delete pesanan';

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
        DB::table('pesanan')->whereRaw('updated_at <= now() - interval 2 hour')->delete();
        echo 'operation success';
    }
}
