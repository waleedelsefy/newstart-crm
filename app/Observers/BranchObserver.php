<?php

namespace App\Observers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BranchObserver
{
    /**
     * Handle the Branch "saving" event.
     */
    public function saving(Branch $branch): void
    {
        $branch->slug = Str::slug($branch->getTranslation('name', 'en'));
        // $branch->slug = Str::slug(request()->name_en);
    }

    /**
     * Handle the Branch "created" event.
     */
    public function created(Branch $branch): void
    {
    }

    /**
     * Handle the Branch "updated" event.
     */
    public function updated(Branch $branch): void
    {
        //
    }

    /**
     * Handle the Branch "deleted" event.
     */
    public function deleted(Branch $branch): void
    {
        //
    }

    /**
     * Handle the Branch "restored" event.
     */
    public function restored(Branch $branch): void
    {
        //
    }

    /**
     * Handle the Branch "force deleted" event.
     */
    public function forceDeleted(Branch $branch): void
    {
        //
    }
}
