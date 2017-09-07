<?php
/**
 * FlashAndRedirectTrait
 *
 * @author Florian Krämer
 * @copyright 2013 - 2017 Florian Krämer
 * @license MIT
 */
namespace Burzum\UserTools\Controller\Component;

/**
 * FlashAndRedirectTrait
 *
 * @property \Cake\Controller\ComponentRegistry $_registry
 */
trait FlashAndRedirectTrait {

	/**
	 * Helper property to detect a redirect
	 *
	 * @see UserToolComponent::handleFlashAndRedirect();
	 * @var \Cake\Http\Response|null
	 */
	protected $_redirectResponse = null;

	/**
	 * Handles flashes and redirects
	 *
	 * @param string $type Prefix for the array key, mostly "success" or "error"
	 * @param array $options Options
	 * @return mixed
	 */
	public function handleFlashAndRedirect($type, $options) {
		$this->_handleFlash($type, $options);

		return $this->_handleRedirect($type, $options);
	}

	/**
	 * Handles the redirect options.
	 *
	 * @param string $type Prefix for the array key, mostly "success" or "error"
	 * @param array $options Options
	 * @return mixed
	 */
	protected function _handleRedirect($type, $options) {
		if (isset($options[$type . 'RedirectUrl']) && $options[$type . 'RedirectUrl'] !== false) {
			$controller = $this->getController();
			$result = $controller->redirect($options[$type . 'RedirectUrl']);
			$this->_redirectResponse = $result;

			return $result;
		}

		$this->_redirectResponse = null;

		return false;
	}

	/**
	 * Handles the flash options.
	 *
	 * @param string $type Prefix for the array key, mostly "success" or "error"
	 * @param array $options Options
	 * @return bool
	 */
	protected function _handleFlash($type, $options) {
		if (isset($options[$type . 'Message']) && $options[$type . 'Message'] !== false) {
			if (is_string($options[$type . 'Message'])) {
				$flashOptions = [];
				if (isset($options[$type . 'FlashOptions'])) {
					$flashOptions = $options[$type . 'FlashOptions'];
				}

				if (!isset($flashOptions['element'])) {
					if (!$this->_registry->has('Flash')) {
						$this->_registry->load('Flash');
					}

					$flashOptions['element'] = $type;
					$this->_registry->get('Flash')->set($options[$type . 'Message'], $flashOptions);
				}

				return true;
			}
		}

		return false;
	}
}
