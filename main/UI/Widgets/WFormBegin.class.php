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
 * @method WFormBegin create()
 * @method WFormBegin setTplName()
 * @method WFormBegin setViewer()
 * @method WFormBegin setModel()
 */
class WFormBegin extends WFormElement
{
	protected $tplName = 'formBegin';
	protected $url;

	/**
	 * @return WFormBegin
	 */
	public function setSubmitUrl(Href $url)
	{
		$this->url = $url;
		return $this;
	}

	/**
	 * @return Model
	 */
	protected function makeModel()
	{
		return parent::makeModel()->
			set('_url', $this->url);
	}
}

