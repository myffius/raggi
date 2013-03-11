<?php
class RParamsCollection extends RCollection
{

	public function __construct(array $collection = array())
	{
		$this->setCollection($collection);
	}
}
