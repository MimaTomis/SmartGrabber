<?php
namespace SmartGrabber\Tests\Element;

use SmartGrabber\Element\FileElement;
use SmartGrabber\Visitor\ElementVisitorInterface;

class FileElementTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider dataProvider
	 * @param string $key
	 * @param string $path
	 * @param string $name
	 * @param string $mimeType
	 * @param string $extension
	 */
	public function testConstruct($key, $path, $name, $mimeType, $extension)
	{
		$element = new FileElement($key, $path, $name, $mimeType, $extension);

		$this->assertEquals($key, $element->getKey());
		$this->assertEquals($path, $element->getContent());
		$this->assertEquals($name, $element->getName());
		$this->assertEquals($mimeType, $element->getMimeType());
		$this->assertEquals($extension, $element->getExtension());
		$this->assertEquals($path, $element->getPath());
	}

	/**
	 * @dataProvider filePathProvider
	 * @param string $path
	 */
	public function testSetPath($path)
	{
		$element = new FileElement('abc', 'def/path', 'test.jpg');
		$element->setPath($path);

		$this->assertEquals($path, $element->getPath());
	}

	/**
	 * @dataProvider fileNameProvider
	 * @param string $name
	 */
	public function testSetName($name)
	{
		$element = new FileElement('abc', 'def/path', 'test.jpg');
		$element->setName($name);

		$this->assertEquals($name, $element->getName());
	}

	public function testAcceptVisitor()
	{
		$element = new FileElement('test', 'image.jpg', 'image.jpg');

		$visitor = $this->getMock(ElementVisitorInterface::class);
		$visitor->expects($this->once())
			->method('visitFile')
			->with($this->equalTo($element));

		$element->accept($visitor);
	}

	public function dataProvider()
	{
		return [
			['field-1', '/a/b/c/image.jpg', 'image.jpg', 'image/jpeg', 'jpg'],
			['field-2', '/a/b/c/data.png', 'data.png', 'image/png', 'png'],
			['field-3', '/a/b/d/data.png', 'title.pdf', 'application/pdf', 'pdf']
		];
	}

	public function filePathProvider()
	{
		return [
			['/path/to/file1'],
			['/path/to2/file2'],
			['/path3/to/file3']
		];
	}

	public function fileNameProvider()
	{
		return [
			['filename1.png'],
			['filename2.png'],
			['filename3.png']
		];
	}
}