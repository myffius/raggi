<?php
namespace raggi\base\sessions
{
	/**
	 * SessionHandlerInterface интерфейс, который является
	 * прототипом для создания пользовательского обработчика сессии.
	 * Любой класс обработчика должен реализовывать этот интерфейс.
	 * В более ранних версиях заменяет стандартный интерфейс
	 * SessionHandlerInterface, доступный в PHP >= 5.4.0
	 * @link http://www.php.net/manual/ru/class.sessionhandlerinterface.php
	 */
	interface SessionHandlerInterface
	{

		/**
		 * Закрывает сессию
		 * @link http://www.php.net/manual/ru/sessionhandlerinterface.close.php
		 * @return bool <p>
		 * Возвращаемое значение сессионного хранилища (обычно TRUE в случае успеха, FALSE в случае ошибки).
		 * Данное значение возвращается обратно в PHP для внутренней обработки.
		 * </p>
		 */
		public function close();

		/**
		 * Уничтожает сессию
		 * @link http://www.php.net/manual/ru/sessionhandlerinterface.destroy.php
		 * @param int $sessionId идентификатор уничтожаемой сессии.
		 * @return bool <p>
		 * Возвращаемое значение сессионного хранилища (обычно TRUE в случае успеха, FALSE в случае ошибки).
		 * Данное значение возвращается обратно в PHP для внутренней обработки.
		 * </p>
		 */
		public function destroy($sessionId);

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
		public function gc($maxLifeTime);

		/**
		 * Инициализирует сессию
		 * @link http://www.php.net/manual/ru/sessionhandlerinterface.open.php
		 * @param string $savePath путь для сохранения фала сессии.
		 * @param string $sessionId идентификатор сессии.
		 * @return bool <p>
		 * Возвращаемое значение сессионного хранилища (обычно TRUE в случае успеха, FALSE в случае ошибки).
		 * Данное значение возвращается обратно в PHP для внутренней обработки.
		 * </p>
		 */
		public function open($savePath, $sessionId);


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
		public function read($sessionId);

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
		public function write($sessionId, $sessionData);
	}

}
