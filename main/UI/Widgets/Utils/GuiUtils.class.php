<?php
/***************************************************************************
 *   Copyright (C) by Evgeny M. Stepanov                                   *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/


class GuiUtils
{
	public static function ObjectToString($object)
	{
		if (is_object($object)) {

			if ($object instanceof Date)
				return (string)$object->toDate();

			elseif ($object instanceof Named)
				return $object->getName();

			elseif ($object instanceof Titled)
				return $object->getTitle();

			elseif ($object instanceof Stringable)
				return $object->toString();

			elseif ($object instanceof Identifiable)
				return get_class($object).'['.$object->getId().']';
		} else
			return (string)$object;
	}
}
