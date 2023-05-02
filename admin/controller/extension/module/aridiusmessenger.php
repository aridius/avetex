<?php
class ControllerExtensionModulearidiusMessenger extends Controller {
	
	private $error = array();

	public function index() {

		$this->load->language('extension/module/aridiusmessenger');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_aridiusmessenger', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
		
            if (isset($this->request->post['apply'])) {
			$this->response->redirect($this->url->link('extension/module/aridiusmessenger', 'user_token=' . $this->session->data['user_token'], true));
            } else {
	        $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
            }
		}

	    $data['heading_title'] = $this->language->get('heading_title');
		
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
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
			'href' => $this->url->link('extension/module/aridiuscallback', 'user_token=' . $this->session->data['user_token'], true)
		);
		
		$data['action'] = $this->url->link('extension/module/aridiusmessenger', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
		
		$top_links_block = array();
		if (isset($this->request->post['module_aridiusmessenger_top_links'])) {
			  $top_links_block =  $this->request->post['module_aridiusmessenger_top_links'];
		} elseif ($this->config->get('module_aridiusmessenger_top_links')) {
		  $top_links_block = $this->config->get('module_aridiusmessenger_top_links');
		}
			

		$this->load->model('tool/image');
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['top_links'] = array();
		foreach ($top_links_block as $top_link) {
		if ($top_link['image'] && is_file(DIR_IMAGE . $top_link['image'])) {
			$messenger_block_prod = $this->model_tool_image->resize($top_link['image'], 100, 100);
		} else {
			$messenger_block_prod = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
			$data['top_links'][] = array(
			'title' => $top_link['title'],
			'image'       => $top_link['image'],
			'href' => $top_link['href'],
		    'image_href'  => $messenger_block_prod,
			);
		}		

	    if (isset($this->request->post['module_aridiusmessenger_mailnamemain'])) {
			$data['module_aridiusmessenger_mailnamemain'] = $this->request->post['module_aridiusmessenger_mailnamemain'];
		} else {
			$data['module_aridiusmessenger_mailnamemain'] = $this->config->get('module_aridiusmessenger_mailnamemain');
		}	

		if (isset($this->request->post['module_aridiusmessenger_mail'])) {
			$data['module_aridiusmessenger_mail'] = $this->request->post['module_aridiusmessenger_mail'];
		} else {
			$data['module_aridiusmessenger_mail'] = $this->config->get('module_aridiusmessenger_mail');
		}

		if (isset($this->request->post['module_aridiusmessenger_mailnamemain']) && is_file(DIR_IMAGE . $this->request->post['module_aridiusmessenger_mailnamemain'])) {
			$data['main'] = $this->model_tool_image->resize($this->request->post['module_aridiusmessenger_mailnamemain'], 100, 100);
		} elseif ($this->config->get('module_aridiusmessenger_mailnamemain') && is_file(DIR_IMAGE . $this->config->get('module_aridiusmessenger_mailnamemain'))) {
			$data['main'] = $this->model_tool_image->resize($this->config->get('module_aridiusmessenger_mailnamemain'), 100, 100);
		} else {
			$data['main'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}		

		if (isset($this->request->post['module_aridiusmessenger_mail']) && is_file(DIR_IMAGE . $this->request->post['module_aridiusmessenger_mail'])) {
			$data['mail'] = $this->model_tool_image->resize($this->request->post['module_aridiusmessenger_mail'], 100, 100);
		} elseif ($this->config->get('module_aridiusmessenger_mail') && is_file(DIR_IMAGE . $this->config->get('module_aridiusmessenger_mail'))) {
			$data['mail'] = $this->model_tool_image->resize($this->config->get('module_aridiusmessenger_mail'), 100, 100);
		} else {
			$data['mail'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}		

		if (isset($this->request->post['module_aridiusmessenger_mailstatus'])) {
			$data['module_aridiusmessenger_mailstatus'] = $this->request->post['module_aridiusmessenger_mailstatus'];
		} else {
			$data['module_aridiusmessenger_mailstatus'] = $this->config->get('module_aridiusmessenger_mailstatus');
		}

		if (isset($this->request->post['module_aridiusmessenger_status'])) {
			$data['module_aridiusmessenger_status'] = $this->request->post['module_aridiusmessenger_status'];
		} else {
			$data['module_aridiusmessenger_status'] = $this->config->get('module_aridiusmessenger_status');
		}

		if (isset($this->request->post['module_aridiusmessenger_mailname'])) {
			$data['module_aridiusmessenger_mailname'] = $this->request->post['module_aridiusmessenger_mailname'];
		} else {
			$data['module_aridiusmessenger_mailname'] = $this->config->get('module_aridiusmessenger_mailname');
		}

		$this->response->setOutput($this->load->view('extension/module/aridiusmessenger', $data));
	}

	private function validate() {
		
		if (!$this->user->hasPermission('modify', 'extension/module/aridiusmessenger')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

}
