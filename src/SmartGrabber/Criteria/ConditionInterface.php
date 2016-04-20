<?php
namespace SmartGrabber\Criteria;

interface ConditionInterface
{
	/**
	 * Data type for string or text
	 */
	const TYPE_STRING = 'string';
	/**
	 * Data type for files
	 */
	const TYPE_FILE = 'file';

	/**
	 * Return query to find element, e.g. xpath or jquery selector
	 *
	 * @return string
	 */
	public function getQuery();

	/**
	 * Return key of field in result
	 *
	 * @return string
	 */
	public function getKey();

	/**
	 * Return type of field in result.
	 *
	 * @return string
	 */
	public function getType();
}