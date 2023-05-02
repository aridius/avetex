<?php
class ControllerExtensionModuleAridiusBannerPlus extends Controller {
	
public function index($setting) {

        $this->load->model('tool/image');

		$banner_plus_top_links 	= $setting['aridius_banner_plus_top_links'];
					
		$data['width'] = $setting['width'];
		$data['height'] = $setting['height'];
		$data['deluxe_lazy'] = $this->config->get('theme_deluxe_lazy');
		$data['aridius_banner_plus_top_links'] = array();
		
		if(isset($banner_plus_top_links) && is_array($banner_plus_top_links)) foreach ($banner_plus_top_links as $banner_plus_top_link) {
					
		if ($banner_plus_top_link['image'] && is_file(DIR_IMAGE . $banner_plus_top_link['image'])) {
			$banner_block_prod = $this->model_tool_image->resize($banner_plus_top_link['image'], $setting['width'], $setting['height']);
		} else {
			$banner_block_prod = $this->model_tool_image->resize('no_image.png', $setting['width'], $setting['height']);
		}
		
		$data['aridius_banner_plus_top_links'][] = array(
			'name' => $banner_plus_top_link['name'][$this->config->get('config_language_id')],
			'description' 		=> html_entity_decode($banner_plus_top_link['description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8'),
			'price' => $banner_plus_top_link['price'][$this->config->get('config_language_id')],
			'link' => $banner_plus_top_link['link'][$this->config->get('config_language_id')],
			'btn' => $banner_plus_top_link['btn'][$this->config->get('config_language_id')],
			'background' => $banner_plus_top_link['background'],
			'color_name' => $banner_plus_top_link['color_name'],
			'color_price' => $banner_plus_top_link['color_price'],
			'color_btn_b' => $banner_plus_top_link['color_btn_b'],
			'color_btn_c' => $banner_plus_top_link['color_btn_c'],
			'color_btn_bh' => $banner_plus_top_link['color_btn_bh'],
			'color_btn_ch' => $banner_plus_top_link['color_btn_ch'],
			'sort_order' => $banner_plus_top_link['sort_order'],
		    'image_href'  => $banner_block_prod,
					
			);
		}


		if (!empty($data['aridius_banner_plus_top_links'])){
			foreach ($data['aridius_banner_plus_top_links'] as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			} 
			array_multisort($sort_order, SORT_ASC, $data['aridius_banner_plus_top_links']);
		}

		return $this->load->view('extension/module/aridius_banner_plus', $data);
		
	}
}