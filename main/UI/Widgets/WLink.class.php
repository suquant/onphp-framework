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
 * @method WLink create()
 * @method WLink setTplName()
 * @method WLink setViewer()
 * @method WLink setModel()
 * @method WLink setParams()
 * @method WLink setValue()
 */
class WLink extends WPropertiesElement
{
	protected $tplName = 'hyperlink';

	public function __construct($name = null)
	{
		parent::__construct($name);
		$this->model->
			set('id', '')->
			set('class', '');
	}

	/**
	 * @param type $classes
	 * @return WLink
	 */
	public function setCSSClass($classes)
	{
		$this->model->set('class', $classes);
		return $this;
	}
}

