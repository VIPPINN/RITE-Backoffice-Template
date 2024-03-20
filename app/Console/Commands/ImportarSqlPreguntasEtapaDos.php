<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportarSqlPreguntasEtapaDos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:PreguntasEtapaDos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Se importan las preguntas que van se incluyen en el formulario de la Etapa 2';

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
      DB::unprepared(file_get_contents('database/sql/preguntasSistema.sql'));
          
      Log::info('La Importanción fue exitosa.');
    }
}
