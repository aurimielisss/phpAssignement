<?php
class CategoryController {
    private $slimApp;
    private $model;
    private $requestBody;
    
    public function __construct($model, $action = null, $slimApp, $parameters=null){
        $this->model = $model;
        $this->slimApp = $slimApp;
        $this->requestBody = json_decode($this->slimApp->request->getBody(),true);
    
    if (! empty ( $parameters ["id"] ))
			$id = $parameters ["id"];
            
         switch ($action) {
			case ACTION_GET :
				$this->getCategory ( $id );
				break;
			case ACTION_GET_ALL :
				$this->getCategories ();
				break;
			case ACTION_UPDATE :
				$this->updateCategory ( $id, $this->requestBody );
				break;
			case ACTION_CREATE :
				$this->createCategory ( $this->requestBody );
				break;
			case ACTION_DELETE :
				$this->deleteCategory ( $id );
				break;
			case ACTION_SEARCH :
				$string = $parameteres ["SearchingString"];
				$this->searchCategory ( $string );
				break;
			case null :
				$this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
				$Message = array (
						GENERAL_MESSAGE_LABEL => GENERAL_CLIENT_ERROR 
				);
				$this->model->apiResponse = $Message;
				break;
		}       
    }
}


?>