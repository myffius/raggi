<?php

namespace raggi\base\sessions;

use \raggi\base\BaseComponent;
use \raggi\exceptions\Exception;

/**
 * Реализует механизм работы с сессией.
 * Использует стандартный механизм хранения.
 *
 * @property boolean $isStarted
 * @property string $id
 * @property string $name
 * @property integer $count
 * @property \raggi\base\sessions\HttpSessionIterator $iterator
 */
class NativeHttpSession extends BaseComponent implements SessionHandlerInterface, \IteratorAggregate, \ArrayAccess, \Countable
{
	/**
	 *
	 */
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
	 * Возращает количество элементов в сессии
	 * @return int
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
	 * Возвращает итератор для объекта сессии
	 * @link http://php.net/manual/ru/iteratoraggregate.getiterator.php
	 * @return \raggi\base\sessions\HttpSessionIterator
	 */
	public function getIterator()
	{
		return new HttpSessionIterator;
	}

	/**
	 * Определяет, существует ли заданное смещение (ключ)
	 * Данный метод вызывается, когда используется функция isset() или
	 * функция empty() для текущего объекта
	 * @link http://php.net/manual/ru/arrayaccess.offsetexists.php
	 * @param mixed $offset ключ для проверки
	 * @return bool
	 */
	public function offsetExists($offset)
	{
		return isset($_SESSION[$offset]);
	}

	/**
	 * Возвращает значение по заданному смещению (ключу)
	 * Данный метод исполняется, когда проверяется смещение (ключ)
	 * на пустоту с помощью функции empty().
	 * @link http://php.net/manual/ru/arrayaccess.offsetget.php
	 * @param mixed $offset смещение (ключ) для возврата.
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		return isset($_SESSION[$offset]) ? $_SESSION[$offset] : null;
	}

	/**
	 * Устанавливает заданное смещение (ключ)
	 * @link http://php.net/manual/ru/arrayaccess.offsetset.php
	 * @param mixed $offset смещение (ключ), которому будет присваиваться значение.
	 * @param mixed $value значение для присвоения.
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		$_SESSION[$offset] = $value;
	}

	/**
	 * Удаляет смещение
	 * @link http://php.net/manual/ru/arrayaccess.offsetunset.php
	 * @param mixed $offset Смещение для удаления.
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
	 * @throws \raggi\exceptions\Exception
	 * @return bool <p>
	 * Возвращаемое значение сессионного хранилища (обычно TRUE в случае успеха, FALSE в случае ошибки).
	 * Данное значение возвращается обратно в PHP для внутренней обработки.
	 * </p>
	 */
	public function open($savePath, $sessionId)
	{
		if ($this->getIsStarted())
			throw new Exception('Повторное открытие сессии');
		return session_start();
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
		return '';
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
		return true;
	}

	/**
	 * Возращает true, если сессия запущена
	 * @return bool
	 */
	public function getIsStarted()
	{
		return session_id() != '';
	}

	/**
	 * @param bool $destroy
	 * @return bool
	 */
	public function regenerate($destroy = false)
	{
		return session_regenerate_id($destroy);
	}

	/**
	 * @return string
	 */
	public function getId()
	{
		return session_id();
	}

	/**
	 * @param $sessionId
	 */
	public function setId($sessionId)
	{
		session_id($sessionId);
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return session_name();
	}

	/**
	 * @param $sessionName
	 */
	public function setName($sessionName)
	{
		session_name($sessionName);
	}

	public function getSavePath()
	{
		return session_save_path();
	}

	public function setSavePath($path)
	{
		if(is_dir($path))
			session_save_path($path);
		else
			throw new Exception('Указан некорректный путь');
	}
}
