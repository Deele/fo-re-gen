<?php

/**
 * Class JsonResponse provides standartized JSON output
 *
 * @author Nils Lindentals <nils@webmultishop.com>
 *
 * @copyright 2014 Web Multishop Company LLD
 * @license GPL
 */
class JsonResponse extends ResponseType {

	/**
	 * @var bool Generate callback function (for JSONP requests)
	 */
	public $generateCallbackFunction = true;

	/**
	 * Outputs JSON response
	 */
	public function getOutput() {

		// Prepeare JSON response
		if (!is_null($this->success)) {
			$this->setResponse($this->successKey, $this->success);
		}
		$this->prepareMessages();
		$this->response = CJavaScript::jsonEncode($this->response);

		$this->setResponseHeaders();

		// Output data
		if ($this->generateCallbackFunction) {

			/**
			 * @var $app CWebApplication
			 * @var $req CHttpRequest
			 */
			$app = Yii::app();
			$req = $app->getRequest();
		
			if ($callback = $req->getQuery('callback')) {
				return $callback.'('.$this->response.')';
			}
		}
		return $this->response;
	}

	/**
	 * Sets required response headers
	 */
	public function setResponseHeaders() {
		parent::setResponseHeaders();

		// Set header to json content type
		mtHeader::json();
	}
}