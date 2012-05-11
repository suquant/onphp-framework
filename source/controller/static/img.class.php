<?php

/**
 * @author stev
 */
class img extends BaseStaticController
{
	protected function getHeaders()
	{
		$imageType = ImageType::createByFileName(
			$this->getView()
		);

		return array_merge(
			parent::getHeaders(),
			array('Content-Type: '.$imageType->getMimeType())
		);
	}

	protected function getPrefix()
	{
		return 'img';
	}
}

