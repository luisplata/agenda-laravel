<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProfileVisit extends Model
{
    use HasFactory;

    protected $fillable = ['profile_id', 'visited_at'];

    public $timestamps = true;

    /**
     * Relación con el usuario (perfil visitado)
     */
    public function profile()
    {
        return $this->belongsTo(User::class, 'profile_id');
    }

    /**
     * Obtener visitas en un rango de tiempo específico
     */
    public static function getVisitsByRange($interval, $profileId = null)
    {
        $dateFormat = $interval === '3 MONTH' ? "%Y-%m" : "%Y-%m-%d";

        $query = DB::table('profile_visits')
            ->select(
                DB::raw("DATE_FORMAT(visited_at, '$dateFormat') as date"),
                DB::raw('COUNT(*) as total_visits')
            )
            ->where('visited_at', '>=', DB::raw("NOW() - INTERVAL $interval"))
            ->groupBy(DB::raw("DATE_FORMAT(visited_at, '$dateFormat')")) // ✅ Se agrupa correctamente
            ->orderBy('date', 'ASC');

        if ($profileId) {
            $query->where('profile_id', $profileId);
        }

        return $query->get();
    }


}
