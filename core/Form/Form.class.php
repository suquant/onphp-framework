<?php
/****************************************************************************
 *   Copyright (C) 2004-2009 by Konstantin V. Arkhipov, Anton E. Lebedevich *
 *                                                                          *
 *   This program is free software; you can redistribute it and/or modify   *
 *   it under the terms of the GNU Lesser General Public License as         *
 *   published by the Free Software Foundation; either version 3 of the     *
 *   License, or (at your option) any later version.                        *
 *                                                                          *
 ****************************************************************************/

	/**
	 * Complete Form class.
	 * 
	 * @ingroup Form
	 * @ingroup Module
	**/
	final class Form extends RegulatedForm
	{
		const WRONG			= BasePrimitive::WRONG;
		const MISSING		= BasePrimitive::MISSING;

		private $proto				= null;

		private $importFiltering	= true;

		/**
		 * @return Form
		**/
		public static function create()
		{
			return new self;
		}

		/**
		 * @return Form
		**/
		public function setProto(EntityProto $proto)
		{
			$this->proto = $proto;

			return $this;
		}

		/**
		 * @return EntityProto
		**/
		public function getProto()
		{
			return $this->proto;
		}


		public function export()
		{
			$result = array();

			foreach ($this->primitives as $name => $prm) {
				if ($prm->isImported())
					$result[$name] = $prm->exportValue();
			}

			return $result;
		}

		public function exportValue($name)
		{
			return $this->get($name)->exportValue();
		}

		public function toFormValue($value)
		{
			if ($value instanceof FormField)
				return $this->getValue($value->getName());
			elseif ($value instanceof LogicalObject)
				return $value->toBoolean($this);
			else
				return $value;
		}


		/**
		 * @return Form
		**/
		public function import($scope)
		{
			foreach ($this->primitives as $prm)
				$this->importPrimitive($scope, $prm);

			return $this;
		}

		/**
		 * @return Form
		**/
		public function importMore($scope)
		{
			foreach ($this->primitives as $prm) {
				if (!$prm->isImported())
					$this->importPrimitive($scope, $prm);
			}

			return $this;
		}

		/**
		 * @return Form
		**/
		public function importOne($name, $scope)
		{
			return $this->importPrimitive($scope, $this->get($name));
		}

		/**
		 * @return Form
		**/
		public function importValue($name, $value)
		{
			$this->get($name)->importValue($value);

			return $this;
		}

		/**
		 * @return Form
		**/
		public function importOneMore($name, $scope)
		{
			$prm = $this->get($name);

			if (!$prm->isImported())
				return $this->importPrimitive($scope, $prm);

			return $this;
		}

		/**
		 * @return Form
		**/
		private function importPrimitive($scope, BasePrimitive $prm)
		{
			$prm->import($scope);

			return $this;
		}


		/**
		 * primitive marking
		**
		//@{
		**
		 * @return Form
		**/
		public function markGood($name)
		{
			$this->get($name)->markGood();

			return $this;
		}

		/**
		 * @return Form
		**/
		public function markMissing($name, $label = null)
		{
			return $this->markCustom($name, BasePrimitive::MISSING, $label);
		}

		/**
		 * rule or primitive
		 *
		 * @return Form
		**/
		public function markWrong($name, $label = null)
		{
			$prm = $this->get($name);
			$prm->markWrong();

			if ($label !== null)
				$prm->setWrongLabel($label);

			return $this;
		}

		/**
		 * Set's custom error mark for primitive.
		 *
		 * @return Form
		**/
		public function markCustom($name, $customMark, $label = null)
		{
			$this->get($name)->setErrorLabel($customMark, $label);

			return $this;
		}
		//@}

		public function hasError($name)
		{
			return $this->get($name)->getError() !== null;
		}

		public function getError($name)
		{
			return $this->get($name)->getError();
		}

		public function getErrors()
		{
			$errors = array();
			foreach($this->primitives as $name => $prm) {
				if (null !== $prm->getError())
					$errors[$name] = $prm->getError();
			}

			return $errors;
		}

		public function getInnerErrors()
		{
			$result = $this->getErrors();

			foreach ($this->primitives as $name => $prm) {
				if (
					(
						($prm instanceof PrimitiveFormsList)
						|| ($prm instanceof PrimitiveForm)
					)
					&& $prm->getValue()
				) {
					if ($errors = $prm->getInnerErrors()) {
						$result[$name] = $errors;
					} else {
						unset($result[$name]);
					}
				}
			}

			return $result;
		}

		/**
		 * Returns plain list of error's labels
		**/
		public function getTextualErrors()
		{
			$list = array();

			foreach ($this->primitives as $name => $prm) {
				if ($label = $this->getTextualErrorFor($name))
					$list[$name] = $label;
			}

			return $list;
		}

		public function getTextualErrorFor($name)
		{
			return $this->get($name)->getActualErrorLabel();
		}

		/**
		 * @return Form
		**/
		public function dropAllErrors()
		{
			foreach($this->primitives as $name => $prm) {
				$prm->dropError();
			}

			return $this;
		}


		/**
		 * @return Form
		**/
		public function enableImportFiltering()
		{
			$this->importFiltering = true;

			return $this;
		}

		/**
		 * @return Form
		**/
		public function disableImportFiltering()
		{
			$this->importFiltering = false;

			return $this;
		}

		/**
		 * @return Form
		**/
		public function setImportFiltering($really = false)
		{
			$this->importFiltering = ($really === true);

			return $this;
		}


		/**
		 * @return Form
		**/
		public function addErrorDescription($name, $errorType, $description)
		{
			$this->get($name)->setErrorDescription($errorType, $description);

			return $this;
		}

		public function getErrorDescriptionFor($name)
		{
			return $this->get($name)->getActualErrorDescription();
		}


		/**
		 * @return Form
		**/
		public function addWrongLabel($name, $label)
		{
			return $this->addErrorLabel($name, BasePrimitive::WRONG, $label);
		}

		/**
		 * @return Form
		**/
		public function addMissingLabel($name, $label)
		{
			return $this->addErrorLabel($name, BasePrimitive::MISSING, $label);
		}

		/**
		 * @return Form
		**/
		public function addCustomLabel($name, $customMark, $label)
		{
			return $this->addErrorLabel($name, $customMark, $label);
		}

		public function getWrongLabel($name)
		{
			return $this->getErrorLabel($name, BasePrimitive::WRONG);
		}

		public function getMissingLabel($name)
		{
			return $this->getErrorLabel($name, BasePrimitive::MISSING);
		}


		/**
		 * Assigns specific label for given primitive and error type.
		 * One more example of horrible documentation style.
		 * 
		 * @param	$name		string	primitive or rule name
		 * @param	$errorType	enum	Form::(WRONG|MISSING)
		 * @param	$label		string	YDFB WTF is this :-) (c) /.
		 * @throws	MissingElementException
		 * @return	Form
		**/
		private function addErrorLabel($name, $errorType, $label)
		{
			$this->get($name)->setErrorLabel($errorType, $label);

			return $this;
		}

		private function getErrorLabel($name, $errorType)
		{
			return $this->get($name)->getErrorLabel($errorType);
		}

	}
