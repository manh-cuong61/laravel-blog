<?php

namespace App\Http\Requests;

use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;

use Illuminate\Validation\ValidationException;

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Http\JsonResponse;

use Illuminate\Validation\Rule;

use App\Models\Post;

class CreatePostRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
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
            'title'=> 'required|unique:posts',
            'description' => 'required',
            'image' => 'required|image',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'description.required' => 'bạn chưa nhập mô tả',
            'title.required' => 'bạn chưa nhập tiêu đề',
            'title.unique' => 'tiêu đề đã tồn tại',
            'image.required' => 'Bạn phải thêm ảnh',
            'image.image' => 'sai định dạng ảnh'
        ];
    }

    protected function failedValidation(Validator $validator) 
    {

        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(
            [
                'error' => $errors,
                'status_code' => 422,
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
