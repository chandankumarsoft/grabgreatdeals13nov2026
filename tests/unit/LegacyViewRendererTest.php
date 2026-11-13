<?php

use App\Libraries\LegacyViewRenderer;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class LegacyViewRendererTest extends CIUnitTestCase
{
    public function testRendersAnUnmodifiedLegacyView(): void
    {
        $renderer = new LegacyViewRenderer('frontend');
        $output   = $renderer->render('front/404');

        $this->assertStringContainsString('Go to Back', $output);
        $this->assertStringContainsString('href="', $output);
    }

    public function testRendersBackendViewsFromTheirOwnDirectory(): void
    {
        helper('form');
        $renderer = new LegacyViewRenderer('backend');
        $output   = $renderer->render('login');

        $this->assertStringContainsString('Grab Great Deals Admin Panel', $output);
        $this->assertStringContainsString('name="csrf_test_name"', $output);
        $this->assertStringContainsString('name="csrf-token"', $output);
    }

    public function testRendersProjectImagesUsingTheLocalBaseUrl(): void
    {
        $renderer = new LegacyViewRenderer('frontend');
        $output   = $renderer->render('front/warrantyinformation_page');

        $this->assertStringContainsString(base_url('assets/front/images/cart/warranty.jpg'), $output);
        $this->assertStringNotContainsString('https://www.seller.grabgreatdeals.com/', $output);
    }

    public function testLocalizesLegacyContentImageUrls(): void
    {
        helper('legacy_storefront');
        $content = '<img src="http://localhost:8080/ggd-ci4/uploads/item.webp">'
            . '<img src="https://127.0.0.1:8080/ggd-ci4/uploads/post.webp">'
            . '<img src="https://cdn.example.com/image.webp">';

        $localized = legacy_localize_content_urls($content);

        $this->assertStringContainsString(base_url('uploads/item.webp'), $localized);
        $this->assertStringContainsString(base_url('uploads/post.webp'), $localized);
        $this->assertStringContainsString('https://cdn.example.com/image.webp', $localized);
        $this->assertStringNotContainsString('localhost:8080', $localized);
        $this->assertStringNotContainsString('127.0.0.1', $localized);
    }

    public function testRejectsViewPathTraversal(): void
    {
        $renderer = new LegacyViewRenderer('frontend');

        $this->expectException(\InvalidArgumentException::class);
        $renderer->render('../README');
    }

    public function testProvidesAndRestoresLegacyServerHeaderDefaults(): void
    {
        $originalServer = $_SERVER;
        unset($_SERVER['HTTPS'], $_SERVER['HTTP_REFERER']);
        $_SERVER['HTTP_HOST']   = 'localhost';
        $_SERVER['REQUEST_URI'] = '/about-us';

        try {
            $renderer = new LegacyViewRenderer('frontend');
            $output   = $renderer->render('front/breadcrumbs');

            $this->assertStringContainsString('http://localhost/', $output);
            $this->assertArrayNotHasKey('HTTPS', $_SERVER);
            $this->assertArrayNotHasKey('HTTP_REFERER', $_SERVER);
        } finally {
            $_SERVER = $originalServer;
        }
    }
}
