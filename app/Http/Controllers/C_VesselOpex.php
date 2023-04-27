<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\R_VesselOpex;
class C_VesselOpex extends Controller
{

    protected $vesselOpex;


    /**
     * C_Voyage constructor.
     */
    public function __construct(R_VesselOpex $vesselOpex)//
    {
        $this->vesselOpex = $vesselOpex;
    }

    public function create($id,Request $request)
    {
        $params = $request->all();

        $validatedData = $this->validate_params($params,
            [
                'vessel_opex_date' => 'required|date',
                'vessel_opex_expenses' =>  'required|numeric',
            ],
            [
                'vessel_opex_date' => 'vessel_opex_date',
                'vessel_opex_expenses' =>  'vessel_opex_expenses',
            ]
        );

        return $this->vesselOpex->create($id,$params);
    }


}
