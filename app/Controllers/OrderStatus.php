<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class OrderStatus extends BaseController
{
    public function track_order_status(): RedirectResponse|ResponseInterface
    {
        $trackingNumber = $this->request->getGet('odr');
        if (! is_scalar($trackingNumber) || trim((string) $trackingNumber) === '') {
            return $this->response->setStatusCode(400)->setBody('Tracking number is required.');
        }

        $tracking = db_connect()->table('tbl_tracking_no_send')
            ->select('TrackingUrl')
            ->where('trackingNumber', trim((string) $trackingNumber))
            ->orderBy('id', 'DESC')
            ->get()
            ->getRow();

        $url = is_object($tracking) ? trim((string) $tracking->TrackingUrl) : '';
        $parts = $url === '' ? false : parse_url($url);
        if (
            ! is_array($parts)
            || strtolower((string) ($parts['scheme'] ?? '')) !== 'https'
            || empty($parts['host'])
            || isset($parts['user'])
            || isset($parts['pass'])
        ) {
            return $this->response->setStatusCode(404)->setBody('Tracking information was not found.');
        }

        return redirect()->to($url);
    }
}
