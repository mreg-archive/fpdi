<?php
namespace fpdi;

/**
 * @runTestsInSeparateProcesses
 */
class IntegrationTest extends \PHPUnit_Framework_TestCase
{
    public function createPDF(FPDI $fpdi, $filename)
    {
        $fpdi->setSourceFile(__DIR__ . '/A.pdf');

        $template = $fpdi->importPage(1);
        $size = $fpdi->getTemplateSize($template);
        $fpdi->AddPage('P', array($size['w'], $size['h']));
        $fpdi->useTemplate($template);

        $template = $fpdi->importPage(1);
        $fpdi->AddPage('P', array($size['w'], $size['h']));
        $fpdi->useTemplate($template);

        file_put_contents(
            __DIR__ . '/' . $filename,
            $fpdi->Output('', 'S')
        );
    }

    /**
     * Merge PDF using FPDF
     */
    public function testFPDF()
    {
        $fpdi = new FPDI;
        $this->assertInstanceOf('\fpdf\FPDF', $fpdi);
        $this->assertNotInstanceOf('\TCPDF', $fpdi);
        $this->createPDF($fpdi, 'FPDF_AA.pdf');
    }

    /**
     * Merge PDF using TCPDF
     */
    public function testTCPDF()
    {
        // Force autoloading of TCPDF
        new \TCPDF;
        $fpdi = new FPDI;
        $this->assertNotInstanceOf('\fpdf\FPDF', $fpdi);
        $this->assertInstanceOf('\TCPDF', $fpdi);
        $this->createPDF($fpdi, 'TCPDF_AA.pdf');
    }
}
