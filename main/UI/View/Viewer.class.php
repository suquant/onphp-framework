<?php
/***************************************************************************
 *   Copyright (C) by Evgeny M. Stepanov                                   *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/


class Viewer extends Singleton
{
	protected static $partViewers = array();

	/**
	 * include tpl
	 *
	 * @param string $path
	 * @return IfacePartViewer
	 */
	static public function load($path=null, $model=null)
	{
		if (self::get() instanceof IfacePartViewer)
			return self::get()->view($path, $model);

		throw new WrongArgumentException('PartViewer is not defined');
	}

	/**
	 * get current PartViever
	 * @return	IfacePartViewer
	 */
	static public function get()
	{
		return current(self::$partViewers);
	}

	/**
	 * push in a stack
	 * @return	IfacePartViewer
	 */
	static public function push(IfacePartViewer $partViewer)
	{
		array_push(self::$partViewers, $partViewer);

		return $partViewer;
	}

	/**
	 * Pop the element off the end of stack
	 * @return IfacePartViewer | null
	 */
	static public function pop()
	{
		return array_pop(self::$partViewers);
	}

}

