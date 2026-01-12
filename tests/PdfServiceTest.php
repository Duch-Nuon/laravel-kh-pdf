<?php

namespace KhmerPdf\LaravelKhPdf\Tests;

use Illuminate\Support\Facades\Storage;
use KhmerPdf\LaravelKhPdf\Commands\PdfDemoCommand;
use KhmerPdf\LaravelKhPdf\Facades\PdfKh;
use Orchestra\Testbench\TestCase;

class PdfServiceTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \KhmerPdf\LaravelKhPdf\Providers\PdfKhServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'PdfKh' => PdfKh::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    /** @test */
    public function service_provider_is_loaded()
    {
        $this->assertTrue(class_exists(PdfKh::class));
    }

    /** @test */
    public function facade_is_available()
    {
        $this->assertTrue(class_exists(PdfKh::class));
    }

    /** @test */
    public function can_load_html()
    {
        $html = '<html><body><p>Test</p></body></html>';
        $pdf = PdfKh::loadHtml($html);
        $pdf = (array)$pdf;
        $this->assertEquals($html, $pdf["\0*\0htmlContent"]);
    }

    /** @test */
    public function can_add_mpdf_config()
    {
        $html = '<html><body><p>Test</p></body></html>';
        $pdf = PdfKh::loadHtml($html)->addMPdfConfig(['format' => 'A4']);
        $pdf = (array)$pdf;
        $this->assertEquals('A4', $pdf["\0*\0config"]['format']);           
        $this->assertEquals($html, $pdf["\0*\0htmlContent"]);

    }

    /** @test */
    public function can_save_pdf()
    {
        $html = '<html><body><p>Test</p></body></html>';
        $path = PdfKh::loadHtml($html)->save('test.pdf', 'public');        
        $this->assertNotNull($path);
    }

    /** @test */
    public function can_add_watermark_text()
    {
        $html = '<html><body><p>Test</p></body></html>';
        $pdf = PdfKh::loadHtml($html)->watermarkText('Confidential', 0.2);        
        $this->assertNotNull($pdf);
    }

    /** @test */
    public function can_add_watermark_image()
    {
        $html = '<html><body><p>Test</p></body></html>';
        $pdf = PdfKh::loadHtml($html)->watermarkImage('path/to/image.png');
        
        $this->assertNotNull($pdf);
    }

    /** @test */
    public function can_write_barcode()
    {
        $html = '<html><body><p>Test</p></body></html>';
        $pdf = PdfKh::loadHtml($html)->writeBarcode('123456789', 50, 100);
        
        $this->assertNotNull($pdf);
    }

    /** @test */
    public function can_chain_methods()
    {
        $html = '<html><body><p>Test</p></body></html>';
        $pdf = PdfKh::loadHtml($html)
            ->addMPdfConfig(['format' => 'A4'])
            ->watermarkText('Draft', 0.1);
                    
        $this->assertNotNull($pdf);
    }
}