<?php

namespace App\Controllers\Backend;

use App\Libraries\WebpImage;
use App\Models\Backend\BackendCategoryModel;
use App\Models\Backend\BackendProductModel;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\HTTP\ResponseInterface;
use InvalidArgumentException;
use RuntimeException;
use Throwable;

class Product extends AdminBaseController
{
    private const VIDEO_EXTENSIONS = ['avi', 'flv', 'wmv', 'mp4'];
    private const VIDEO_MIME_TYPES = [
        'video/avi',
        'video/mp4',
        'video/mpeg',
        'video/msvideo',
        'video/x-flv',
        'video/x-ms-asf',
        'video/x-msvideo',
        'video/x-ms-wmv',
        'application/octet-stream',
    ];

    public function add_product_form(): string
    {
        return $this->renderAdminPage('add_product', [
            'all_cat' => (new BackendCategoryModel())->get_all_category(),
        ]);
    }

    public function edit_product(): ResponseInterface|string
    {
        $productId = $this->request->getGet('pro_id');
        if (! is_scalar($productId) || ! ctype_digit((string) $productId) || (int) $productId < 1) {
            return $this->response->setStatusCode(400)->setBody('Invalid product.');
        }

        $model   = new BackendProductModel();
        $product = $model->edit_product_model((int) $productId);
        if ($product === null) {
            return $this->response->setStatusCode(404)->setBody('Product not found.');
        }

        return $this->renderAdminPage('edit_product', [
            'all_product'                => $product,
            'all_cat_of_product'         => $model->get_all_category_of_product((int) $productId),
            'all_pro_short_description'  => $model->get_all_pro_shortdesc((int) $productId),
        ]);
    }

    public function insert_product(): ResponseInterface|string
    {
        return $this->saveProduct();
    }

    public function update_product(): ResponseInterface|string
    {
        $productId = $this->positiveId($this->request->getPost('pro_id'));
        if ($productId === null) {
            return $this->response->setStatusCode(400)->setBody('Invalid product.');
        }

        return $this->saveProduct($productId);
    }

    private function saveProduct(?int $productId = null): ResponseInterface|string
    {
        $model = new BackendProductModel();
        $existingProduct = $productId === null ? null : $model->product($productId);
        if ($productId !== null && $existingProduct === null) {
            return $this->response->setStatusCode(404)->setBody('Product not found.');
        }

        $rules = [
            'pro_title' => 'required|min_length[5]|max_length[255]',
            'product_sku_name' => 'required|max_length[255]',
            'pro_price' => 'required',
            'pro_manufacturer_country_name' => 'required|max_length[255]',
        ];
        if ($existingProduct === null) {
            $rules['pro_image'] = 'uploaded[pro_image]|max_size[pro_image,20480]|is_image[pro_image]|mime_in[pro_image,image/jpg,image/jpeg,image/png,image/gif,image/webp]';
        }
        $validation = service('validation');
        $validation->setRules($rules);
        if (! $validation->run($this->request->getPost())) {
            return $this->renderProductForm($productId, $existingProduct);
        }

        $categoryIds = $this->positiveIds($this->request->getPost('category_multi_data'));
        $shortDescriptions = $this->stringList($this->request->getPost('featuredbullettext'));
        if ($categoryIds === [] || $shortDescriptions === []) {
            $validation->setError('category_multi_data', 'Select at least one product category.');
            $validation->setError('featuredbullettext', 'Enter at least one short description.');
            return $this->renderProductForm($productId, $existingProduct);
        }

        $data = $this->productData($productId);
        if (! is_numeric($data['pro_price']) || ($data['pro_offer_price'] !== '' && ! is_numeric($data['pro_offer_price']))) {
            $validation->setError('pro_price', 'Enter a valid product price.');
            return $this->renderProductForm($productId, $existingProduct);
        }

        $uploadedFiles = [];
        try {
            $mainImage = $this->storeProductImage($this->request->getFile('pro_image'), $uploadedFiles, $existingProduct?->pro_image);
            $data['pro_image'] = $mainImage;
            $featureImages = $this->storeMultipleProductImages($this->request->getFileMultiple('pro_image_features'), $uploadedFiles);
            $colors = $this->productColors($uploadedFiles);
            if ($existingProduct === null) {
                $data['added_user_id'] = (int) service('session')->get('userid');
                $productId = $model->createProduct(
                    $data,
                    $categoryIds,
                    $shortDescriptions,
                    $this->productSizes(),
                    $colors,
                    $this->stringList($this->request->getPost('product_tags')),
                    $this->stringList($this->request->getPost('product_search_keywords')),
                    $featureImages,
                );
                service('session')->setFlashdata('flsh_msg', 'New Product Added Successfully.');
            } else {
                $data['updated_user_id'] = (int) service('session')->get('userid');
                $model->updateProduct(
                    (int) $productId,
                    $data,
                    $categoryIds,
                    $shortDescriptions,
                    $this->productSizes(),
                    $colors,
                    $this->stringList($this->request->getPost('product_tags')),
                    $this->stringList($this->request->getPost('product_search_keywords')),
                    $featureImages,
                );
                service('session')->setFlashdata('update_pro_msg', 'Product Updated Successfully.');
            }
        } catch (InvalidArgumentException $exception) {
            $this->removeProductImages($uploadedFiles);
            $validation->setError('pro_image', $exception->getMessage());

            return $this->renderProductForm($productId, $existingProduct);
        } catch (Throwable $exception) {
            $this->removeProductImages($uploadedFiles);
            throw $exception;
        }

        return redirect()->to(base_url($existingProduct === null ? 'product-preview?pro_id=' . $productId : 'edit-product?pro_id=' . $productId));
    }

    /**
     * @return array<string, mixed>
     */
    private function productData(?int $productId): array
    {
        $posted = $this->request->getPost();
        $value = static fn (string $key): string => isset($posted[$key]) && is_scalar($posted[$key])
            ? trim(strip_tags((string) $posted[$key]))
            : '';
        $price = str_replace([',', '$', '@', '-', '_', ' '], '', $value('pro_price'));
        $offerPrice = str_replace([',', '$', '@', '-', '_', ' '], '', $value('pro_offer_price'));
        $flags = [
            'is_normal', 'is_featured', 'is_topseller', 'is_special', 'is_hot_sale',
            'is_recent', 'is_toprated', 'is_onsale', 'is_best_rate',
        ];
        $data = [
            'pro_title' => $value('pro_title'),
            'pro_title_slug' => url_title(strtolower($value('pro_title'))),
            'product_sku_name' => $value('product_sku_name'),
            'pro_reference_url' => $value('pro_reference_url'),
            'pro_manufacturer_country_name' => $value('pro_manufacturer_country_name'),
            'pro_desc' => (string) ($posted['pro_desc'] ?? ''),
            'pro_brand' => $this->positiveId($this->request->getPost('pro_brand')) ?? 0,
            'pro_shipping_charge' => $value('shipping_charge') === '' ? 1 : (int) $value('shipping_charge'),
            'pro_weight' => $value('product_weight'),
            'pro_length' => $value('product_length'),
            'pro_width' => $value('product_width'),
            'pro_height' => $value('product_height'),
            'pro_price' => $price,
            'pro_offer_price' => $offerPrice,
            'pro_quantity' => $this->positiveId($this->request->getPost('pro_quantity')) ?? 0,
            'pro_availability' => $this->positiveId($this->request->getPost('pro_availability')) ?? 1,
            'pro_status' => $this->positiveId($this->request->getPost('pro_status')) ?? 1,
        ];
        foreach ($flags as $flag) {
            $data[$flag] = $this->request->getPost($flag) === '1' ? 1 : 0;
        }

        return $data;
    }

    /**
     * @param list<string> $uploadedFiles
     */
    private function storeProductImage(?UploadedFile $file, array &$uploadedFiles, ?string $existing = null): string
    {
        if ($file === null || $file->getError() === UPLOAD_ERR_NO_FILE) {
            if ($existing !== null && $existing !== '') {
                return $existing;
            }
            throw new InvalidArgumentException('Please select a product image.');
        }
        $this->validateProductImage($file);
        $name = $this->productImageName($file);
        $uploadedFiles[] = $name;
        WebpImage::store($file, FCPATH . 'uploads', $name);
        $this->createProductImageVariants($name);

        return $name;
    }

    /**
     * @param list<UploadedFile> $files
     * @param list<string> $uploadedFiles
     * @return list<string>
     */
    private function storeMultipleProductImages(array $files, array &$uploadedFiles): array
    {
        $stored = [];
        foreach ($files as $file) {
            if ($file->getError() === UPLOAD_ERR_NO_FILE) {
                continue;
            }
            $this->validateProductImage($file);
            $name = $this->productImageName($file);
            $uploadedFiles[] = $name;
            WebpImage::store($file, FCPATH . 'uploads', $name);
            $this->createProductImageVariants($name);
            $stored[] = $name;
        }

        return $stored;
    }

    private function validateProductImage(UploadedFile $file): void
    {
        if (
            ! $file->isValid()
            || $file->hasMoved()
            || $file->getSize() > 20 * 1024 * 1024
            || ! in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/gif', 'image/webp'], true)
        ) {
            throw new InvalidArgumentException('Upload a JPG, PNG, GIF, or WEBP product image up to 20 MB.');
        }
    }

    private function productImageName(UploadedFile $file): string
    {
        $extension = strtolower($file->getClientExtension());
        if (! in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
            throw new InvalidArgumentException('Unsupported product image format.');
        }

        $name = date('ymdHis') . bin2hex(random_bytes(6)) . '.' . $extension;

        return WebpImage::filename($file, $name);
    }

    private function createProductImageVariants(string $name): void
    {
        $source = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . $name;
        foreach (['xlarge' => [1024, 768], 'large' => [800, 800], 'medium' => [576, 486], 'thumbnail' => [180, 180]] as $folder => [$width, $height]) {
            $directory = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . $folder;
            if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
                throw new RuntimeException('Unable to create product image variant directory.');
            }
            service('image')->withFile($source)->resize($width, $height, false)->save($directory . DIRECTORY_SEPARATOR . $name);
        }
    }

    /**
     * @param list<string> $uploadedFiles
     * @return list<array{name: string, image: string, regular_price: string, sale_price: string, quantity: int}>
     */
    private function productColors(array &$uploadedFiles): array
    {
        $names = $this->arrayValue('product_color_name');
        $regularPrices = $this->arrayValue('product_color_regular_price');
        $salePrices = $this->arrayValue('product_color_sale_price');
        $quantities = $this->arrayValue('product_color_quantity');
        $images = $this->request->getFileMultiple('product_color_name_image') ?? [];
        $oldImages = $this->arrayValue('product_color_name_image_hidden');
        $colors = [];

        foreach ($names as $index => $name) {
            $name = trim(strip_tags((string) $name));
            if ($name === '') {
                continue;
            }
            $imageName = isset($oldImages[$index]) && is_scalar($oldImages[$index]) ? basename((string) $oldImages[$index]) : '';
            $image = $images[$index] ?? null;
            if ($image instanceof UploadedFile && $image->getError() !== UPLOAD_ERR_NO_FILE) {
                $this->validateProductImage($image);
                $imageName = $this->productImageName($image);
                $uploadedFiles[] = $imageName;
                WebpImage::store($image, FCPATH . 'uploads', $imageName);
                $this->createProductImageVariants($imageName);
            }
            $colors[] = [
                'name' => $name,
                'image' => $imageName,
                'regular_price' => $this->arrayScalar($regularPrices, $index),
                'sale_price' => $this->arrayScalar($salePrices, $index),
                'quantity' => max(0, (int) $this->arrayScalar($quantities, $index)),
            ];
        }

        return $colors;
    }

    /**
     * @return list<array{size_id: int, regular_price: string, sale_price: string, quantity: int}>
     */
    private function productSizes(): array
    {
        $ids = $this->arrayValue('product_size_name');
        $regularPrices = $this->arrayValue('product_attr_size_regular_price');
        $salePrices = $this->arrayValue('product_attr_size_sale_price');
        $quantities = $this->arrayValue('product_attr_size_quantity');
        $sizes = [];

        foreach ($ids as $index => $id) {
            $sizes[] = [
                'size_id' => $this->positiveId($id) ?? 0,
                'regular_price' => $this->arrayScalar($regularPrices, $index),
                'sale_price' => $this->arrayScalar($salePrices, $index),
                'quantity' => max(0, (int) $this->arrayScalar($quantities, $index)),
            ];
        }

        return $sizes;
    }

    private function renderProductForm(?int $productId, ?object $product): string
    {
        $categoryModel = new BackendCategoryModel();
        if ($product === null) {
            return $this->renderAdminPage('add_product', ['all_cat' => $categoryModel->get_all_category()]);
        }
        $model = new BackendProductModel();

        return $this->renderAdminPage('edit_product', [
            'all_product' => $product,
            'all_cat_of_product' => $model->get_all_category_of_product((int) $productId),
            'all_pro_short_description' => $model->get_all_pro_shortdesc((int) $productId),
        ]);
    }

    /**
     * @param list<string> $files
     */
    private function removeProductImages(array $files): void
    {
        foreach ($files as $name) {
            foreach (['', 'xlarge' . DIRECTORY_SEPARATOR, 'large' . DIRECTORY_SEPARATOR, 'medium' . DIRECTORY_SEPARATOR, 'thumbnail' . DIRECTORY_SEPARATOR] as $variant) {
                $path = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . $variant . $name;
                if (is_file($path) && ! unlink($path)) {
                    log_message('warning', 'Unable to remove failed product upload {path}.', ['path' => $path]);
                }
            }
        }
    }

    public function delete_product(string $productId): ResponseInterface
    {
        if (! ctype_digit($productId) || (int) $productId < 1) {
            return $this->response->setStatusCode(404)->setBody('Product not found.');
        }

        $model = new BackendProductModel();
        $product = $model->product((int) $productId);
        if ($product === null) {
            return $this->response->setStatusCode(404)->setBody('Product not found.');
        }
        $model->deleteProduct((int) $productId);
        $this->removeProductImages($this->productImageNames($product));
        service('session')->setFlashdata('flsh_msg', 'Product Deleted Successfully');

        return redirect()->to(admin_url('product-list'));
    }

    public function delete_multi_product(): ResponseInterface
    {
        $productIds = $this->positiveIds($this->request->getPost('multi_pro_id'));
        if ($productIds === []) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Select at least one product.']);
        }

        $model = new BackendProductModel();
        foreach ($productIds as $productId) {
            $product = $model->product($productId);
            if ($product === null) {
                continue;
            }
            $model->deleteProduct($productId);
            $this->removeProductImages($this->productImageNames($product));
        }

        service('session')->setFlashdata('flsh_msg', 'Product Deleted Successfully');

        return $this->response->setJSON(['success' => 'successfully', 'status_code' => 1]);
    }

    public function add_product_to_upsell(): ResponseInterface|string
    {
        $referenceProductId = $this->positiveId($this->request->getGet('pro_id'));
        if ($referenceProductId === null) {
            return $this->response->setStatusCode(400)->setBody('Invalid product.');
        }

        $model = new BackendProductModel();
        if ($model->product($referenceProductId) === null) {
            return $this->response->setStatusCode(404)->setBody('Product not found.');
        }
        $upsellProduct = $model->upsellProduct($referenceProductId);

        return $this->renderAdminPage('upsell/add_product_to_upsell', [
            'all_product_data' => $model->upsellCandidates($referenceProductId),
            'prev_added_data' => $upsellProduct ?? (object) [],
            'reference_pro_id' => $referenceProductId,
        ]);
    }

    public function add_product_to_upsell_insert(): ResponseInterface
    {
        $referenceProductId = $this->positiveId($this->request->getPost('reference_pro_id'));
        $upsellProductId = $this->positiveId($this->request->getPost('upsell_pro_id'));
        $model = new BackendProductModel();

        if (
            $referenceProductId === null
            || $upsellProductId === null
            || $referenceProductId === $upsellProductId
            || $model->product($referenceProductId) === null
            || $model->product($upsellProductId) === null
        ) {
            service('session')->setFlashdata('upsell_error', 'Select two different existing products.');

            return redirect()->to(admin_url('add-product-to-upsell?pro_id=' . ($referenceProductId ?? '')));
        }

        if (! $model->addUpsellProduct($upsellProductId, $referenceProductId)) {
            service('session')->setFlashdata('upsell_error', 'Unable to add the upsell product.');

            return redirect()->to(admin_url('add-product-to-upsell?pro_id=' . $referenceProductId));
        }

        service('session')->setFlashdata('flsh_msg', 'New Upsell Product Added Successfully.');

        return redirect()->to(admin_url('add-product-to-upsell?pro_id=' . $referenceProductId));
    }

    public function add_product_to_upsell_delete(string $referenceProductId): ResponseInterface
    {
        $id = $this->positiveId($referenceProductId);
        if ($id === null) {
            return $this->response->setStatusCode(400)->setBody('Invalid product.');
        }

        (new BackendProductModel())->deleteUpsellProducts($id);
        service('session')->setFlashdata('flsh_msg', 'Upsell Product Deleted Successfully');

        return redirect()->to(admin_url('add-product-to-upsell?pro_id=' . $id));
    }

    /**
     * @return list<string>
     */
    private function productImageNames(object $product): array
    {
        $images = [];
        foreach (['pro_image', 'product_image_feature1', 'product_image_feature2', 'product_image_feature3', 'product_image_feature4', 'product_image_feature5', 'product_image_feature6'] as $field) {
            $name = $product->{$field} ?? '';
            if (is_string($name) && preg_match('/\A[A-Za-z0-9._-]+\.(?:jpe?g|png|gif|webp)\z/i', $name) === 1) {
                $images[] = $name;
            }
        }

        return array_values(array_unique($images));
    }

    private function positiveId(mixed $value): ?int
    {
        if (! is_scalar($value) || ! ctype_digit((string) $value) || (int) $value < 1) {
            return null;
        }

        return (int) $value;
    }

    /**
     * @return list<int>
     */
    private function positiveIds(mixed $values): array
    {
        if (! is_array($values)) {
            $values = is_scalar($values) ? [$values] : [];
        }
        $ids = [];
        foreach ($values as $value) {
            $id = $this->positiveId($value);
            if ($id !== null) {
                $ids[] = $id;
            }
        }

        return array_values(array_unique($ids));
    }

    /**
     * @return list<mixed>
     */
    private function arrayValue(string $key): array
    {
        $value = $this->request->getPost($key);

        return is_array($value) ? array_values($value) : [];
    }

    /**
     * @param list<mixed> $values
     */
    private function arrayScalar(array $values, int $index): string
    {
        return isset($values[$index]) && is_scalar($values[$index])
            ? trim((string) $values[$index])
            : '';
    }

    /**
     * @return list<string>
     */
    private function stringList(mixed $value): array
    {
        if (is_string($value)) {
            $value = explode(',', $value);
        } elseif (! is_array($value)) {
            return [];
        }
        $items = [];
        foreach ($value as $item) {
            if (! is_scalar($item)) {
                continue;
            }
            $item = trim(strip_tags((string) $item));
            if ($item !== '') {
                $items[] = $item;
            }
        }

        return array_values(array_unique($items));
    }

    public function product_preview(): ResponseInterface|string
    {
        $productId = $this->request->getGet('pro_id');
        if (! is_scalar($productId) || ! ctype_digit((string) $productId) || (int) $productId < 1) {
            return $this->response->setStatusCode(400)->setBody('Invalid product.');
        }

        $product = (new BackendProductModel())->product((int) $productId);
        if ($product === null) {
            return $this->response->setStatusCode(404)->setBody('Product not found.');
        }

        return $this->renderAdminPage('product_preview', ['product' => $product]);
    }

    public function add_product_video_form(): string
    {
        return $this->renderAdminPage('add_product_video_page');
    }

    public function save_product_video(): ResponseInterface|string
    {
        $roleResponse = $this->requireVideoRole();
        if ($roleResponse !== null) {
            return $roleResponse;
        }

        $sku = $this->validatedSku();
        if ($sku === null) {
            return $this->add_product_video_form();
        }

        $model   = new BackendProductModel();
        $product = $model->findBySku($sku);
        if ($product === null) {
            return $this->renderAdminPage('add_product_video_page', [
                'form_data_error' => 'This SKU does not exist.',
            ]);
        }

        $video = $this->uploadVideo($sku);
        if ($video === null) {
            return $this->renderAdminPage('add_product_video_page', [
                'form_data_error' => 'Please select a supported video file (AVI, FLV, WMV, or MP4).',
            ]);
        }

        if (! $model->updateVideo((int) $product->pro_id, $video)) {
            $this->removeVideo($video);
            throw new RuntimeException('Unable to save the product video.');
        }

        service('session')->setFlashdata('flsh_msg', 'New Product Video Uploaded Successfully.');

        return redirect()->to(admin_url('video-list'));
    }

    public function video_list(): string
    {
        return $this->renderAdminPage('product_video_list', [
            'all_video' => (new BackendProductModel())->videos(),
        ]);
    }

    public function video_edit_product(string $productId): ResponseInterface|string
    {
        $roleResponse = $this->requireVideoRole();
        if ($roleResponse !== null) {
            return $roleResponse;
        }

        if (! ctype_digit($productId) || (int) $productId < 1) {
            return $this->response->setStatusCode(404)->setBody('Product not found.');
        }

        $product = (new BackendProductModel())->findVideoProduct((int) $productId);
        if ($product === null) {
            return $this->response->setStatusCode(404)->setBody('Product not found.');
        }

        return $this->renderAdminPage('edit_product_video_page', ['all_data' => $product]);
    }

    public function update_product_video(): ResponseInterface|string
    {
        $roleResponse = $this->requireVideoRole();
        if ($roleResponse !== null) {
            return $roleResponse;
        }

        $sku = $this->validatedSku();
        if ($sku === null) {
            return $this->renderAdminPage('edit_product_video_page', [
                'all_data' => (object) ['product_sku_name' => (string) $this->request->getPost('product_sku_name')],
            ]);
        }

        $model   = new BackendProductModel();
        $product = $model->findBySku($sku);
        if ($product === null) {
            return $this->renderAdminPage('edit_product_video_page', [
                'all_data' => (object) ['product_sku_name' => $sku],
                'form_data_error' => 'This SKU does not exist.',
            ]);
        }

        $video = $this->uploadVideo($sku);
        if ($video === null) {
            return $this->renderAdminPage('edit_product_video_page', [
                'all_data' => $product,
                'form_data_error' => 'Please select a supported video file (AVI, FLV, WMV, or MP4).',
            ]);
        }

        if (! $model->updateVideo((int) $product->pro_id, $video)) {
            $this->removeVideo($video);
            throw new RuntimeException('Unable to update the product video.');
        }
        $this->removeVideo((string) $product->product_video_name);

        service('session')->setFlashdata('flsh_msg', 'New Product Video Uploaded Successfully.');

        return redirect()->to(admin_url('video-list'));
    }

    public function video_delete(string $productId): ResponseInterface
    {
        $roleResponse = $this->requireVideoRole();
        if ($roleResponse !== null) {
            return $roleResponse;
        }

        if (! ctype_digit($productId) || (int) $productId < 1) {
            return $this->response->setStatusCode(404)->setBody('Product not found.');
        }

        $model   = new BackendProductModel();
        $product = $model->findVideoProduct((int) $productId);
        if ($product === null) {
            return $this->response->setStatusCode(404)->setBody('Product not found.');
        }
        if (! $model->updateVideo((int) $productId, null)) {
            throw new RuntimeException('Unable to remove the product video.');
        }
        $this->removeVideo((string) $product->product_video_name);

        service('session')->setFlashdata('flsh_msg', 'Product Video Deleted Successfully.');

        return redirect()->to(admin_url('video-list'));
    }

    private function validatedSku(): ?string
    {
        $validation = service('validation');
        $validation->setRules([
            'product_sku_name' => 'required|max_length[255]',
        ]);
        if (! $validation->run($this->request->getPost())) {
            return null;
        }

        return trim(strip_tags((string) $this->request->getPost('product_sku_name')));
    }

    private function uploadVideo(string $sku): ?string
    {
        $file = $this->request->getFile('video');
        if (! $file instanceof UploadedFile || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        $extension = strtolower($file->getClientExtension());
        if (
            ! $file->isValid()
            || $file->hasMoved()
            || ! in_array($extension, self::VIDEO_EXTENSIONS, true)
            || ! in_array($file->getMimeType(), self::VIDEO_MIME_TYPES, true)
            || $file->getSize() > 200 * 1024 * 1024
        ) {
            service('session')->setFlashdata('error', 'Upload an AVI, FLV, WMV, or MP4 file up to 200 MB.');

            return null;
        }

        $directory = FCPATH . 'video';
        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            throw new RuntimeException('Unable to create the product video directory.');
        }

        helper('text');
        $fileName = url_title(strtolower($sku)) . '-' . date('ymdHis') . '-' . bin2hex(random_bytes(3)) . '.' . $extension;
        if (! $file->move($directory, $fileName)) {
            throw new RuntimeException('Unable to save the product video.');
        }

        return $fileName;
    }

    private function removeVideo(string $fileName): void
    {
        if (preg_match('/\A[A-Za-z0-9._-]+\.(?:avi|flv|wmv|mp4)\z/i', $fileName) !== 1) {
            return;
        }

        $path = FCPATH . 'video' . DIRECTORY_SEPARATOR . $fileName;
        if (is_file($path) && ! unlink($path)) {
            log_message('warning', 'Unable to remove product video {path}.', ['path' => $fileName]);
        }
    }

    private function requireVideoRole(): ?ResponseInterface
    {
        if (in_array((int) service('session')->get('userrole'), [1, 4, 5], true)) {
            return null;
        }

        return $this->response->setStatusCode(403)->setBody('You are not authorized to manage product videos.');
    }
}
