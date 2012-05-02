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
 * @package UI\Widget
 */
class WPropertiesElement extends BaseWidget
{
	/**
	 *
	 * @param type $name
	 * @param type $value
	 * @param array $params
	 * @return WPropertiesElement
	 */
	static public function create($name=null, $value=null, array $params=array())
	{
		$widget = new static($name);

		if ($value)
			$widget->setValue($value);

		if ($params)
			$widget->setParams($params);

		return $widget;
	}
		
	/**
	 * @param array $params
	 * @return WPropertiesElement
	 */
	public function setParams(array $params)
	{
		foreach($params as $key => $value) {
			$this->model->set($key, $value);
		}

		return $this;
	}

	/**
	 * @param  $value
	 * @return WPropertiesElement
	 */
	public function setValue($value)
	{
		$this->model->set('value', $value);

		return $this;
	}
}
