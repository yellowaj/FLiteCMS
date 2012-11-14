<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$this->load->view('admin/general/admin_head', (isset($head_data)) ? $head_data : '');

if($header_active) { $this->load->view('admin/general/admin_header', (isset($header_data)) ? $header_data : ''); }

$this->load->view($page, (isset($page_data)) ? $page_data : '');

if($footer_active) { $this->load->view('admin/general/admin_footer', (isset($footer_data)) ? $footer_data : ''); }