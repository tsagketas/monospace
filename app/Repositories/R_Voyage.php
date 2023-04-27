<?php

namespace App\Repositories;

use App\Models\Voyage;
use App\Models\Vessel;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LogicException;
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
        //σε περιπτωση που υπαρχει starting date
        if( empty($data['voyage_start']))
            throw new InvalidArgumentException("Empty Start Date provided!");

        //σε περιπτωση που υπαρχει vessel
        if(empty($data['voyage_vessel_id']))
            throw new InvalidArgumentException("No Vessel provided!");

        //σε περιπτωση που παει να μπει λαθος ημερομηνια
        if(!empty($data['voyage_end']) && Carbon::parse($data['voyage_start'])->greaterThan(Carbon::parse($data['voyage_end'])) ){
            throw new InvalidArgumentException("Wrong Date Values provided!");
        }

        //ελεγχος για ongoing voyage
        $vessel = Vessel::find($data['voyage_vessel_id']);
        if (empty($vessel))
            throw new ModelNotFoundException("The Vessel provided does not exist! ID:" . $data['voyage_vessel_id']);

        if($vessel->onGoingVoyage()->count()>0){
            throw new InvalidArgumentException("The Vessel Already Has a Voyage on going!");
        }

        //εισαγωγη status
        $data['voyage_status']='pending';
        //date format για βαση
        $data['voyage_start']=Carbon::parse($data['voyage_start'])->format('Y-m-d H:i:s');
        if(isset($data['voyage_end'])){ $data['voyage_end']=Carbon::parse($data['voyage_end'])->format('Y-m-d H:i:s');}
        //υπολογισμος code
        $data['voyage_code']=$vessel->vessel_name.'-'.$data['voyage_start'];

        $rec = $this->model->newInstance($data);

        if($rec->save())
            return 'Record Created! ID: '.$rec->voyage_id;

        return 'Could not Insert Record';
    }

    public function update($id,array $data)
    {
        //σε περιπτωση που δεν υπαρχει
        $rec=Voyage::find($id);
        if (empty($rec))
            throw new ModelNotFoundException("The Voyage provided does not exist! ID:" . $id);

        //σε περιπτωση που ειναι submitted
        if($rec->voyage_status=='submitted'){
            throw new LogicException("The Voyage provided is submitted, cannot be edited");
        }

        $voyage_start = isset($data['voyage_start']) ? $data['voyage_start'] : $rec->voyage_start;
        $voyage_end = isset($data['voyage_end']) ? $data['voyage_end'] : $rec->voyage_end;
        $voyage_vessel_id = isset($data['voyage_vessel_id']) ? $data['voyage_vessel_id'] : $rec->voyage_vessel_id;
        $voyage_status = isset($data['voyage_status']) ? $data['voyage_status'] : $rec->voyage_status;
        $voyage_revenues = isset($data['voyage_revenues']) ? $data['voyage_revenues'] : $rec->voyage_revenues;
        $voyage_expenses = isset($data['voyage_expenses']) ? $data['voyage_expenses'] : $rec->voyage_expenses;
        $voyage_profit=null;

        //date format για βαση
        $voyage_start=Carbon::parse($voyage_start)->format('Y-m-d H:i:s');
        $voyage_end=Carbon::parse($voyage_end)->format('Y-m-d H:i:s');

        //σε περιπτωση που παει να μπει λαθος ημερομηνια
        if(Carbon::parse($voyage_start)->greaterThan($voyage_end) ){
            throw new InvalidArgumentException("Wrong Date Values provided!");
        }

        //ελεγχος για ongoing voyage
        $vessel = Vessel::find($voyage_vessel_id);
        if($voyage_status=='ongoing'){
            if (empty($vessel))
                throw new ModelNotFoundException("The Vessel provided does not exist! ID:" . $voyage_vessel_id);

            $ongoing_voyage=$vessel->onGoingVoyage()->first();
            if($ongoing_voyage){
                if($ongoing_voyage->voyage_id!=$id) {
                    throw new InvalidArgumentException("The Vessel Already Has a Voyage on going!");
                }
            }
        }
        //σε περιπτωση που παει να να το κανει submit
        else if($voyage_status=='submitted'){
            if($voyage_start && $voyage_end && $voyage_revenues && $voyage_expenses ){

                $voyage_profit=$voyage_revenues-$voyage_expenses;
                $voyage_status='submitted';
            }else{
                throw new InvalidArgumentException("Additional Information Needed! Cannot Be Submitted!");
            }
        }

        //υπολογισμος code σε περιπτωση που αλλαξε το vessel ή το voyage_start
        $voyage_code=$vessel->vessel_name.'-'.$voyage_start;

        if($rec->update([
            'voyage_vessel_id' => $voyage_vessel_id,
            'voyage_start' => $voyage_start,
            'voyage_end' =>  $voyage_end,
            'voyage_revenues' => $voyage_revenues,
            'voyage_expenses' => $voyage_expenses,
            'voyage_status' => $voyage_status,
            'voyage_profit' => $voyage_profit,
            'voyage_code' => $voyage_code
        ]))
            return 'Record Updated! ID: '.$rec->voyage_id;

        return 'Could not Update Record';
    }
}
