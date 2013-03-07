<?php

	class RCoreComponent
	{
		public function __get($property)
		{
			$getter = 'get' . $property;
			if (method_exists($this, $getter))
				return $this->$getter();
			throw new RException('Property '.$property.' is not defined in '.get_class($this));
		}

		public function __set($property, $value)
		{
			$setter = 'set' . $property;
			if (method_exists($this, $setter))
				return $this->$setter($value);
			throw new RException('Property '.$property.' is not defined in '.get_class($this));
		}
	}
