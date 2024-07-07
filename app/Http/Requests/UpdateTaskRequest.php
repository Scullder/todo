<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();

        if ($method == 'PUT') {
            return [
                'title' => 'string|required',
                'description' => 'string|required',
                'status' => 'boolean|required',
                'deadline' => 'date_format:Y-m-d H:i:s|required',
            ];
        } 

        return [
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'status' => 'sometimes|boolean',
            'deadline' => 'sometimes|date_format:Y-m-d H:i:s',
        ];
    }
}
