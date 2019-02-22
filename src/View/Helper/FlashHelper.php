<?php

namespace Bootstrap4\View\Helper;

class FlashHelper extends \Cake\View\Helper\FlashHelper {

    /**
     * {@inheritDoc}
     */
    public function render($key = 'flash', array $options = []) {

        $pluginOverrides = ['Flash/default', 'Flash/error', 'Flash/info', 'Flash/success', 'Flash/warning'];

        if (!$this->getSession()->check("Flash.$key")) {
            return null;
        }

        $stack = $this->getSession()->consume("Flash.$key");

        if (!is_array($stack)) {
            throw new \UnexpectedValueException(sprintf(
                'Value for flash setting key "%s" must be an array.',
                $key
            ));
        }

        foreach ($stack as &$item) {

            list($plugin, $element) = pluginSplit($item['element']);
            if ($plugin === null && in_array($item['element'], $pluginOverrides)) {
                $item['element'] = 'Bootstrap4.' . $element;
            }
        }
        $this->getSession()->write("Flash.$key", $stack);

        return parent::render($key, $options);
    }

    /**
     * Wrapper for session/getSession so we can support CakePHP < 3.5
     *
     * @return \Cake\Network\Session
     */
    private function getSession() {
        if (method_exists($this->getView()->getRequest(), 'getSession')) {
            return $this->getView()->getRequest()->getSession();
        } else {
            /** @noinspection PhpDeprecationInspection */
            return $this->request->session();
        }
    }
}