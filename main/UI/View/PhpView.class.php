<?php
/***************************************************************************
 *   Copyright (C) by Evgeny M. Stepanov                                   *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/
/* $Id: PlainPhpView.class.php 351 2011-02-09 17:33:01Z stev $ */


class PhpView extends SimplePhpView
{
	/**
	 * @return PhpView
	**/
	public function render(/* Model */ $model = null)
	{
		if ($model instanceof Model)
			extract($model->getList());

		$partViewer = Viewer::push(
			new PartViewer($this->partViewResolver, $model)
		);

		ob_start();

		try {
			$this->preRender();
			include $this->templatePath;
			$this->postRender();
		}
		catch (Exception $e){
			ob_end_clean();
			echo $e;
			exit();
			// DebugUtils::ExcOutOrSendMail($e);
		}

		echo ob_get_clean();

		Viewer::pop();

		return $this;
	}

//	protected function preRender()
//	{
//		if (defined('PRINT_VIEW_PATH')) {
//			echo PHP_EOL."<!-- {$this->cutExcess($this->templatePath)} -->".PHP_EOL;
//		}
//	}
//
//	protected function postRender()
//	{
//		if (defined('PRINT_VIEW_PATH')) {
//			echo PHP_EOL."<!--: {$this->cutExcess($this->templatePath)} -->".PHP_EOL;
//		}
//	}
//
//	private function cutExcess($path)
//	{
//		return str_replace(EXT_TPL, '',
//			str_replace(PATH_TEMPLATES, '', $path)
//		);
//	}

}
