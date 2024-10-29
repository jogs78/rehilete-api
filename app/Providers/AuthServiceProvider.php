<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Abono;
use App\Models\Evento;
use App\Models\Gasto;
use App\Models\Medio;
use App\Models\Paquete;
use App\Models\Servicio;
use App\Models\Usuario;
use App\Policies\AbonoPolicy;
use App\Policies\EventoPolicy;
use App\Policies\GastoPolicy;
use App\Policies\MedioPolicy;
use App\Policies\PaquetePolicy;
use App\Policies\ServicioPolicy;
use App\Policies\UsuarioPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Evento::class => EventoPolicy::class,
        Servicio::class => ServicioPolicy::class,
        Paquete::class => PaquetePolicy::class,
        Medio::class => MedioPolicy::class,
        Usuario::class => UsuarioPolicy::class,
        Abono::class => AbonoPolicy::class,
        Gasto::class => GastoPolicy::class,
        //falta como son las politicas de abonos y de usuarios, gastos
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
