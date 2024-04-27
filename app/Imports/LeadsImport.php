<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\Interest;
use App\Models\Lead;
use App\Models\PhoneNumber;
use App\Models\Project;
use App\Models\Source;
use App\Models\User;
use App\Notifications\GeneralNotification;
use App\Notifications\ImportStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\ImportFailed;

class LeadsImport implements ToCollection, WithHeadingRow, WithValidation, WithChunkReading, ShouldQueue, WithEvents
{
    public function __construct(public User $importedBy)
    {
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $branch_id = Branch::where('name->en', trim($row['branch']))
                ->orWhere('name->ar', trim($row['branch']))->pluck('id')[0] ?? 1;

            $lead = Lead::create([
                'name' => $row['name'],
                'notes' => $row['notes'],
                'branch_id' => $branch_id,
            ]);

            $phones = explode(' | ', $row['phones']);

            if (count($phones) > 0) {
                foreach ($phones as $index => $phone) {
                    PhoneNumber::create([
                        'callable_type' => 'App\Models\Lead',
                        'callable_id' => $lead->id,
                        'number' => $phone,
                    ]);
                }
            }

            $interestsNames = explode(' | ', $row['interests']);
            $interests_ids = Interest::whereIn('name->en', $interestsNames)
                ->orWhereIn('name->ar', $interestsNames)->pluck('id')->toArray();

            $sourcesNames = explode(' | ', $row['sources']);
            $sources_ids = Source::whereIn('name->en', $sourcesNames)
                ->orWhereIn('name->ar', $sourcesNames)->pluck('id')->toArray();

            $projectsNames = explode(' | ', $row['projects']);
            $projects_ids = Project::whereIn('name->en', $projectsNames)
                ->orWhereIn('name->ar', $projectsNames)->pluck('id')->toArray();

            $lead->interests()->attach($interests_ids);
            $lead->sources()->attach($sources_ids);
            $lead->projects()->attach($projects_ids);
        }
    }


    public function rules(): array
    {
        return [
            'name' => ['required']
        ];
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function registerEvents(): array
    {
        $options = [
            'title' => [
                'en' => 'Importing fail',
                'ar' => 'فشلت عملية الاستراد',
            ],
            'description' => [
                'en' => [
                    'Please try again',
                ],
                'ar' => [
                    'يرجى اعادة المحاول مرة اخرى'
                ]
            ],
            'icon' => 'feather icon-upload-cloud',
            'url' => route('leads.index'),
            'color' => 'danger',
        ];

        return [
            ImportFailed::class => function (ImportFailed $event) use ($options) {
                $this->importedBy->notify(new GeneralNotification($options));
            },
        ];
    }
}
