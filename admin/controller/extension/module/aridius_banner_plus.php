<?php
class ControllerExtensionModuleAridiusBannerPlus extends Controller {
	private $error = array();

	public function index() {

	    $this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
				
		$this->load->language('extension/module/aridius_banner_plus');
		
		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('aridius_banner_plus', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}
            $this->cache->delete('product');
			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
			$this->response->redirect($this->url->link('extension/module/aridius_banner_plus', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true));
            } else {
	        $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
            }
		}		

		
		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
		}	
		
		if (isset($this->error['height'])) {
			$data['error_height'] = $this->error['height'];
		} else {
			$data['error_height'] = '';
		}	

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/aridius_banner_plus', 'user_token=' . $this->session->data['user_token'], true)
		);

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/aridius_banner_plus', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/aridius_banner_plus', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($module_info)) {
			$data['width'] = $module_info['width'];
		} else {
			$data['width'] = 262;
		}

		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($module_info)) {
			$data['height'] = $module_info['height'];
		} else {
			$data['height'] = 280;
		}

        $this->load->model('tool/image');
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		$top_links_block = array();

		if (isset($this->request->post['aridius_banner_plus_top_links'])) {
			$top_links_block = $this->request->post['aridius_banner_plus_top_links'];
		} elseif (!empty($module_info)) {
			$top_links_block =  $module_info['aridius_banner_plus_top_links'];
		} else {
	
			$top_links_block = array();
		}	

		$data['banner_links'] = array();
		foreach ($top_links_block as $banner_link) {
		if ($banner_link['image'] && is_file(DIR_IMAGE . $banner_link['image'])) {
			$banner_block_prod = $this->model_tool_image->resize($banner_link['image'], 100, 100);
		} else {
			$banner_block_prod = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
			
			$data['banner_links'][] = array(
			'name' => $banner_link['name'],
			'image'       => $banner_link['image'],
			'description' => $banner_link['description'],
			'price' => $banner_link['price'],
			'link' => $banner_link['link'],
			'btn' => $banner_link['btn'],
			'sort_order' => $banner_link['sort_order'],
			'background' => $banner_link['background'],
			'color_name' => $banner_link['color_name'],
			'color_price' => $banner_link['color_price'],
			'color_btn_b' => $banner_link['color_btn_b'],
			'color_btn_c' => $banner_link['color_btn_c'],
			'color_btn_bh' => $banner_link['color_btn_bh'],
			'color_btn_ch' => $banner_link['color_btn_ch'],
		    'image_href'  => $banner_block_prod,
			);
		}

	    if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/aridius_banner_plus', $data));
		
	}
	
	protected function validate() {

	if (!$this->user->hasPermission('modify', 'extension/module/aridius_banner_plus')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		
		if (!$this->request->post['width']) {
		$this->error['width'] = $this->language->get('error_width');
		}

		if (!$this->request->post['height']) {
		$this->error['height'] = $this->language->get('error_height');
		}	
		
		return !$this->error;
	}


}