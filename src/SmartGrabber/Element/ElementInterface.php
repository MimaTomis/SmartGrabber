<?php
namespace SmartGrabber\Element;

use SmartGrabber\Visitor\ElementVisitorInterface;

interface ElementInterface
{
	/**
	 * Get content of element
	 *
	 * @return string
	 */
	public function getContent();

	/**
	 * Set content of element
	 *
	 * @param string $content
	 */
	public function setContent($content);

	/**
	 * Get name of element. This name equal to name from condition.
	 *
	 * @return string
	 */
	public function getKey();

	/**
	 * Accept visitor for preparing element content
	 *
	 * @param ElementVisitorInterface $visitor
	 */
	public function accept(ElementVisitorInterface $visitor);
}