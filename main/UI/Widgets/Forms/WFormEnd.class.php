<?php
/***************************************************************************
 *   Copyright (C) by Evgeny M. Stepanov                                   *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/


	class WFormEnd extends BaseWidget
	{
		protected $tplName = 'formEnd';
		protected $tplPrefix = 'form';

		/**
		 * @static
		 * @return WFormEnd
		 */
		public static function create()
		{
			return new static();
		}
	}