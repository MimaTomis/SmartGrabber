<?php
namespace SmartGrabber\Tests\Criteria;

use SmartGrabber\Criteria\Condition;
use SmartGrabber\Criteria\ConditionInterface;
use SmartGrabber\Criteria\Criteria;

class CriteriaTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider urlProvider
	 * @param string $url
	 */
	public function testSetUrlFromConstruct($url)
	{
		$criteria = new Criteria($url);
		$this->assertEquals($url, $criteria->getUrl());
	}

	/**
	 * @dataProvider objectConditionsProvider
	 * @param Condition $condition
	 */
	public function testAddCondition($condition)
	{
		$criteria = new Criteria('http://ya.ru');

		$criteria->addCondition($condition);
		$conditions = $criteria->getConditions();

		$this->assertContains($condition, $conditions);
	}

	/**
	 * @dataProvider objectConditionsProvider
	 * @param Condition $condition
	 */
	public function testCreateCondition($condition)
	{
		$criteria = new Criteria('http://ya.ru');

		$newCondition = $criteria->createCondition($condition->getKey(), $condition->getQuery(), $condition->getType());

		$this->assertEquals($condition->getKey(), $newCondition->getKey());
		$this->assertEquals($condition->getType(), $newCondition->getType());
		$this->assertEquals($condition->getQuery(), $newCondition->getQuery());
	}

	public function testSetOnlyObjectConditions()
	{
		$condition1 = new Condition('field-1', '/a/b/c', ConditionInterface::TYPE_STRING);
		$condition2 = new Condition('field-2', '/a/d/c', ConditionInterface::TYPE_FILE);
		$criteria = new Criteria('http://ya.ru');

		$criteria->setConditions([
			$condition1,
			$condition2
		]);

		$conditions = $criteria->getConditions();

		$this->assertCount(2, $conditions);
		$this->assertContains($condition1, $conditions);
		$this->assertContains($condition2, $conditions);
	}

	/**
	 * @dataProvider mixedConditionsProvider
	 * @param $conditions
	 */
	public function testSetMixedConditions($conditions)
	{
		$criteria = new Criteria('http://ya.ru');
		$criteria->setConditions($conditions);

		$this->checkMixedConditions($criteria, $conditions);
	}

	/**
	 * @dataProvider mixedConditionsProvider
	 * @param array $conditions
	 */
	public function testSetConditionsInConstruct($conditions)
	{
		$criteria = new Criteria('http://ya.ru', $conditions);

		$this->checkMixedConditions($criteria, $conditions);
	}

	public function checkMixedConditions($criteria, $conditions)
	{
		$criteriaConditions = $criteria->getConditions();
		reset($criteriaConditions);

		$this->assertContainsOnlyInstancesOf(ConditionInterface::class, $criteriaConditions);
		$this->assertCount(count($conditions), $criteriaConditions);

		foreach ($conditions as $key => $data) {
			$condition = current($criteriaConditions);
			next($criteriaConditions);

			if (is_object($data)) {
				$this->assertEquals($data->getKey(), $condition->getKey());
				$this->assertEquals($data->getQuery(), $condition->getQuery());
				$this->assertEquals($data->getType(), $condition->getType());
			} else {
				$this->assertEquals($key, $condition->getKey());

				if (is_string($data)) {
					$this->assertEquals($data, $condition->getQuery());
					$this->assertEquals(ConditionInterface::TYPE_STRING, $condition->getType());
				} else {
					$this->assertEquals($data[0], $condition->getQuery());
					(count($data) > 1) ?
						$this->assertEquals($data[1], $condition->getType()) :
						$this->assertEquals(ConditionInterface::TYPE_STRING, $condition->getType());
				}
			}
		}
	}

	public function urlProvider()
	{
		return [
			['http://abcf.ru'],
			['http://abcf.net'],
			['http://abcf.com']
		];
	}

	public function objectConditionsProvider()
	{
		return [
			[new Condition('field-1', '/a/b/c', ConditionInterface::TYPE_STRING)],
			[new Condition('field-3', '/a/b/e', ConditionInterface::TYPE_FILE)]
		];
	}

	public function mixedConditionsProvider()
	{
		return [
			[
				[
					'field-1' => ['/a/b/c', ConditionInterface::TYPE_STRING],
					'field-3' => '/n/b/g',
					'field-4' => ['/q/b/e'],
					new Condition('field-5', '/p/o/c', ConditionInterface::TYPE_STRING),
					new Condition('field-6', 'x/bz', ConditionInterface::TYPE_FILE),
					new Condition('field-7', 'x/bz/dsa/')
				]
			]
		];
	}
}