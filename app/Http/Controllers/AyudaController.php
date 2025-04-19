<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class AyudaController extends Controller
{

    public function inicializar()
    {
        Artisan::call('db:wipe');
        Artisan::call('migrate',
            [
                '--seed' => true,
                '--force' => true,
            ]);

    }
}
