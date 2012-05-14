<?php

abstract class View_Wedding extends Kostache_Layout {

	protected $_layout = 'layout';

	public function charset()
	{
		return Kohana::$charset;
	}

}

