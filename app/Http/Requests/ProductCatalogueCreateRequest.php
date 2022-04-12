<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCatalogueCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'modelCode' => "required",
            'modelDesc' => "required",
            'datelist.0.price' => "required",
            'datelist.0.status' => "required",
            'datelist.0.startDate' => "required|date",
            'datelist.0.endDate' => "required|date|after:datelist.0.startDate",
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
            "datelist.0.price.required" =>  'The price field is required.',
            "datelist.0.status.required" =>  'The status field is required.',
            "datelist.0.startDate.required" =>  'The start date field is required.',
            "datelist.0.endDate.required" =>  'The end date field is required.',
            "datelist.0.endDate.after" =>  'The end date must be a date after start date.',
        ];
    }
}
