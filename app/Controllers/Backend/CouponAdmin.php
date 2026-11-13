<?php

namespace App\Controllers\Backend;

use App\Models\Backend\BackendCouponModel;
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;

class CouponAdmin extends AdminBaseController
{
    public function index(): string
    {
        return $this->renderAdminPage('coupon/add_coupon');
    }

    public function add_coupon_record(): ResponseInterface|string
    {
        $validation = $this->couponValidation();
        if (! $validation->run($this->request->getPost())) {
            return $this->renderAdminPage('coupon/add_coupon');
        }

        $coupon = $this->couponFormData();
        $coupon['coupon_added_by'] = (int) service('session')->get('userid');
        $coupon['created_at'] = date('Y-m-d H:i:s');

        if (! (new BackendCouponModel())->addCoupon($coupon)) {
            throw new RuntimeException('Unable to add the coupon.');
        }

        service('session')->setFlashdata('flsh_msg', 'Coupon Added Successfully');

        return redirect()->to(admin_url('coupon-record-list'));
    }

    public function coupon_record_list(): string
    {
        return $this->renderAdminPage('discount_coupon_list', [
            'all_coupon' => (new BackendCouponModel())->coupons(),
        ]);
    }

    public function edit_discount_coupon(string $couponId): ResponseInterface|string
    {
        $id = $this->positiveId($couponId);
        $model = new BackendCouponModel();
        $coupon = $id === null ? null : $model->coupon($id);
        if ($coupon === null) {
            return $this->response->setStatusCode(404)->setBody('Coupon not found.');
        }

        if ($this->request->getMethod() === 'post') {
            $validation = $this->couponValidation();
            if (! $validation->run($this->request->getPost())) {
                return $this->renderAdminPage('edit_coupon_details', ['all_coupon' => $coupon]);
            }

            $data = $this->couponFormData();
            $data['coupon_updated_by'] = (int) service('session')->get('userid');
            $data['updated_at'] = date('Y-m-d H:i:s');

            if (! $model->updateCoupon($id, $data)) {
                throw new RuntimeException('Unable to update the coupon.');
            }

            service('session')->setFlashdata('flsh_msg', 'Coupon Updated Successfully');

            return redirect()->to(admin_url('coupon-record-list'));
        }

        return $this->renderAdminPage('edit_coupon_details', ['all_coupon' => $coupon]);
    }

    public function delete_discount_coupon(string $couponId): ResponseInterface
    {
        $id = $this->positiveId($couponId);
        if ($id === null || (new BackendCouponModel())->coupon($id) === null) {
            return $this->response->setStatusCode(404)->setBody('Coupon not found.');
        }

        if (! (new BackendCouponModel())->deleteCoupon(
            $id,
            (int) service('session')->get('userid'),
            date('Y-m-d H:i:s'),
        )) {
            throw new RuntimeException('Unable to delete the coupon.');
        }

        service('session')->setFlashdata('flsh_msg', 'Coupon Has Been Deleted Successfully');

        return redirect()->to(admin_url('coupon-record-list'));
    }

    public function get_all_discount_email_list(): string
    {
        return $this->renderAdminPage('discount_email_list', [
            'all_contact' => (new BackendCouponModel())->discountEmailList(),
        ]);
    }

    public function delete_discount_email_id(string $emailId): ResponseInterface
    {
        if (! ctype_digit($emailId) || (int) $emailId < 1) {
            return $this->response->setStatusCode(404)->setBody('Email entry not found.');
        }

        if (! (new BackendCouponModel())->deleteDiscountEmail((int) $emailId)) {
            throw new RuntimeException('Unable to delete the discount email entry.');
        }

        service('session')->setFlashdata('flsh_msg', 'Email Deleted Successfully');

        return redirect()->to(admin_url('discount-email-list'));
    }

    public function get_all_sms_list(): string
    {
        return $this->renderAdminPage('sms_list', [
            'all_contact' => (object) ['messages' => []],
            'sms_unavailable_message' => 'SMS history is unavailable until the provider is configured securely.',
        ]);
    }

    private function couponValidation(): \CodeIgniter\Validation\Validation
    {
        $validation = service('validation');
        $validation->setRules([
            'coupon_name' => 'required|max_length[255]',
            'coupon_description' => 'required',
            'coupon_type' => 'required|in_list[percentage]',
            'coupon_amount' => 'required|numeric|greater_than[0]|less_than_equal_to[100]',
            'coupon_expiry_date' => 'required|valid_date[Y-m-d]',
        ]);

        return $validation;
    }

    /**
     * @return array<string, string>
     */
    private function couponFormData(): array
    {
        $fields = ['coupon_name', 'coupon_description', 'coupon_type', 'coupon_amount', 'coupon_expiry_date'];
        $data = [];
        foreach ($fields as $field) {
            $value = $this->request->getPost($field);
            $data[$field] = is_scalar($value) ? trim((string) $value) : '';
        }

        return $data;
    }

    private function positiveId(string $value): ?int
    {
        if (! ctype_digit($value) || (int) $value < 1) {
            return null;
        }

        return (int) $value;
    }
}
