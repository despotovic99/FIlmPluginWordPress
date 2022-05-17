<?php
require_once 'SettingsPageController.php';
require_once 'MovieController.php';

abstract class BaseController {

    public abstract function handle_action($action);

}