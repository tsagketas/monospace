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
                'voyage_revenues' => 'float',
                'voyage_expenses' => 'float',
            ],
            [
                'voyage_vessel_id' => 'voyage_vessel_id',
                'voyage_start' => 'voyage_start',
            ]
        );

        $this->voyage->create($params);

        return $this->send_response($this->create_response(true,'Sums calculated',null));
    }

}
