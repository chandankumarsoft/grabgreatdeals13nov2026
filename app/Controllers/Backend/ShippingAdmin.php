<?php

namespace App\Controllers\Backend;

use App\Models\Backend\BackendShippingModel;
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;

class ShippingAdmin extends AdminBaseController
{
    public function index(): string
    {
        return $this->renderAdminPage('shipping/add_shipping');
    }

    public function add_shipping_record(): ResponseInterface|string
    {
        if (! $this->validateCharge()) {
            return $this->renderAdminPage('shipping/add_shipping');
        }

        $model = new BackendShippingModel();
        $userId = (int) service('session')->get('userid');
        if (! $model->addCharge($this->chargeData() + [
            'created_by' => $userId,
            'updated_by' => $userId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ])) {
            throw new RuntimeException('Unable to add the shipping charge.');
        }

        service('session')->setFlashdata('flsh_msg', 'Shipping Charges Added Successfully');

        return redirect()->to(admin_url('shipping-charge-record-list'));
    }

    public function shipping_record_list(): string
    {
        return $this->renderAdminPage('shipping/shipping_charge_list', [
            'all_shipping_charge' => (new BackendShippingModel())->charges(),
        ]);
    }

    public function edit_shipping_charge(string $chargeId): ResponseInterface|string
    {
        $id = $this->positiveId($chargeId);
        $charge = $id === null ? null : (new BackendShippingModel())->charge($id);
        if ($charge === null) {
            return $this->response->setStatusCode(404)->setBody('Shipping charge not found.');
        }

        return $this->renderAdminPage('shipping/edit_shipping_details', [
            'all_shipping_charge' => $charge,
        ]);
    }

    public function update_shipping_charge(): ResponseInterface|string
    {
        $id = $this->positiveId($this->request->getPost('shipping_id_hidden'));
        $model = new BackendShippingModel();
        if ($id === null || $model->charge($id) === null) {
            return $this->response->setStatusCode(404)->setBody('Shipping charge not found.');
        }
        if (! $this->validateCharge()) {
            return $this->renderAdminPage('shipping/edit_shipping_details', [
                'all_shipping_charge' => $model->charge($id),
            ]);
        }

        if (! $model->updateCharge($id, $this->chargeData() + [
            'updated_by' => (int) service('session')->get('userid'),
            'updated_at' => date('Y-m-d H:i:s'),
        ])) {
            throw new RuntimeException('Unable to update the shipping charge.');
        }

        service('session')->setFlashdata('flsh_msg', 'Shipping Charge Updated Successfully');

        return redirect()->to(admin_url('shipping-charge-record-list'));
    }

    public function delete_shipping_charge(string $chargeId): ResponseInterface
    {
        $id = $this->positiveId($chargeId);
        $model = new BackendShippingModel();
        if ($id === null || $model->charge($id) === null) {
            return $this->response->setStatusCode(404)->setBody('Shipping charge not found.');
        }

        if (! $model->deleteCharge($id, (int) service('session')->get('userid'), date('Y-m-d H:i:s'))) {
            throw new RuntimeException('Unable to delete the shipping charge.');
        }

        service('session')->setFlashdata('flsh_msg', 'Shipping Charge Has Been Deleted Successfully');

        return redirect()->to(admin_url('shipping-charge-record-list'));
    }

    public function add_shipping_charge_to_products(): string
    {
        $model = new BackendShippingModel();

        return $this->renderAdminPage('shipping/add_shipping_charge_to_products_page', [
            'shippingchargedetails' => $model->charges(),
            'productsnamedetails' => $model->products(),
        ]);
    }

    public function save_shipping_charge_to_products(): ResponseInterface
    {
        $chargeIds = $this->postedIds('shippingchargelist');
        $productIds = $this->postedIds('productsnamedetails');
        if ($chargeIds === null || $productIds === null || $chargeIds === [] || $productIds === []) {
            return $this->response->setStatusCode(400)->setBody('Select at least one product and shipping charge.');
        }

        $model = new BackendShippingModel();
        if (! $this->validShippingSelection($model, $chargeIds, $productIds)) {
            return $this->response->setStatusCode(400)->setBody('Select existing products and shipping charges.');
        }

        $model->addProductCharges($chargeIds, $productIds, (int) service('session')->get('userid'));
        service('session')->setFlashdata('flsh_msg', 'Charges Added Successfully');

        return redirect()->to(admin_url('shipping-charge-products-list'));
    }

    public function shipping_charge_products_list(): string
    {
        return $this->renderAdminPage('shipping/shipping_charge_products_list', [
            'all_shipping_charge' => (new BackendShippingModel())->productChargeList(),
        ]);
    }

    public function edit_shipping_product_list_charge(string $productId): ResponseInterface|string
    {
        $id = $this->positiveId($productId);
        $model = new BackendShippingModel();
        $product = $id === null ? null : $model->product($id);
        if ($product === null) {
            return $this->response->setStatusCode(404)->setBody('Product not found.');
        }

        return $this->renderAdminPage('shipping/shipping_charge_products_list_edit', [
            'shippingcharge' => $model->charges(),
            'shippingchargedetails' => $model->productCharges($id),
            'productsnamedetails' => [$product],
            'productinblrel' => [(object) ['pro_id' => $id]],
            'selected_pro_id' => $id,
        ]);
    }

    public function edit_save_shipping_charge_to_products(): ResponseInterface
    {
        $chargeIds = $this->postedIds('shippingchargelist');
        $productIds = $this->postedIds('productsnamedetails');
        if ($chargeIds === null || $productIds === null || $productIds === []) {
            return $this->response->setStatusCode(400)->setBody('Select a product to update.');
        }

        $model = new BackendShippingModel();
        if (! $this->validShippingSelection($model, $chargeIds, $productIds, true)) {
            return $this->response->setStatusCode(400)->setBody('Select existing products and shipping charges.');
        }

        $model->replaceProductCharges($chargeIds, $productIds, (int) service('session')->get('userid'));
        service('session')->setFlashdata('flsh_msg', 'Charges Updated Successfully');

        return redirect()->to(admin_url('shipping-charge-products-list'));
    }

    public function delete_save_shipping_charge_to_products(): ResponseInterface
    {
        $productId = $this->positiveId($this->request->getPost('product_id'));
        if ($productId === null || (new BackendShippingModel())->product($productId) === null) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'This product is not available']);
        }

        if (! (new BackendShippingModel())->deleteProductCharges($productId)) {
            throw new RuntimeException('Unable to remove the product shipping charges.');
        }

        return $this->response->setJSON(['success' => 'This product Deleted']);
    }

    private function validateCharge(): bool
    {
        $validation = service('validation');
        $validation->setRules([
            'start_day' => 'required|integer|greater_than_equal_to[0]',
            'till_day' => 'required|integer|greater_than_equal_to[0]',
            'shipping_description' => 'required|max_length[255]',
            'shipping_amount' => 'required|numeric|greater_than_equal_to[0]',
        ]);
        if (! $validation->run($this->request->getPost())) {
            return false;
        }

        if ((int) $this->request->getPost('start_day') > (int) $this->request->getPost('till_day')) {
            $validation->setError('start_day', 'The start day cannot exceed the till day.');

            return false;
        }

        return true;
    }

    /**
     * @return array{start_day: int, till_day: int, shipping_description: string, shipping_amount: string}
     */
    private function chargeData(): array
    {
        return [
            'start_day' => (int) $this->request->getPost('start_day'),
            'till_day' => (int) $this->request->getPost('till_day'),
            'shipping_description' => trim((string) $this->request->getPost('shipping_description')),
            'shipping_amount' => trim((string) $this->request->getPost('shipping_amount')),
        ];
    }

    /**
     * @return list<int>|null
     */
    private function postedIds(string $key): ?array
    {
        $values = $this->request->getPost($key);
        if ($values === null) {
            return [];
        }
        if (! is_array($values)) {
            return null;
        }

        $ids = [];
        foreach ($values as $value) {
            $id = $this->positiveId($value);
            if ($id === null) {
                return null;
            }
            $ids[] = $id;
        }

        return array_values(array_unique($ids));
    }

    /**
     * @param list<int> $chargeIds
     * @param list<int> $productIds
     */
    private function validShippingSelection(
        BackendShippingModel $model,
        array $chargeIds,
        array $productIds,
        bool $allowEmptyCharges = false,
    ): bool {
        if (! $allowEmptyCharges && $chargeIds === []) {
            return false;
        }
        foreach ($chargeIds as $chargeId) {
            if ($model->charge($chargeId) === null) {
                return false;
            }
        }
        foreach ($productIds as $productId) {
            if ($model->product($productId) === null) {
                return false;
            }
        }

        return true;
    }

    private function positiveId(mixed $value): ?int
    {
        if (! is_scalar($value) || ! ctype_digit((string) $value) || (int) $value < 1) {
            return null;
        }

        return (int) $value;
    }
}
