<?php

namespace App\Repositories;

use App\Models\VesselOpex;
use App\Models\Vessel;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;
use Carbon\Carbon;

class R_VesselOpex
{

    protected $model;

    /**
     * R_Voyage constructor.
     */

    public function __construct(VesselOpex $model)//
    {
        $this->model = $model;
    }

    public function create($id,array $data)
    {

        //σε περιπτωση που υπαρχει starting date
        if( empty($data['vessel_opex_date']))
            throw new InvalidArgumentException("Empty Date provided!");

        //σε περιπτωση που υπαρχει vessel
        if(empty($id))
            throw new InvalidArgumentException("No Vessel provided!");

        //σε περιπτωση που υπαρχει expenses
        if(empty($data['vessel_opex_expenses']))
            throw new InvalidArgumentException("No Expenses provided!");


        //ελεγχος για ongoing voyage
        $vessel = Vessel::find($id);
        if (empty($vessel))
            throw new ModelNotFoundException("The Vessel provided does not exist! ID:" . $id);

        //date format για βαση
        $data['vessel_opex_date']=Carbon::parse($data['vessel_opex_date'])->format('Y-m-d H:i:s');

        $vessel_opexes=$vessel->opexes()->get();

        foreach($vessel_opexes as $opex){
            if(Carbon::parse($opex->vessel_opex_date)->equalTo(Carbon::parse($data['vessel_opex_date']))){
                throw new InvalidArgumentException("The Vessel Has Already Opex for the given Date!");
            }
        }
        $data['vessel_opex_vessel_id']=$id;
        $rec = $this->model->newInstance($data);

        if($rec->save())
            return 'Record Created! ID: '.$rec->vessel_opex_id;

        return 'Could not Insert Record';
    }

}
