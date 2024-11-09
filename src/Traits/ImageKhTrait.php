<?php

namespace KhmerPdfImg\LaravelKhPdfImg\Traits;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

trait ImageKhTrait 
{
    protected $htmlContent;
    protected $filename;
    protected $pdfContent;

    protected $pageWidth = 612;  // Standard Letter size: 8.5in x 11in (in points)
    protected $pageHeight = 792; // Standard Letter size: 8.5in x 11in (in points)

    /**
     * Load HTML content for PDF generation
     */
    public function loadHtml(string $htmlContent)
    {
        $this->htmlContent = $htmlContent;
        $this->generate();  // Automatically generate PDF after loading HTML
        return $this;  // Return $this for method chaining
    }

    /**
     * Generate PDF from HTML content (simplified here)
     */
    protected function generate()
    {
        $this->pdfContent = "%PDF-1.4\n";  // PDF version

        // Define the catalog (which will point to pages)
        $this->pdfContent .= "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";

        // Define the Pages object that contains a reference to the Page object
        $this->pdfContent .= "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";

        // Define the Page object (content and size)
        $this->pdfContent .= "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 {$this->pageWidth} {$this->pageHeight}] /Contents 4 0 R >>\nendobj\n";
        
        // Generate content for the page (text)
        $this->generateTextContent();
        
        // Finalize PDF
        $this->pdfContent .= "trailer\n<< /Root 1 0 R /Size 5 >>\n";
        $this->pdfContent .= "startxref\n";
        $this->pdfContent .= strlen($this->pdfContent);  // Byte offset for xref table
        $this->pdfContent .= "\n%%EOF\n";
    }

    protected function generateTextContent()
    {
        // Add text to PDF from HTML (simplified)
        $text = strip_tags($this->htmlContent); // Simple text parsing: stripping HTML tags
        $text = str_replace("\n", ' ', $text);  // Replace line breaks with spaces

        // Escape the text for PDF compatibility (basic escape)
        $escapedText = '(' . addslashes($text) . ')';

        // Define the content stream for the page
        $this->pdfContent .= "4 0 obj\n<< /Length 5 0 R >>\nstream\n";
        $this->pdfContent .= "BT\n/F1 12 Tf\n72 720 Td\n";  // Positioning text at (72, 720) - start at the top left
        $this->pdfContent .= $escapedText . " Tj\nET\n"; // Text object (render text)
        $this->pdfContent .= "endstream\nendobj\n";
        
        // Define the font (simplified)
        $this->pdfContent .= "5 0 obj\n<< /Length 6 0 R >>\nstream\n";
        $this->pdfContent .= "1 0 0 1 0 0 cm\n";  // Font transformation (identity matrix)
        $this->pdfContent .= "endstream\nendobj\n";
    }

    /**
     * Download the PDF (forces download in the browser)
     */
    public function download(string $filename)
    {
        $this->filename = $filename;
        return Response::make($this->pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $this->filename . '"',
        ]);
    }

    /**
     * Stream the PDF (view PDF in browser)
     */
    public function stream(string $filename)
    {
        $this->filename = $filename;
        return Response::make($this->pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $this->filename . '"',
        ]);
    }

    /**
     * Save the PDF to disk
     */
    public function save(string $path, string $disk = 'public')
    {
        // Save to the specified path
        Storage::disk($disk)->put($path, $this->pdfContent);
        return Storage::disk($disk)->url($path);  // Return the URL where the file is saved
    }
}