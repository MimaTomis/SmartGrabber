<?php
namespace SmartGrabber\Tests\Element;

use SmartGrabber\Element\StringElement;
use SmartGrabber\Visitor\ElementVisitorInterface;

class StringElementTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider dataProvider
	 * @param string $key
	 * @param string $content
	 */
	public function testConstruct($key, $content)
	{
		$element = new StringElement($key, $content);

		$this->assertEquals($key, $element->getKey());
		$this->assertEquals($content, $element->getContent());
	}

	public function testAcceptVisitor()
	{
		$element = new StringElement('test', 'testContent');

		$visitor = $this->getMock(ElementVisitorInterface::class);
		$visitor->expects($this->once())
			->method('visitString')
			->with($this->equalTo($element));

		$element->accept($visitor);
	}

	public function dataProvider()
	{
		return [
			['field-1', 'vcxvcx'],
			['field-2', 'asd'],
			['field-3', 'qweq']
		];
	}
}