<?php

/**
 * Class HelpController handles requests to /api/help
 *
 * @author Nils Lindentals <nils@webmultishop.com>
 *
 * @copyright 2014 Web Multishop Company LLD
 * @license GPL
 */
class HelpController extends ApiControllerBase {

	/**
	 * @var string the name of the default action. Defaults to 'help'.
	 */
	public $defaultAction = 'help';

	/**
	 * Outputs response to requests:
	 * "/api" (default action for default controller)
	 * "/api/help" (default action)
	 * "/api/help/help" (this specific action)
	 */
	public function actionHelp() {
		$this->response->addMessage(array(
			'class' => 'info',
			'text' => 'You have reached API'
		));
		$avilableControllers = array(
			array(
				'controller' => 'help',
				'actions' => array(
					'help' => $this->createUrl('help', 'help')
				)
			),
			array(
				'controller' => 'user',
				'actions' => array(
					'help' => $this->createUrl('user', 'help')
				)
			),
		);
		$this->response->setResponse(
			'avilableControllers',
			$avilableControllers
		);
	}
}