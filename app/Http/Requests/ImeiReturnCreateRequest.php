<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImeiReturnCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'poNumber' => "required",
            'siteCode' => "required",
            'imeilist.0.imei' => "required",
            'imeilist.0.status' => "required",
        ];
    }

    /**
     * Get the error messages for the defined validation rules
     *
     * @return array
     */
    public function messages() 
    {
        return [
            'poNumber.required' => 'PO Number is Required',
            'siteCode.required' => 'siteCode field is required',
            'imeilist.0.imei.required' => 'IMEI is Required',
            'imeilist.0.status.required' => 'Status is Required',
        ];
    }
}
