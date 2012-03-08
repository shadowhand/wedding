<?php

class Controller_Wedding extends Controller {

	public function action_page()
	{
		$page = $this->request->param('page') ?: 'home';
		$this->view = Kostache::factory("wedding/{$page}");
	}

	public function after()
	{
		$this->response->body($this->view->render());
		parent::after();
	}

}
