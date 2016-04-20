<?php
namespace SmartGrabber\Tests\Finder;

use DOMNavigator\Finder\XPathFinder;
use DOMNavigator\Loader\FileLoader;
use DOMNavigator\Navigator;
use SmartGrabber\Criteria\Condition;
use SmartGrabber\Criteria\ConditionInterface;
use SmartGrabber\Criteria\Criteria;
use SmartGrabber\Finder\NavigatorFinder;

class NavigatorFinderTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var NavigatorFinder
	 */
	protected $finder;

	public function setUp()
	{
		$navigator = new Navigator(new FileLoader(), new XPathFinder());
		$this->finder = new NavigatorFinder($navigator);
	}

	/**
	 * @dataProvider criteriaProvider
	 * @param Criteria $criteria
	 * @param string $instanceOf
	 * @param array $values
	 */
	public function testFind($criteria, $instanceOf, $values)
	{
		$generator = $this->finder->find($criteria);

		/**
		 * @var ConditionInterface $condition
		 * @var \DOMNodeList $nodeList
		 */
		foreach ($generator as $condition => $nodeList) {
			$this->assertInstanceOf(ConditionInterface::class, $condition);
			$this->assertInstanceOf(\DOMNodeList::class, $nodeList);

			$this->assertEquals(count($values), $nodeList->length);

			foreach ($nodeList as $key => $node) {
				$this->assertInstanceOf($instanceOf, $node);
				$this->assertEquals($values[$key], $node->textContent);
			}
		}
	}

	public function criteriaProvider()
	{
		$criteria1 = new Criteria(FIXTURES_DIR.'/form.html', [
			new Condition('action', '//form/@action', Condition::TYPE_FILE),
		]);

		$criteria2 = new Criteria(FIXTURES_DIR.'/simple.html', [
			new Condition('list', '//ul/li', Condition::TYPE_STRING),
		]);

		return [
			[$criteria1, \DOMAttr::class, ['/simple.html']],
			[$criteria2, \DOMElement::class, ['Item #1', 'Item #2', 'Item #3']]
		];
	}
}