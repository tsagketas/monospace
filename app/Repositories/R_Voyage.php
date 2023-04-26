<?php

namespace App\Repositories;

use App\Models\Voyage;
use App\Models\Vessel;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;
use Carbon\Carbon;

class R_Voyage
{

    protected $model;

    /**
     * R_Voyage constructor.
     */

    public function __construct(Voyage $model)//
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        if( empty($data['voyage_start']))
            throw new InvalidArgumentException("Empty Date provided!");

        if(empty($data['voyage_vessel_id']))
            throw new InvalidArgumentException("No Vessel provided!");

        if(!empty($data['voyage_end']) && Carbon::parse($data['voyage_start'])->greaterThan(Carbon::parse($data['voyage_end'])) ){
            throw new InvalidArgumentException("Wrong Date Values provided!");
        }

        $vessel = Vessel::find($data['voyage_vessel_id']);
        if (empty($vessel))
            throw new ModelNotFoundException("The Vessel provided does not exist! ID:" . $data['voyage_vessel_id']);

        if($vessel->voyages->count()>0){
            foreach($vessel->voyages as $voyage){
                if($voyage->voyage_status=='ongoing'){
                    throw new InvalidArgumentException("The Vessel Already Has a Voyage on going!");
                }
            }
        }

        $data['voyage_status']='pending';
        $data['voyage_code']=$vessel->vessel_name.'-'.$data['voyage_start'];


        $model = $this->model->newInstance($data);
        $model->save();
    }


}
