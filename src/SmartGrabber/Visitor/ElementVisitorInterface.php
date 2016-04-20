<?php
namespace SmartGrabber\Visitor;

use SmartGrabber\Element\FileElement;
use SmartGrabber\Element\StringElement;

interface ElementVisitorInterface
{
	/**
	 * Visit file element.
	 *
	 * @param FileElement $element
     */
	public function visitFile(FileElement $element);

	/**
	 * Visit string element
	 *
	 * @param StringElement $element
	 */
	public function visitString(StringElement $element);
}