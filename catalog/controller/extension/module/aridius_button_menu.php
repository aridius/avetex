<?php
class ControllerExtensionModuleAridiusButtonMenu extends Controller {
	
    public function index() {
   
   $this->load->language('extension/module/aridius_button_menu');
	
	return $this->load->view('extension/module/aridius_button_menu');
   
   }
}