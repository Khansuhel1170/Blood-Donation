<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'gender'=> 'required',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:5',
            'phone' => 'required|int|min:10',
            'address' => 'required|string|max:255',
            'city' => 'required',
        ];
    }
    public function message()
    {
        // return [
        //     'name.required' => 'Name is required',
        //     'email.required' => 'Email is required',
        //     'password.required' => 'Password is required',
        //     'phone.required' => 'Phone is required',
        //     'address.required' => 'Address is required',
        //     'city.required' => 'City is required',
        //     'state.required' => 'State is required',
        //     'name.string' => 'Name should be string',
        //     'password.string' => 'Password should be string',
        // ];
    }
}
