<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportarSqlEstructuraEtapaDos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:EstructuraEtapaDos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importando el archivo sql con la estructura correspondiente a la etapa 2';

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
        DB::unprepared(file_get_contents('database/sql/modeloDatos.sql'));
          
        Log::info('SQL Import Done');
    }
}
