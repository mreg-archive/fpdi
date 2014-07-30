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
            $filename,
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

        $filename = __DIR__ . '/FPDF_AA.pdf';
        $this->createPDF($fpdi, $filename);
        $this->assertTrue(file_exists($filename), "$filename should be created");
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

        $filename = __DIR__ . '/TCPDF_AA.pdf';
        $this->createPDF($fpdi, $filename);
        $this->assertTrue(file_exists($filename), "$filename should be created");
    }

    /**
     * Since the code is namespaced the creation of new spl exceptions must refer
     * to the global namespace. This must be canged througout the codebase. This
     * test assures that the converting script does coveres thos issue.
     */
    public function testThrowSplException()
    {
        $this->setExpectedException('\InvalidArgumentException');
        new pdf_parser(__DIR__ . '/this-file-does-not-exists.foobar');
    }
}
