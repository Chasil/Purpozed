<?php

namespace Purpozed2;

interface ControllerInterface {
    public function getDescription();
    public function getTemplate();
    public function setViewVariables();
}