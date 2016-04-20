<?php
namespace SmartGrabber;

use SmartGrabber\Criteria\ConditionInterface;
use SmartGrabber\Criteria\CriteriaInterface;
use SmartGrabber\Element\ElementInterface;
use SmartGrabber\Factory\ElementFactoryInterface;
use SmartGrabber\Finder\FinderInterface;
use SmartGrabber\Visitor\ElementVisitorInterface;

class Grabber implements GrabberInterface
{
	/**
	 * @var ElementVisitorInterface
	 */
	private $visitor;
	/**
	 * @var FinderInterface
	 */
	private $finder;
	/**
	 * @var ElementFactoryInterface
	 */
	private $elementFactory;

	public function __construct(FinderInterface $finder, ElementFactoryInterface $elementFactory, ElementVisitorInterface $elementVisitor = null)
	{
		$this->finder = $finder;
		$this->visitor = $elementVisitor;
		$this->elementFactory = $elementFactory;
	}

	/**
	 * Set visitor for found elements
	 *
	 * @param ElementVisitorInterface $visitor
	 */
	public function setVisitor(ElementVisitorInterface $visitor)
	{
		$this->visitor = $visitor;
	}

	/**
	 * Parse by criteria. Find all elements by given criteria.
	 * If visitor is accepted, visit in each of element.
	 *
	 * @param CriteriaInterface $criteria
	 * @return array
	 */
	public function grab(CriteriaInterface $criteria)
	{
		$result = [];
		$generator = $this->finder->find($criteria);

		/**
		 * @var ConditionInterface $condition
		 * @var \DOMNodeList $nodeList
		 */
		foreach ($generator as $condition => $nodeList) {
			if ($nodeList->length) {
				foreach ($nodeList as $node) {
					$element = $this->createElement($criteria, $condition, $node);

					if ($this->visitor)
						$element->accept($this->visitor);

					$this->addToResult($result, $element);
				}
			}
		}

		return $result;
	}

	/**
	 * Create element object.
	 *
	 * @param CriteriaInterface $criteria
	 * @param ConditionInterface $condition
	 * @param \DOMNode $node
	 *
	 * @return ElementInterface
	 */
	protected function createElement(CriteriaInterface $criteria, ConditionInterface $condition, \DOMNode $node)
	{
		if ($condition->getType() == ConditionInterface::TYPE_FILE)
			return $this->elementFactory->createFile($criteria->getUrl(), $condition->getKey(), $node);
		else
			return $this->elementFactory->createString($condition->getKey(), $node);
	}

	/**
	 * Add content to result
	 *
	 * @param array $result
	 * @param ElementInterface $element
	 */
	protected function addToResult(array &$result, $element)
	{
		if (isset($result[$element->getKey()])) {
			if (!is_array($result[$element->getKey()]))
				$result[$element->getKey()] = [$result[$element->getKey()]];

			$result[$element->getKey()][] = $element;
		} else
			$result[$element->getKey()] = $element;
	}
}