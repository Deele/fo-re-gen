<?php

/**
 * Class ApiModule handles "/api" requests
 *
 * @author Nils Lindentals <nils@webmultishop.com>
 *
 * @copyright 2014 Web Multishop Company LLD
 * @license GPL
 */
class ApiModule extends CWebModule {

	/**
	 * @var string the ID of the default controller for this module. Defaults to 'default'.
	 */
	public $defaultController = 'help';

	/**
	 * Initializes the module.
	 * This method is called at the end of the module constructor.
	 * Note that at this moment, the module has been configured, the behaviors
	 * have been attached and the application components have been registered.
	 * @see preinit
	 */
	public function init() {
		$this->setImport(
			array(
				'api.models.*',
				'api.components.*',
			)
		);
	}

	/**
	 * The pre-filter for controller actions
	 *
	 * @param CController $controller the controller
	 * @param CAction $action the action
	 *
	 * @return boolean whether the action should be executed.
	 */
	public function beforeControllerAction($controller, $action) {
		if (parent::beforeControllerAction($controller, $action)) {
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else {
			return false;
		}
	}
}
