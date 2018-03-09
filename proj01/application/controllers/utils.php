<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Utils extends CI_Controller
{
    public function migrate(){
        $this->load->library("migration");

        if ($this->migration->current() === FALSE)
        {
            show_error($this->migration->error_string());
        }
    }
}