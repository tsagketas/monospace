<?php

namespace App\Repositories;

use App\Models\Vessel;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;
use Carbon\Carbon;

class R_Vessel
{

    protected $model;

    /**
     * R_Voyage constructor.
     */

    public function __construct(Vessel $model)//
    {
        $this->model = $model;
    }

    public function get_vessel_report($id)
    {
       $ret= DB::SELECT(DB::RAW("
            SELECT
                voyages.voyage_id AS voyage_id,
                voyages.voyage_start AS start,
                voyages.voyage_end AS end,
                voyages.voyage_revenues AS voyage_revenues,
                voyages.voyage_expenses AS voyage_expenses,
                voyages.voyage_profit AS voyage_profit,
                voyages.voyage_profit / EXTRACT(EPOCH FROM (voyages.voyage_end - voyages.voyage_start))::INTEGER AS voyage_profit_daily_average,
                SUM(vessel_opexes.vessel_opex_expenses) AS vessel_expenses_total,
                (voyages.voyage_profit - SUM(vessel_opexes.vessel_opex_expenses)) AS net_profit,
                (voyages.voyage_profit - SUM(vessel_opexes.vessel_opex_expenses)) / EXTRACT(EPOCH FROM (voyages.voyage_end - voyages.voyage_start))::INTEGER AS net_profit_daily_average
            FROM
                voyages
            LEFT JOIN
                vessels ON vessels.vessel_id = voyages.voyage_vessel_id
            LEFT JOIN
                vessel_opexes ON vessel_opexes.vessel_opex_vessel_id = voyages.voyage_vessel_id AND vessel_opexes.vessel_opex_date >= voyages.voyage_start AND vessel_opexes.vessel_opex_date <= voyages.voyage_end
            WHERE
                vessels.vessel_id = $id
            GROUP BY
                voyages.voyage_id
        "));

       return $ret;

    }

}
