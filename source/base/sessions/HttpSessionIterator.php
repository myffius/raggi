<?php

namespace raggi\base\sessions;
/**
 * Итератор для сессий.
 * @see \raggi\base\sessions\NativeHttpSession::getIterator()
 */
class HttpSessionIterator implements \Iterator
{
	/**
	 * Ключи массива $_SESSION
	 * @var array
	 */
	private $_keys;
	/**
	 * Текщие положение указателя в массиве ключей
	 * @var int
	 * @see \raggi\base\sessions\NativeHttpSession::$_keys
	 */
	private $_currentKeyIndex;

	public function __construct()
	{
		$this->_keys = array_keys($_SESSION);
		$this->_currentKeyIndex = 0;
	}
	/**
	 * Возвращает текущий элемент
	 * @link http://php.net/manual/ru/iterator.current.php
	 * @return mixed
	 */
	public function current()
	{
		return $_SESSION[$this->_keys[$this->_currentKeyIndex]];
	}

	/**
	 * Смещает указатель на следующий элемент
	 * @link http://php.net/manual/ru/iterator.next.php
	 * @return void
	 */
	public function next()
	{
		$this->_currentKeyIndex++;
	}

	/**
	 * Возвращает ключ текущего элемента
	 * @link http://php.net/manual/ru/iterator.key.php
	 * @return mixed значение, если ключ существует, иначе null
	 */
	public function key()
	{
		return isset($this->_keys[$this->_currentKeyIndex]) ? $this->_keys[$this->_currentKeyIndex] : null;
	}

	/**
	 * Выполняет проверку на валидность текущей позиции
	 * @link http://php.net/manual/ru/iterator.valid.php
	 * @return bool
	 */
	public function valid()
	{
		return $this->_currentKeyIndex !== false;
	}

	/**
	 * Сбрасывает указатель на первый элемент массива
	 * @link http://php.net/manual/ru/iterator.rewind.php
	 * @return void
	 */
	public function rewind()
	{
		$this->_currentKeyIndex = 0;
	}
}
