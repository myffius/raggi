<?php

namespace raggi\base;

use \raggi\exceptions\Exception;

class BaseComponent
{
	public function __get($property)
	{
		$getter = 'get' . $property;
		if (method_exists($this, $getter))
			return $this->$getter();
		throw new Exception('В классе '.get_class($this).' не определено свойство '.$property);
	}

	public function __set($property, $value)
	{
		$setter = 'set' . $property;
		if (method_exists($this, $setter))
			return $this->$setter($value);
		throw new Exception('В классе '.get_class($this).' не определено свойство '.$property);
	}

	public function raiseEvent($sender)
	{

	}
}
