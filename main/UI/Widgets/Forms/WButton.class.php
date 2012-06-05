<?php
/***************************************************************************
 *   Copyright (C) by Georgiy T. Kutsurua                                  *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/

	class WButton extends WFormElement
	{
		protected $tplPrefix	= 'form';
		protected $tplName		= 'button';

		/**
		 * @static
		 * @param null $name
		 * @return WButton
		 */
		public static function create($name=null)
		{
			return new static($name);
		}
	}