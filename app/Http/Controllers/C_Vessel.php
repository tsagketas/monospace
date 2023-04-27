<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\R_Vessel;
class C_Vessel extends Controller
{

    protected $vessel;


    /**
     * C_Voyage constructor.
     */
    public function __construct(R_Vessel $vessel)//
    {
        $this->vessel = $vessel;
    }

    public function create(Request $request)
    {
        $params = $request->all();

        $validatedData = $this->validate_params($params,
            [
                'vessel_name' => 'required|string',
                'vessel_imo_number' => 'required|string',
            ],
            [
                'vessel_name' => 'vessel_name',
                'vessel_imo_number' => 'vessel_imo_number',
            ]
        );

        return $this->vessel->create($params);
    }

    public function update($id,Request $request)
    {

        $params = $request->all();

        return $this->vessel->update($id,$params);
    }

    public function get_vessel_report($id)
    {
        return $this->vessel->get_vessel_report($id);
    }


}
