<?php
namespace SmartGrabber\Factory;

use SmartGrabber\Element\FileElement;
use SmartGrabber\Element\StringElement;

interface ElementFactoryInterface
{
	/**
	 * Create file element.
	 * First argument is equal to criteria url.
	 * Second argument is equal to key from criteria.
	 *
	 * @param $url
	 * @param string $key
	 * @param \DOMNode $domNode
	 *
	 * @return FileElement
	 */
	public function createFile($url, $key, \DOMNode $domNode);

	/**
	 * Create string element. First argument is equal to key from criteria.
	 *
	 * @param string $key
	 * @param \DOMNode $domNode
	 *
	 * @return StringElement
	 */
	public function createString($key, \DOMNode $domNode);
}