<?php

/**
 * Class ResponseType provides output data type functionallity
 *
 * @author Nils Lindentals <nils@webmultishop.com>
 *
 * @copyright 2014 Web Multishop Company LLD
 * @license GPL
 */
class ResponseType extends CComponent {

	/**
	 * @var array
	 */
	public $response = array();

	/**
	 * @var string Messages response item key
	 */
	public $messagesKey = 'messages';

	/**
	 * @var array Messages response item value
	 */
	public $messages = array();

	/**
	 * @var string Success response item value
	 */
	public $success;

	/**
	 * @var string Success response item key
	 */
	public $successKey = 'success';

	/**
	 * @var string XML root element
	 */
	public $rootElement = 'root';

	/**
	 * @var int HTTP status code
	 */
	public $statusCode = HttpStatusCode::OK;

	/**
	 * @param mixed $setSuccess Set success to specified value
	 */
	public function __construct($setSuccess = null) {
		if (!is_null($setSuccess)) {
			$this->setSuccess($setSuccess);
		}
	}

	/**
	 * Adds new message to messages array
	 *
	 * @param array $data Message data
	 *
	 * @return $this For chaining
	 */
	public function addMessage($data) {
		$this->messages[] = $data;
		return $this;
	}

	/**
	 * Set new response item key to specified value
	 *
	 * @param string $key Response item key
	 * @param mixed $value Response item value
	 * @param bool $mergeIfArray If {@link $value} is array and response item is set, merge them together
	 *
	 * @return $this For chaining
	 */
	public function setResponse($key, $value, $mergeIfArray = false) {
		if (isset($this->response[$key]) && is_array($this->response[$key]) && $mergeIfArray && is_array($value)) {
			$this->response[$key] = array_merge(
				$this->response[$key],
				$value
			);
		}
		else {
			$this->response[$key] = $value;
		}
		return $this;
	}

	/**
	 * Sets success to specified value
	 *
	 * @param mixed $value New success value
	 *
	 * @return $this For chaining
	 */
	public function setSuccess($value) {
		$this->success = $value;
		return $this;
	}

	/**
	 * Returns prepared response
	 */
	public function getOutput() {
		return $this->response;
	}

	/**
	 * Outputs response
	 *
	 * @param bool $endApp Ends YII application after output
	 */
	public function output($endApp = true) {

		echo $this->getOutput();

		if ($endApp) {

			/**
			 * @var $app CWebApplication
			 */
			$app = Yii::app();

			// End yii app
			$app->end();
		}
	}

	/**
	 * Merges messages ({@link JsonResponse::messages}) into response
	 */
	public function prepareMessages() {
		if (!empty($this->messages)) {
			$this->setResponse($this->messagesKey, $this->messages, true);
		}
	}

	/**
	 * Sets required response headers
	 */
	public function setResponseHeaders() {

		// Set HTTP status code header
		http_response_code($this->statusCode);
	}
}