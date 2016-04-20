<?php
namespace SmartGrabber\Finder;

use SmartGrabber\Criteria\CriteriaInterface;

interface FinderInterface
{
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
	public function find(CriteriaInterface $criteria);
}