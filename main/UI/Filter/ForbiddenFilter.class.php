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
 * Forbidden only the specified items
 */
class ForbiddenFilter extends BaseFieldsFilter
{

	public function apply($value)
	{
		Assert::isTrue(
			(
				is_array($value) && is_scalar(key($value))
			),
			'Value must be an array and each elements must be scalar type!'
		);

		foreach ($this->fields as $val) {
			unset($value[$val]);
		}

		return parent::apply($value);
	}
}

