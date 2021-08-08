<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'username' => 'required|min:6|max:24|unique:users,username,NULL,id,deleted_at,NULL',
            'password' => 'required|min:6|confirmed'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '*Bạn chưa nhập họ và tên.',
            'password.required' => '*Bạn chưa nhập mật khẩu.',
            'password.min' => '*Độ dài mật khẩu nằm trong khoảng 6~24.',
            'password.confirmed' => '*Nhập lại mật khẩu không chính xác.',
            'phone.required' => '*Bạn chưa nhập số điện thoại.',
            'phone.max' => '*Số điện thoại không hợp lệ.',
            'phone.min' => '*Số điện thoại không hợp lệ.',
            'email.required' => '*Bạn chưa nhập địa chỉ email.',
            'birth.required' => '*Bạn chưa chọn ngày sinh.',
            'address.required' => '*Bạn chưa nhập địa chỉ.',
            'username.required' => '*Bạn chưa nhập tên đăng nhập.',
            'username.min' => '*Độ dài tên đăng nhập nằm trong khoảng 6~24.',
            'username.max' => '*Độ dài tên đăng nhập nằm trong khoảng 6~24.',
            'username.unique' => '*Tên đăng nhập đã tồn tại.',
        ];
    }
}
