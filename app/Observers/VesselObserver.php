<?php

namespace App\Observers;

use App\Models\Vessel;
use App\Models\Voyage;

class VesselObserver
{
    /**
     * Handle the Vessel "updating" event.
     *
     */
    public function updating(Vessel $vessel)
    {
        if ($vessel->isDirty('vessel_name')) {

            $voyages=Voyage::where('voyage_vessel_id',$vessel->vessel_id)->get();
            foreach ($voyages as $voyage) {
                $voyage->voyage_code = $vessel->vessel_name.'-'.$voyage->voyage_start; // Replace with the desired new voyage code
                $voyage->save();
            }
        }
    }


    /**
     * Handle the Vessel "created" event.
     *
     * @param  \App\Models\Vessel  $vessel
     * @return void
     */
    public function created(Vessel $vessel)
    {
        //
    }

    /**
     * Handle the Vessel "updated" event.
     *
     * @param  \App\Models\Vessel  $vessel
     * @return void
     */
    public function updated(Vessel $vessel)
    {
        //
    }

    /**
     * Handle the Vessel "deleted" event.
     *
     * @param  \App\Models\Vessel  $vessel
     * @return void
     */
    public function deleted(Vessel $vessel)
    {
        //
    }

    /**
     * Handle the Vessel "restored" event.
     *
     * @param  \App\Models\Vessel  $vessel
     * @return void
     */
    public function restored(Vessel $vessel)
    {
        //
    }

    /**
     * Handle the Vessel "force deleted" event.
     *
     * @param  \App\Models\Vessel  $vessel
     * @return void
     */
    public function forceDeleted(Vessel $vessel)
    {
        //
    }
}
