<?php

namespace App\Observers;

use App\Models\Voyage;

class VoyageObserver
{
    /**
     * Handle the Vessel "updating" event.
     *
     */
    public function updating(Voyage $voyage)
    {
//        if ($voyage->isDirty('voyage_start')) {
//            $vessel_name=explode('-',$voyage->voyage_code)[0];
//            $voyage->voyage_code = $vessel_name.'-'.$voyage->voyage_start;
//            $voyage->save();
//        }
    }
    /**
     * Handle the Voyage "created" event.
     *
     * @param  \App\Models\Voyage  $voyage
     * @return void
     */
    public function created(Voyage $voyage)
    {
        //
    }

    /**
     * Handle the Voyage "updated" event.
     *
     * @param  \App\Models\Voyage  $voyage
     * @return void
     */
    public function updated(Voyage $voyage)
    {
        if ($voyage->isDirty('voyage_start')) {
            $vessel_name=explode('-',$voyage->voyage_code)[0];
            $voyage->voyage_code = $vessel_name.'-'.$voyage->voyage_start;
            $voyage->save();
        }
    }

    /**
     * Handle the Voyage "deleted" event.
     *
     * @param  \App\Models\Voyage  $voyage
     * @return void
     */
    public function deleted(Voyage $voyage)
    {
        //
    }

    /**
     * Handle the Voyage "restored" event.
     *
     * @param  \App\Models\Voyage  $voyage
     * @return void
     */
    public function restored(Voyage $voyage)
    {
        //
    }

    /**
     * Handle the Voyage "force deleted" event.
     *
     * @param  \App\Models\Voyage  $voyage
     * @return void
     */
    public function forceDeleted(Voyage $voyage)
    {
        //
    }
}
