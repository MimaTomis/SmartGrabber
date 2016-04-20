<?php
namespace SmartGrabber\Factory;

use LogicException;
use SmartGrabber\Element\FileElement;
use SmartGrabber\Element\StringElement;

class BaseElementFactory implements ElementFactoryInterface
{
	/**
	 * Create file element.
	 * First argument is equal to criteria url.
	 * Second argument is equal to key from criteria.
	 *
	 * @param string $url
	 * @param string $key
	 * @param \DOMNode $domNode
	 *
	 * @return FileElement
	 */
	public function createFile($url, $key, \DOMNode $domNode)
	{
		$nodeContent = $domNode->textContent;
		$filePath = $this->normalizeFilePath($url, $nodeContent);

		if (!$filePath)
			throw new LogicException(sprintf('File "%s" is not exists', $nodeContent));

		$mimeType = $this->getFileMimeType($filePath);
		list($name, $extension) = $this->getFileNameAndExtension($filePath);

		return new FileElement($key, $filePath, $name, $mimeType, $extension);
	}

	/**
	 * Create string element. First argument is equal to key from criteria.
	 *
	 * @param string $key
	 * @param \DOMNode $domNode
	 *
	 * @return StringElement
	 */
	public function createString($key, \DOMNode $domNode)
	{
		$content = $domNode->textContent;

		return new StringElement($key, $content);
	}

	/**
	 * Get file mime type
	 *
	 * @param $filePath
	 *
	 * @return string
	 */
	protected function getFileMimeType($filePath)
	{
		if (!is_file($filePath)) {
			$fileResource = fopen($filePath, 'rb');

			if (!$fileResource)
				throw new LogicException(sprintf('"%s" is not file', $filePath));

			$fileContent = fgets($fileResource, 1024);
			$infoResource = finfo_open(FILEINFO_MIME_TYPE);
			$mimeType = finfo_buffer($infoResource, $fileContent);

			fclose($fileResource);
			finfo_close($infoResource);
		} else {
			$infoResource = finfo_open(FILEINFO_MIME_TYPE);
			$mimeType = finfo_file($infoResource, $filePath);

			finfo_close($infoResource);
		}

		return $mimeType;
	}

	/**
	 * Get file name and extension. Return array with two elements: first is name and second is extension.
	 * If extension not found, second argument exists but is null
	 *
	 * @param $filePath
	 *
	 * @return array
	 */
	protected function getFileNameAndExtension($filePath)
	{
		$filePath = preg_replace('/\?.*$/', '', $filePath);
		$info = pathinfo($filePath);

		$name = $info['basename'];
		$extension = !empty($info['extension']) ? $info['extension'] : null;

		return [$name, $extension];
	}

	/**
	 * Join url to file path if need.
	 *
	 * @param string $url
	 * @param string $filePath
	 *
	 * @return mixed
	 */
	protected function normalizeFilePath($url, $filePath)
	{
		if (!filter_var($filePath, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED|FILTER_FLAG_HOST_REQUIRED)) {
			if (filter_var($url, FILTER_VALIDATE_URL)) {
				$filePath = rtrim($url, '/') . '/' . ltrim($filePath, '/');
			} else if (!file_exists($filePath)) {
				$path = '/'.ltrim($filePath, '/');
				$url = explode('/', trim($url, '/'));

				do {
					$filePath = '/'.implode('/', $url) . $path;

					if (file_exists($filePath))
						goto success;

					end($url);
					unset($url[key($url)]);
				} while (sizeof($url));

				return false;
			}
		}

		success:
			return $filePath;
	}
}