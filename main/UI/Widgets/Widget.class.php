<?php
/***************************************************************************
 *   Copyright (C) 2012 by Kutsurua Georgy Tamazievich                     *
 *   email: g.kutsurua@gmail.com, icq: 723737, jabber: soloweb@jabber.ru   *
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
		 * @return WidgetButton
		 */
		public static function button()
		{
			return WidgetButton::create();
		}

		/**
		 * @static
		 * @return WidgetButtonGroup
		 */
		public static function buttonGroup()
		{
			return WidgetButtonGroup::create();
		}

		/**
		 * @static
		 * @return WidgetButtonDropDown
		 */
		public static function buttonDropDown()
		{
			return WidgetButtonDropDown::create();
		}

		/**
		 * @static
		 * @param Form $form
		 * @param Hstore|null $labels
		 * @return WForm
		 */
		public static function form(Form $form, Hstore $labels=null)
		{
			return WForm::create($form, $labels);
		}

	}