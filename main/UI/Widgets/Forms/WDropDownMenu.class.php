<?php
/***************************************************************************
 *   Copyright (C) by Georgiy T. Kutsurua                                  *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/

	class WDropDownMenu extends WFormElement
	{
		protected $tplPrefix	= 'form';
		protected $tplName		= 'dropDownMenu';

		/**
		 * @static
		 * @param null $name
		 * @return WDropDownMenu
		 */
		public static function create($name=null)
		{
			return new static($name);
		}

		public function __construct($name=null)
		{
			parent::__construct($name);

			$this->model->set('links', array());
		}

		/**
		 * @param WButton $button
		 */
		public function add(WLink $link)
		{
			$links = $this->model->get('links');
			$links[] = $link;

			$this->model->set('links', $links);

			return $this;
		}


	}