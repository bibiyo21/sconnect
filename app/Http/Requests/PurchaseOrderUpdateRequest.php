<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class PurchaseOrderUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'billing_document' => 'required',
            // 'sales_order' => 'required',
            'status' => 'required',
            'remarks' => 'required_if:status,R',
            'item' => 'required',
            'item.*.orderQuantity' => 'required',
            'item.*.invoiceQuantity' => 'required',
            'item.*.price' => 'required',
            'item.*.invoicePrice' => 'required',
            'item.*.orderQuantity' => 'required',
            'item.*.deliveryDate' => 'required_if:status,D',
        ];
    }
}