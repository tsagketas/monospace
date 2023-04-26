<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voyage extends Model
{
    use HasFactory;
    protected $fillable = [
        'voyage_id',
        'voyage_vessel_id',
        'voyage_code',
        'voyage_start',
        'voyage_end',
        'voyage_status',
        'voyage_revenues',
        'voyage_expenses',
        'voyage_profit',
    ];

    protected $table = 'voyages';
    protected $primaryKey = 'voyage_id';

    public function vessel()
    {
        return $this->hasOne(Vessel::class, 'vessel_id', 'voyage_vessel_id');
    }

}
