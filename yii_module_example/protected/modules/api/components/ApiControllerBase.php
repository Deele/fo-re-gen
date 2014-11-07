<?php

/**
 * Class ApiControllerBase is base class that is used as template for other API controllers
 *
 * @author Nils Lindentals <nils@webmultishop.com>
 *
 * @copyright 2014 Web Multishop Company LLD
 * @license GPL
 */
class ApiControllerBase extends CController {

	/**
	 * @var string the name of the default action. Defaults to 'index'.
	 */
	public $defaultAction = 'list';

	/**
	 * @var JsonResponse|XmlResponse response object
	 */
	public $response;

	/**
	 * @var string
	 */
	public $version = '1.0';

	/**
	 * @param string $controller
	 * @param string $action
	 *
	 * @return string
	 */
	public function createUrl($controller, $action) {
		return '/api/'.$controller.'/'.$action;
	}

	/**
	 * This method is invoked right before an action is to be executed (after all possible filters.)
	 * You may override this method to do last-minute preparation for the action.
	 * @param CAction $action the action to be executed.
	 * @return boolean whether the action should be executed.
	 */
	public function beforeAction($action) {
		$responseType = 'xml';

		/**
		 * @var CWebApplication $app
		 * @var CHttpRequest $req
		 */
		$app = Yii::app();
		$req = $app->getRequest();
		if ($altType = $req->getQuery('alt', false)) {
			$responseType = $altType;
		}
		else {
			foreach ($this->getAcceptTypes() as $acceptedType) {
				$type = $acceptedType['type'];
				if ($type == 'text/json' || $type == 'application/json') {
					$responseType = 'json';
					break;
				}
				elseif ($type == 'text/xml' || $type == 'application/xml' || $type == '*/*') {
					$responseType = 'xml';
					break;
				}
			}
		}
		switch ($responseType) {
			case 'json':
				$this->response = new JsonResponse();
				$this->disableWbLogRoute();
				break;
			case 'xml':
			default:
				$this->response = new XmlResponse();
				$this->disableWbLogRoute();
				break;
		}
		if (is_null($this->response)) {
			return false;
		}
		$this->response->setResponse(
			'version',
			$this->version
		);
		$this->response->setResponse(
			'encoding',
			'UTF-8'
		);
		if (YII_DEBUG) {
			$this->response->setResponse(
				'controller',
				$action->controller->getId()
			);
			$this->response->setResponse(
				'action',
				$action->getId()
			);
		}
		return true;
	}

	/**
	 * Returns array with accepted types
	 *
	 * @return array
	 */
	public function getAcceptTypes() {

		/**
		 * @var CWebApplication $app
		 * @var CHttpRequest $req
		 */
		$app = Yii::app();
		$req = $app->getRequest();
		$acceptedTypes = array();
		$getAcceptTypes = explode(',', $req->getAcceptTypes());
		foreach ($getAcceptTypes as $orderNum => $v) {
			$priority = 1;
			$data = explode(';', $v);
			if (isset($data[1])) {
				$data2 = explode('=', $data[1]);
				if ($data2[0] == 'q') {
					$priority = (float) $data2[1];
				}
			}
			$c = count($getAcceptTypes);
			$priority += ($c - $orderNum - 1);
			$acceptedTypes[] = array(
				'priority' => $priority,
				'type' => $data[0]
			);
		}
		if (!function_exists('getAcceptTypesSort')) {
			function getAcceptTypesSort($a, $b) {
				if ($a['priority'] == $b['priority']) {
					return 0;
				}
				return ($a['priority'] > $b['priority']) ? -1 : 1;
			}
		}
		usort($acceptedTypes, 'getAcceptTypesSort');
		return $acceptedTypes;
	}

	/**
	 * Disable Yii CWebLogRoute logging for all requests
	 */
	public function disableWbLogRoute() {

		/**
		 * @var CWebApplication $app
		 * @var CLogRouter $logger
		 */
		$app = Yii::app();
		$logger = $app->getComponent('log');
		$routes = $logger->getRoutes();
		foreach ($routes as $route) {
			if ($route instanceof CWebLogRoute) {
				$route->enabled = false;
			}
		}
	}

	/**
	 * Outputs response
	 */
	public function afterAction() {
		$this->response->output();
	}
}