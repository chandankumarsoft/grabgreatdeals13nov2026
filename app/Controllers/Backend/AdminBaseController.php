<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Libraries\LegacyDatabaseAdapter;
use App\Libraries\LegacyInputAdapter;
use App\Libraries\LegacySessionAdapter;
use App\Libraries\LegacyViewRenderer;
use App\Models\Backend\BackendBlogModel;
use App\Models\Backend\BackendCategoryModel;
use App\Models\Backend\BackendProductModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class AdminBaseController extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper(['url', 'legacy_storefront', 'form']);
    }

    protected function renderAdminPage(string $contentView, array $contentData = []): string
    {
        $renderer = $this->backendRenderer();

        return $renderer->render('adminpanel', [
            'main_content' => $renderer->render($contentView, $contentData),
        ]);
    }

    protected function backendRenderer(): LegacyViewRenderer
    {
        helper('form');
        helper('legacy_storefront');

        $session = new LegacySessionAdapter(service('session'));

        return new LegacyViewRenderer('backend', [
            'session'       => $session,
            'db'            => new LegacyDatabaseAdapter(db_connect()),
            'input'         => new LegacyInputAdapter($this->request),
            'BlogModel'     => new BackendBlogModel(),
            'CategoryModel' => new BackendCategoryModel(),
            'ProductModel'  => new BackendProductModel(),
        ]);
    }
}
