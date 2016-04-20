<?php
namespace SmartGrabber\Finder;

use DOMNavigator\NavigatorInterface;
use SmartGrabber\Criteria\CriteriaInterface;

class NavigatorFinder implements FinderInterface
{
	/**
	 * @var NavigatorInterface
	 */
	private $navigator;

	public function __construct(NavigatorInterface $navigator)
	{
		$this->navigator = $navigator;
	}

	/**
	 * Find nodes by criteria. Return \Generator.
	 * Sending key as object of Condition with associated value as object of \DOMNodeList.
	 *
	 * @see http://php.net/manual/en/language.generators.overview.php
	 *
	 * @param CriteriaInterface $criteria
	 *
	 * @return \Generator
	 */
	public function find(CriteriaInterface $criteria)
	{
		$url = $criteria->getUrl();
		$this->navigator->loadHTML($url);

		foreach ($criteria->getConditions() as $condition) {
			$nodeList = $this->navigator->navigate($condition->getQuery());

			yield $condition => $nodeList;
		}
	}
}