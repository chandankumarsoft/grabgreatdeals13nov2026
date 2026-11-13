<?php

namespace App\Controllers\Backend;

use App\Libraries\WebpImage;
use App\Models\Backend\BackendBlogModel;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\HTTP\ResponseInterface;
use InvalidArgumentException;
use RuntimeException;
use Throwable;

class BlogAdmin extends AdminBaseController
{
    public function index(): string
    {
        return $this->renderAdminPage('add_blog');
    }

    public function show_blog_list(): string
    {
        return $this->renderAdminPage('blog_list', [
            'all_blog' => (new BackendBlogModel())->blogs(),
        ]);
    }

    public function edit_blog_form(): ResponseInterface|string
    {
        $blogId = $this->positiveId($this->request->getGet('blog_id'));
        $blog = $blogId === null ? null : (new BackendBlogModel())->blog($blogId);
        if ($blog === null) {
            return $this->response->setStatusCode(404)->setBody('Blog post not found.');
        }

        return $this->renderAdminPage('edit_blog', ['blog_details' => $blog]);
    }

    public function insert_blog_data(): ResponseInterface|string
    {
        $model = new BackendBlogModel();
        $tagIds = $this->postedIds('blogtags');
        $categoryIds = $this->postedIds('blogcategories');
        $validation = $this->blogValidation(true);
        $relationsAreValid = $tagIds !== null
            && $tagIds !== []
            && $categoryIds !== null
            && $categoryIds !== []
            && $model->hasBlogRelations($tagIds, $categoryIds);
        if (
            ! $validation->run($this->request->getPost())
            || ! $relationsAreValid
        ) {
            if (! $relationsAreValid) {
                $validation->setError('blogcategories', 'Select at least one valid blog tag and category.');
            }

            return $this->renderAdminPage('add_blog');
        }

        $uploadedFiles = [];
        try {
            $image = $this->storeBlogImage($this->request->getFile('blogfeatureimage'), $uploadedFiles, true);
            $blogId = $model->createBlog($this->blogData($image), $tagIds, $categoryIds);
        } catch (InvalidArgumentException $exception) {
            $this->removeBlogImages($uploadedFiles);
            $validation->setError('blogfeatureimage', $exception->getMessage());

            return $this->renderAdminPage('add_blog');
        } catch (Throwable $exception) {
            $this->removeBlogImages($uploadedFiles);
            throw $exception;
        }

        service('session')->setFlashdata('flsh_msg', 'Blog Added Successfully');

        return redirect()->to(admin_url('edit-blog?blog_id=' . $blogId));
    }

    public function update_blog(): ResponseInterface|string
    {
        $model = new BackendBlogModel();
        $blogId = $this->positiveId($this->request->getPost('blog_id'));
        $existingBlog = $blogId === null ? null : $model->blog($blogId);
        if ($blogId === null || $existingBlog === null) {
            return $this->response->setStatusCode(404)->setBody('Blog post not found.');
        }

        $tagIds = $this->postedIds('blogtags');
        $categoryIds = $this->postedIds('blogcategories');
        $validation = $this->blogValidation(false);
        $relationsAreValid = $tagIds !== null
            && $tagIds !== []
            && $categoryIds !== null
            && $categoryIds !== []
            && $model->hasBlogRelations($tagIds, $categoryIds);
        if (
            ! $validation->run($this->request->getPost())
            || ! $relationsAreValid
        ) {
            if (! $relationsAreValid) {
                $validation->setError('blogcategories', 'Select at least one valid blog tag and category.');
            }

            return $this->renderAdminPage('edit_blog', ['blog_details' => $existingBlog]);
        }

        $uploadedFiles = [];
        try {
            $image = $this->storeBlogImage($this->request->getFile('blogfeatureimage'), $uploadedFiles, false, (string) $existingBlog->image);
            $model->updateBlog($blogId, $this->blogData($image), $tagIds, $categoryIds);
        } catch (InvalidArgumentException $exception) {
            $this->removeBlogImages($uploadedFiles);
            $validation->setError('blogfeatureimage', $exception->getMessage());

            return $this->renderAdminPage('edit_blog', ['blog_details' => $existingBlog]);
        } catch (Throwable $exception) {
            $this->removeBlogImages($uploadedFiles);
            throw $exception;
        }

        service('session')->setFlashdata('flsh_msg', 'Blog Updated Successfully');

        return redirect()->to(admin_url('blog-list'));
    }

    public function delete_blog(): ResponseInterface
    {
        $blogId = $this->positiveId($this->request->getGet('blog_id'));
        $model = new BackendBlogModel();
        if ($blogId === null || $model->blog($blogId) === null) {
            return $this->response->setStatusCode(404)->setBody('Blog post not found.');
        }

        $model->deleteBlog($blogId);
        service('session')->setFlashdata('flsh_msg', 'Blog Delete Successfully');

        return redirect()->to(admin_url('blog-list'));
    }

    public function addtagsofblog(): ResponseInterface
    {
        $name = $this->request->getPost('addnewtagsvalue');
        $name = is_string($name) ? trim(strip_tags($name)) : '';
        if ($name === '' || mb_strlen($name) > 255) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Enter a tag name.']);
        }

        $added = (new BackendBlogModel())->addTag($name);

        return $this->response->setJSON($added
            ? ['datainserted' => 'Tag Added Successfully']
            : ['exist' => 'Tag is Already Exist']);
    }

    public function fetchalltags(): ResponseInterface
    {
        return $this->response->setJSON((new BackendBlogModel())->fetch_all_tags());
    }

    public function addcategoryofblog(): ResponseInterface
    {
        $name = $this->request->getPost('addnewcategoryvalue');
        $name = is_string($name) ? trim(strip_tags($name)) : '';
        if ($name === '' || mb_strlen($name) > 255) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Enter a category name.']);
        }

        $added = (new BackendBlogModel())->addCategory($name);

        return $this->response->setJSON($added
            ? ['datainserted' => 'Category Added Successfully']
            : ['exist' => 'Category Name is Already Exist']);
    }

    public function fetchallcategory(): ResponseInterface
    {
        return $this->response->setJSON((new BackendBlogModel())->fetch_all_category());
    }

    private function blogValidation(bool $requiresImage): \CodeIgniter\Validation\Validation
    {
        $validation = service('validation');
        $rules = [
            'blog_title' => 'required|max_length[255]',
            'blog_desc' => 'required',
        ];
        if ($requiresImage) {
            $rules['blogfeatureimage'] = 'uploaded[blogfeatureimage]|max_size[blogfeatureimage,20480]|is_image[blogfeatureimage]|mime_in[blogfeatureimage,image/jpg,image/jpeg,image/png,image/gif,image/webp]';
        }
        $validation->setRules($rules);

        return $validation;
    }

    /**
     * @param list<int> $tagIds
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

    private function blogData(string $image): array
    {
        helper('text');
        $title = trim((string) $this->request->getPost('blog_title'));

        return [
            'user_id' => (int) service('session')->get('userid'),
            'title' => $title,
            'slug' => url_title($title),
            'image' => $image,
            'content' => (string) $this->request->getPost('blog_desc'),
        ];
    }

    /**
     * @param list<string> $uploadedFiles
     */
    private function storeBlogImage(?UploadedFile $file, array &$uploadedFiles, bool $required, string $existing = ''): string
    {
        if ($file === null || $file->getError() === UPLOAD_ERR_NO_FILE) {
            if (! $required && $existing !== '') {
                return $existing;
            }
            throw new InvalidArgumentException('Please select a blog feature image.');
        }
        if (! $file->isValid() || $file->hasMoved() || $file->getSize() > 20 * 1024 * 1024) {
            throw new InvalidArgumentException('Upload a valid blog image up to 20 MB.');
        }

        if (! in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/gif', 'image/webp'], true)) {
            throw new InvalidArgumentException('Upload a JPG, PNG, GIF, or WEBP blog image.');
        }

        $extension = strtolower((string) $file->guessExtension());
        if (! in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
            throw new InvalidArgumentException('Upload a JPG, PNG, GIF, or WEBP blog image.');
        }

        $directory = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'blog';
        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            throw new RuntimeException('Unable to create the blog upload directory.');
        }
        $name = WebpImage::filename($file, date('ymdHis') . bin2hex(random_bytes(6)) . '.' . $extension);
        $uploadedFiles[] = $name;
        WebpImage::store($file, $directory, $name);

        return 'uploads/blog/' . $name;
    }

    /**
     * @param list<string> $names
     */
    private function removeBlogImages(array $names): void
    {
        foreach ($names as $name) {
            $path = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'blog' . DIRECTORY_SEPARATOR . basename($name);
            if (is_file($path) && ! unlink($path)) {
                log_message('warning', 'Unable to remove failed blog upload {path}.', ['path' => $path]);
            }
        }
    }

    private function positiveId(mixed $value): ?int
    {
        if (! is_scalar($value) || ! ctype_digit((string) $value) || (int) $value < 1) {
            return null;
        }

        return (int) $value;
    }
}
