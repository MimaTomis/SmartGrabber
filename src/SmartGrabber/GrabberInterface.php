<?php
namespace SmartGrabber;

use SmartGrabber\Criteria\CriteriaInterface;
use SmartGrabber\Visitor\ElementVisitorInterface;

interface GrabberInterface
{
	/**
	 * Set visitor for found elements
	 *
	 * @param ElementVisitorInterface $visitor
	 */
	public function setVisitor(ElementVisitorInterface $visitor);

	/**
	 * Grab by criteria. Find all elements by given criteria.
	 * If visitor is accepted, visit in each of element.
	 *
	 * @param CriteriaInterface $criteria
	 *
	 * @return array
	 */
	public function grab(CriteriaInterface $criteria);
}