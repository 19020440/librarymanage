<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PasswordRequest extends FormRequest
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
        $rules['password'] = 'required|min:6|confirmed';
        if ($this->password_old && Auth::user()) {
            $password = Auth::user()->password;
            if (!Hash::check($this->password_old, $password)) {
                $rules['password_old'] = "same:$password";
            }
        }
        if ($this->username) {
            $user = DB::table('users')->where('username', $this->username)->first();
            $email = $user->email;
            if (!$this->email == $email) {
                $email = Hash::make($email);
                $rules['email'] = "same:$email";
            }
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'password_old.same' => '*Mật khẩu hiện tại không chính xác.',
            'password.required' => '*Bạn chưa nhập mật khẩu mới.',
            'password.min' => '*Độ dài mật khẩu nằm trong khoảng 6~24.',
            'password.confirmed' => '*Nhập lại mật khẩu không chính xác.',
            'email.same' => '*Email không chính xác.'
        ];
    }
}
