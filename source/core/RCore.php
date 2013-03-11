<?php

	class RCore
	{
		protected $__classVersion__ = '';

		public function __get($property)
		{
			$getter = 'get' . $property;
			if (method_exists($this, $getter))
				return $this->$getter();
			throw new RException('В классе '.get_class($this).' не определено свойство '.$property);
		}

		public function __set($property, $value)
		{
			$setter = 'set' . $property;
			if (method_exists($this, $setter))
				return $this->$setter($value);
			throw new RException('В классе '.get_class($this).' не определено свойство '.$property);
		}

		public function getClassVersion()
		{
			return get_class($this) . ' ' . $this->__classVersion__;
		}
	}
