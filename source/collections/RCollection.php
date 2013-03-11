<?php

	abstract class RCollection extends RCore implements IteratorAggregate, Countable
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
		 * (PHP 5 &gt;= 5.0.0)<br/>
		 * Retrieve an external iterator
		 * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
		 * @return Traversable An instance of an object implementing <b>Iterator</b> or
		 * <b>Traversable</b>
		 */
		public function getIterator()
		{
			// TODO: Implement getIterator() method.
		}

		/**
		 * (PHP 5 &gt;= 5.1.0)<br/>
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
