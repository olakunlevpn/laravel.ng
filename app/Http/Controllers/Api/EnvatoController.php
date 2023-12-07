<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\EnvatoApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\EnvatoPurchaseRequest;
use App\Services\EnvatoApiService;
use App\Services\EnvatoPurchaseService;
use Illuminate\Http\JsonResponse;

class EnvatoController extends Controller
{
    protected EnvatoApiService $envatoApiService;
    protected EnvatoPurchaseService $envatoPurchaseService;

    public function __construct(EnvatoApiService $envatoApiService, EnvatoPurchaseService $envatoPurchaseService)
    {
        $this->envatoApiService = $envatoApiService;
        $this->envatoPurchaseService = $envatoPurchaseService;
    }

    public function checkLicense(EnvatoPurchaseRequest $request): JsonResponse
    {

        $validated = $request->validated();

        try {

            $saleInformation = $this->envatoApiService->getSaleInformation($validated['key']);
            return $this->envatoPurchaseService->processPurchase(
                $saleInformation,
                $request->validatedDomain($validated['url']
                )
            );

        } catch (EnvatoApiException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        }
    }

}
