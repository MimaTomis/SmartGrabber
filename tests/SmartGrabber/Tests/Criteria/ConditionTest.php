<?php
namespace SmartGrabber\Tests\Criteria;

use SmartGrabber\Criteria\Condition;
use SmartGrabber\Criteria\ConditionInterface;

class ConditionTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider conditionProvider
	 * @param Condition $condition
	 * @param string $query
	 * @param string $name
	 * @param string $type
	 */
	public function testGetQuery($condition, $name, $query, $type)
	{
		$this->assertEquals($query, $condition->getQuery());
	}

	/**
	 * @dataProvider conditionProvider
	 * @param Condition $condition
	 * @param string $query
	 * @param string $name
	 * @param string $type
	 */
	public function testGetName($condition, $name, $query, $type)
	{
		$this->assertEquals($name, $condition->getKey());
	}

	/**
	 * @dataProvider conditionProvider
	 * @param Condition $condition
	 * @param string $query
	 * @param string $name
	 * @param string $type
	 */
	public function testGetType($condition, $name, $query, $type)
	{
		$this->assertEquals($type, $condition->getType());
	}

	public function conditionProvider()
	{
		return [
			[new Condition('field-1', '/a/b/c', ConditionInterface::TYPE_STRING), 'field-1', '/a/b/c', ConditionInterface::TYPE_STRING],
			[new Condition('field-3', '/a', ConditionInterface::TYPE_FILE), 'field-3', '/a', ConditionInterface::TYPE_FILE]
		];
	}
}