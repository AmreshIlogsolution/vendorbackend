<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
        return [
            'invoice_number' =>'required',
            'invoice_date' =>'required',
            'invoice_amount' =>'required',
            'invoice_image' =>'required |image|mimes:jpeg,png,jpg,gif|max:2048',  
            'invoice_coverLetter_image' =>'image|mimes:jpeg,png,jpg,gif|max:2048',         
        ];
    }
}
