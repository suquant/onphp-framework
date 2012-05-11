<?php
/***************************************************************************
 *   Copyright (C) 2012 by Kutsurua Georgy Tamazievich                     *
 *   email: g.kutsurua@gmail.com, icq: 723737, jabber: soloweb@jabber.ru   *
 ***************************************************************************/


	class Widget extends StaticFactory
	{
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