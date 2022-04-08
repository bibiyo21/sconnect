<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class PurchaseOrderCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'poNumber' => 'required',
            'siteCode' => 'required',
            'orderDate' => 'required|date_format:YmdHis',
            'deliveryMode' => 'required',
            'items' => 'required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new Response([
            'resultCode' => 'Failed',
            'message' => $validator->errors()
        ], 422);
        throw new ValidationException($validator, $response);
    }
}
