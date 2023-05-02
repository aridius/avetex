<?php
class ControllerExtensionModuleAridiusInfoBlock extends Controller {
	
	public function index() {
        $this->load->model('tool/image');

	    $aridius_infoblock = $this->config->get('module_aridius_infoblock_top_links');

		$data['mod_ifoblocks'] = array();
					if(isset($aridius_infoblock) && is_array($aridius_infoblock)) foreach ($aridius_infoblock as $mod_ifoblocks) {
						$data['mod_ifoblocks'][] = array(
						'title' 			=> $mod_ifoblocks['title'][$this->config->get('config_language_id')],
						'image' 			=> $this->model_tool_image->resize($mod_ifoblocks['image'],44, 44),
						'description' 		=> html_entity_decode($mod_ifoblocks['description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8')
						);
			}	

        return $this->load->view('extension/module/aridius_infoblock', $data);
		
	}
}