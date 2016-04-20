<?php
namespace SmartGrabber\Tests;

use SmartGrabber\Element\FileElement;
use SmartGrabber\Element\StringElement;
use SmartGrabber\Factory\BaseElementFactory;

class BaseElementFactoryTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var BaseElementFactory
	 */
	protected $factory;

	public function setUp()
	{
		$this->factory = new BaseElementFactory();
	}

	/**
	 * @dataProvider fileDataProvider
	 *
	 * @param string $url
	 * @param string $key
	 * @param \DOMNode $node
	 * @param string $path
	 * @param string $name
	 * @param string $extension
	 * @param string $mimeType
	 */
	public function testCreateFile($url, $key, $node, $path, $name, $extension, $mimeType)
	{
		$file = $this->factory->createFile($url, $key, $node);

		$this->assertInstanceOf(FileElement::class, $file);
		$this->assertEquals($key, $file->getKey());
		$this->assertEquals($path, $file->getContent());
		$this->assertEquals($path, $file->getPath());
		$this->assertEquals($name, $file->getName());
		$this->assertEquals($extension, $file->getExtension());
		$this->assertEquals($mimeType, $file->getMimeType());
	}

	/**
	 * @dataProvider stringDataProvider
	 *
	 * @param string $key
	 * @param \DOMNode $node
	 */
	public function testCreateString($key, $node)
	{
		$string = $this->factory->createString($key, $node);

		$this->assertInstanceOf(StringElement::class, $string);
		$this->assertEquals($key, $string->getKey());
		$this->assertEquals($node->textContent, $string->getContent());
	}

	public function fileDataProvider()
	{
		return [
			[FIXTURES_DIR, 'test-file', new \DOMElement('div', 'form.html'), FIXTURES_DIR.'/form.html', 'form.html', 'html', 'text/html'],
			['http://yost.ru', 'test-url', new \DOMElement('div', 'http://www.orimi.com/pdf-test.pdf'), 'http://www.orimi.com/pdf-test.pdf', 'pdf-test.pdf', 'pdf', 'application/pdf'],
			['http://www.orimi.com', 'test-url', new \DOMAttr('div', '/pdf-test.pdf'), 'http://www.orimi.com/pdf-test.pdf', 'pdf-test.pdf', 'pdf', 'application/pdf'],
			[FIXTURES_DIR.'/temp', 'test-file', new \DOMAttr('div', 'simple.html'), FIXTURES_DIR.'/simple.html', 'simple.html', 'html', 'text/html']
		];
	}

	public function stringDataProvider()
	{
		return [
			['test-key-1', new \DOMElement('div', 'test text for string compare')],
			['test-key-2', new \DOMAttr('href', 'test text for string compare')]
		];
	}
}