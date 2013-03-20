<?php

namespace raggi\collections;

class ParamsCollection extends Collection
{
	public function __construct(array $collection = array())
	{
		$this->setCollection($collection);
	}
}
