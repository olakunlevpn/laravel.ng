<?php

namespace App\Exceptions\Api;

use Exception;

class EnvatoApiException extends  Exception
{
    public static function fromResponseCode(int $responseCode): self
    {
        return match ($responseCode) {
            404 => new self("Invalid purchase code"),
            403 => new self("The personal token is missing the required permission for this script"),
            401 => new self("The personal token is invalid or has been deleted"),
            default => new self("Got status {$responseCode}, try again shortly")
        };
    }
}
