<?php
/****************************************************************************
 *   Copyright (C) 2008-2010 by Konstantin V. Arkhipov                      *
 *                                                                          *
 *   This program is free software; you can redistribute it and/or modify   *
 *   it under the terms of the GNU Lesser General Public License as         *
 *   published by the Free Software Foundation; either version 3 of the     *
 *   License, or (at your option) any later version.                        *
 *                                                                          *
 ****************************************************************************/

	/**
	 * @ingroup Primitives
	**/
	final class PrimitiveAlias extends BasePrimitive
	{
		private $primitive = null;

		public function __construct($name, BasePrimitive $prm)
		{
			$this->name = $name;
			$this->primitive = $prm;
		}

		/**
		 * @return PrimitiveAlias
		**/
		public function clean()
		{
			$this->primitive->clean();

			return $this;
		}

		public function getInner()
		{
			return $this->primitive;
		}

		public function getName()
		{
			return $this->name;
		}

		public function getDefault()
		{
			return $this->primitive->getDefault();
		}

		/**
		 * @return PrimitiveAlias
		**/
		public function setDefault($default)
		{
			$this->primitive->setDefault($default);

			return $this;
		}

		/**
		 * @return PrimitiveAlias
		**/
		public function setValue($value)
		{
			$this->primitive->setValue($value);

			return $this;
		}

		public function getValue()
		{
			return $this->primitive->getValue();
		}

		/**
		 * usually, you should not use this method
		 *
		 * @return PrimitiveAlias
		**/
		public function setRawValue($raw)
		{
			$this->primitive->setRawValue($raw);

			return $this;
		}

		public function getRawValue()
		{
			return $this->primitive->getRawValue();
		}

		/**
		 * @deprecated by getFormValue
		**/
		public function getActualValue()
		{
			return $this->primitive->getActualValue();
		}

		public function getSafeValue()
		{
			return $this->primitive->getSafeValue();
		}

		public function getFormValue()
		{
			if (!$this->primitive->isImported()) {
				if ($this->primitive->getValue() === null)
					return null;

				return $this->primitive->exportValue();
			}

			return $this->primitive->getRawValue();
		}

		public function exportValue()
		{
			return $this->primitive->exportValue();
		}

		/**
		 * @return PrimitiveAlias
		**/
		public function dropValue()
		{
			$this->primitive->dropValue();

			return $this;
		}


		public function isImported()
		{
			return $this->primitive->isImported();
		}

		public function importValue($value)
		{
			return $this->primitive->importValue($value);
		}

		public function import($scope)
		{
			if (array_key_exists($this->name, $scope)) {
				$result =
					$this->primitive->import(
						array(
							$this->primitive->getName() => $scope[$this->name]
						)
					);

				if(
					($error = $this->primitive->getError())
					&& $error !== null
				) {
					$this->setError($error);
				}

				return $result;
			}

			return null;
		}

	}
