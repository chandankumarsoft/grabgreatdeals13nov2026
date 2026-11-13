<?php

namespace App\Controllers\Backend;

use App\Libraries\WebpImage;
use App\Models\Backend\BackendAttributeModel;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\HTTP\ResponseInterface;
use InvalidArgumentException;
use RuntimeException;

class Attribute extends AdminBaseController
{
    private const ATTRIBUTE_VIEWS = [
        'tags' => [
            'add'       => 'attributes/add_tags_page',
            'edit'      => 'attributes/edit_tags_page',
            'list'      => 'attributes/product_tags_list',
            'listVar'   => 'all_products_tags',
            'editVar'   => 'tags_data_by_id',
            'id'        => 'product_tag_id',
            'name'      => 'product_tag_name',
            'slug'      => 'product_tag_slug',
            'description' => 'product_tag_description',
            'input'     => 'product_tag_name',
            'slugInput' => 'product_tag_slug',
            'descInput' => 'product_tag_description',
            'minLength' => 3,
            'success'   => 'Tags Added',
            'updated'   => 'Tags Updated',
            'listRoute' => 'product-tags-list',
        ],
        'type' => [
            'add'       => 'attributes/add_product_type_page',
            'edit'      => 'attributes/edit_pro_type_page',
            'list'      => 'attributes/product_types_list',
            'listVar'   => 'all_product_type',
            'editVar'   => 'protype_data_by_id',
            'id'        => 'product_type_id',
            'name'      => 'product_type_name',
            'slug'      => 'product_type_slug',
            'description' => 'product_type_description',
            'input'     => 'product_type_name',
            'slugInput' => 'product_type_slug',
            'descInput' => 'product_type_description',
            'minLength' => 1,
            'success'   => 'types Added',
            'updated'   => 'types Updated',
            'listRoute' => 'product-type-list',
        ],
        'size' => [
            'add'       => 'attributes/add_size_page',
            'edit'      => 'attributes/edit_size_page',
            'list'      => 'attributes/product_sizes_list',
            'listVar'   => 'all_size',
            'editVar'   => 'size_data_by_id',
            'id'        => 'size_id',
            'name'      => 'size_name',
            'slug'      => 'size_slug',
            'description' => 'size_description',
            'input'     => 'product_size_name',
            'slugInput' => 'product_size_slug',
            'descInput' => 'product_size_description',
            'minLength' => 1,
            'success'   => 'sizes Added',
            'updated'   => 'sizes Updated',
            'listRoute' => 'product-sizes-list',
        ],
        'color' => [
            'add'       => 'attributes/add_color_page',
            'edit'      => 'attributes/edit_color_page',
            'list'      => 'attributes/product_color_list',
            'listVar'   => 'all_product_color',
            'editVar'   => 'color_data_by_id',
            'id'        => 'color_id',
            'name'      => 'color',
            'slug'      => 'color_slug',
            'description' => 'color_description',
            'input'     => 'product_color_name',
            'updateInput' => 'color',
            'slugInput' => 'product_color_slug',
            'descInput' => 'product_color_description',
            'minLength' => 3,
            'success'   => 'Color Added',
            'updated'   => 'Color Updated',
            'listRoute' => 'product-color-list',
        ],
        'search' => [
            'add'       => 'attributes/add_search_keyword_page',
            'edit'      => 'attributes/edit_search_key_page',
            'list'      => 'attributes/product_search_key_list',
            'listVar'   => 'all_product_search_key',
            'editVar'   => 'search_key_data_by_id',
            'id'        => 'search_key_id',
            'name'      => 'search_key_name',
            'slug'      => 'search_key_slug',
            'description' => 'search_key_description',
            'input'     => 'product_search_key_name',
            'updateInput' => 'search_key',
            'slugInput' => 'product_search_key_slug',
            'descInput' => 'product_search_key_description',
            'minLength' => 3,
            'success'   => 'search_key Added',
            'updated'   => 'search_key Updated',
            'listRoute' => 'product-search_keywords-list',
        ],
    ];

    public function add_tags(): ResponseInterface|string
    {
        return $this->createAttribute('tags');
    }

    public function add_type(): ResponseInterface|string
    {
        return $this->createAttribute('type');
    }

    public function add_sizes(): ResponseInterface|string
    {
        return $this->createAttribute('size');
    }

    public function add_product_color(): ResponseInterface|string
    {
        return $this->createAttribute('color');
    }

    public function add_product_search_keywords(): ResponseInterface|string
    {
        return $this->createAttribute('search');
    }

    public function show_tags(): string
    {
        return $this->listAttributes('tags');
    }

    public function show_type(): string
    {
        return $this->listAttributes('type');
    }

    public function show_sizes(): string
    {
        return $this->listAttributes('size');
    }

    public function show_color_list(): string
    {
        return $this->listAttributes('color');
    }

    public function show_search_keywords_list(): string
    {
        return $this->listAttributes('search');
    }

    public function edit_product_tags(string $id): ResponseInterface|string
    {
        return $this->editAttribute('tags', $id);
    }

    public function edit_product_type(string $id): ResponseInterface|string
    {
        return $this->editAttribute('type', $id);
    }

    public function edit_product_sizes(string $id): ResponseInterface|string
    {
        return $this->editAttribute('size', $id);
    }

    public function edit_product_color(string $id): ResponseInterface|string
    {
        return $this->editAttribute('color', $id);
    }

    public function edit_product_search_keywords(string $id): ResponseInterface|string
    {
        return $this->editAttribute('search', $id);
    }

    public function update_product_tags(): ResponseInterface|string
    {
        return $this->updateAttribute('tags', 'hidden_product_tag_id');
    }

    public function update_product_type(): ResponseInterface|string
    {
        return $this->updateAttribute('type', 'hidden_product_type_id');
    }

    public function update_product_sizes(): ResponseInterface|string
    {
        return $this->updateAttribute('size', 'hidden_product_size_id');
    }

    public function update_product_color(): ResponseInterface|string
    {
        return $this->updateAttribute('color', 'hidden_product_color_id');
    }

    public function update_product_search_keywords(): ResponseInterface|string
    {
        return $this->updateAttribute('search', 'hidden_product_search_key_id');
    }

    public function delete_product_tags(string $id): ResponseInterface
    {
        return $this->deleteAttribute('tags', $id);
    }

    public function delete_product_type(string $id): ResponseInterface
    {
        return $this->deleteAttribute('type', $id);
    }

    public function delete_product_sizes(string $id): ResponseInterface
    {
        return $this->deleteAttribute('size', $id);
    }

    public function delete_product_color(string $id): ResponseInterface
    {
        return $this->deleteAttribute('color', $id);
    }

    public function delete_product_search_keywords(string $id): ResponseInterface
    {
        return $this->deleteAttribute('search', $id);
    }

    public function colorconvertvalue(): ResponseInterface
    {
        $updated = (new BackendAttributeModel())->normalizeColorImagePaths();
        service('session')->setFlashdata('flsh_msg', $updated . ' color image paths updated.');

        return redirect()->to(base_url('admin'));
    }

    public function product_attr_image(): ResponseInterface|string
    {
        $productId = $this->request->getGet('pro_id');
        if (! is_scalar($productId) || ! ctype_digit((string) $productId) || (int) $productId < 1) {
            return $this->response->setStatusCode(400)->setBody('Invalid product.');
        }

        return $this->renderAdminPage('product_attr_image', [
            'selected_attr_image' => (new BackendAttributeModel())->colorRelationsForProduct((int) $productId),
            'selected_attrimg'    => (new BackendAttributeModel())->attributeImagesForProduct((int) $productId),
        ]);
    }

    public function product_attr_image_save(): ResponseInterface
    {
        $colors = $this->request->getPost('product_color_name');
        if (! is_array($colors) || $colors === []) {
            return $this->response->setStatusCode(400)->setBody('Invalid product attribute data.');
        }

        $model        = new BackendAttributeModel();
        $imageRows    = [];
        $savedFiles   = [];
        $productId    = null;
        $files        = $this->request->getFiles();

        foreach (array_keys($colors) as $key) {
            $relationProductId = $this->request->getPost('attr_color_relation_product_id' . $key);
            $colorId           = $this->request->getPost('attr_relation_color_name' . $key);
            if (
                ! is_scalar($relationProductId) || ! ctype_digit((string) $relationProductId)
                || ! is_scalar($colorId) || ! ctype_digit((string) $colorId)
            ) {
                $this->removeAttributeImages($savedFiles);

                return $this->response->setStatusCode(400)->setBody('Invalid product attribute data.');
            }

            $relationProductId = (int) $relationProductId;
            $colorId           = (int) $colorId;
            if ($model->findColorRelation($relationProductId, $colorId) === null) {
                $this->removeAttributeImages($savedFiles);

                return $this->response->setStatusCode(400)->setBody('Product color not found.');
            }
            if ($productId !== null && $productId !== $relationProductId) {
                $this->removeAttributeImages($savedFiles);

                return $this->response->setStatusCode(400)->setBody('Images must belong to one product.');
            }
            $productId ??= $relationProductId;

            $field = 'product_color_name_image' . $key;
            $uploads = $files[$field] ?? [];
            if ($uploads instanceof UploadedFile) {
                $uploads = [$uploads];
            }
            if (! is_array($uploads)) {
                $this->removeAttributeImages($savedFiles);

                return $this->response->setStatusCode(400)->setBody('Invalid image upload.');
            }

            foreach ($uploads as $upload) {
                if (! $upload instanceof UploadedFile || $upload->getError() === UPLOAD_ERR_NO_FILE) {
                    continue;
                }

                if (! $this->isValidAttributeImage($upload)) {
                    $this->removeAttributeImages($savedFiles);
                    service('session')->setFlashdata('error', 'Upload a JPG, PNG, or GIF image.');

                    return $this->redirectToAttributeImages($relationProductId);
                }

                $fileName = WebpImage::filename($upload, $upload->getRandomName());
                $directory = FCPATH . 'uploads';
                try {
                    if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
                        throw new RuntimeException('Unable to create the product upload directory.');
                    }
                    $savedFiles[] = $fileName;
                    WebpImage::store($upload, $directory, $fileName);
                    $this->createAttributeImageVariants($directory, $fileName);
                } catch (RuntimeException | InvalidArgumentException $exception) {
                    if (is_file($directory . DIRECTORY_SEPARATOR . $fileName) && ! in_array($fileName, $savedFiles, true)) {
                        $savedFiles[] = $fileName;
                    }
                    $this->removeAttributeImages($savedFiles);
                    throw $exception;
                }
                $imageRows[] = [
                    'product_id'               => $relationProductId,
                    'attr_relation_color_name' => $colorId,
                    'image'                    => $fileName,
                ];
            }
        }

        if ($imageRows !== [] && ! $model->createAttributeImages($imageRows)) {
            $this->removeAttributeImages($savedFiles);
            throw new RuntimeException('Unable to save product attribute images.');
        }

        service('session')->setFlashdata('flsh_msg', 'Attr Image Added Successfully');

        return $this->redirectToAttributeImages($productId ?? 0);
    }

    public function product_attr_image_delete(): ResponseInterface
    {
        $imageId = $this->request->getGet('attrimg_id');
        if (! is_scalar($imageId) || ! ctype_digit((string) $imageId) || (int) $imageId < 1) {
            return $this->response->setStatusCode(400)->setBody('Invalid attribute image.');
        }

        $model = new BackendAttributeModel();
        $image = $model->findAttributeImage((int) $imageId);
        if ($image === null) {
            return $this->response->setStatusCode(404)->setBody('Attribute image not found.');
        }
        if (! $model->deleteAttributeImage((int) $imageId)) {
            throw new RuntimeException('Unable to delete the product attribute image.');
        }

        service('session')->setFlashdata('flsh_msg', 'Attr Image Deleted Successfully');

        return $this->redirectToAttributeImages((int) $image->product_id);
    }

    public function product_feature_image_delete(): ResponseInterface
    {
        $imageId = $this->request->getPost('ImgId');
        if (! is_scalar($imageId) || ! ctype_digit((string) $imageId) || (int) $imageId < 1) {
            return $this->response->setStatusCode(400)->setJSON(['success' => 0]);
        }

        if (! (new BackendAttributeModel())->deleteProductFeatureImage((int) $imageId)) {
            throw new RuntimeException('Unable to delete the product feature image.');
        }

        return $this->response->setJSON(['success' => 1]);
    }

    private function createAttribute(string $attribute): ResponseInterface|string
    {
        $config = self::ATTRIBUTE_VIEWS[$attribute];
        if (strtoupper($this->request->getMethod()) !== 'POST') {
            return $this->renderAdminPage($config['add']);
        }

        $input = $config['input'];
        $validation = service('validation');
        $validation->setRules([
            $input => 'required|min_length[' . $config['minLength'] . ']|max_length[255]',
        ]);
        if (! $validation->run($this->request->getPost())) {
            return $this->renderAdminPage($config['add']);
        }

        $name  = trim(strip_tags((string) $this->request->getPost($input)));
        $model = new BackendAttributeModel();
        if ($model->nameExists($attribute, $name)) {
            $validation->setError($input, 'The ' . $attribute . ' name is already in use.');

            return $this->renderAdminPage($config['add']);
        }

        if (! $model->create(
            $attribute,
            $this->storedName($attribute, $name),
            $this->slug($config['slugInput'], $name),
            strip_tags((string) $this->request->getPost($config['descInput']))
        )) {
            throw new RuntimeException('Unable to save the product attribute.');
        }

        service('session')->setFlashdata('success', $config['success']);

        return $this->renderAdminPage($config['add']);
    }

    private function listAttributes(string $attribute): string
    {
        $config = self::ATTRIBUTE_VIEWS[$attribute];

        return $this->renderAdminPage($config['list'], [
            $config['listVar'] => (new BackendAttributeModel())->all($attribute),
        ]);
    }

    private function editAttribute(string $attribute, string $id): ResponseInterface|string
    {
        $config = self::ATTRIBUTE_VIEWS[$attribute];
        if (! ctype_digit($id) || (int) $id < 1) {
            return $this->response->setStatusCode(404)->setBody('Product attribute not found.');
        }

        $record = (new BackendAttributeModel())->find($attribute, (int) $id);
        if ($record === null) {
            return $this->response->setStatusCode(404)->setBody('Product attribute not found.');
        }

        return $this->renderAdminPage($config['edit'], [$config['editVar'] => $record]);
    }

    private function updateAttribute(string $attribute, string $idField): ResponseInterface|string
    {
        $config = self::ATTRIBUTE_VIEWS[$attribute];
        $id     = $this->request->getPost($idField);
        if (! is_scalar($id) || ! ctype_digit((string) $id) || (int) $id < 1) {
            return $this->response->setStatusCode(400)->setBody('Invalid product attribute.');
        }

        $model  = new BackendAttributeModel();
        $record = $model->find($attribute, (int) $id);
        if ($record === null) {
            return $this->response->setStatusCode(404)->setBody('Product attribute not found.');
        }

        $input = $config['updateInput'] ?? $config['input'];
        $validation = service('validation');
        $validation->setRules([
            $input => 'required|min_length[' . $config['minLength'] . ']|max_length[255]',
        ]);
        if (! $validation->run($this->request->getPost())) {
            return $this->renderAdminPage($config['edit'], [$config['editVar'] => $record]);
        }

        $name = trim(strip_tags((string) $this->request->getPost($input)));
        if ($model->nameExists($attribute, $name, (int) $id)) {
            $validation->setError($input, 'The ' . $attribute . ' name is already in use.');

            return $this->renderAdminPage($config['edit'], [$config['editVar'] => $record]);
        }

        if (! $model->update(
            $attribute,
            (int) $id,
            $this->storedName($attribute, $name),
            $this->slug($config['slugInput'], $name),
            strip_tags((string) $this->request->getPost($config['descInput']))
        )) {
            throw new RuntimeException('Unable to update the product attribute.');
        }

        service('session')->setFlashdata('flsh_msg', $config['updated']);

        return redirect()->to(base_url($config['listRoute']));
    }

    private function deleteAttribute(string $attribute, string $id): ResponseInterface
    {
        $config = self::ATTRIBUTE_VIEWS[$attribute];
        if (! ctype_digit($id) || (int) $id < 1) {
            return $this->response->setStatusCode(404)->setBody('Product attribute not found.');
        }

        $model = new BackendAttributeModel();
        if ($model->find($attribute, (int) $id) === null) {
            return $this->response->setStatusCode(404)->setBody('Product attribute not found.');
        }
        if (! $model->delete($attribute, (int) $id)) {
            throw new RuntimeException('Unable to delete the product attribute.');
        }

        return redirect()->to(base_url($config['listRoute']));
    }

    private function storedName(string $attribute, string $name): string
    {
        return $attribute === 'color' ? ucfirst(trim(strtolower($name))) : $name;
    }

    private function slug(string $field, string $name): string
    {
        $value = trim(strip_tags((string) $this->request->getPost($field)));
        if ($value === '') {
            $value = $name;
        }

        return url_title(strtolower($value));
    }

    private function isValidAttributeImage(UploadedFile $file): bool
    {
        return $file->isValid()
            && ! $file->hasMoved()
            && in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/gif'], true);
    }

    private function createAttributeImageVariants(string $directory, string $fileName): void
    {
        $variants = [
            'large'     => [600, 600],
            'medium'    => [300, 300],
            'thumbnail' => [180, 180],
            'small'     => [100, 67],
        ];
        foreach ($variants as $variant => [$width, $height]) {
            $targetDirectory = $directory . DIRECTORY_SEPARATOR . $variant;
            if (! is_dir($targetDirectory) && ! mkdir($targetDirectory, 0755, true) && ! is_dir($targetDirectory)) {
                throw new RuntimeException('Unable to create product image variants directory.');
            }

            $saved = service('image')
                ->withFile($directory . DIRECTORY_SEPARATOR . $fileName)
                ->resize($width, $height, false)
                ->save($targetDirectory . DIRECTORY_SEPARATOR . $fileName);
            if (! $saved) {
                throw new RuntimeException('Unable to resize the product attribute image.');
            }
        }
    }

    /**
     * @param list<string> $fileNames
     */
    private function removeAttributeImages(array $fileNames): void
    {
        foreach ($fileNames as $fileName) {
            foreach (['', 'large', 'medium', 'thumbnail', 'small'] as $directory) {
                $path = FCPATH . 'uploads' . ($directory === '' ? '' : DIRECTORY_SEPARATOR . $directory)
                    . DIRECTORY_SEPARATOR . $fileName;
                if (is_file($path) && ! unlink($path)) {
                    log_message('warning', 'Unable to remove product attribute image {path}.', ['path' => $path]);
                }
            }
        }
    }

    private function redirectToAttributeImages(int $productId): ResponseInterface
    {
        return redirect()->to(admin_url('edit-product-attr-image?pro_id=' . $productId));
    }
}
