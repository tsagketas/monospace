<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vessel extends Model
{
    use HasFactory;
    protected $fillable = [
        'vessel_id',
        'vessel_name',
        'vessel_imo_number',
    ];

    protected $table = 'vessels';
    protected $primaryKey = 'vessel_id';

    public function pendingOrSubmittedVoyages()
    {
        return $this->hasMany(Voyage::class, 'voyage_vessel_id')->whereIn('voyage_status', ['pending', 'submitted']);
    }

    public function opexes()
    {
        return $this->hasMany(VesselOpex::class, 'vessel_opex_vessel_id','vessel_id');
    }

    public function onGoingVoyage()
    {
        return $this->hasOne(Voyage::class, 'voyage_vessel_id')->where('voyage_status', 'ongoing');
    }


    public function voyages()
    {
        return $this->hasMany(Voyage::class, 'voyage_vessel_id','vessel_id');
    }
}
