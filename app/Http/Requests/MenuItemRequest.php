<?php

namespace App\Http\Requests;


use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class MenuItemRequest extends FormRequest
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
             'title'=>'required', Rule::unique('menu_items', 'title')->ignore(Request()->id),
         ];
     }

     /**
      * Get the error messages for the defined validation rules.
      *
      * @return array<string, string>
     */

     public function messages(): array
     {
         return [
             'title.required' => 'Menu Item Name is required.',
             'title.unique' => 'Menu Item Name Already exists.',
         ];
     }


     public function failedValidation(Validator $validator)
     {
         throw new HttpResponseException(response()->json([
             'status'   => false,
             'errors'      => $validator->errors()
         ]));
     }

}