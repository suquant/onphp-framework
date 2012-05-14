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
	class WTernary extends WFormElement
	{
		protected $tplName = 'ternary';

		/**
		 * @static
		 * @param null $name
		 * @return WTernary
		 */
		public static function create($name=null)
		{
			return new static($name);
		}

		public function __construct($name=null)
		{
			parent::__construct($name);

			$this->setTrueValue(1);
			$this->setFalseValue(0);
		}

		/**
		 * @param type $value
		 * @return WTernary
		 */
		public function setTrueValue($value)
		{
			$this->model->set('trueValue', $value);

			return $this;
		}

		/**
		 * @param type $value
		 * @return WTernary
		 */
		public function setFalseValue($value)
		{
			$this->model->set('falseValue', $value);

			return $this;
		}

		/**
		 * @return Model
		 */
		protected function makeModel()
		{
			return parent::makeModel();
		}
	}
