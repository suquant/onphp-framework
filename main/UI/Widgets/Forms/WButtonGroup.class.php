<?php
/***************************************************************************
 *   Copyright (C) by Georgiy T. Kutsurua                                  *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/

	class WButtonGroup extends WFormElement
	{
		protected $tplPrefix	= 'form';
		protected $tplName		= 'buttonGroup';

		/**
		 * @static
		 * @return WButtonGroup
		 */
		public static function create()
		{
			return new static();
		}

		public function __construct($name=null)
		{
			parent::__construct($name);

			$this->model->set('buttons', array());
		}

		/**
		 * @param WButton $button
		 */
		public function add(WButton $button)
		{
			$buttons = $this->model->get('buttons');
			$buttons[] = $button;

			$this->model->set('buttons', $buttons);

			return $this;
		}


	}