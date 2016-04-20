<?php
namespace SmartGrabber\Criteria;

class Condition implements ConditionInterface
{
	/**
	 * @var string
	 */
	private $query;
	/**
	 * @var string
	 */
	private $key;
	/**
	 * @var string
	 */
	private $type;

	/**
	 * Constructor. Set rule properties, such as path, name and type
	 *
	 * @see ConditionInterface::getQuery
	 * @see ConditionInterface::getKey
	 * @see ConditionInterface::getType
	 *
	 * @param string $key
	 * @param string $query
	 * @param string $type
	 */
	public function __construct($key, $query, $type = ConditionInterface::TYPE_STRING)
	{
		$this->query = $query;
		$this->key = $key;
		$this->type = $type;
	}

	/**
	 * Return query to find element, e.g. xpath or jquery selector
	 *
	 * @return string
	 */
	public function getQuery()
	{
		return $this->query;
	}

	/**
	 * Return key of field in result
	 *
	 * @return string
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * Return type of field in result.
	 *
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}
}