<?php

namespace App\Libraries;

use CodeIgniter\HTTP\Exceptions\HTTPException;
use RuntimeException;

final class LegacySmsGateway
{
    public function send(string $to, string $message): bool
    {
        $accountSid = (string) env('twilio.accountSid', '');
        $authToken = (string) env('twilio.authToken', '');
        $fromNumber = (string) env('twilio.fromNumber', '');

        if ($accountSid === '' || $authToken === '' || $fromNumber === '') {
            throw new RuntimeException('SMS delivery is not configured.');
        }

        $url = 'https://api.twilio.com/2010-04-01/Accounts/'
            . rawurlencode($accountSid) . '/Messages.json';

        try {
            $response = service('curlrequest')->post($url, [
                'auth'        => [$accountSid, $authToken],
                'form_params' => [
                    'From' => $fromNumber,
                    'To'   => $to,
                    'Body' => $message,
                ],
                'http_errors' => false,
                'timeout'     => 15,
            ]);
        } catch (HTTPException $exception) {
            log_message('error', 'SMS provider request failed: {message}', [
                'message' => $exception->getMessage(),
            ]);

            return false;
        }

        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            log_message('error', 'SMS provider rejected a message with status {status}.', [
                'status' => $response->getStatusCode(),
            ]);

            return false;
        }

        return true;
    }
}
