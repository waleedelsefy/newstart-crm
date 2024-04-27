<?php

namespace App\Http\Requests;

use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use App\Rules\UniquePhone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $user = $this->user ? $this->user : 0;

        return [
            'name' => ['required', 'string', 'max:255'],
            // 'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id ?? null)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id ?? null)],
            'country_code' => ['required', 'string', 'max:4'],
            'phone_number' => ['required', 'numeric', new UniquePhone($user)],
            'gender' => ['required', 'string', 'in:male,female'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'branches_ids' => ['required'],
            'role_id' => ['required', Rule::in(Role::get()->pluck('id')->toArray())],
        ];
    }
}
