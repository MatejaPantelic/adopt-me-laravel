<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnimalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>['required','alpha'],
            'breed'=>['required','regex:/^[\pL\s\-]+$/u','max:50'],
            'color'=>['nullable','alpha','max:50'],
            'weight'=>['nullable','numeric'],
            'gender'=>['required'],
            'pedigree'=>['required'],
            'birth_date'=> ['required', 'date', 'before_or_equal:today'],
        ];
    }
}
