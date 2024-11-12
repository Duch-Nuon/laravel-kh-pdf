<?php

namespace KhmerPdf\LaravelKhPdf\Traits;
use Illuminate\Support\Facades\Storage;

trait PdfKhTrait 
{
    protected $htmlContent;
    protected $filename;
    protected $pdf;

    protected $config = [];

     /**
     * Initialize mPDF instance with the stored configuration and HTML content.
     */
    protected function initMPdf()
    {
        if(!$this->pdf)
        {
            $this->pdf = app()->makeWith('mPdf', $this->config);
            $this->pdf->WriteHTML($this->htmlContent);
        }

        return $this->pdf;
    }

    /**
     * Load HTML content for PDF generation
     */
    public function loadHtml(string $html)
    {
        $this->htmlContent = $html;
        return $this;
    }

    /**
     * Download the PDF (forces download in the browser)
     */
    public function download(string $filename)
    {
        $this->filename = $filename;
        return $this->initMPdf()->Output($this->filename, 'D');
    }

    /**
     * Stream the PDF (view PDF in browser)
     */
    public function stream(string $filename)
    {
        $this->filename = $filename;
        return $this->initMPdf()->Output($this->filename, 'I');
    }

    /**
     * Save the PDF to disk
     */
    public function save(string $path, string $disk = 'public')
    {
        if(!$disk)
        {
            $disk = 'public';
        }
        // Save to the specified path
        Storage::disk($disk)->put($path, $this->initMPdf()->OutputBinaryData());
        return Storage::disk($disk)->url($path); // return url 
    }

    /**
     * Creates a new mPDF instance with the specified configuration.
     *
     * @param array $config Configuration options for mPDF.
     *                      Refer to https://mpdf.github.io/reference/mpdf-variables/overview.html
     */
    public function addMPdfConfig($config = [])
    {
        $this->config = $config;
        return $this;
    }
    
    /**
    * @param array $config Configuration options for mPDF.
    *                      Refer to https://mpdf.github.io/reference/mpdf-variables/overview.html
    */
    public function watermarkText(
        string $text, 
        float $opacity = 0.2, 
        string $font = 'battambang',
        int $size = 100,
        int $angle = 45,
        string $color = '',
        array $config = []
    )
    {
        $this->config = $config;
        $this->config['showWatermarkText'] = true;
        $this->config['watermark_font'] = $font;

        $this->pdf = $this->initMPdf();
        $this->pdf->SetWatermarkText(new \Mpdf\WatermarkText($text, $size, $angle, $color, $opacity, $font));

        return $this;
    }

}