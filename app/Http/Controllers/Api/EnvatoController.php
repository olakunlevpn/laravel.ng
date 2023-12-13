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

        if($this->checkMasterKey($validated)){
            return response()->json([
                'status' => 'success',
                'message' => 'Your license is valid'
            ],204);
        }

        try {
           $purchase_code = $validated['key'];
            $saleInformation = $this->envatoApiService->getSaleInformation($purchase_code);
            return $this->envatoPurchaseService->processPurchase(
                $saleInformation,
                $purchase_code,
                $request->validatedDomain($validated['url']
                )
            );

        } catch (EnvatoApiException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
        }
    }

    private function checkMasterKey(mixed $validated)
    {
        return in_array($validated['key'], config('envato.master_key'));

    }

}
