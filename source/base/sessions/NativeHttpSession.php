<?php

namespace raggi\base\sessions;

/**
 *
 */
class NativeHttpSession extends \raggi\base\BaseComponent implements SessionHandlerInterface, \IteratorAggregate, \ArrayAccess, \Countable
{
	public function __construct()
	{
		session_set_save_handler(
			array($this, 'open'),
			array($this, 'close'),
			array($this, 'read'),
			array($this, 'write'),
			array($this, 'destroy'),
			array($this, 'gc')
		);
	}

	/**
	 * Returns the number of items in the session.
	 * @return integer the number of session variables
	 */
	public function getCount()
	{
		return count($_SESSION);
	}

	/**
	 * Количество элементов объекта
	 * @link http://php.net/manual/ru/countable.count.php
	 * @return int
	 */
	public function count()
	{
		return $this->getCount();
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
		return new HttpSessionIterator;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Whether a offset exists
	 * @link http://php.net/manual/en/arrayaccess.offsetexists.php
	 * @param mixed $offset <p>
	 * An offset to check for.
	 * </p>
	 * @return boolean true on success or false on failure.
	 * </p>
	 * <p>
	 * The return value will be casted to boolean if non-boolean was returned.
	 */
	public function offsetExists($offset)
	{
		return isset($_SESSION[$offset]);
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Offset to retrieve
	 * @link http://php.net/manual/en/arrayaccess.offsetget.php
	 * @param mixed $offset <p>
	 * The offset to retrieve.
	 * </p>
	 * @return mixed Can return all value types.
	 */
	public function offsetGet($offset)
	{
		return isset($_SESSION[$offset]) ? $_SESSION[$offset] : null;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Offset to set
	 * @link http://php.net/manual/en/arrayaccess.offsetset.php
	 * @param mixed $offset <p>
	 * The offset to assign the value to.
	 * </p>
	 * @param mixed $value <p>
	 * The value to set.
	 * </p>
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		$_SESSION[$offset] = $value;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Offset to unset
	 * @link http://php.net/manual/en/arrayaccess.offsetunset.php
	 * @param mixed $offset <p>
	 * The offset to unset.
	 * </p>
	 * @return void
	 */
	public function offsetUnset($offset)
	{
		unset($_SESSION[$offset]);
	}

	/**
	 * Закрывает сессию
	 * @link http://www.php.net/manual/ru/sessionhandlerinterface.close.php
	 * @return bool <p>
	 * Возвращаемое значение сессионного хранилища (обычно TRUE в случае успеха, FALSE в случае ошибки).
	 * Данное значение возвращается обратно в PHP для внутренней обработки.
	 * </p>
	 */
	public function close()
	{
		if($this->getIsStarted())
			session_write_close();
	}

	/**
	 * Уничтожает сессию
	 * @link http://www.php.net/manual/ru/sessionhandlerinterface.destroy.php
	 * @param int $sessionId идентификатор уничтожаемой сессии.
	 * @return bool <p>
	 * Возвращаемое значение сессионного хранилища (обычно TRUE в случае успеха, FALSE в случае ошибки).
	 * Данное значение возвращается обратно в PHP для внутренней обработки.
	 * </p>
	 */
	public function destroy($sessionId)
	{
		if ($this->getIsStarted())
		{
			session_unset();
			session_destroy();
		}
	}

	/**
	 * Очищает старые сессии
	 * @link http://www.php.net/manual/ru/sessionhandlerinterface.gc.php
	 * @param int $maxLifeTime <p>
	 * Сессии, которые не обновлялись в течении maxLifeTime секунд будут удалены.
	 * </p>
	 * @return bool <p>
	 * Возвращаемое значение сессионного хранилища (обычно TRUE в случае успеха, FALSE в случае ошибки).
	 * Данное значение возвращается обратно в PHP для внутренней обработки.
	 * </p>
	 */
	public function gc($maxLifeTime)
	{
		return true;
	}

	/**
	 * Инициализирует сессию
	 * @link http://www.php.net/manual/ru/sessionhandlerinterface.open.php
	 * @param string $savePath путь для сохранения фала сессии.
	 * @param string $sessionId идентификатор сессии.
	 * @throws Exception
	 * @return bool <p>
	 * Возвращаемое значение сессионного хранилища (обычно TRUE в случае успеха, FALSE в случае ошибки).
	 * Данное значение возвращается обратно в PHP для внутренней обработки.
	 * </p>
	 */
	public function open($savePath, $sessionId)
	{
		if ($this->getIsStarted())
			throw new Exception('bla bla');
		session_start();
	}

	/**
	 * Читает данные сессии
	 * @link http://www.php.net/manual/ru/sessionhandlerinterface.read.php
	 * @param string $sessionId идентификатор сессии для чтения.
	 * @return string <p>
	 * Возвращает закодированную строку прочитанных данных.
	 * Если ничего не прочитано, возвращается пустая строка.
	 * Возвращаемое  значение передается для обработки внутри PHP.
	 * </p>
	 */
	public function read($sessionId)
	{
		// TODO: Implement read() method.
	}

	/**
	 * Записывает данные в сессию
	 * @link http://www.php.net/manual/ru/sessionhandlerinterface.write.php
	 * @param string $sessionId идентификатор сессии.
	 * @param string $sessionData <p>
	 * Закодированные данные сессии. Эти данные - результат внутреннего кодирование PHP
	 * суперглобального массива $_SESSION в сериализованную строку и передачи ее
	 * в качестве этого параметра.
	 * </p>
	 * @return bool <p>
	 * Возвращаемое значение сессионного хранилища (обычно TRUE в случае успеха, FALSE в случае ошибки).
	 * Данное значение возвращается обратно в PHP для внутренней обработки.
	 * </p>
	 */
	public function write($sessionId, $sessionData)
	{
		// TODO: Implement write() method.
	}

	/**
	 * @return bool
	 */
	public function getIsStarted()
	{
		return session_id() != '';
	}
}
