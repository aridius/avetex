<?php
class ControllerExtensionModuleAridiusMessenger extends Controller {
	
	public function index() {

	$data['language_id'] = $this->config->get('config_language_id');

	$this->load->model('tool/image');
	$data['aridiusmessenger_mailnamemain'] = $this->model_tool_image->resize($this->config->get('module_aridiusmessenger_mailnamemain'),66, 66);	
	$data['aridiusmessenger_mail'] = $this->model_tool_image->resize($this->config->get('module_aridiusmessenger_mail'),66, 66);	

	$data['aridiusmessenger_mailname'] = $this->config->get('module_aridiusmessenger_mailname');

    $data['aridiusmessenger_mailstatus'] = $this->config->get('module_aridiusmessenger_mailstatus');

	$aridiusmessenger_top_links = $this->config->get('module_aridiusmessenger_top_links');

		$data['top_links'] = array();

		if(isset($aridiusmessenger_top_links) && is_array($aridiusmessenger_top_links)) foreach ($aridiusmessenger_top_links as $top_links) {
			$data['top_links'][] = array(
			'title' 			=> $top_links['title'][$this->config->get('config_language_id')],
			'image' 			=> $this->model_tool_image->resize($top_links['image'],66, 66),
			'href' 		=> html_entity_decode($top_links['href'], ENT_QUOTES, 'UTF-8')
			
			
			
			
			);
		}

		return $this->load->view('extension/module/aridiusmessenger', $data);
		
	}
}