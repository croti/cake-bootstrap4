<?php

namespace Bootstrap4\View;

trait BootstrapViewTrait {

    public function initializeBootstrap(array $options = []) {
        $this->loadHelper('Html', ['className' => 'Bootstrap4.Html']);
        $this->loadHelper('Flash', ['className' => 'Bootstrap4.Flash']);
        $this->loadHelper('Form', ['className' => 'Bootstrap4.Form']);
        $this->loadHelper('Paginator', ['className' => 'Bootstrap4.Paginator']);
    }

    /**
     * Slightly tweaked the order $paths and $elementsPaths are traversed. This allows
     * Prefixes to take precedence
     *
     * @inheritdoc
     */
    protected function _getElementFileName($name, $pluginCheck = true) {
        list($plugin, $name) = $this->pluginSplit($name, $pluginCheck);

        $paths = $this->_paths($plugin);
        $elementPaths = $this->_getSubPaths('Element');
        foreach ($elementPaths as $elementPath) {
            foreach ($paths as $path) {
                if (file_exists($path . $elementPath . DIRECTORY_SEPARATOR . $name . $this->_ext)) {
                    return $path . $elementPath . DIRECTORY_SEPARATOR . $name . $this->_ext;
                }
            }
        }
        return false;
    }
}