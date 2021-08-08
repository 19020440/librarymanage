<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
        $min = date_format(now()->addHours(7), 'Y-m-d');
        $max = date_format(now()->addDays(30), 'Y-m-d');
        $rules = [
            'address' => 'required',
            'time_promise_pay' => "required|before:$max|after:$min"
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'address.required' => '*Bạn chưa nhập địa chỉ.',
            'time_promise_pay.required' => '*Bạn chưa chọn ngày trả sách.',
            'time_promise_pay.before' => '*Ngày trả sách phải trước 1 tháng sau khi mượn sách.',
            'time_promise_pay.after' => '*Ngày trả sách phải sau ngày mượn sách.'
        ];
    }
}
