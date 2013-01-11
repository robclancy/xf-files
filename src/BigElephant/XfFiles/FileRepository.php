<?php namespace BigElephant\XfFiles;

use ArrayAccess;
use IteratorAggregate;

class FileRepository implements ArrayAccess, IteratorAggregate {

	protected $files;

	public function __construct($dir = false)
	{
		if ($dir)
		{
			$this->scanDirectory($dir);
		}
	}

	public function scanDirectory($path)
	{
		
	}

	public function getIterator()
	{
		return new ArrayIterator($this->files);
	}

	public function get($key)
	{
		if (isset($this->files[$key]))
		{
			return $this->files[$key];
		}

		return null;
	}

	public function has($key)
	{
		return ! is_null($this->get($key));
	}

	public function offsetExists($key)
	{
		return $this->has($key);
	}

	public function offsetGet($key)
	{
		return $this->get($key);
	}

	public function offsetSet($key, $value)
	{
	}

	public function offsetUnset($key)
	{
	}
}