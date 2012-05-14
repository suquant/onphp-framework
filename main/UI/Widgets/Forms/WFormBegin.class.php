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
	 *
	 * @out variables
	 * 	$caption
	 * 	$description
	 * 	$action
	 * 	$method
	 * 	$enctype
	 */
	class WFormBegin extends WFormElement
	{
		protected $tplName = 'formBegin';


		/**
		 * @static
		 * @param null $name
		 * @return WFormBegin
		 */
		public static function create($name=null)
		{
			return new static($name);
		}

		public function __construct($name=null)
		{
			parent::__construct($name=null);

			$this->model->set('caption', null);
			$this->model->set('description', null);
			$this->model->set('action', null);
			$this->model->set('method', 'GET');
			$this->model->set('enctype', 'multipart/form-data');
		}

		/**
		 * @return WFormBegin
		 */
		public function setAction($action)
		{
			$this->model->set('action', $action);

			return $this;
		}

		/**
		 * @return WFormBegin
		**/
		public function setMethod($method)
		{
			$this->model->set('method', $method);

			return $this;
		}

		/**
		 * @return WFormBegin
		**/
		public function setEnctype($enctype)
		{
			$this->model->set('enctype', $enctype);

			return $this;
		}

		/**
		 * @return WFormBegin
		**/
		public function setCaption($caption)
		{
			$this->model->set('caption', $caption);

			return $this;
		}

		/**
		 * @return WFormBegin
		 */
		public function setDescription($description)
		{
			$this->model->set('description', $description);

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

