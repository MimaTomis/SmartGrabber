<?php
namespace SmartGrabber\Element;

abstract class AbstractElement implements ElementInterface
{
	/**
	 * @var string
	 */
	private $key;
	/**
	 * @var string
	 */
	private $content;

	public function __construct($key, $content)
	{
		$this->key = $key;
		$this->content = $content;
	}

	/**
	 * Get content of element
	 *
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * Get name of element. This name equal to name from condition.
	 *
	 * @return string
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * Set content of element
	 *
	 * @param string $content
	 */
	public function setContent($content)
	{
		$this->content = $content;
	}

	/**
	 * Convert element to string
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->getContent();
	}
}