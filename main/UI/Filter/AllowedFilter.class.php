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
	 * allow only the specified items
	 */
	class AllowedFilter extends BaseFieldsFilter
	{

		/**
		 * @return BaseFieldsFilter
		 */
		public function apply($value)
		{
			$diff = array_diff(
				array_keys($value),
				array_values($this->fields)
			);

			foreach($diff as $key)
				unset($value[$key]);

			return parent::apply($value);
		}
	}

?>
