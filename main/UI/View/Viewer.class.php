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
	/**
	 * @var ViewResolver
	 */
	protected static $widgetViewResolver = null;

	/**
	 * @static
	 * @return null|ViewResolver
	 */
	public static function getWidgetViewResolver()
	{
		if(!static::$widgetViewResolver)
			static::setWidgetsResolver(
				MultiPrefixPhpViewResolver::create()->setViewClassName(
					'SimplePhpView'
				)->setPostfix(
					EXT_TPL
				)->addPrefix(
					ONPHP_SOURCE_PATH.'templates'.DIRECTORY_SEPARATOR.'widgets'.DIRECTORY_SEPARATOR.'bootstrap'.DIRECTORY_SEPARATOR
				)
			);

		return static::$widgetViewResolver;
	}

	public static function setWidgetsResolver(ViewResolver $resolver)
	{
		static::$widgetViewResolver = $resolver;
	}
}

