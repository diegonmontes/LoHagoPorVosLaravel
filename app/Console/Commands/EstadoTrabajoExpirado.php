<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Trabajo;


class EstadoTrabajoExpirado extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'actualizarestadotrabajo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza el estado a 2 cuando expira el anuncio';

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
        $trabajo = new Trabajo;
        $trabajo->whereRaw('tiempoExpiracion < NOW()')
                ->where('eliminado','=',0)
                ->update(['idEstado'=>2]);
        
    }
}
