<?php

interface FIlmPluginFilmRepoInterface {


    public function checkFilmTableAndRunMigrations();

    public function getAllFilmData();

    public function getFilmDatafForListTable();

}