<?php
defined('BASEPATH') or exit('No direct script access allowed');
require FCPATH . 'vendor/autoload.php';
$hook['pre_system'] = function () {
    $dotenv = new Dotenv\Dotenv(APPPATH);
    $dotenv->load();
};