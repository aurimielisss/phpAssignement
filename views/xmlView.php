<?php
class xmlView
{
	private $model, $controller, $slimApp;

	public function __construct($controller, $model, $slimApp) {
		$this->controller = $controller;
		$this->model = $model;
		$this->slimApp = $slimApp;		
	}

	public function output(){
		//prepare json response
		$this->slimApp->response->headers->set('Content-Type', 'text/xml');
		$xmlResponse = xmlrpc_encode($this->model->apiResponse);
		$this->slimApp->response->write($xmlResponse);
	}
}
?>