<?php
namespace SmartGrabber\Element;

use SmartGrabber\Visitor\ElementVisitorInterface;

class StringElement extends AbstractElement
{
	public function __construct($key, $content)
	{
		parent::__construct($key, $content);
	}

	/**
	 * Accept visitor for preparing element content
	 *
	 * @param ElementVisitorInterface $visitor
	 */
	public function accept(ElementVisitorInterface $visitor)
	{
		$visitor->visitString($this);
	}
}