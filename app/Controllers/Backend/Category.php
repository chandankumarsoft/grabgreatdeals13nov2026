<?php

namespace App\Controllers\Backend;

use App\Models\Backend\BackendCategoryModel;
use CodeIgniter\HTTP\ResponseInterface;

class Category extends AdminBaseController
{
    public function add_category_form(): string
    {
        return $this->renderAdminPage('add_category');
    }

    public function get_sub_subcat(): ResponseInterface
    {
        return $this->categoryOptions($this->request->getPost('category_sub_id'));
    }

    public function get_sub_sub_subcat(): ResponseInterface
    {
        return $this->categoryOptions($this->request->getPost('category_sub_sub_id'));
    }

    public function save_category(): ResponseInterface|string
    {
        $validation = service('validation');
        $validation->setRules(['category_name' => 'required|min_length[2]|max_length[255]']);

        if (! $validation->run($this->request->getPost())) {
            return $this->add_category_form();
        }

        helper('text');
        $name = $this->normalizedName((string) $this->request->getPost('category_name'));
        if (! (new BackendCategoryModel())->create($name, url_title(strtolower($name)))) {
            throw new \RuntimeException('Unable to save the category.');
        }

        service('session')->setFlashdata('flsh_msg', 'Category Added Successfully');

        return redirect()->to(admin_url('category-list'));
    }

    public function save_sub_category(): ResponseInterface|string
    {
        return $this->saveChildCategory('category_sub_id', 'sub_category_name', 'sub-category-list');
    }

    public function save_sub_sub_category(): ResponseInterface|string
    {
        return $this->saveChildCategory('sub_category_id', 'sub_sub_category_name', 'sub-of-sub-category-list');
    }

    public function show_category_list(): string
    {
        return $this->renderAdminPage('category_list', [
            'all_cats' => (new BackendCategoryModel())->get_all_category(),
        ]);
    }

    public function show_sub_category_list(): string
    {
        return $this->renderAdminPage('sub_category_list', [
            'all_sub_cats' => (new BackendCategoryModel())->get_all_sub_category(),
        ]);
    }

    public function show_sub_sub_category_list(): string
    {
        return $this->renderAdminPage('sub_sub_category_list', [
            'all_sub_cats' => (new BackendCategoryModel())->get_all_sub_sub_category(),
        ]);
    }

    public function delete_category(string $categoryId): ResponseInterface
    {
        return $this->deleteCategory($categoryId, 'category-list');
    }

    public function delete_sub_category(string $categoryId): ResponseInterface
    {
        return $this->deleteCategory($categoryId, 'sub-category-list');
    }

    public function delete_sub_sub_category(string $categoryId): ResponseInterface
    {
        return $this->deleteCategory($categoryId, 'sub-of-sub-category-list');
    }

    public function edit_category(string $categoryId): ResponseInterface|string
    {
        return $this->editCategory($categoryId, 'edit_category', 'cat_by_id');
    }

    public function edit_sub_category(string $categoryId): ResponseInterface|string
    {
        return $this->editCategory($categoryId, 'edit_sub_category', 'sub_cat_by_id');
    }

    public function edit_sub_sub_category(string $categoryId): ResponseInterface|string
    {
        return $this->editCategory($categoryId, 'edit_sub_sub_category', 'sub_sub_cat_by_id');
    }

    public function update_category(string $categoryId): ResponseInterface|string
    {
        return $this->updateCategory($categoryId, 'category_name', 'category-list', 'edit_category', 'cat_by_id');
    }

    public function update_sub_category(string $categoryId): ResponseInterface|string
    {
        return $this->updateCategory($categoryId, 'sub_category_name', 'sub-category-list', 'edit_sub_category', 'sub_cat_by_id');
    }

    public function update_sub_sub_category(string $categoryId): ResponseInterface|string
    {
        return $this->updateCategory($categoryId, 'sub_category_name', 'sub-of-sub-category-list', 'edit_sub_sub_category', 'sub_sub_cat_by_id');
    }

    private function saveChildCategory(string $parentField, string $nameField, string $redirectPath): ResponseInterface|string
    {
        $validation = service('validation');
        $validation->setRules([
            $parentField => 'required|is_natural_no_zero',
            $nameField   => 'required|min_length[2]|max_length[255]',
        ]);

        if (! $validation->run($this->request->getPost())) {
            return $this->add_category_form();
        }

        $model = new BackendCategoryModel();
        $parentId = (int) $this->request->getPost($parentField);
        if (! $model->exists($parentId)) {
            return $this->response->setStatusCode(400)->setBody('The selected parent category does not exist.');
        }

        helper('text');
        $name = $this->normalizedName((string) $this->request->getPost($nameField));
        if (! $model->create($name, url_title(strtolower($name)), $parentId)) {
            throw new \RuntimeException('Unable to save the category.');
        }

        service('session')->setFlashdata('flsh_msg', 'Category Added Successfully');

        return redirect()->to(base_url($redirectPath));
    }

    private function deleteCategory(string $categoryId, string $redirectPath): ResponseInterface
    {
        if (! ctype_digit($categoryId) || (int) $categoryId < 1) {
            return $this->response->setStatusCode(404)->setBody('Category not found.');
        }

        $model = new BackendCategoryModel();
        if (! $model->exists((int) $categoryId)) {
            return $this->response->setStatusCode(404)->setBody('Category not found.');
        }

        if (! $model->deleteTree((int) $categoryId)) {
            throw new \RuntimeException('Unable to delete the category.');
        }

        service('session')->setFlashdata('flsh_msg', 'Category Deleted Successfully');

        return redirect()->to(base_url($redirectPath));
    }

    private function editCategory(string $categoryId, string $view, string $field): ResponseInterface|string
    {
        if (! ctype_digit($categoryId) || (int) $categoryId < 1) {
            return $this->response->setStatusCode(404)->setBody('Category not found.');
        }

        $category = (new BackendCategoryModel())->getById((int) $categoryId);
        if ($category === null) {
            return $this->response->setStatusCode(404)->setBody('Category not found.');
        }

        return $this->renderAdminPage($view, [$field => $category]);
    }

    private function updateCategory(
        string $categoryId,
        string $field,
        string $redirectPath,
        string $view,
        string $dataField,
    ): ResponseInterface|string {
        if (! ctype_digit($categoryId) || (int) $categoryId < 1) {
            return $this->response->setStatusCode(404)->setBody('Category not found.');
        }

        $model = new BackendCategoryModel();
        $category = $model->getById((int) $categoryId);
        if ($category === null) {
            return $this->response->setStatusCode(404)->setBody('Category not found.');
        }

        $validation = service('validation');
        $validation->setRules([$field => 'required|min_length[2]|max_length[255]']);
        if (! $validation->run($this->request->getPost())) {
            return $this->renderAdminPage($view, [$dataField => $category]);
        }

        helper('text');
        $name = $this->normalizedName((string) $this->request->getPost($field));
        if (! $model->update((int) $categoryId, $name, url_title(strtolower($name)))) {
            throw new \RuntimeException('Unable to update the category.');
        }

        service('session')->setFlashdata('flsh_msg', 'Category Updated Successfully');

        return redirect()->to(base_url($redirectPath));
    }

    private function categoryOptions(mixed $parentId): ResponseInterface
    {
        if (! is_scalar($parentId) || ! ctype_digit((string) $parentId) || (int) $parentId < 1) {
            return $this->response->setStatusCode(400)->setBody('Invalid parent category.');
        }

        $options = "<option value=''>Select Sub category</option>";
        foreach ((new BackendCategoryModel())->get_sub_category((string) $parentId) as $category) {
            $options .= '<option value="' . esc((string) $category->category_id) . '">'
                . esc((string) $category->category_name)
                . '</option>';
        }

        return $this->response->setContentType('text/html')->setBody($options);
    }

    private function normalizedName(string $name): string
    {
        return ucfirst(strtolower(trim($name)));
    }
}
