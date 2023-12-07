<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\EnvatoApiService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class EnvatoPurchaseRequest extends FormRequest
{
    protected EnvatoApiService $envatoApiService;

    public function __construct(EnvatoApiService $envatoApiService)
    {
        $this->envatoApiService = $envatoApiService;
    }

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
            'url' => 'required|url',
            'key' => 'required|regex:/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i',
        ];
    }

    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'status'   => 'error',

            'message'   => $validator->errors()

        ], 422));

    }



    public function messages()

    {

        return [

            'url.required' => 'The server domain is required',
            'key.required' => 'The license key is required',
            'key.regex' => 'The license key provided is invalid',

        ];

    }



    /**
     * Validate the domain and ensure it's a production domain.
     *
     * @return string|null
     */
    public function validatedDomain($domain): ?string
    {
        if (!$this->envatoApiService->isValidDomain($domain)) {
            return $domain;
        }

        return null;
    }
}
