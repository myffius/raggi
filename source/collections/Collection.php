<?php

namespace raggi\collections;

use \raggi\base\BaseComponent;

abstract class Collection extends BaseComponent implements \IteratorAggregate, \Countable
{
	protected $_collection;

	public function setCollection($collection)
	{
		$this->_collection = $collection;
	}

	public function getCollection()
	{
		return $this->_collection;
	}

	/**
	 * Retrieve an external iterator
	 * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
	 * @return \raggi\collections\CollectionIterator
	 */
	public function getIterator()
	{
		// TODO: Implement getIterator() method.
	}

	/**
	 * Count elements of an object
	 * @link http://php.net/manual/en/countable.count.php
	 * @return int The custom count as an integer.
	 * </p>
	 * <p>
	 * The return value is cast to an integer.
	 */
	public function count()
	{
		// TODO: Implement count() method.
	}

	public function add($key, $value, $rewrite = false)
	{

	}
}
