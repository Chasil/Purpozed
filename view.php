<?php

namespace Purpozed2;

class View {

    private $variables = array();

    public function __set($name, $value) {
        $this->variables[$name]=$value;
    }

    public function __get($name) {
        return $this->variables[$name];
    }

    public function getVariables() {
        return $this->variables;
    }
}