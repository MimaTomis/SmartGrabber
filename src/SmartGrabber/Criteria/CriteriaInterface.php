<?php
namespace SmartGrabber\Criteria;

interface CriteriaInterface
{
	/**
	 * Return url for document, who be parsed.
	 * Maybe url or file path.
	 *
	 * @return string
	 */
	public function getUrl();

	/**
	 * Return all parse conditions
	 *
	 * @return ConditionInterface[]
	 */
	public function getConditions();
}