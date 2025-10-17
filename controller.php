<?php

namespace Purpozed2;

abstract class Controller implements ControllerInterface {
    protected $view;
    protected $menuActiveButton;

    public function __construct() {
        $this->view = new View();
        $this->view->menuActiveButton = $this->getMenuActiveButton();
    }

    public function getDescription() {
        return $this->description;
    }

    public function getTemplate() {
        return strtolower(str_replace('Purpozed2\Controllers\\', '', get_class($this)));
    }

    public function getViewVariables() {
        return $this->view->getVariables();
    }

    private function getMenuActiveButton() {
        return $this->menuActiveButton;
    }


}