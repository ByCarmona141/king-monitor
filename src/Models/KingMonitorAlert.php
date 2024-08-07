<?php

namespace ByCarmona141\KingMonitor\Models;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KingMonitorAlert extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'king_user_id',
        'token',
        'ip',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'king_user_id' => 'integer',
    ];

    // Obtenemos la ultima alerta del dia del usuario
    public function lastAlertToday() {
        try {
            return kingMonitorAlert::whereDate('created_at', '=', date('Y-m-d'))->where('king_user_id', '=', auth()->user()->id)->latest()->first();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Alertas del día, si no se manda el dia se obtienen las alertas del día
//    public function kingDay(Request $request): KingMonitorAlertCollection {
//        $response = NULL;
//
//        if ($request->data['attributes']['day'] === NULL) {
//            $response = KingMonitorAlertCollection::make(KingMonitorAlert::whereDate('created_at', '=', today())->get());
//        } else {
//            $response = KingMonitorAlertCollection::make(KingMonitorAlert::whereDate('created_at', '=', $request->data['attributes']['day'])->get());
//        }
//
//        // Guardamos la accion en el monitor
//        $kingMonitor = new KingMonitor();
//        $kingMonitor->monitor($response);
//
//        return $response;
//    }

    // Alertas del día, si no se manda el dia se obtienen las alertas del día
    public function kingDayCount(Request $request) {
        // Generar un resource para guardar la respuesta y obtener el codigo de estado porque asi da error
        $response = NULL;

        if ($request->data['attributes']['day'] === NULL) {
            $response = response()->json(kingMonitorAlert::whereDate('created_at', '=', today())->count());
        } else {
            $response = response()->json(kingMonitorAlert::whereDate('created_at', '=', $request->data['attributes']['day'])->count());
        }

        // Guardamos la accion en el monitor
        //$kingMonitor = new KingMonitor();
        //$kingMonitor->monitor($response);

        return $response;
    }

    // Alertas del mes si no se manda el mes entonces se obtiene las del mes actual
    public function kingMonth(Request $request) {
        $response = NULL;

        if ($request->data['attributes']['month'] === NULL) {
            $response = KingMonitorAlertCollection::make(kingMonitorAlert::whereMonth('created_at', '=', now()->month)->get());
        } else {
            $response = KingMonitorAlertCollection::make(kingMonitorAlert::whereMonth('created_at', '=', $request->data['attributes']['month'])->get());
        }

        // Guardamos la accion en el monitor
        //$kingMonitor = new KingMonitor();
        //$kingMonitor->monitor($response);

        return $response;
    }

    // Alertas del mes de un año en especifico si no se manda el mes ni el año entonces se obtiene las del mes y año actual
    public function kingMonthYear(Request $request) {
        $response = NULL;

        // Si no se manda el año ni el mes se obtienen los datos del año y mes actuales
        if ($request->data['attributes']['month'] === NULL && $request->data['attributes']['year'] === NULL) {
            $response = KingMonitorAlertCollection::make(kingMonitorAlert::whereMonth('created_at', '=', now()->month)->whereYear('created_at', '=', now()->year)->get());
        } else if ($request->data['attributes']['year'] === NULL) { // Si no se manda el año entonces se obtiene del año actual
            $response = KingMonitorAlertCollection::make(kingMonitorAlert::whereMonth('created_at', '=', $request->data['attributes']['month'])->whereYear('created_at', '=', now()->year)->get());
        } else if ($request->data['attributes']['month'] === NULL) { // Si no se manda el mes entonces se obtiene del mes actual
            $response = KingMonitorAlertCollection::make(kingMonitorAlert::whereMonth('created_at', '=', now()->month)->whereYear('created_at', '=', $request->data['attributes']['year'])->get());
        } else { // Si se manda el año y el mes se obtienen los datos del año y mes solicitados
            $response = KingMonitorAlertCollection::make(kingMonitorAlert::whereMonth('created_at', '=', $request->data['attributes']['month'])->whereYear('created_at', '=', $request->data['attributes']['year'])->get());
        }

        // Guardamos la accion en el monitor
        //$kingMonitor = new KingMonitor();
        //$kingMonitor->monitor($response);

        return $response;
    }
}

