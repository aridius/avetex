<?php
class ControllerExtensionModuleAridiusIcons extends Controller {
	private $error = array();

	public function index() {

	    $this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
				
		$this->load->language('extension/module/aridius_icons');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_aridius_icons', $this->request->post);

		$this->session->data['success'] = $this->language->get('text_success');

		if (isset($this->request->post['apply'])) {
			$this->response->redirect($this->url->link('extension/module/aridius_icons', 'user_token=' . $this->session->data['user_token'], true));
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
			'href' => $this->url->link('extension/module/aridius_icons', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/aridius_icons', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->post['module_aridius_icons_status'])) {
			$data['module_aridius_icons_status'] = $this->request->post['module_aridius_icons_status'];
		} else {
			$data['module_aridius_icons_status'] = $this->config->get('module_aridius_icons_status');
		}

        if (isset($this->request->post['module_aridius_icons_colico'])) {
			$data['module_aridius_icons_colico'] = $this->request->post['module_aridius_icons_colico'];
		} else {
			$data['module_aridius_icons_colico'] = $this->config->get('module_aridius_icons_colico');
		}

		if (isset($this->request->post['module_aridius_icons_popup'])) {
			$data['module_aridius_icons_popup'] = $this->request->post['module_aridius_icons_popup'];
		} else {
			$data['module_aridius_icons_popup'] = $this->config->get('module_aridius_icons_popup');
		}
		
		if (isset($this->request->post['module_aridius_icons_link'])) {
			$data['module_aridius_icons_link'] = $this->request->post['module_aridius_icons_link'];
		} else {
			$data['module_aridius_icons_link'] = $this->config->get('module_aridius_icons_link');
		}
		
		if (isset($this->request->post['module_aridius_icons_top'])) {
			$data['module_aridius_icons_top'] = $this->request->post['module_aridius_icons_top'];
		} else {
			$data['module_aridius_icons_top'] = $this->config->get('module_aridius_icons_top');
		}
	
		$top_links_block = array();
		if (isset($this->request->post['module_aridius_icons_top_links'])) {
		    $top_links_block =  $this->request->post['module_aridius_icons_top_links'];
	    } elseif ($this->config->get('module_aridius_icons_top_links')) {
	        $top_links_block = $this->config->get('module_aridius_icons_top_links');
	    }
		
        $this->load->model('tool/image');
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['top_links'] = array();
		foreach ($top_links_block as $top_link) {
		if ($top_link['image'] && is_file(DIR_IMAGE . $top_link['image'])) {
			$banner_block_prod = $this->model_tool_image->resize($top_link['image'], 100, 100);
		} else {
			$banner_block_prod = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
			$data['top_links'][] = array(
			'title' => $top_link['title'],
			'image'       => $top_link['image'],
			'main_text' => $top_link['main_text'],
			'add_link' => $top_link['add_link'],
			'description' => $top_link['description'],
		    'image_href'  => $banner_block_prod,
			);
		}		

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/aridius_icons', $data));
		
	}
	
	protected function validate() {

	if (!$this->user->hasPermission('modify', 'extension/module/aridius_icons')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}


}