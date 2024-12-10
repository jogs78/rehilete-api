<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'usuario_id', 'paquete_id', 'paquete_precio', 'precio',
        'fecha', 'hora_inicio', 'hora_fin', 'descripcion', 'gerente_id',
        'num_personas', 'confirmacion', 'realizado', 'razon',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function paquete()
    {
        return $this->belongsTo(Paquete::class);
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class);
    }

    public function fotos()
    {
        return $this->hasMany(Foto::class);
    }

    public function gastos()
    {
        return $this->hasMany(Gasto::class);
    }

    public function totalgastos()
    {
        return $this->gastos()->sum('cantidad');
    }

    public function abonos()
    {
        return $this->hasMany(Abono::class);
    }

    public function totalAbonos(): float
    {
        return $this->abonos()->sum('cantidad');
    }

    public function dueño()
    {
        return $this->hasOne(Usuario::class, 'id', 'usuario_id');
    }

    public function gerente()
    {
        return $this->hasOne(Usuario::class, 'id', 'gerente_id')
//        ->withDefault();
            ->withDefault(['nombre' => 'Sin gerente que haya revisado']);

    }

    public function enRangoHorario()
    {
        // Obtener el inicio del día de la fecha del evento
        $inicioDiaEvento = Carbon::parse($this->fecha)->startOfDay();

        // Calcular el inicio y fin del rango
        $horaInicio = Carbon::parse($this->fecha . ' ' . $this->hora_inicio);
        $horaFin = Carbon::parse($this->fecha . ' ' . $this->hora_fin)->addHours(4);

        // Si la hora fin es menor que la hora inicio, significa que el evento cruza a la madrugada
        if ($horaFin->lessThan($horaInicio)) {
            $horaFin->addDay(); // Avanzamos un día si el evento cruza a la madrugada
        }

        // Verificar si el momento actual está en el rango
        $ahora = Carbon::now();
        return $ahora->between($inicioDiaEvento, $horaFin);
    }

}
