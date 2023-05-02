<?php
class ControllerExtensionModuleAridiusIcons extends Controller {
	
	public function index() {
        $this->load->model('tool/image');
		$data['language_id'] = $this->config->get('config_language_id');

        $data['aridius_icons_colico'] = $this->config->get('module_aridius_icons_colico');
        $data['aridius_icons_popup'] = $this->config->get('module_aridius_icons_popup');
        $data['aridius_icons_link'] = $this->config->get('module_aridius_icons_link');
        $data['aridius_icons_top'] = $this->config->get('module_aridius_icons_top');

	    $aridius_icons_top_links = $this->config->get('module_aridius_icons_top_links');

			$data['mod_icons'] = array();
					if(isset($aridius_icons_top_links) && is_array($aridius_icons_top_links)) foreach ($aridius_icons_top_links as $mod_icons) {
						$data['mod_icons'][] = array(
						'main_text' 			=> $mod_icons['main_text'],
						'add_link' 			=> $mod_icons['add_link'],
						'title' 			=> $mod_icons['title'],
						'image' 			=> $this->model_tool_image->resize($mod_icons['image'],44, 44),
						'description' 		=> html_entity_decode($mod_icons['description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8')
						);
			}	

		return $this->load->view('extension/module/aridius_icons', $data);
		
	}
}