<?php
 require 'Slim/Slim.php';
require_once "config/config.inc.php";

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$app->group('/api', function () use ($app) {
	
	
	$app->map ( "/users(/:id)", function ($userID = null) use($app) {
		$request = $app->request;
		$httpMethod = $request->getMethod ();
		$mediaType = $request->getMediaType();
		
		$action = null;
		$view = null;
		$parameters ["id"] = $userID;
		// 		prepare parameters to be passed to the controller (example: ID)
		
		if (($userID == null) or is_numeric ( $userID )) {
			switch ($httpMethod) {
				case "GET" :
					if ($userID != null)
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
		
		return new loadRunMVCComponents ( "UserModel", "UserController", $view, $action, $app, $parameters );
		
	})->via ( "GET", "POST", "PUT", "DELETE" );
	
	$app->map ( "/category(/:id)", function ($categoryId = null) use($app) {
		$request = $app->request;
		$httpMethod = $request->getMethod ();
		$mediaType = $request->getMediaType();
		
		$action = null;
		$view = null;
		$parameters ["id"] = $categoryId;
		// 		prepare parameters to be passed to the controller (example: ID)
		
		if (($userID == null) or is_numeric ( $categoryId )) {
			switch ($httpMethod) {
				case "GET" :
					if ($categoryId != null)
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
		
		return new loadRunMVCComponents ( "CategoryModel", "CategoryController", $view, $action, $app, $parameters );
		
	})->via ( "GET", "POST", "PUT", "DELETE" );
});

$app->run();

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

?>