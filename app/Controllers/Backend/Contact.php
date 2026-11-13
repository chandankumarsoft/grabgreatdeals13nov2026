<?php

namespace App\Controllers\Backend;

use App\Models\Backend\BackendContactModel;
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;

class Contact extends AdminBaseController
{
    public function get_all_contact_message(): string
    {
        return $this->renderAdminPage('message_list', [
            'all_contact' => (new BackendContactModel())->contactMessages(),
        ]);
    }

    public function delete_contact_by_id(string $contactId): ResponseInterface
    {
        $id = $this->positiveId($contactId);
        if ($id === null) {
            return $this->response->setStatusCode(404)->setBody('Contact message not found.');
        }

        if (! (new BackendContactModel())->deleteContactMessage($id)) {
            throw new RuntimeException('Unable to delete the contact message.');
        }

        service('session')->setFlashdata('flsh_msg', 'Message Deleted Successfully');

        return redirect()->to(admin_url('contact-message-list'));
    }

    public function view_contact_by_id(string $contactId): ResponseInterface|string
    {
        $id = $this->positiveId($contactId);
        $message = $id === null ? null : (new BackendContactModel())->contactMessage($id);
        if ($message === null) {
            return $this->response->setStatusCode(404)->setBody('Contact message not found.');
        }

        $renderer = $this->backendRenderer();

        return $renderer->render('adminpanel', [
            'other_content' => $renderer->render('view_contact', [
                'contact_message_by_id' => $message,
            ]),
        ]);
    }

    public function get_all_complaints_message(): string
    {
        return $this->renderAdminPage('complaints_message_list', [
            'all_complaints' => (new BackendContactModel())->complaintMessages(),
        ]);
    }

    public function get_all_applicants_message(): string
    {
        return $this->renderAdminPage('applicants_message_list', [
            'all_applicants' => (new BackendContactModel())->applicantMessages(),
        ]);
    }

    public function customer_details(): string
    {
        return $this->renderAdminPage('customer_list', [
            'all_customer' => (new BackendContactModel())->customers(),
        ]);
    }

    public function customer_details_update(): ResponseInterface|string
    {
        $customerId = $this->positiveId($this->request->getGet('cus_id'));
        $model = new BackendContactModel();
        $customer = $customerId === null ? null : $model->customer($customerId);
        if ($customer === null) {
            return $this->response->setStatusCode(404)->setBody('Customer not found.');
        }

        return $this->renderAdminPage('edit_customer_details', [
            'all_customer' => $customer,
            'countryList' => $model->countries(),
            'stateList' => $model->statesForCountry($customer->cus_country ?? null),
        ]);
    }

    public function customer_details_update_save(): ResponseInterface
    {
        $customerId = $this->positiveId($this->request->getPost('cus_name_hidden'));
        $model = new BackendContactModel();
        if ($customerId === null || $model->customer($customerId) === null) {
            return $this->response->setStatusCode(404)->setBody('Customer not found.');
        }

        $fields = [
            'cus_name',
            'cus_email',
            'cus_gender',
            'date_of_birth',
            'cus_mobile_full_no',
            'cus_address',
            'cus_city',
            'cus_country',
            'cus_state',
            'cus_zip',
        ];
        $customer = [];
        foreach ($fields as $field) {
            $value = $this->request->getPost($field);
            if (! is_scalar($value)) {
                return $this->response->setStatusCode(400)->setBody('Invalid customer details.');
            }
            $customer[$field] = trim((string) $value);
        }
        $customer['updatedon'] = date('Y-m-d H:i:s');
        $customer['updatedby'] = (int) service('session')->get('userid');

        if (! $model->updateCustomer($customerId, $customer)) {
            throw new RuntimeException('Unable to update the customer details.');
        }

        service('session')->setFlashdata('flsh_msg', 'Data Updated Successfully');

        return redirect()->to(admin_url('customer-details'));
    }

    public function customer_details_delete(string $customerId): ResponseInterface
    {
        $id = $this->positiveId($customerId);
        if ($id === null) {
            return $this->response->setStatusCode(404)->setBody('Customer not found.');
        }

        if (! (new BackendContactModel())->softDeleteCustomer(
            $id,
            (int) service('session')->get('userid'),
            date('Y-m-d H:i:s'),
        )) {
            throw new RuntimeException('Unable to delete the customer.');
        }

        service('session')->setFlashdata('flsh_msg', 'Data Deleted Successfully');

        return redirect()->to(admin_url('customer-details'));
    }

    private function positiveId(mixed $value): ?int
    {
        if (! is_scalar($value) || ! ctype_digit((string) $value) || (int) $value < 1) {
            return null;
        }

        return (int) $value;
    }
}
