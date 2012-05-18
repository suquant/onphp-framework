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
	 * @var array
	 */
	protected $attrs			= array();

	/**
	 * @static
	 * @param null $name
	 * @return WPropertiesElement
	 */
	public static function create($name=null)
	{
		return new static($name);
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
		if(
			!isset($this->attrs['class']) ||
			!array_search($value, $this->attrs['class'])
		)
			$this->attrs['class'][] = $value;

		return $this;
	}

	/**
	 * @param $value
	 * @return WPropertiesElement
	 */
	public function removeClass($value)
	{
		if(
			isset($this->attrs['class'])
			&& ($key = array_search($value, $this->attrs['class']))
		)
			unset($this->attrs['class'][$key]);

		return $this;
	}

	/**
	 * @param $value
	 * @return WPropertiesElement
	 */
	public function setClass($value)
	{
		return $this->addClass($value);
	}

	/**
	 * @param $attr
	 * @return WPropertiesElement
	 */
	public function dropAttr($attr)
	{
		if(isset($this->attrs[$attr]))
			unset($this->attrs[$attr]);

		return $this;
	}

	/**
	 * @param $attr
	 * @param $value
	 * @return WPropertiesElement
	 */
	public function setAttr($attr, $value)
	{
		Assert::isScalar($value);

		$this->attrs[$attr] = $value;

		return $this;
	}

	/**
	 * @param $attr
	 * @return null
	 */
	public function getAttr($attr)
	{
		if(isset($this->attrs[$attr]))
			return $this->attrs[$attr];

		return null;
	}

	/**
	 * Get all attributes
	 * @return array
	 */
	public function getAttrs()
	{
		return $this->attrs;
	}

	/**
	 * Set attrs
	 * Important: All old attributes will be ovverided
	 * @param array $attrs
	 * @return WPropertiesElement
	 */
	public function setAttrs(array $attrs)
	{
		foreach($attrs as $key => $value)
			$this->setAttr($key, $value);

		return $this;
	}

	/**
	 * @return string result
	 */
	protected function rendering(/*Model*/$model = null, $merge=true)
	{
		$attrs = $this->attrs;

		$this->model->set(
			'getAttr',
			function($name=null, $value=null, $separator=' ') use (&$attrs)
			{
				if($name) {
					Assert::isScalar($name, 'attr name must be scalar type, gived "'.gettype($name).'"');

					if($value) {
						Assert::isScalar($value, 'attr value must be scalar type, gived "'.gettype($value).'"');

						if($name=='class')
						{
							if(!isset($attrs['class']))
								$attrs['class'] = array();

							$attrs['class'] = array_merge(
								$attrs['class'],
								array(
									$value
								)
							);
						} else {
							$attrs[$name] = $value;
						}
					}

					$return = isset($attrs[$name])
							? $attrs[$name]
							: '';

					unset($attrs[$name]);

					if(is_array($return))
						$return = implode($separator, $return);

					return $return;
				} else {
					$return = '';

					foreach($attrs as $key => $value)
					{
						if(is_array($value))
							$value = implode($separator, $value);

						$return.=' '.$key.'="'.$value.'"';
					}

					return $return;
				}

				Assert::isUnreachable();
			}
		);

		return parent::rendering($model, $merge);
	}


}
