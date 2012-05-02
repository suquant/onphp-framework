<?php

/**
 * @author stev
 */
class css extends BaseStaticController
{
	protected function getHeaders()
	{
		return array_merge(
			parent::getHeaders(),
			array('Content-Type: text/css')
		);
	}

	protected function getPostfix()
	{
		return 'css';
	}
}

