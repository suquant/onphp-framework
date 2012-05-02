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
abstract class BaseWidget implements IfaceWidget
{
	protected $name = null;
	protected $tplPrefix = null;
	protected $tplName = null;
	/**
	 * @var Model
	 */
	protected $model;

	/**
	 * @var InterfacePartViewer
	 */
	protected $viewer = null;

	public function __construct($name = null)
	{
		$this->name = $name;
		$this->model = new Model();
	}

	/**
	 * @return BaseWidget
	 */
	public function setTplName($tplName)
	{
		$this->tplName = (string)$tplName;

		return $this;
	}

	/**
	 * @return BaseWidget
	 */
	public function setPrefix($prefix)
	{
		$this->tplPrefix = (string)$prefix;

		return $this;
	}

	public function getTplName()
	{
		return $this->tplName;
	}

	public function getTplPrefix()
	{
		return $this->tplPrefix
			? $this->tplPrefix.DIRECTORY_SEPARATOR
			: null;
	}

	/**
	 * @return BaseWidget
	 */
	public function setViewer(IfacePartViewer $viewer)
	{
		$this->viewer = $viewer;

		return $this;
	}

	/**
	 * @return IfacePartViewer
	 */
	public function getViewer()
	{
		if ($this->viewer instanceof IfacePartViewer)
			return $this->viewer;

		Assert::isInstance(
			Viewer::get(), 'IfacePartViewer',
			'Don`t set partViewer, see PhpView or set Viewer::push(partViewer)'
		);

		return Viewer::get();
	}

	public function render(/*Model*/$model = null, $merge=true)
	{
		echo $this->rendering($model, $merge);
	}

	/**
	 * @return string result
	 */
	protected function rendering(/*Model*/$model = null, $merge=true)
	{
		$source = null;
		ob_start();

		$this->prepareModel();

		try {
			if ($model && $merge) {
				$this->model->merge($model);
			}

			$this->getViewer()->view(
				$this->getTplPrefix().$this->tplName,
				$this->model
			);

			$source = ob_get_contents();
		} catch (WrongArgumentException $e) {
			return $e->__toString();
		} catch (Exception $e) {
			// TODO : Ð¿ÑÐ¾Ð¿Ð¸ÑÐ°ÑÑ ÑÐ¸ÑÑÐµÐ¼Ð½ÑÐ¹ ÑÐµÑÐ²Ð¸Ñ Ð¸Ð½ÑÐ¾ÑÐ¼Ð¸ÑÐ¾Ð²Ð°Ð½Ð¸Ñ Ð¾Ð± Ð¾ÑÐ¸Ð±ÐºÐ°Ñ
			// Ð¸ÑÐ¿Ð¾Ð»ÑÐ·ÑÑ ÑÐ°Ð·Ð½ÑÐµ ÑÑÑÐ°ÑÐµÐ³Ð¸Ð¸ Ð¸Ð½ÑÐ¾ÑÐ¼Ð¸ÑÐ¾Ð²Ð°Ð½Ð¸Ñ Ð¸Ð»Ð¸ ÑÐµÐ¿Ð¾ÑÐºÐ¸, Ð»Ð¾Ð³, Ð¿Ð¾ÑÑÐ°, ÑÐ°Ð±Ð±Ð¸Ñ..
			// Ð° ÑÐ°Ðº Ð¶Ðµ Ð¿Ð¾Ð²ÐµÐ´ÐµÐ½Ð¸Ðµ, ÑÐµÐ´Ð¸ÑÐµÐºÑ Ð½Ð° Ð¿ÑÐ¾Ð´Ð°ÐºÑÐ¸Ð½Ðµ Ð½Ð°Ð¿ÑÐ¸Ð¼ÐµÑ
			return($e->__toString());
		}

		ob_end_clean();

		return $source;
	}

	public function __toString()
	{
		return (string)$this->rendering();
	}

	/**
	 * @return BaseWidget
	 */
	public function setModel(Model $model)
	{
		$this->model = $model;
		return $this;
	}

	/**
	 * @return BaseWidget
	 */
	final public function mergeModel(Model $model, $owerwrite = false)
	{
		$this->model->merge($model, $owerwrite);
		return $this;
	}

	/**
	 * @return Model
	 */
	final public function getModel()
	{
		return $this->model;
	}
	/**
	 * @return Model
	 */
	protected function makeModel()
	{
		return $this->model->set('widgetName', $this->name);
	}

	final protected function prepareModel()
	{
		$model = $this->getViewer()->getModel();

		$this->makeModel();

		return $this->model->
			set(
				'parentModel',
				$model->has('parentModel')
					? $model->get('parentModel')
					: null
			)->
			set(
				'rootModel',
				$model->has('rootModel')
					? $model->get('rootModel')
					: $this->model
			);
	}
}

