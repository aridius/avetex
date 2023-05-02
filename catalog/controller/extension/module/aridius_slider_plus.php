<?php
class ControllerExtensionModuleAridiusSliderPlus extends Controller {
	
public function index($setting) {

static $module = 0;	
        
		$this->load->model('tool/image');
	
            $data['width'] = $setting['width'];
			$data['height'] = $setting['height'];
			$data['deluxe_lazy'] = $this->config->get('theme_deluxe_lazy');
            $data['transitionStyle'] = $setting['transitionStyle'];

			$slider_plus_top_links 	= $setting['aridius_slider_plus_top_links'];
			$data['aridius_slider_plus_top_links'] = array();
			if(isset($slider_plus_top_links) && is_array($slider_plus_top_links)) foreach ($slider_plus_top_links as $slider_plus_top_link) {
			if ($slider_plus_top_link['image'] && is_file(DIR_IMAGE . $slider_plus_top_link['image'])) {
				$slider_block_prod = $this->model_tool_image->resize($slider_plus_top_link['image'], $setting['width'], $setting['height']);
			} else {
				$slider_block_prod = $this->model_tool_image->resize('no_image.png', $setting['width'], $setting['height']);
			}
			
			$data['aridius_slider_plus_top_links'][] = array(
			'name' => $slider_plus_top_link['name'][$this->config->get('config_language_id')],
			'description' 		=> html_entity_decode($slider_plus_top_link['description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8'),
			'price' => $slider_plus_top_link['price'][$this->config->get('config_language_id')],
			'link' => $slider_plus_top_link['link'][$this->config->get('config_language_id')],
			'btn' => $slider_plus_top_link['btn'][$this->config->get('config_language_id')],
			'background' => $slider_plus_top_link['background'],
			'color_name' => $slider_plus_top_link['color_name'],
			'color_price' => $slider_plus_top_link['color_price'],
			'color_btn_b' => $slider_plus_top_link['color_btn_b'],
			'color_btn_c' => $slider_plus_top_link['color_btn_c'],
			'color_btn_bh' => $slider_plus_top_link['color_btn_bh'],
			'color_btn_ch' => $slider_plus_top_link['color_btn_ch'],
			'sort_order' => $slider_plus_top_link['sort_order'],
		    'image_href'  => $slider_block_prod,
					  );
			}

		$data['module'] = $module++;
		
		if (!empty($data['aridius_slider_plus_top_links'])){
			foreach ($data['aridius_slider_plus_top_links'] as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			} 
			array_multisort($sort_order, SORT_ASC, $data['aridius_slider_plus_top_links']);
		}			
		

		return $this->load->view('extension/module/aridius_slider_plus', $data);
		
	}
}