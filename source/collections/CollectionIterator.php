<?php

namespace raggi\collections;

use \raggi\base\BaseComponent;

/**
 * CollectionIterator реализует интерфейс итератора для
 * классов производных от \raggi\collections\Collection
 *
 * @author myffius
 * @package raggi.collections
 * @version 1.0
 */
class CollectionIterator extends BaseComponent implements \Iterator
{
	/**
	 * @var integer индекс текущего элемента
	 */
	private $_index;
	/**
	 * @var array данные для итерации
	 */
	private $_data;
	/**
	 * @var integer колчество эоементов, содержащихся в данных
	 */
	private $_count;

	/**
	 * @param array $data данные для итерации
	 */
	public function __construct($data)
	{
		$this->_data = $data;
		$this->_index = 0;
		$this->_count = count($data);
	}

	/**
	 * Возвращает текщий элемент
	 * @link http://php.net/manual/en/iterator.current.php
	 * @return mixed
	 */
	public function current()
	{
		return $this->_data[$this->_index];
	}

	/**
	 * Перемещает указатель на следующий элемент
	 * @link http://php.net/manual/en/iterator.next.php
	 * @return void
	 */
	public function next()
	{
		$this->_index++;
	}

	/**
	 * Возвращает ключ текущего элемента
	 * @link http://php.net/manual/en/iterator.key.php
	 * @return mixed
	 */
	public function key()
	{
		return $this->_index;
	}

	/**
	 * Делает проверку на существование смещения
	 * @link http://php.net/manual/en/iterator.valid.php
	 * @return boolean
	 */
	public function valid()
	{
		return $this->_index < $this->_count;
	}

	/**
	 * Устанавливает смещение в начало данных
	 * @link http://php.net/manual/en/iterator.rewind.php
	 * @return void
	 */
	public function rewind()
	{
		$this->_index = 0;
	}
}
