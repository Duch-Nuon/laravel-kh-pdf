<?php

namespace KhmerPdf\LaravelKhPdf\Traits;
use Illuminate\Support\Facades\Storage;

trait PdfKhTrait 
{
    protected $htmlContent;
    protected $filename;
    protected $pdf;

    /**
     * Load HTML content for PDF generation
     */
    public function loadHtml(string $htmlContent)
    {
        $this->pdf = app('mPdf');
        $this->pdf->WriteHTML($htmlContent);

        return $this;  // Return $this for method chaining
    }

    /**
     * Download the PDF (forces download in the browser)
     */
    public function download(string $filename)
    {
        $this->filename = $filename;
        return $this->pdf->Output($this->filename, 'D');
    }

    /**
     * Stream the PDF (view PDF in browser)
     */
    public function stream(string $filename)
    {
        $this->filename = $filename;
        return $this->pdf->Output($this->filename, 'I');
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
        Storage::disk($disk)->put($path, $this->pdf->OutputBinaryData());
        return Storage::disk($disk)->url($path); // return url 
    }
}