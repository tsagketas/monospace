<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\R_Voyage;
class C_Voyage extends Controller
{

    protected $voyage;


    /**
     * C_Voyage constructor.
     */
    public function __construct(R_Voyage $voyage)//
    {
        $this->voyage = $voyage;
    }

    public function create(Request $request)
    {
        $params = $request->all();

        $validatedData = $this->validate_params($params,
            [
                'voyage_vessel_id' => 'required|integer',
                'voyage_start' => 'required|date',
                'voyage_end' =>  'nullable|date|after_or_equal:voyage_start',
                'voyage_revenues' => 'nullable|numeric',
                'voyage_expenses' => 'nullable|numeric',
            ],
            [
                'voyage_vessel_id' => 'voyage_vessel_id',
                'voyage_start' => 'voyage_start',
                'voyage_end' =>  'voyage_end',
                'voyage_revenues' => 'voyage_revenues',
                'voyage_expenses' => 'voyage_expenses',
            ]
        );

        return $this->voyage->create($params);    }

    public function update($id,Request $request)
    {
        $params = $request->all();

        $validatedData = $this->validate_params($params,
            [
                'voyage_vessel_id' => 'nullable|integer',
                'voyage_start' => 'nullable|date',
                'voyage_end' =>  'nullable|date|after_or_equal:voyage_start',
                'voyage_revenues' => 'nullable|numeric',
                'voyage_expenses' => 'nullable|numeric',
                'voyage_status' => 'nullable|string',
            ],
            [
                'voyage_vessel_id' => 'voyage_vessel_id',
                'voyage_start' => 'voyage_start',
                'voyage_end' => 'voyage_end',
                'voyage_revenues' => 'voyage_revenues',
                'voyage_expenses' => 'voyage_expenses',
                'voyage_status' => 'voyage_status',
            ]
        );

        return $this->voyage->update($id,$params);
    }

}
