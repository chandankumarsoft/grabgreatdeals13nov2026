<?php

namespace App\Controllers\Backend;

use App\Models\Backend\BackendOrderModel;
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;

class OrderAdmin extends AdminBaseController
{
    public function manage_order(): string
    {
        $filters = [];
        foreach (['payment_status', 'payment_type', 'view_status', 'tracking_status', 'currency'] as $key) {
            $value = $this->request->getGet($key);
            if (is_scalar($value)) {
                $filters[$key] = trim((string) $value);
            }
        }

        return $this->renderAdminPage('order_list', [
            'all_order' => (new BackendOrderModel())->orders($filters),
        ]);
    }

    public function view_order(string $orderId): ResponseInterface|string
    {
        $id = $this->positiveId($orderId);
        $model = new BackendOrderModel();
        $order = $id === null ? null : $model->order($id);
        if ($order === null) {
            return $this->response->setStatusCode(404)->setBody('Order not found.');
        }

        $billing = $model->billing($id);
        $shipping = $model->shipping($id);
        if ($billing === null || $shipping === null) {
            throw new RuntimeException('The order is missing billing or shipping details.');
        }
        $details = $model->orderDetails($id);
        if (! $model->markViewed($id)) {
            throw new RuntimeException('Unable to update the order viewed status.');
        }

        return $this->renderAdminPage('order_details', [
            'order_info' => $order,
            'bill_info' => $billing,
            'ship_info' => $shipping,
            'order_details_info' => $details,
        ]);
    }

    public function delete_order(string $orderId): ResponseInterface
    {
        $id = $this->positiveId($orderId);
        $model = new BackendOrderModel();
        $order = $id === null ? null : $model->order($id);
        if ($order === null) {
            return $this->response->setStatusCode(404)->setBody('Order not found.');
        }
        $shippingId = $this->positiveId($order->shipping_id ?? null);
        $paymentId = $this->positiveId($order->payment_id ?? null);
        if ($shippingId === null || $paymentId === null) {
            throw new RuntimeException('The order is missing shipping or payment references.');
        }

        $model->deleteOrder($id, $shippingId, $paymentId);
        service('session')->setFlashdata('flsh_msg', 'Order Deleted Successfully');

        return redirect()->to(admin_url('manage-order'));
    }

    public function sendOrderNoToCus(): ResponseInterface
    {
        return $this->response->setStatusCode(503)->setJSON([
            'mail_send_status' => 0,
            'error' => 'Tracking email and SMS are not configured securely.',
        ]);
    }

    private function positiveId(mixed $value): ?int
    {
        if (! is_scalar($value) || ! ctype_digit((string) $value) || (int) $value < 1) {
            return null;
        }

        return (int) $value;
    }
}
