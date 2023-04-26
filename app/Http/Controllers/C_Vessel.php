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

    public function get_vessel_report($id)
    {
        return $this->vessel->get_vessel_report($id);
    }


}
