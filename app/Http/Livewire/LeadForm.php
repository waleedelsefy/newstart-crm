<?php

namespace App\Http\Livewire;

use App\Helpers\Helper;
use App\Models\Country;
use App\Models\Developer;
use App\Models\Interest;
use App\Models\Lead;
use App\Models\PhoneNumber;
use App\Models\Project;
use App\Models\Source;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Throwable;
use Illuminate\Support\Str;

class LeadForm extends Component
{
    public $lead = null;
    public $name;
    public $notes;
    public array $interestsIds = [];
    public array $sourcesIds = [];

    public $countriesOptions = [];

    // Phones

    public int $phonesLimit = 3;
    public int $phonesCount = 1;
    public array $phones = [];

    // Projects

    public $projects = [];
    public $developerWithProjects = [];
    public $projectsOptions = [];
    public $developer_id = '';
    public $projects_ids = [];


    // Other properties

    protected $rules = [
        'name' => ['required', 'string', 'min:2'],
        'notes' => ['required', 'min:2'],
        'interestsIds' => ['required'],
        'sourcesIds' => ['required'],
        'projects' => ['required'],
        'phones' => ['required'],
        'phones.*.code' => ['required'],
        // 'phones.*.number' => ['min:10'],
    ];

    protected $messages = [];

    protected $listeners = [
        'changeProjectsPerDeveloper' => 'changeProjectsPerDeveloper',
        'projectsUpdated' => 'addProjects'
    ];

    public function mount()
    {
        $this->countriesOptions = Country::all();

        if ($this->lead) {
            $this->name = $this->lead->name;
            $this->notes = strip_tags($this->lead->notes);
            $this->interestsIds = $this->lead->interests->pluck('id')->toArray();
            $this->sourcesIds = $this->lead->sources->pluck('id')->toArray();
            $this->projects = $this->lead->projects;

            $this->phonesCount = $this->lead->phones()->count();

            foreach ($this->lead->phones as $phone) {
                $this->phones[] = [
                    'code' => $phone->country_code,
                    'number' => $phone->number
                ];
            }
        }
    }

    // Render

    public function render()
    {
        return view('livewire.lead-form', [
            'interests' =>  Interest::all(),
            'sources' =>  Source::all(),
            'developersOptions' => Developer::all(),
        ]);
    }

    // Other logic

    public function hydrate()
    {
        $this->emit('select2Hydrate');
        $this->dispatchBrowserEvent('render-select2');
    }

    // Save Logic

    public function store()
    {
        $lead = Lead::create([
            'name' => $this->name,
            'notes' => Helper::linkify($this->notes)
        ]);

        $lead->interests()->attach($this->interestsIds);
        $lead->sources()->attach($this->sourcesIds);
        $lead->projects()->attach($this->projects->pluck('id')->toArray());

        foreach ($this->phones as $phone) {
            PhoneNumber::create([
                'country_code' => $phone['code'],
                'number' => $phone['number'],
                'callable_type' => 'App\Models\Lead',
                'callable_id' => $lead->id,
            ]);
        }

        $this->reset(['name', 'notes', 'interestsIds', 'sourcesIds', 'phonesCount', 'phones', 'developerWithProjects', 'projects']);
    }

    public function update()
    {
        $this->lead->update([
            'name' => $this->name,
            'notes' => Helper::linkify($this->notes)
        ]);

        $this->lead->sources()->sync($this->sourcesIds);
        $this->lead->interests()->sync($this->interestsIds);
        $this->lead->projects()->sync($this->projects->pluck('id')->toArray());

        if ($this->phones) {
            $phones = array_filter($this->phones);
            $this->lead->phones()->delete();

            foreach ($phones as $phone) {
                PhoneNumber::create([
                    'callable_type' => 'App\Models\Lead',
                    'callable_id' => $this->lead->id,
                    'country_code' => $phone['code'],
                    'number' => $phone['number'],
                ]);
            }
        }
    }

    public function save()
    {
        $this->dispatchBrowserEvent('render-quill');
        $this->validate();


        DB::beginTransaction();
        try {
            if ($this->lead) {
                $this->update();
            } else {
                $this->store();
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollback();
        }

        return redirect()->route('leads.index');
    }

    // Projects

    public function changeProjectsPerDeveloper()
    {
        $selectedProjectsIds = $this->getSelectedProjectsIds();
        $this->projectsOptions = Project::whereNotIn('id', $selectedProjectsIds)->where('developer_id', $this->developer_id)->get();
    }

    public function addProjects()
    {
        $this->developerWithProjects[$this->developer_id] = [...$this->developerWithProjects[$this->developer_id] ?? [], ...$this->projects_ids];
        $this->getProjectsModels();
        $this->changeProjectsPerDeveloper();
        // $this->reset(['developer_id', 'projects_ids', 'projectsOptions']);
    }

    private function getSelectedProjectsIds()
    {
        $selectedProjectsIds = [];

        if ($this->lead) {
            $selectedProjectsIds = Lead::find($this->lead->id)->projects->pluck('id')->toArray();
        }

        foreach ($this->developerWithProjects as $projects_ids) {
            foreach ($projects_ids as $project_id) {
                $selectedProjectsIds[] =  $project_id;
            }
        }
        return array_unique($selectedProjectsIds);
    }

    private function getProjectsModels()
    {
        $selectedProjectsIds = $this->getSelectedProjectsIds();
        $this->projects = Project::whereIn('id', array_unique($selectedProjectsIds))->select(['id', 'name', 'developer_id'])->get();
    }

    public function removeProject($projectId, $developerId)
    {
        $selectedDeveloperProjectsIds = $this->developerWithProjects[$developerId] ?? [];
        $this->developerWithProjects[$developerId] = array_filter($selectedDeveloperProjectsIds, fn ($item) => $item != $projectId);

        if ($this->lead) {
            $this->lead->projects()->detach($projectId);
        }

        $this->getProjectsModels();
        $this->reset(['developer_id', 'projects_ids', 'projectsOptions']);
    }

    // Phones

    public function addNewPhoneField()
    {
        $this->phonesLimit > $this->phonesCount ? $this->phonesCount++ : false;
    }

    public function removePhoneField()
    {
        if ($this->phonesCount > 1) {
            $this->phonesCount--;
            array_pop($this->phones);
        }
    }

    public function identifyPhoneCode($index)
    {
        $phoneNumber =  str_replace('+', '', $this->phones[$index]['number']);

        foreach ($this->countriesOptions as $country) {
            if (Str::startsWith($phoneNumber, $country->phone_code)) {
                $this->phones[$index]['code'] = $country->phone_code;
            }
        }
    }
}
