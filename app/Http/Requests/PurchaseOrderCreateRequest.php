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
            'items' => 'required',
            'items.*.modelCode' => 'required',
            'items.*.orderQuantity' => 'required',
            'items.*.price' => 'required',
            'items.*.taxcode' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new Response([
            'resultCode' => 'Failed',
            'errorCode' => '422: Please provide appropriate field values',
            'message' => $validator->errors()
        ], 422);
        throw new ValidationException($validator, $response);
    }

    /**
     * Get the error messages for the defined validation rules
     *
     * @return array
     */
    public function messages() 
    {
        return [
            'poNumber.required' => 'poNumber field is required',
            'siteCode.required' => 'siteCode field is required',
            'orderDate.required' => 'orderDate field is required',
            'orderDate.date_format' => 'orderDate must be in yyyymmddhhmmiss',
            'items.*.modelCode.required' => 'modelCode is required',
            'items.*.orderQuantity.required' => 'modelCode is required',
            'items.*.price.required' => 'price is required',
            'items.*.taxcode.required' => 'taxcode is required',
        ];
    }
}
