<?php

namespace App\Services;

use App\Models\EnvatoPurchase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class EnvatoPurchaseService
{
    /**
     * Process the Envato purchase information.
     *
     * @param array $saleInformation
     * @param string|null $domain
     * @return JsonResponse
     */
    public function processPurchase(array $saleInformation, string|null $domain): JsonResponse
    {
        $apiData = $this->transformSaleInformation($saleInformation, $domain);
        $envatoPurchase = EnvatoPurchase::firstOrNew(['item_id' => $apiData['item_id']]);

        if (!is_null($envatoPurchase->domain)) {
            return response()->json([
                'status' => 'error',
                'message' => 'This license is already used and installed.'
            ],422);

        }

        $envatoPurchase->fill($apiData)->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Valid'
        ],204);

    }

    /**
     * Transform the sale information into the required format.
     *
     * @param array $saleInformation
     * @param string|null $domain
     * @return array
     */
    private function transformSaleInformation(array $saleInformation, string|null $domain): array
    {
        return [
            'verified_at' => Carbon::now(),
            'amount' => $saleInformation['amount'],
            'sold_at' => $saleInformation['sold_at'],
            'license' => $saleInformation['license'],
            'support_amount' => $saleInformation['support_amount'],
            'supported_until' => $saleInformation['supported_until'],
            'item_id' => $saleInformation['item']['id'],
            'item_name' => $saleInformation['item']['name'],
            'item_updated_at' => $saleInformation['item']['updated_at'],
            'item_site' => $saleInformation['item']['site'],
            'price_cents' => $saleInformation['item']['price_cents'],
            'buyer' => $saleInformation['buyer'],
            'domain' => $domain
        ];
    }
}

