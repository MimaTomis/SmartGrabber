<?php
namespace SmartGrabber\Element;

use SmartGrabber\Visitor\ElementVisitorInterface;

class FileElement extends AbstractElement
{
	/**
	 * @var string
	 */
	protected $name;
	/**
	 * @var string
	 */
	protected $mimeType;
	/**
	 * @var string
	 */
	protected $extension;
	/**
	 * @var string
	 */
	private $path;

	public function __construct($key, $path, $name, $mimeType = null, $extension = null)
	{
		parent::__construct($key, $path);

		$this->setName($name);
		$this->setPath($path);
		$this->mimeType = $mimeType;
		$this->extension = $extension;
	}

	/**
	 * Original name of file
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set original name of file
	 *
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * Mime type. Returns only if it's possible.
	 *
	 * @return string|null
	 */
	public function getMimeType()
	{
		return $this->mimeType;
	}

	/**
	 * Extension. Returns only if it's possible.
	 *
	 * @return string|null
	 */
	public function getExtension()
	{
		return $this->extension;
	}

	/**
	 * Get file path. It may be not equal to node content, be
	 *
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * Set file path
	 *
	 * @param string $path
	 */
	public function setPath($path)
	{
		$this->path = $path;
	}

	/**
	 * Accept visitor for preparing element content
	 *
	 * @param ElementVisitorInterface $visitor
	 */
	public function accept(ElementVisitorInterface $visitor)
	{
		$visitor->visitFile($this);
	}
}