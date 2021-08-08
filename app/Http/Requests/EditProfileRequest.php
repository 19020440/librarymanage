<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProfileRequest extends FormRequest
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
        $rules = [
            'name' => 'required',
            'phone' => 'required|max:10|min:10',
            'email' => 'required',
            'birth' => 'required',
            'address' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '*Bạn chưa nhập họ và tên.',
            'phone.required' => '*Bạn chưa nhập số điện thoại.',
            'phone.max' => '*Số điện thoại không hợp lệ.',
            'phone.min' => '*Số điện thoại không hợp lệ.',
            'email.required' => '*Bạn chưa nhập địa chỉ email.',
            'birth.required' => '*Bạn chưa chọn ngày sinh.',
            'address.required' => '*Bạn chưa nhập địa chỉ.'
        ];
    }
}
