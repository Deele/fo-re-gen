<?php

/**
 * Class XmlResponse provides standartized XML output
 *
 * @author Nils Lindentals <nils@webmultishop.com>
 *
 * @copyright 2014 Web Multishop Company LLD
 * @license GPL
 */
class XmlResponse extends ResponseType {

	/**
	 * Outputs XML response
	 */
	public function getOutput() {

		// Prepeare XML response
		if (!is_null($this->success)) {
			$this->setResponse($this->successKey, $this->success);
		}
		$this->prepareMessages();
		$xml = new SimpleXMLElement("<?xml version=\"1.0\"?><$this->rootElement></$this->rootElement>");
		self::array_to_xml($this->response, $xml);
		$this->response = $xml->asXML();

		$this->setResponseHeaders();

		return $this->response;
	}

	/**
	 * Converts array to XML
	 *
	 * @param array $data
	 * @param SimpleXMLElement $xml
	 */
	public static function array_to_xml($data, &$xml) {
		foreach ($data as $key => $value) {
			if (is_array($value)) {
				if (!is_numeric($key)){
					$subnode = $xml->addChild((string) $key);
					self::array_to_xml($value, $subnode);
				}
				else{
					$subnode = $xml->addChild('item');
					$subnode->addAttribute('key', $key);
					self::array_to_xml($value, $subnode);
				}
			}
			else {
				$xml->addChild((string) $key, htmlspecialchars((string) $value));
			}
		}
	}

	/**
	 * Sets required response headers
	 */
	public function setResponseHeaders() {
		parent::setResponseHeaders();

		// Set header to json content type
		mtHeader::xml();
	}
}