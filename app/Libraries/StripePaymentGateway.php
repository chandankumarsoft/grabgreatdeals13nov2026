<?php

namespace App\Libraries;

use CodeIgniter\HTTP\Exceptions\HTTPException;
use RuntimeException;

final class StripePaymentGateway
{
    /**
     * @param array<string, scalar|array> $parameters
     * @return array<string, mixed>
     */
    public function createPaymentIntent(array $parameters, string $idempotencyKey): array
    {
        if (preg_match('/\A[a-zA-Z0-9_-]{1,255}\z/', $idempotencyKey) !== 1) {
            throw new RuntimeException('Invalid Stripe idempotency key.');
        }

        return $this->request('POST', 'payment_intents', $parameters, $idempotencyKey);
    }

    /**
     * @return array<string, mixed>
     */
    public function retrievePaymentIntent(string $intentId): array
    {
        if (preg_match('/\Api_[A-Za-z0-9]+\z/', $intentId) !== 1) {
            throw new RuntimeException('Invalid Stripe payment intent ID.');
        }

        return $this->request('GET', 'payment_intents/' . rawurlencode($intentId));
    }

    /**
     * @param array<string, scalar|array> $parameters
     * @return array<string, mixed>
     */
    private function request(
        string $method,
        string $endpoint,
        array $parameters = [],
        ?string $idempotencyKey = null,
    ): array {
        $secretKey = trim((string) env('stripe.secretKey', ''));
        if (! str_starts_with($secretKey, 'sk_')) {
            throw new RuntimeException('Stripe secret key is not configured.');
        }

        try {
            $options = [
                'auth'         => [$secretKey, ''],
                'http_errors'  => false,
                'timeout'      => 20,
            ];
            if ($idempotencyKey !== null) {
                $options['headers']['Idempotency-Key'] = $idempotencyKey;
            }
            if ($method === 'POST') {
                $options['form_params'] = $parameters;
            }
            $response = service('curlrequest')->request(
                $method,
                'https://api.stripe.com/v1/' . $endpoint,
                $options,
            );
        } catch (HTTPException $exception) {
            throw new RuntimeException('Stripe API request failed.', 0, $exception);
        }

        $data = json_decode((string) $response->getBody(), true);
        if (
            $response->getStatusCode() < 200
            || $response->getStatusCode() >= 300
            || ! is_array($data)
        ) {
            $message = is_array($data) ? (string) ($data['error']['message'] ?? 'Invalid provider response.') : 'Invalid provider response.';
            throw new RuntimeException('Stripe API error: ' . $message);
        }

        return $data;
    }
}
