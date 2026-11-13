<?php

namespace App\Controllers\Backend;

use App\Libraries\WebpImage;
use App\Models\Backend\BackendBannerModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\Files\UploadedFile;
use RuntimeException;

class Baner extends AdminBaseController
{
    public function add_baner_form(): string
    {
        return $this->renderAdminPage('add_baner');
    }

    public function insert_baner(): ResponseInterface|string
    {
        $validation = service('validation');
        $validation->setRules([
            'baner_text' => 'permit_empty|max_length[5000]',
            'baner_link' => 'required|valid_url|max_length[2048]',
        ]);
        if (! $validation->run($this->request->getPost())) {
            return $this->add_baner_form();
        }

        $imagePath = $this->uploadBanner(true);
        if (! is_string($imagePath)) {
            return $this->add_baner_form();
        }

        $inserted = (new BackendBannerModel())->create([
            'baner_name' => $imagePath,
            'baner_link' => trim((string) $this->request->getPost('baner_link')),
            'baner_text' => (string) $this->request->getPost('baner_text'),
            'baner_page' => 1,
        ]);
        if (! $inserted) {
            $this->removeBannerFile($imagePath);
            throw new RuntimeException('Unable to save the banner.');
        }

        service('session')->setFlashdata('flsh_msg', 'Banner Added Successfully');

        return redirect()->to(admin_url('baner-list'));
    }

    public function show_baner_list(): string
    {
        return $this->renderAdminPage('baner_list', [
            'all_baner' => (new BackendBannerModel())->all(),
        ]);
    }

    public function edit_baner_form(string $bannerId): ResponseInterface|string
    {
        if (! ctype_digit($bannerId) || (int) $bannerId < 1) {
            return $this->response->setStatusCode(404)->setBody('Banner not found.');
        }

        $banner = (new BackendBannerModel())->find((int) $bannerId);
        if ($banner === null) {
            return $this->response->setStatusCode(404)->setBody('Banner not found.');
        }

        return $this->renderAdminPage('edit_baner', ['baner_details' => $banner]);
    }

    public function update_baner(): ResponseInterface|string
    {
        $bannerId = $this->request->getPost('baner_id');
        if (! is_scalar($bannerId) || ! ctype_digit((string) $bannerId) || (int) $bannerId < 1) {
            return $this->response->setStatusCode(400)->setBody('Invalid banner.');
        }

        $model = new BackendBannerModel();
        $banner = $model->find((int) $bannerId);
        if ($banner === null) {
            return $this->response->setStatusCode(404)->setBody('Banner not found.');
        }

        $validation = service('validation');
        $validation->setRules([
            'baner_text' => 'permit_empty|max_length[5000]',
            'baner_link' => 'required|valid_url|max_length[2048]',
        ]);
        if (! $validation->run($this->request->getPost())) {
            return $this->renderAdminPage('edit_baner', ['baner_details' => $banner]);
        }

        $uploadedImagePath = $this->uploadBanner(false);
        if ($uploadedImagePath === false) {
            return $this->renderAdminPage('edit_baner', ['baner_details' => $banner]);
        }

        $imagePath = $uploadedImagePath ?? (string) $banner->baner_name;
        $updated = $model->update((int) $bannerId, [
            'baner_name' => $imagePath,
            'baner_link' => trim((string) $this->request->getPost('baner_link')),
            'baner_text' => (string) $this->request->getPost('baner_text'),
            'baner_page' => 1,
        ]);
        if (! $updated) {
            if ($imagePath !== (string) $banner->baner_name) {
                $this->removeBannerFile($imagePath);
            }
            throw new RuntimeException('Unable to update the banner.');
        }

        service('session')->setFlashdata('flsh_msg', 'Banner Updated Successfully');

        return redirect()->to(admin_url('baner-list'));
    }

    public function delete(): ResponseInterface
    {
        $bannerId = $this->request->getGet('baner_id');
        if (! is_scalar($bannerId) || ! ctype_digit((string) $bannerId) || (int) $bannerId < 1) {
            return $this->response->setStatusCode(400)->setBody('Invalid banner.');
        }

        $model = new BackendBannerModel();
        $banner = $model->find((int) $bannerId);
        if ($banner === null) {
            return $this->response->setStatusCode(404)->setBody('Banner not found.');
        }
        if (! $model->delete((int) $bannerId)) {
            throw new RuntimeException('Unable to delete the banner.');
        }

        $this->removeBannerFile((string) $banner->baner_name);

        return redirect()->to(admin_url('baner-list'));
    }

    private function uploadBanner(bool $required): string|false|null
    {
        $file = $this->request->getFile('baner_name');
        if (! $file instanceof UploadedFile || $file->getError() === UPLOAD_ERR_NO_FILE) {
            if ($required) {
                service('session')->setFlashdata('error_image', 'Choose an image to upload.');
            }

            return null;
        }

        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (
            ! $file->isValid()
            || $file->hasMoved()
            || ! in_array($file->getMimeType(), $allowedMimeTypes, true)
            || $file->getSize() > 5 * 1024 * 1024
        ) {
            service('session')->setFlashdata('error_image', 'Upload a JPG, PNG, or GIF image up to 5 MB.');

            return false;
        }

        $directory = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'baner';
        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            throw new RuntimeException('Unable to create the banner upload directory.');
        }

        $fileName = WebpImage::filename($file, $file->getRandomName());
        WebpImage::store($file, $directory, $fileName);

        return 'uploads/baner/' . $fileName;
    }

    private function removeBannerFile(string $relativePath): void
    {
        if (preg_match('/\Auploads\/baner\/[A-Za-z0-9._-]+\z/', $relativePath) !== 1) {
            return;
        }

        $path = FCPATH . str_replace('/', DIRECTORY_SEPARATOR, $relativePath);
        if (is_file($path) && ! unlink($path)) {
            log_message('warning', 'Unable to remove banner image {path}.', ['path' => $relativePath]);
        }
    }
}
