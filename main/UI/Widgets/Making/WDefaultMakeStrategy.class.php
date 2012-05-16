<?php
/***************************************************************************
 *   Copyright (C) by Evgeny M. Stepanov                                   *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/

/**
 * @package UI\Widget
 */
class WDefaultMakeStrategy extends Singleton implements IfaceWidgetMakeStrategy, Instantiatable
{
	protected $map = array(
		'BasePrimitive' => 'Primitive'
	);

	/**
	 * @static
	 * @return WDefaultMakeStrategy
	 */
	public static function me()
	{
		return Singleton::getInstance(__CLASS__);
	}

	public function makeBy($object)
	{
		// 1. mapping class
		// 2. mapping interface
		// 3. other logic

		if (!is_object($object))
			throw new WrongArgumentException();

		$method = $this->getMethodName(class_parents($object));

		if (!$method)
			$method = $this->getMethodName(class_implements($object));

		if ($method)
			return $this->{$method}($object);

		return $this->makeByDefault($object);
	}

	protected function getMethodName(array $classes)
	{
		$list = array_intersect($classes, array_keys($this->map));

		if (isset($this->map[current($list)])) {
			return 'makeBy'.$this->map[current($list)];
		}
	}

	/*
	protected function makeByClassName() {	}
	protected function makeByIfaceName() {	}
	*/

	protected function makeByDefault($object)
	{
		throw new MissingElementException(__METHOD__.' - Other logic is not set.');
	}

	/**
	 * пока одним скопом, потом можно разнести на метды
	 *
	 * @param BasePrimitive $prm
	 * @return IfaceWidget
	 * @throws WrongArgumentException
	 */
	protected function makeByPrimitive(BasePrimitive $prm)
	{
		$src = null;

		if ($prm instanceof PrimitiveIdentifier) {
			$src = WTextField::create($prm->getName())->
				setRequired($prm->isRequired())->
				setLabel($prm->getName())->
				setValue(
					$prm->getValue()
					? $prm->getValue()->getId()
					: NULL
				);
		}
		elseif ($prm instanceof PrimitiveDate) {
			$src = WCalendar::create($prm->getName())->
				setRequired($prm->isRequired())->
				setLabel($prm->getName())->
				setValue($prm->getValue());
		}
		elseif ($prm instanceof PrimitiveTime) {
			$src = WCalendar::create($prm->getName())->
				setRequired($prm->isRequired())->
				setLabel($prm->getName())->
				setValue($prm->getValue());
		}
		elseif ($prm instanceof PrimitiveString) {
			if($prm->getMax() > 128) {
				$src = WTextArea::create($prm->getName())->
					setRequired($prm->isRequired())->
					setLabel($prm->getName())->
					setParams(array('size'=>$prm->getMax()))->
					setValue($prm->getValue());
			} else {
				$src = WTextField::create($prm->getName())->
					setRequired($prm->isRequired())->
					setLabel($prm->getName())->
					setParams(array('size'=>$prm->getMax()))->
					setValue($prm->getValue());
			}
		}
		else if ($prm instanceof PrimitiveInteger) {
			$src = WTextField::create($prm->getName())->
				setRequired($prm->isRequired())->
				setLabel($prm->getName())->
				setValue($prm->getValue());
		}
		else if ($prm instanceof PrimitiveBoolean) {
			$src = WBoolean::create($prm->getName())->
				setRequired($prm->isRequired())->
				setLabel($prm->getName())->
				setValue($prm->getValue());
		}
		else if ($prm instanceof PrimitiveTernary) {
			$src = WTernary::create($prm->getName())->
				setRequired($prm->isRequired())->
				setLabel($prm->getName())->
				setTrueValue($prm->getTrueValue())->
				setFalseValue($prm->getFalseValue())->
				setValue($prm->getValue());
		}
		else if ($prm instanceof PrimitiveEnumeration) {
			$class = $prm->getClassName();
			$class = new TestStatus(TestStatus::getAnyId());

			$src = WSelect::create($prm->getName())->
				setRequired($prm->isRequired())->
				setLabel($prm->getName())->
				setArray($class->getObjectList())->
				setValue($prm->getValue());
		}
		else if ($prm instanceof PrimitiveList) {
			$src = WMultiSelect::create($prm)->
				setRequired($prm->isRequired())->
				setLabel($prm->getName())->
				setValue($prm->getValue());
		}
		else {
			throw new WrongArgumentException();
		}

		return $src;
	}
}

