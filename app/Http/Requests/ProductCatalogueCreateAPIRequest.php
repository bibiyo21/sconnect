<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCatalogueCreateAPIRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'catalogues' => 'required',
            'catalogues.*.modelCode' => "required",
            'catalogues.*.modelDesc' => "required",
            'catalogues.*.datelist.*.price' => "required",
            'catalogues.*.datelist.*.status' => "required",
            'catalogues.*.datelist.*.startDate' => "required|date",
            'catalogues.*.datelist.*.endDate' => "required|date|after:datelist.0.startDate",
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
            "catalogues.*.datelist.*.price.required" =>  'The price field is required.',
            "catalogues.*.datelist.*.status.required" =>  'The status field is required.',
            "catalogues.*.datelist.*.startDate.required" =>  'The start date field is required.',
            "catalogues.*.datelist.*.endDate.required" =>  'The end date field is required.',
            "catalogues.*.datelist.*.endDate.after" =>  'The end date must be a date after start date.',
        ];
    }
}
