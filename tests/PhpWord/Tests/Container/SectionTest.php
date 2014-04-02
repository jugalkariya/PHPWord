<?php
/**
 * PHPWord
 *
 * @link        https://github.com/PHPOffice/PHPWord
 * @copyright   2014 PHPWord
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt LGPL
 */

namespace PhpOffice\PhpWord\Tests\Container;

use PhpOffice\PhpWord\Container\Section;
use PhpOffice\PhpWord\Style;

/**
 * Test class for PhpOffice\PhpWord\Container\Section
 *
 * @runTestsInSeparateProcesses
 */
class SectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Get settings
     */
    public function testGetSettings()
    {
        $oSection = new Section(0);
        $this->assertAttributeEquals($oSection->getSettings(), 'settings', new Section(0));
    }

    /**
     * Get elements
     */
    public function testGetElements()
    {
        $oSection = new Section(0);
        $this->assertAttributeEquals($oSection->getElements(), 'elements', new Section(0));
    }

    /**
     * Get footer
     */
    public function testGetFooter()
    {
        $oSection = new Section(0);
        $this->assertAttributeEquals($oSection->getFooter(), 'footer', new Section(0));
    }

    /**
     * Get headers
     */
    public function testGetHeaders()
    {
        $oSection = new Section(0);
        $this->assertAttributeEquals($oSection->getHeaders(), 'headers', new Section(0));
    }

    /**
     * Set settings
     */
    public function testSetSettings()
    {
        $expected = 'landscape';
        $object = new Section(0);
        $object->setSettings(array('orientation' => $expected));
        $this->assertEquals($expected, $object->getSettings()->getOrientation());
    }

    /**
     * Add elements
     */
    public function testAddElements()
    {
        $objectSource = __DIR__ . "/../_files/documents/reader.docx";
        $imageSource = __DIR__ . "/../_files/images/PhpWord.png";
        $imageUrl = 'http://php.net//images/logos/php-med-trans-light.gif';

        $section = new Section(0);
        $section->addText(utf8_decode('ä'));
        $section->addLink(utf8_decode('http://äää.com'), utf8_decode('ä'));
        $section->addTextBreak();
        $section->addPageBreak();
        $section->addTable();
        $section->addListItem(utf8_decode('ä'));
        $section->addObject($objectSource);
        $section->addImage($imageSource);
        $section->addMemoryImage($imageUrl);
        $section->addTitle(utf8_decode('ä'), 1);
        $section->createTextRun();
        $section->createFootnote();
        $section->addCheckBox(utf8_decode('chkä'), utf8_decode('Contentä'));
        $section->addTOC();

        $elementCollection = $section->getElements();
        $elementTypes = array('Text', 'Link', 'TextBreak', 'PageBreak',
            'Table', 'ListItem', 'Object', 'Image', 'Image',
            'Title', 'TextRun', 'Footnote', 'CheckBox');
        $i = 0;
        foreach ($elementTypes as $elementType) {
            $this->assertInstanceOf("PhpOffice\\PhpWord\\Element\\{$elementType}", $elementCollection[$i]);
            $i++;
        }
        $this->assertInstanceOf("PhpOffice\\PhpWord\\TOC", $elementCollection[$i]);
    }

    /**
     * Test add object exception
     *
     * @expectedException \PhpOffice\PhpWord\Exception\InvalidObjectException
     */
    public function testAddObjectException()
    {
        $source = __DIR__ . "/_files/xsl/passthrough.xsl";
        $section = new Section(0);
        $section->addObject($source);
    }

    /**
     * Add title with predefined style
     */
    public function testAddTitleWithStyle()
    {
        Style::addTitleStyle(1, array('size' => 14));
        $section = new Section(0);
        $section->addTitle('Test', 1);
        $elementCollection = $section->getElements();

        $this->assertInstanceOf("PhpOffice\\PhpWord\\Element\\Title", $elementCollection[0]);
    }

    /**
     * Create header footer
     */
    public function testCreateHeaderFooter()
    {
        $object = new Section(0);
        $elements = array('Header', 'Footer');

        foreach ($elements as $element) {
            $method = "create{$element}";
            $this->assertInstanceOf("PhpOffice\\PhpWord\\Container\\{$element}", $object->$method());
        }
        $this->assertFalse($object->hasDifferentFirstPage());
    }
}