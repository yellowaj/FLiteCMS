<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$this->load->view('front/general/head', (isset($head_data)) ? $head_data : '');

if($header_active) { $this->load->view('front/general/header', (isset($header_data)) ? $header_data : ''); }

$this->load->view($page, (isset($page_data)) ? $page_data : '');

if($footer_active) { $this->load->view('front/general/footer', (isset($footer_data)) ? $footer_data : ''); }