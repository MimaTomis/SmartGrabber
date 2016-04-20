<?php
namespace SmartGrabber\Criteria;

class Criteria implements CriteriaInterface
{
	/**
	 * @see getUrl
	 * @var string
	 */
	protected $url;
	/**
	 * @see getConditions
	 * @var ConditionInterface[]
	 */
	protected $conditions = [];

	/**
	 * Set url and list of conditions
	 *
	 * @param string $url
	 * @param array $conditions
     */
	public function __construct($url, array $conditions = [])
	{
		$this->url = $url;

		if (!empty($conditions))
			$this->setConditions($conditions);
	}

	/**
	 * Return url for document, who be parsed.
	 * Maybe url or file path.
	 *
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * Return all parse conditions
	 *
	 * @return ConditionInterface[]
	 */
	public function getConditions()
	{
		return $this->conditions;
	}

	/**
	 * Set conditions from array
	 *
	 * @param array $conditions
	 */
	public function setConditions(array $conditions)
	{
		foreach ($conditions as $key => $condition) {
			if (is_object($condition))
				$this->addCondition($condition);
			else {
				list($name, $path, $type) = is_string($condition) ?
					[$key, $condition, ConditionInterface::TYPE_STRING] :
					array_pad(array_merge([$key], $condition), 3, ConditionInterface::TYPE_STRING);

				$this->createCondition($name, $path, $type);
			}
		}
	}

	/**
	 * Add condition for search elements
	 *
	 * @param ConditionInterface $condition
     */
	public function addCondition(ConditionInterface $condition)
	{
		$this->conditions[] = $condition;
	}

	/**
	 * Create a condition
	 *
	 * @param string $name
	 * @param string $query
	 * @param string $type
	 *
	 * @return ConditionInterface
	 */
	public function createCondition($name, $query, $type = ConditionInterface::TYPE_STRING)
	{
		$condition = new Condition($name, $query, $type);
		$this->addCondition($condition);

		return $condition;
	}
}