<?php

namespace App\Console\Commands;

use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Console\Command;

class LeadFromUpcomingToToday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:lead-from-upcoming-to-today';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $leadsWithEventReminderUpcoming = Lead::where('reminder', 'upcoming')->whereDate('reminder_date', Carbon::today());
        $leadsWithEventReminderUpcoming->update(['reminder' => 'today']);
    }
}
