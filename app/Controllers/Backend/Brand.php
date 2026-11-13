<?php

namespace App\Controllers\Backend;

use App\Models\Backend\BackendBrandModel;
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;

class Brand extends AdminBaseController
{
    public function add_brand_form(): string
    {
        return $this->renderAdminPage('add_brand');
    }

    public function save_brand(): ResponseInterface|string
    {
        $validation = service('validation');
        $validation->setRules(['brand_name' => 'required|min_length[2]|max_length[255]']);

        if (! $validation->run($this->request->getPost())) {
            return $this->add_brand_form();
        }

        if (! (new BackendBrandModel())->create(trim((string) $this->request->getPost('brand_name')))) {
            throw new RuntimeException('Unable to save the brand.');
        }

        service('session')->setFlashdata('flsh_msg', 'Brand Added Successfully');

        return redirect()->to(admin_url('brand-list'));
    }

    public function show_brand_list(): string
    {
        return $this->renderAdminPage('brand_list', [
            'all_brands' => (new BackendBrandModel())->all(),
        ]);
    }

    public function delete_brand(string $brandId): ResponseInterface
    {
        if (! ctype_digit($brandId) || (int) $brandId < 1) {
            return $this->response->setStatusCode(404)->setBody('Brand not found.');
        }

        if ((new BackendBrandModel())->find((int) $brandId) === null) {
            return $this->response->setStatusCode(404)->setBody('Brand not found.');
        }

        if (! (new BackendBrandModel())->delete((int) $brandId)) {
            throw new RuntimeException('Unable to delete the brand.');
        }

        service('session')->setFlashdata('flsh_msg', 'Brand Deleted Successfully');

        return redirect()->to(admin_url('brand-list'));
    }

    public function edit_brand(string $brandId): ResponseInterface|string
    {
        if (! ctype_digit($brandId) || (int) $brandId < 1) {
            return $this->response->setStatusCode(404)->setBody('Brand not found.');
        }

        $brand = (new BackendBrandModel())->find((int) $brandId);
        if ($brand === null) {
            return $this->response->setStatusCode(404)->setBody('Brand not found.');
        }

        return $this->renderAdminPage('edit_brand', ['brand_by_id' => $brand]);
    }

    public function update_brand(string $brandId): ResponseInterface|string
    {
        if (! ctype_digit($brandId) || (int) $brandId < 1) {
            return $this->response->setStatusCode(404)->setBody('Brand not found.');
        }

        $model = new BackendBrandModel();
        $brand = $model->find((int) $brandId);
        if ($brand === null) {
            return $this->response->setStatusCode(404)->setBody('Brand not found.');
        }

        $validation = service('validation');
        $validation->setRules(['brand_name' => 'required|min_length[2]|max_length[255]']);
        if (! $validation->run($this->request->getPost())) {
            return $this->renderAdminPage('edit_brand', ['brand_by_id' => $brand]);
        }

        if (! $model->update((int) $brandId, trim((string) $this->request->getPost('brand_name')))) {
            throw new RuntimeException('Unable to update the brand.');
        }

        service('session')->setFlashdata('flsh_msg', 'Brand Updated Successfully');

        return redirect()->to(admin_url('brand-list'));
    }
}
