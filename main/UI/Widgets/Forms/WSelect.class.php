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
	class WSelect extends WFormElement
	{
		protected $tplName = 'select';

		/**
		 * @static
		 * @param null $name
		 * @return WSelect
		 */
		public static function create($name=null)
		{
			return new static($name);
		}

		public function __construct($name=null)
		{
			parent::__construct($name);

			$this->model->set('isMulti', null);
		}

		/**
		 * @param array $list
		 * @return WSelect
		 */
		public function setList(array $list)
		{
			$this->model->set('list', $list);

			return $this;
		}

		public function setMulti($boolean)
		{
			$this->model->set('isMulti', ($boolean === true));

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