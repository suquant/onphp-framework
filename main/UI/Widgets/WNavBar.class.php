<?php
/***************************************************************************
 *   Copyright (C) by Evgeny M. Stepanov                                   *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/

/**
 * @method WLink setTplName()
 * @method WLink setViewer()
 * @method WLink setModel()
 */
class WNavBar extends BaseWidget
{
	protected $tplName = 'navbar';

	/**
	 *
	 * @param type $name
	 * @return WNavBar
	 */
	public static function create($name = null)
	{
		return new static($name);
	}


	public function __construct($name = null)
	{
		parent::__construct($name);

		$this->model->
			set('brandHref', '')->
			set('brandValue', '');
	}

	/**
	 * @param type $href
	 * @param type $value
	 * @return WNavBar
	 */
	public function setBrand($href, $value)
	{
		$this->model->
			set('brandHref', $href)->
			set('brandValue', $value);

		return $this;
	}
}

