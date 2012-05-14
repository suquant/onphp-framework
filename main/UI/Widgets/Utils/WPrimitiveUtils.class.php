<?php
/***************************************************************************
 *   Copyright (C) by Georgiy T. Kutsurua                                  *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/

	class WPrimitiveUtils extends StaticFactory
	{
		protected static $map = array(
			'BasePrimitive' => 'makeByBasePrimitive', // Default

			'PrimitiveDate' => 'makeByPrimitiveDate',
			'PrimitiveTime' => 'makeByPrimitiveTime',
			'PrimitiveString' => 'makeByPrimitiveString',
			'PrimitiveBoolean' => 'makeByPrimitiveBoolean',
			'PrimitiveTernary' => 'makeByPrimitiveTernary',
			'PrimitiveEnumeration' => 'makeByPrimitiveEnumeration',
			'PrimitiveEnumerationList' => 'makeByPrimitiveEnumerationList',
			'PrimitiveEnum' => 'makeByPrimitiveEnum',
			'PrimitiveEnumList' => 'makeByPrimitiveEnumList',
		);

		/**
		 * @param BasePrimitive $primitive
		 * @return WFormElement
		 * @throws WrongArgumentException
		 */
		public static function makeByPrimitive(BasePrimitive $primitive)
		{
			$widget = null;
			$primitiveClassName = get_class($primitive);
			$widgetClassName = $primitiveClassName;

			if(isset(static::$map[$widgetClassName]))
				$widget = ClassUtils::callStaticMethod(__CLASS__.'::'.static::$map[$widgetClassName], $primitive);
			else {
				$parents = class_parents($primitiveClassName);

				foreach($parents as $parent)
				{
					$className = $parent;
					if(isset(static::$map[$className])) {
						$widget = ClassUtils::callStaticMethod(__CLASS__.'::'.static::$map[$className], $primitive);
						break;
					}

				}
			}

			if(!$widget)
				throw new WrongArgumentException(
					'cannot find widget for "'.$primitiveClassName.'" primitve!'
				);

			return $widget;
		}

		/**
		 * @static
		 * @param WFormElement $widget
		 * @param BasePrimitive $primitive
		 * @return WFormElement
		 */
		protected static function fill(WFormElement $widget, BasePrimitive $primitive)
		{
			return $widget->setLabel(
				$primitive->getName()
			)->setRequired(
				$primitive->isRequired()
			)->setName(
				$primitive->getName()
			);
		}

		/**
		 * @static
		 * @param BasePrimitive $primitive
		 * @return WTextField
		 */
		public static function makeByBasePrimitive(BasePrimitive $primitive)
		{
			return static::fill(
				WTextField::create()->setValue($primitive->getValue()),
				$primitive
			);
		}


		/**
		 * @static
		 * @param PrimitiveDate $primitive
		 * @return WCalendar
		 */
		public static function makeByPrimitiveDate(PrimitiveDate $primitive)
		{
			return static::fill(
				WCalendar::create()->setValue($primitive->getValue()),
				$primitive
			);
		}

		/**
		 * @static
		 * @param PrimitiveTime $primitive
		 * @return WCalendar
		 */
		public static function makeByPrimitiveTime(PrimitiveTime $primitive)
		{
			return static::fill(
				WCalendar::create()->setFormat('d.m.Y h:i')->setValue($primitive->getValue()),
				$primitive
			);
		}

		/**
		 * @static
		 * @param PrimitiveString $primitive
		 * @return WTextField|WTextArea
		 */
		public static function makeByPrimitiveString(PrimitiveString $primitive)
		{
			$w = null;

			if($primitive->getMax() > 255)
				$w = WTextArea::create();
			else
				$w = WTextField::create();

			$w->setValue($primitive->getValue());

			return static::fill($w, $primitive);
		}


		/**
		 * @static
		 * @param PrimitiveBoolean $primitive
		 * @return WBoolean
		 */
		public static function makeByPrimitiveBoolean(PrimitiveBoolean $primitive)
		{
			return static::fill(
				WBoolean::create()->setValue($primitive->getValue()),
				$primitive
			);
		}

		/**
		 * @static
		 * @param PrimitiveTernary $primitive
		 * @return WTernary
		 */
		public static function makeByPrimitiveTernary(PrimitiveTernary $primitive)
		{
			return static::fill(
				WTernary::create()->setTrueValue($primitive->getTrueValue())->setFalseValue($primitive->getFalseValue())->setValue($primitive->getValue()),
				$primitive
			);
		}

		/**
		 * @static
		 * @param PrimitiveTernary $primitive
		 * @return WSelect
		 */
		public static function makeByPrimitiveEnumeration(PrimitiveEnumeration $primitive)
		{
			$className = $primitive->getClassName();
			$any = new $className(
				ClassUtils::callStaticMethod(
					$primitive->getClassName().'::getAnyId'
				)
			);

			return static::fill(
				WSelect::create()->setList(
					$any->getNameList()
				)->setValue($primitive->getValue() && $primitive->getValue()->getId() || null),
				$primitive
			);
		}

		/**
		 * @static
		 * @param PrimitiveTernary $primitive
		 * @return WTernary
		 */
		public static function makeByPrimitiveEnumerationList(PrimitiveEnumerationList $primitive)
		{
			return static::fill(
				static::makeByPrimitiveEnumeration($primitive)->setMulti(true),
				$primitive
			);
		}

		/**
		 * @static
		 * @param PrimitiveTernary $primitive
		 * @return WSelect
		 */
		public static function makeByPrimitiveEnum(PrimitiveEnum $primitive)
		{
			return static::fill(
				WSelect::create()->setList(
					ClassUtils::callStaticMethod(
						$primitive->getClassName().'::getNameList'
					)
				),
				$primitive
			);
		}

		/**
		 * @static
		 * @param PrimitiveTernary $primitive
		 * @return WSelect
		 */
		public static function makeByPrimitiveEnumList(PrimitiveEnumList $primitive)
		{
			return static::fill(
				static::makeByPrimitiveEnum($primitive)->setMulti(true),
				$primitive
			);
		}

	}