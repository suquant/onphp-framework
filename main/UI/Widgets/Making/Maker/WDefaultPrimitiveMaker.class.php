<?php
/***************************************************************************
 *   Copyright (C) by Georgiy T. Kutsurua                                  *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/

	class WDefaultPrimitiveMaker extends Singleton implements IfaceWidgetMaker, Instantiatable
	{
		public static $map = array(
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

			'PrimitiveIdentifier' => 'makeByPrimitiveIdentifier',
		);

		/**
		 * @static
		 * @return WDefaultPrimitiveMakeStrategy
		 */
		public static function me()
		{
			return Singleton::getInstance(__CLASS__);
		}


		/**
		 * @static
		 * @param WFormElement $widget
		 * @param BasePrimitive $primitive
		 * @return WFormElement
		 */
		public function fill(WFormElement $widget, BasePrimitive $primitive)
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
		protected function makeByBasePrimitive(BasePrimitive $primitive)
		{
			return $this->fill(
				WTextField::create()->setValue($primitive->getValue()),
				$primitive
			);
		}


		/**
		 * @static
		 * @param PrimitiveDate $primitive
		 * @return WCalendar
		 */
		protected function makeByPrimitiveDate(PrimitiveDate $primitive)
		{
			return $this->fill(
				WCalendar::create()->setValue($primitive->getValue()),
				$primitive
			);
		}

		/**
		 * @static
		 * @param PrimitiveTime $primitive
		 * @return WCalendar
		 */
		protected function makeByPrimitiveTime(PrimitiveTime $primitive)
		{
			return $this->fill(
				WCalendar::create()->setFormat('d.m.Y h:i')->setValue($primitive->getValue()),
				$primitive
			);
		}

		/**
		 * @static
		 * @param PrimitiveString $primitive
		 * @return WTextField|WTextArea
		 */
		protected function makeByPrimitiveString(PrimitiveString $primitive)
		{
			$w = null;

			if($primitive->getMax() > 255)
				$w = WTextArea::create();
			else
				$w = WTextField::create();

			$w->setValue($primitive->getValue());

			return $this->fill($w, $primitive);
		}


		/**
		 * @static
		 * @param PrimitiveBoolean $primitive
		 * @return WBoolean
		 */
		protected function makeByPrimitiveBoolean(PrimitiveBoolean $primitive)
		{
			return $this->fill(
				WBoolean::create()->setValue($primitive->getValue()),
				$primitive
			);
		}

		/**
		 * @static
		 * @param PrimitiveTernary $primitive
		 * @return WTernary
		 */
		protected function makeByPrimitiveTernary(PrimitiveTernary $primitive)
		{
			return $this->fill(
				WTernary::create()->setTrueValue($primitive->getTrueValue())->setFalseValue($primitive->getFalseValue())->setValue($primitive->getValue()),
				$primitive
			);
		}

		/**
		 * @static
		 * @param PrimitiveTernary $primitive
		 * @return WSelect
		 */
		protected function makeByPrimitiveEnumeration(PrimitiveEnumeration $primitive)
		{
			$className = $primitive->getClassName();
			$any = new $className(
				ClassUtils::callStaticMethod(
					$primitive->getClassName().'::getAnyId'
				)
			);

			return $this->fill(
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
		protected function makeByPrimitiveEnumerationList(PrimitiveEnumerationList $primitive)
		{
			return $this->fill(
				$this->makeByPrimitiveEnumeration($primitive)->setMulti(true),
				$primitive
			);
		}

		/**
		 * @static
		 * @param PrimitiveTernary $primitive
		 * @return WSelect
		 */
		protected function makeByPrimitiveEnum(PrimitiveEnum $primitive)
		{
			return $this->fill(
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
		protected function makeByPrimitiveEnumList(PrimitiveEnumList $primitive)
		{
			return $this->fill(
				$this->makeByPrimitiveEnum($primitive)->setMulti(true),
				$primitive
			);
		}

		/**
		 * @static
		 * @param PrimitiveTernary $primitive
		 * @return WSelect
		 */
		protected function makeByPrimitiveIdentifier(PrimitiveIdentifier $primitive, $idField='id', $nameField='name')
		{
			$dao = ClassUtils::callStaticMethod($primitive->getClassName().'::dao');

			$q = Criteria::create($dao)->setLimit(100)->toSelectQuery();
			$q->dropFields();
			$q->get($idField);
			$q->get($nameField);

			$rows = $dao->getCustomList($q);
			$list = array();

			foreach($rows as $key => $value)
			{
				$list[$value[$idField]]=$value[$nameField];
			}

			unset($rows);

			$value = ($primitive->getValue())
					? $primitive->getValue()->getId()
					: null;

			return $this->fill(
				WSelect::create()->setList(
					$list
				)->setValue(
					$value
				),
				$primitive
			);
		}

		/**
		 * @return  IfaceWidget
		 */
		public function makeBy($entity)
		{
			Assert::isInstance($entity, 'BasePrimitive',
				'entity must be instane of BasePrimitive, gived "'.gettype($entity).'"'
			);

			$widget = null;
			$primitiveClassName = get_class($entity);
			$widgetClassName = $primitiveClassName;

			if(isset(static::$map[$widgetClassName]) && ($name = static::$map[$widgetClassName] ))
				$widget = $this->{$name}($entity);
			else {
				$parents = class_parents($primitiveClassName);

				foreach($parents as $parent)
				{
					$className = $parent;
					if(isset(static::$map[$className]) && ($name = static::$map[$className] )) {
						$widget = $this->{$name}($entity);
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
	}