<?php
namespace fpdi;

class IntegrationTest extends \PHPUnit_Framework_TestCase
{
    public function testMerge()
    {
        $fpdi = new FPDI;
        $fpdi->setSourceFile(__DIR__ . '/A.pdf');

        $template = $fpdi->importPage(1);
        $size = $fpdi->getTemplateSize($template);
        $fpdi->AddPage('P', array($size['w'], $size['h']));
        $fpdi->useTemplate($template);

        $template = $fpdi->importPage(1);
        $fpdi->AddPage('P', array($size['w'], $size['h']));
        $fpdi->useTemplate($template);

        file_put_contents(__DIR__ . '/AA.pdf', $fpdi->Output('', 'S'));
    }
}
