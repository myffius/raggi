<?php

namespace raggi\base\url;

abstract class UrlRouter
{
	const URL_SCHEME        = 0;
	const URL_HOST          = 1;
	const URL_PORT          = 2;
	const URL_USER          = 3;
	const URL_PASS          = 4;
	const URL_PATH          = 5;
	const URL_QUERY         = 6;
	const URL_FRAGMENT      = 7;
	const URL_CONTROLLER_ID = 8;
	const URL_ACTION_ID     = 9;

	/**
	 * Разбирает URL и возвращает его компоненты
	 * Эта функция разбирает URL и возвращает ассоциативный массив,
	 * содержащий все компоненты URL, которые в нём присутствуют.
	 * Также в массив включены идентификаторы запрашиваемого контроллера
	 * и экшена
	 * @link http://www.php.net/manual/ru/function.parse-url.php
	 * @param $uri
	 * @param $component
	 * @return mixed
	 */
	abstract public function parseUrl($uri, $component = -1);
	abstract public function createUrl($controller, $action, $params = array());
}
