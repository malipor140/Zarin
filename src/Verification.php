<?php

namespace Pishran\Zarinpal;

use Illuminate\Support\Facades\Http;

class Verification
{
    /** @var int */
    private $amount;
    private $merchant_id;

    /** @var string */
    private $authority;

    public function __construct(int $amount, $merchant_id)
    {
        $this->amount = $amount;
        $this->merchant_id = $merchant_id;
    }

    public function send(): VerificationResponse
    {
        $url = config('zarinpal.sandbox_enabled')
            ? 'https://sandbox.zarinpal.com/pg/v4/payment/verify.json'
            : 'https://api.zarinpal.com/pg/v4/payment/verify.json';

        $data = [
            'merchant_id' => $this->merchant_id,
            'amount' => $this->amount,
            'authority' => $this->authority,
        ];

        $response = Http::asJson()->acceptJson()->post($url, $data);

        return new VerificationResponse($response->json());
    }

    public function authority(string $authority): self
    {
        $this->authority = $authority;

        return $this;
    }
}
