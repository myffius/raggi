<?php

namespace raggi\db;

class DbQuery extends \raggi\base\BaseComponent
{
	public $table;
	public $select = '*';
	public $from = '';
	public $where = '';

	public function select($columns = '*')
	{
		$this->select = $columns;
		return $this;
	}

	public function from($tables)
	{
		$this->from = $tables;
		return $this;
	}

	public function where($condition)
	{
		$this->where = $condition;
		return $this;
	}

	protected function prepareColumns($columns)
	{
		if (is_string($columns))
		{
			$columns = str_replace(' as ', ' AS ', $columns);
			$columns = explode(',', $columns);
			foreach ($columns as $key => $column)
				$columns[$key] = explode(' AS ', $column);
			$columns = $this->trim($columns);
			foreach ($columns as $key => $value)
			{
				unset($columns[$key]);
				if (isset($value[1]))
					$columns[$value[1]] = $value[0];
				else
					$columns[] = $value[0];
			}
		}

		$resultColumns = array();
		foreach ($columns as $alias => $columnName)
		{
			$column = '`' . $columnName . '`';
			if (!is_int($alias))
				$column .= ' AS ' . $alias;
			$resultColumns[] = $column;
		}
		return join(', ', $resultColumns);
	}

	protected function prepareSelect($columns)
	{
		return $this->prepareColumns($columns);
	}

	protected function prepareFrom($tables)
	{
		return $this->prepareColumns($tables);
	}

	public function trim($data)
	{
		if (is_array($data))
		{
			foreach ($data as $key => $value)
				$data[$key] = is_array($value) ? $this->trim($value) : trim($value);
		}
		elseif (is_string($data))
			$data = trim($data);
		return $data;
	}

	public function clear()
	{
		$this->table = null;
		$this->select = '*';
		$this->where = '';
	}

	public function getSql()
	{
		$query  = 'SELECT ' . $this->prepareSelect($this->select);
		$query .= ' FROM ' . $this->prepareFrom($this->from);
		return $query;
	}

	public function __toString()
	{
		return $this->getSql();
	}
}
