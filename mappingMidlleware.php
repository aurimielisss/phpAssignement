<?php
class loadRunMVCComponents {
	public $model, $controller, $view;
	public function __construct($modelName, $controllerName, $viewName, $action, $app, $parameters = null) {
		include_once "models/" . $modelName . ".php";
		include_once "controllers/" . $controllerName . ".php";
		include_once "views/" . $viewName . ".php";
		
		$model = new $modelName ();
		$controller = new $controllerName ( $model, $action, $app, $parameters );
		$view = new $viewName ( $controller, $model, $app, $app->headers );
		
		$view->output();
	}
}

class customSlim extends \Slim\Slim {
	private function mapPartial($id, $modelName, $controllerName) {
		$request = $this->request;
		$httpMethod = $request->getMethod();
		$mediaType = $request->getMediaType();
		
		$action = null;
		$view = null;
		$parameters ["id"] = $id;
		// 		prepare parameters to be passed to the controller (example: ID)
		
		if (($id == null) or is_numeric ( $id )) {
			switch ($httpMethod) {
				case "GET" :
					if ($id != null)
						$action = ACTION_GET;
					else
						$action = ACTION_GET_ALL;
				break;
				case "POST" :
						$action = ACTION_CREATE;
				break;
				case "PUT" :
						$action = ACTION_UPDATE;
				break;
				case "DELETE" :
						$action = ACTION_DELETE;
				break;
				default :
			}
		}
		switch ($mediaType) {
			case 'text/xml':
				$view = 'xmlView';
			break;
			default:
			   $view = 'jsonView';
			break;
		}
		
		return new loadRunMVCComponents ($modelName, $controllerName, $view, $action, $this, $parameters );
	}
   
   public function customMap($uri, $modelName, $controllerName) {
		$self = $this;
		$this->map ( $uri, function ($id = null) use($self, $modelName, $controllerName) {
		$this->mapPartial($id, $modelName, $controllerName);
		
	})->via ( "GET", "POST", "PUT", "DELETE" );
	
	}
}