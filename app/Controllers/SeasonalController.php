<?php

namespace App\Controllers;

use App\Libraries\LegacyCartAdapter;
use App\Libraries\LegacyDatabaseAdapter;
use App\Libraries\LegacyPaginationAdapter;
use App\Libraries\LegacySessionAdapter;
use App\Libraries\LegacyUriAdapter;
use App\Libraries\LegacyViewRenderer;
use App\Models\LegacyBlogModel;
use App\Models\LegacyCategoryModel;
use App\Models\LegacyProductModel;

abstract class SeasonalController extends BaseController
{
    protected function renderSeasonalPage(string $page, string $view): string
    {
        helper('legacy_storefront');
        $session = new LegacySessionAdapter(service('session'));
        $renderer = new LegacyViewRenderer('frontend', [
            'session'       => $session,
            'uri'           => new LegacyUriAdapter(service('uri')),
            'cart'          => new LegacyCartAdapter($session),
            'db'            => new LegacyDatabaseAdapter(db_connect()),
            'CategoryModel' => new LegacyCategoryModel(),
            'BlogModel'     => new LegacyBlogModel(),
            'ProductModel'  => new LegacyProductModel(),
            'pagination'    => new LegacyPaginationAdapter('', 0, 10, 0),
        ]);
        $output = '';

        foreach ([
            ['front/header', ['page' => $page]],
            ['front/category', []],
            [$view, []],
            ['front/footer', []],
        ] as [$viewName, $data]) {
            $output .= $renderer->render($viewName, $data);
        }

        return $output;
    }
}
