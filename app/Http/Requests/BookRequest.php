<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'auth' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'year_start' => 'required|max:4|min:4',
            'content' => 'required',
            'image1' => 'required',
            'image2' => 'required',
            'category' => 'required|max:3|min:3'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '*Bạn chưa nhập tên sách.',
            'auth.required' => '*Bạn chưa nhập tên tác giả.',
            'quantity.required' => '*Bạn chưa nhập số lượng cuốn sách.',
            'price.required' => '*Bạn chưa nhập giá cuốn sách.',
            'year_start.required' => '*Bạn chưa nhập năm xuất bản.',
            'year_start.max' => '*Năm xuất bản không hợp lệ',
            'year_start.min' => '*Năm xuất bản không hợp lệ',
            'content.required' => '*Bạn chưa nhập nội dung cuốn sách.',
            'image1.required' => '*Bạn chưa upload ảnh mặt trước.',
            'image2.required' => '*Bạn chưa upload ảnh mặt sau.',
            'category.required' => '*Bạn chưa nhập mã DDC.',
            'category.max' => '*Bạn nhập mã DDC tương ứng trong khoảng 000-999.',
            'category.min' => '*Bạn nhập mã DDC tương ứng trong khoảng 000-999.',
        ];
    }
}
