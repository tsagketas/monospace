<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VesselOpex extends Model
{
    use HasFactory;
    protected $fillable = [
        'vessel_opex_id',
        'vessel_opex_vessel_id',
        'vessel_opex_date',
        'vessel_opex_expenses',
    ];

    protected $table = 'vessel_opexes';
    protected $primaryKey = 'vessel_opex_id';

    public function vessel()
    {
        return $this->hasOne(Vessel::class, 'vessel_id', 'vessel_opex_vessel_id');
    }
}
