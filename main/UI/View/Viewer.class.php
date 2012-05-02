<?php
/***************************************************************************
 *   Copyright (C) by Evgeny M. Stepanov                                   *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/
/* $Id: Viewer.class.php 337 2011-02-02 14:17:00Z stev $ */




class Viewer extends Singleton
{
	protected static $partViewers = array();

	/**
	 * Ð¾ÑÐºÑÑÑÑ ÑÐµÐ¼Ð¿Ð»ÐµÐ¹Ñ ÑÐºÐ°Ð·ÑÐ²Ð°Ñ Ð¾ÑÐ½Ð¾ÑÐ¸ÑÐµÐ»ÑÐ½ÑÐ¹ Ð¿ÑÑÑ
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
	 * Ð¿Ð¾Ð»ÑÑÐ¸ÑÑ ÑÐµÐºÑÑÐ¸Ð¹
	 * @return	IfacePartViewer
	 */
	static public function get()
	{
		return current(self::$partViewers);
	}

	/**
	 * Ð¿Ð¾Ð¼ÐµÑÐ°ÐµÐ¼ Ð² ÑÑÐµÐº
	 * @return	IfacePartViewer
	 */
	static public function push(IfacePartViewer $partViewer)
	{
		array_push(self::$partViewers, $partViewer);

		return $partViewer;
	}

	/**
	 * Ð¸Ð·Ð²Ð»ÐµÐºÐ°ÐµÐ¼ Ð¸Ð· ÑÑÐµÐºÐ°
	 * @return IfacePartViewer | null
	 */
	static public function pop()
	{
		return array_pop(self::$partViewers);
	}

}

