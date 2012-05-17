<?php
/***************************************************************************
 *   Copyright (C) by Georgiy T. Kutsurua                                  *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/


	class Widget extends StaticFactory
	{
		/**
		 * @var ViewResolver
		 */
		protected static $defaultViewResolver	= null;

		/**
		 * Map for view resolver
		 * @var array
		 */
		protected static $viewResolverMap		= array();

		/**
		 * @static
		 * @return ViewResolver
		 */
		public static function getViewResolver(IfaceWidget $widget=null)
		{
			$name = $widget
				? get_class($widget)
				: null;

			if($name && isset(static::$viewResolverMap[$name]))
				return static::$viewResolverMap[$name];

			return static::getDefaultViewResolver();
		}

		/**
		 * @static
		 * @return ViewResolver
		 */
		public static function getDefaultViewResolver()
		{
			if(!static::$defaultViewResolver)
			{
				static::setDefaultViewResolver(
					MultiPrefixPhpViewResolver::create()->setViewClassName(
						'SimplePhpView'
					)->setPostfix(
						EXT_TPL
					)->addPrefix(
						ONPHP_UI_DEFAULT_WTEMPLATES_PATH
					)
				);
			}

			return static::$defaultViewResolver;
		}

		/**
		 * @static
		 * @param ViewResolver $resolver
		 */
		public static function setDefaultViewResolver(ViewResolver $resolver)
		{
			static::$defaultViewResolver = $resolver;
		}

		/**
		 * @static
		 * @param array $map
		 */
		public static function setViewResolverMap(array $map=array())
		{
			static::$viewResolverMap = $map;
		}

		/**
		 * @static
		 * @return WTable
		 */
		public static function table()
		{
			return WTable::create();
		}

		/**
		 * @static
		 * @return WButton
		 */
		public static function button()
		{
			return WButton::create();
		}

		/**
		 * @static
		 * @return WButtonGroup
		 */
		public static function buttonGroup()
		{
			return WButtonGroup::create();
		}

		/**
		 * @static
		 * @return WDropDownMenu
		 */
		public static function dropDownMenu()
		{
			return WDropDownMenu::create();
		}

	}