<?php

interface ControllerInterface {

    public function render();

    public function handleAction($action);

}