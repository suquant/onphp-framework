<?php
/***************************************************************************
 *   Copyright (C) by Evgeny M. Stepanov & Georgiy T. Kutsurua             *
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
	public static function create($name=null, $value=null, array $params=array())
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

	/**
	 * @param $value
	 * @return WPropertiesElement
	 */
	public function addClass($value)
	{
		$class = $this->getAttr('class');

		if($class)
			$class.=' '.$value;
		else
			$class = $value;

		return $this->setAttr('class', $class);
	}

	/**
	 * @param $value
	 * @return WPropertiesElement
	 */
	public function removeClass($value)
	{
		return $this->dropAttr('class');
	}

	/**
	 * @param $value
	 * @return WPropertiesElement
	 */
	public function setClass($value)
	{
		return $this->setAttr('class', $value);
	}

	/**
	 * @return null
	 */
	public function getClass()
	{
		return $this->getAttr('class');
	}

	/**
	 * @param $attr
	 * @return WPropertiesElement
	 */
	public function dropAttr($attr)
	{
		$attrs = $this->getAttrs();

		if(isset($attrs[$attr]))
			unset($attrs[$attr]);

		return $this->setAttrs($attrs);
	}

	/**
	 * @param $attr
	 * @param $value
	 * @return WPropertiesElement
	 */
	public function setAttr($attr, $value)
	{
		$attrs = $this->getAttrs();
		$attrs[$attr] = $value;

		return $this->setAttrs($attrs);
	}

	/**
	 * @param $attr
	 * @return null
	 */
	public function getAttr($attr)
	{
		$attrs = $this->getAttrs();

		if(isset($attrs[$attr]))
			return $attrs[$attr];

		return null;
	}

	/**
	 * Get all attributes
	 * @return array
	 */
	public function getAttrs()
	{
		if(!$this->model->has('attrs') )
			$this->model->set('attrs', array());

		return $this->model->get('attrs');
	}

	/**
	 * Set attrs
	 * Important: All old attributes will be ovverided
	 * @param array $attrs
	 * @return WPropertiesElement
	 */
	public function setAttrs(array $attrs)
	{
		$this->model->set('attrs', $attrs);

		return $this;
	}

	/**
	 * @return string
	 */
	protected function makeStringedAttrs()
	{
		$attrs = $this->getAttrs();
		$res = '';

		foreach($attrs as $key => $value)
			$res .= ' '.$key.'="'.$value.'"';

		return $res;
	}

	/**
	 * @return string result
	 */
	protected function rendering(/*Model*/$model = null, $merge=true)
	{
		$this->model->set(
			'stringedAttrs',
			$this->makeStringedAttrs()
		);

		return parent::rendering($model, $merge);
	}


}
