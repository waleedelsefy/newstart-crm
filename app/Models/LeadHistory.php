<?php

namespace App\Models;

use App\Traits\Dashboard;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class LeadHistory extends Model
{
    use HasFactory, HasTranslations, Dashboard;

    protected $fillable = [
        'type', 'branch_id', 'user_id', 'lead_id', 'event_id',
        'event_name', 'assigned_by', 'assigned_to', 'assigned_at',
        'previous_event', 'reminder', 'reminder_date', 'notes', 'info'
    ];

    public $translatable = ['info'];


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('per_branch', function (Builder $builder) {
            // $builder->where('branch_id', auth()->user()->branch_id);
        });

        static::created(function (LeadHistory $leadHistory) {

            // Save some data about this lead in history table

            $lead = $leadHistory->lead;

            $leadHistory->branch_id = $lead->branch_id;
            $leadHistory->created_by = $lead->created_by;
            $leadHistory->assigned_by = $lead->assigned_by;
            $leadHistory->assigned_to = $lead->assigned_to;
            $leadHistory->assigned_at = $lead->assigned_at;
            $leadHistory->event_name = $leadHistory->event->name ?? 'fresh';

            if ($leadHistory->type == 'event') {

                // Save also some data about reminder of event if there's a reminder date on this event

                if ($leadHistory->reminder_date) {

                    $reminderDate = Carbon::parse($leadHistory->reminder_date)->format('Y-m-d');
                    $reminderTime = Carbon::parse($leadHistory->reminder_date)->format('H:i:s');
                    $reminderDateTime = Carbon::parse($leadHistory->reminder_date);

                    $timeNow = Carbon::now()->format("H:i:s");
                    $todayDate = Carbon::now()->format("Y-m-d");

                    $reminder_name = 'delay';

                    if ($reminderDate == $todayDate && $reminderTime > $timeNow)
                        $reminder_name = 'today';

                    if ($reminderDate > $todayDate)
                        $reminder_name = 'upcoming';

                    // if ($reminderDateTime->diffInHours(Carbon::now()) > 23)
                    //     $reminder_name = 'delay';

                    $leadHistory->reminder = $reminder_name;
                    $leadHistory->lead->reminder = $reminder_name;
                    $leadHistory->lead->saveQuietly();
                } else {

                    $leadHistory->lead->reminder =  NULL;
                    $leadHistory->lead->saveQuietly();
                }
            }

            $leadHistory->save();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function previousEvent()
    {
        return $this->belongsTo(Event::class, 'previous_event', 'id');
    }

    public function createdAt()
    {
        return $this->created_at?->diffForHumans() ?? __('Unknown');
    }

    public function scopeTypeEvent(Builder $builder)
    {
        $builder->where('type', 'event');
    }

    public function scopeFreshLead(Builder $builder)
    {
        $builder->typeEvent()->whereHas('event', fn ($q) => $q->where('name', 'fresh'));
    }

    public function scopeNoAction(Builder $builder)
    {
        $builder->typeEvent()->whereHas('event', fn ($q) => $q->where('name', 'no-action'));
    }
}
