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
	 * @var ViewResolver
	 */
	protected $resolver = null;

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
	public function setViewer(ViewResolver $resolver)
	{
		$this->resolver = $resolver;

		return $this;
	}

	/**
	 * @return ViewResolver
	 */
	public function getResolver()
	{
		if ($this->resolver instanceof ViewResolver)
			return $this->resolver;

		Assert::isInstance(
			Widget::getViewResolver($this), 'ViewResolver',
			'Don`t set resolver, see Widget::setViewResolverMap() or Widget::setDefaultViewResolver()'
		);

		return Viewer::getWidgetViewResolver();
	}

	public function render($model = null, $merge=true)
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

			$view = $this->getResolver()->resolveViewName(
				$this->getTplPrefix().$this->tplName
			);

			$view->render($this->model);

			$source = ob_get_contents();
		} catch (WrongArgumentException $e) {
			return $e->__toString();
		} catch (Exception $e) {
			// TODO : прописать системный сервис информирования об ошибках
			// использую разные стратегии информирования или цепочки, лог, почта, раббит..
			// а так же поведение, редирект на продакшине например
			return($e->__toString());
		}

		ob_end_clean();

		return $source;
	}

	/**
	 * @return string
	 */
	public function toString()
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
		$this->makeModel();

		return $this->model->
			set(
				'parentModel',
				$this->model->has('parentModel')
					? $this->model->get('parentModel')
					: null
			)->
			set(
				'rootModel',
				$this->model->has('rootModel')
					? $this->model->get('rootModel')
					: $this->model
			);
	}
}

