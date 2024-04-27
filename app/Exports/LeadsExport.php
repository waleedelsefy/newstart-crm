<?php

namespace App\Exports;

use App\Models\Lead;
use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Throwable;
use App\Notifications\GeneralNotification;
use Maatwebsite\Excel\Concerns\FromCollection;

class LeadsExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    use Exportable;

    public function __construct(public User $exportedBy)
    {
    }

    public function collection()
    {
        $leadsIds = [];
        if (request()->leads_ids) {
            $leadsIds = explode(',', request()->leads_ids);
        }

        return Lead::permissionsFilter()->where(function ($query) use ($leadsIds) {

            if (count($leadsIds) > 0) {
                $query->whereIn('id', $leadsIds);
            }
        })->filter(request()->query())->with(['branch', 'phones', 'sources', 'interests', 'projects', 'createdBy', 'assignedBy'])->get();
    }

    // public function query()
    // {
    //     // dd(request()->query());
    //     return Lead::where('name', 'LIKE', "%" . request()->get('search') . "%");
    //     // return Lead::filter(request()->query())->with(['branch', 'phones', 'sources', 'interests', 'projects', 'createdBy', 'assignedBy']);
    // }

    public function headings(): array
    {
        return [
            '#',
            __('Name'),
            __('Notes'),
            __('Branch'),
            __('Phones'),
            __('Sources'),
            __('Interests'),
            __('Projects'),
            __('Duplicates'),
            __('Last Event'),
            __('Event Notes'),
            __('Assigned By'),
            __('Assigned To'),
            __('Created By'),
            __('Created At'),
        ];
    }

    public function map($lead): array
    {
        $phones = implode(' | ', $lead->phones->pluck('number')->toArray());
        $sources = implode(' | ', $lead->sources->pluck('name')->toArray());
        $interests = implode(' | ', $lead->interests->pluck('name')->toArray());
        $projects = implode(' | ', $lead->projects->pluck('name')->toArray());

        return [
            $lead->id,
            $lead->name,
            $lead->notes,
            $lead->branch->name,
            $phones,
            $sources,
            $interests,
            $projects,
            $lead->duplicates(),
            $lead->lastEvent()->event->name,
            $lead->lastEvent()->notes,
            $lead->assignedBy ? $lead->assignedBy->username : __('No One'),
            $lead->assignedTo ? $lead->assignedTo->username : __('No One'),
            $lead->createdBy ? $lead->createdBy->username : __('No One'),
            $lead->created_at,
        ];
    }

    public function columnFormats(): array
    {
        return [
            // E is the __('Phones')
            'E' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function failed(Throwable $exception): void
    {
        $options = [
            'title' => [
                'en' => 'Exporting fail',
                'ar' => 'فشلت عملية التصدير',
            ],
            'description' => [
                'en' => [
                    'Please try again',
                ],
                'ar' => [
                    'يرجى اعادة المحاول مرة اخرى'
                ]
            ],
            'icon' => 'feather icon-download-cloud',
            'url' => route('leads.index'),
            'color' => 'danger',
        ];

        $this->exportedBy->notify(new GeneralNotification($options));
    }
}
