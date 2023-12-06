<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\EnvatoApiService;
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
            // Define other validation rules as needed.
        ];
    }

    /**
     * Validate the domain and ensure it's a production domain.
     *
     * @return string|null
     */
    public function validatedDomain(): ?string
    {
        $domain = $this->getHost();

        if ($this->envatoApiService->isValidDomain($domain)) {
            return $domain;
        }

        return null;
    }
}
