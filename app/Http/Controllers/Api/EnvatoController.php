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

    public function checkPurchaseCode(EnvatoPurchaseRequest $request, $purchaseCode): JsonResponse
    {
        try {
            $saleInformation = $this->envatoApiService->getSaleInformation($purchaseCode);
            $response = $this->envatoPurchaseService->processPurchase($saleInformation, $request->validatedDomain());
            return response()->json($response, 200);
        } catch (EnvatoApiException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
