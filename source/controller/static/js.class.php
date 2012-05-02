<?php

/**
 * @author stev
 */
class js extends BaseStaticController
{
	protected function getHeaders()
	{
		return array_merge(
			parent::getHeaders(),
			array('Content-Type: application/javascript')
		);
	}

	protected function getPostfix()
	{
		return 'js';
	}
}

