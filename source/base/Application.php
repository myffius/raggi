<?php

namespace raggi\base;

use \raggi\http\HttpRequest;
use \raggi\exceptions\Exception;

/**
 * @property string $name;
 * @property string $charset;
 * @property \raggi\http\HttpRequest $request;
 */
class Application extends BaseComponent
{
	public $defaultController;
	public $controllerPath;
	public $controllerNamespace;

	private $_configuration;
	private $_name;
	private $_charset;
	private $_request;
	private $_components;
	private $_events;

	public function configure($configuration)
	{
		$defaultConfig = $this->getDefaultConfiguration();
		$configuration = array_replace_recursive($defaultConfig, $configuration);

		if (isset($configuration['application']['class']))
			unset($configuration['application']['class']);

		$this->_configuration = $configuration;
		$this->initialize($this, $configuration['application']);
	}

	public function processRequest(HttpRequest $request)
	{
		$this->_request = $request;
		// @var UrlRouter $urlRouter
		$urlRouter = $this->createComponent('urlRouter');
		$this->setComponent('urlRouter', $urlRouter);
		list($controllerId, $actionId) = $urlRouter->parseUrl($request->getRequestUri());

		if ($controllerId === null)
			$controllerId = $this->_configuration['application']['defaultController'];

		$controllerClass = $this->controllerNamespace . $controllerId;
		$controller = new $controllerClass;
		$controller->runAction($actionId);
	}

	public function getComponent($componentId)
	{
		if ($this->hasComponent($componentId))
			return $this->getComponent($componentId);

		$component = $this->createComponent($componentId);
		$this->setComponent($componentId, $component);
		return $component;
	}

	public function setComponent($componentId, BaseComponent $component)
	{
		$component->setApplication($this);
		$this->_components[$componentId] = $component;
	}

	public function hasComponent($componentId)
	{
		return isset($this->_components[$componentId]);
	}

	public function createComponent($componentId)
	{
		if (!isset($this->_configuration['components'][$componentId]))
			return null;

		$componentConfig = $this->_configuration['components'][$componentId];
		if (!isset($componentConfig['class']))
			throw new Exception('Не определен класс компонента для "' . $componentId . '"');
		$class = $componentConfig['class'];
		unset($componentConfig['class']);
		$component = new $class;
		$this->initialize($component, $componentConfig);
		return $component;
	}

	public function getName()
	{
		return $this->_name;
	}

	public function setName($name)
	{
		$this->_name = $name;
	}

	public function getCharset()
	{
		return $this->_charset;
	}

	public function setCharset($charset)
	{
		$this->_charset = $charset;
	}

	public function getRequest()
	{
		return $this->_request;
	}

	protected function getDefaultConfiguration()
	{
		return array(
			'application' => array(
				'name' => '',
				'charset' => 'utf-8',
				'defaultController' => 'page',
				'controllerNamespace' => '\raggi\app\controllers\\',
			),
			'managers'=>array(
				'url' => array(
					'class' => '\raggi\route\UrlManager',
				),
			),
			'helpers'=>array(
				'html' => array(
					'class' => '\raggi\helpers\languages\Html',
				),
			),
			'events' => array(

			),
		);
	}
}
