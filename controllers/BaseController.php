<?php
require_once 'SettingsController.php';
require_once 'MovieController.php';

abstract class BaseController {

    public abstract function handle_action($action);

}