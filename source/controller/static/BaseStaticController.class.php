<?php
/***************************************************************************
 *   Copyright (C) by Stepanov Evgeny                                      *
 *   from.stev@gmail.com                                                   *
 ***************************************************************************/


abstract class BaseStaticController implements Controller
{
	protected $patten = '~^[^/][\w\d/.]+[^/]$~'; // 'style' 'css/style'
	protected $form;
	protected $mav;
	
	public function __construct()
	{
		$this->mav = ModelAndView::create();
		$this->form = Form::create()->
			add(
				Primitive::string('action')->
					setAllowedPattern($this->patten)->
					required()
			)->
			add(
				Primitive::string('prefix')->
					setAllowedPattern($this->patten)
			);
	}

	public function handleRequest(HttpRequest $request)
	{
		$this->form->import($request->getGet());

		if ($this->form->getErrors()) {
			return $this->mav->setView('error404');
		}

		$this->headersSent($this->getHeaders());

		$this->mav->setView(
			$this->getView()
		);

		return $this->mav;
	}

	protected function getHeaders()
	{
		return array();
	}

	protected function headersSent(array $headers)
	{
		foreach ($headers as $value) {
			header((string)$value);
		}
		
		return $this;
	}

	protected function getView($prefix=null)
	{
		$array = array();
		
		if ($this->getPrefix())
			$array[] = $this->getPrefix();

		if ($this->getPostfix())
			$array[] = $this->getPostfix();

		$array[] = $this->form->getValue('action');

		return	join($array, '/');
	}

	protected function getPrefix()
	{
		return $this->form->getValue('prefix');
	}

	protected function getPostfix()
	{
		return;
	}
}

