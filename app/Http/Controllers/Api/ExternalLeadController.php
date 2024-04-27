<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExternalLeadController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:2'],
            'notes' => ['required', 'string', 'min:2'],
            'phones' => ['required', 'array'],
            'phones.*.code' => ['required', 'string'],
            'phones.*.number' => ['required', 'string', 'min:10'],
            'interestsIds' => ['required', 'array'],
            'sourcesIds' => ['required', 'array'],
            'projects' => ['required', 'array'],
            'reminder' => ['required', ''],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $lead = Lead::create([
            'name' => $request->input('name'),
            'notes' => Helper::linkify($request->input('notes')),
            'reminder' => $request->input('reminder'),
        ]);

        $lead->sources()->attach($request->input('sourcesIds'));

        foreach ($request->input('phones') as $phone) {
            PhoneNumber::create([
                'country_code' => $phone['code'],
                'number' => $phone['number'],
                'callable_type' => 'App\Models\Lead',
                'callable_id' => $lead->id,
            ]);
        }

        return response()->json(['status'=>201, 'message' => 'Lead created successfully' ], 201);
    }
}
