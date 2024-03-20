<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportarSqlInicio extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:EtapaInicial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importando el archivo sql con la estructura correspondiente a la etapa inicial';

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
      DB::unprepared(file_get_contents('database/sql/modeloDatosEtapaInicial.sql'));
          
      Log::info('SQL Import Done');
    }
}
