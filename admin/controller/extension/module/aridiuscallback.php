<?php
class ControllerExtensionModulearidiuscallback extends Controller {
	
	private $error = array();

	public function index() {

		$this->load->language('extension/module/aridiuscallback');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_aridiuscallback', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
		
            if (isset($this->request->post['apply'])) {
			$this->response->redirect($this->url->link('extension/module/aridiuscallback', 'user_token=' . $this->session->data['user_token'], true));
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
		
		$data['aridiuscallback'] = $this->url->link('catalog/aridiuscallback', 'user_token=' . $this->session->data['user_token'], true);
		$data['action'] = $this->url->link('extension/module/aridiuscallback', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		$this->load->language('extension/module/aridiuscallback');

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->request->post['module_aridiuscallback_adddescriptionshow'])) {
			$data['module_aridiuscallback_adddescriptionshow'] = $this->request->post['module_aridiuscallback_adddescriptionshow'];
		} else {
			$data['module_aridiuscallback_adddescriptionshow'] = $this->config->get('module_aridiuscallback_adddescriptionshow');
		}

		if (isset($this->request->post['module_aridiuscallback_firstnameshow'])) {
			$data['module_aridiuscallback_firstnameshow'] = $this->request->post['module_aridiuscallback_firstnameshow'];
		} else {
			$data['module_aridiuscallback_firstnameshow'] = $this->config->get('module_aridiuscallback_firstnameshow');
		}
		if (isset($this->request->post['module_aridiuscallback_firstnamevalid'])) {
			$data['module_aridiuscallback_firstnamevalid'] = $this->request->post['module_aridiuscallback_firstnamevalid'];
		} else {
			$data['module_aridiuscallback_firstnamevalid'] = $this->config->get('module_aridiuscallback_firstnamevalid');
		}
		
		if (isset($this->request->post['module_aridiuscallback_mask'])) {
			$data['module_aridiuscallback_mask'] = $this->request->post['module_aridiuscallback_mask'];
		} else {
			$data['module_aridiuscallback_mask'] = $this->config->get('module_aridiuscallback_mask');
		}
		
		if (isset($this->request->post['module_aridiuscallback_placeholderfirstname'])) {
			$data['module_aridiuscallback_placeholderfirstname'] = $this->request->post['module_aridiuscallback_placeholderfirstname'];
		} else {
			$data['module_aridiuscallback_placeholderfirstname'] = $this->config->get('module_aridiuscallback_placeholderfirstname');
		}
		
		if (isset($this->request->post['module_aridiuscallback_placeholdertell'])) {
			$data['module_aridiuscallback_placeholdertell'] = $this->request->post['module_aridiuscallback_placeholdertell'];
		} else {
			$data['module_aridiuscallback_placeholdertell'] = $this->config->get('module_aridiuscallback_placeholdertell');
		}
		
		if (isset($this->request->post['module_aridiuscallback_emailshow'])) {
			$data['module_aridiuscallback_emailshow'] = $this->request->post['module_aridiuscallback_emailshow'];
		} else {
			$data['module_aridiuscallback_emailshow'] = $this->config->get('module_aridiuscallback_emailshow');
		}
		
		if (isset($this->request->post['module_aridiuscallback_emailvalid'])) {
			$data['module_aridiuscallback_emailvalid'] = $this->request->post['module_aridiuscallback_emailvalid'];
		} else {
			$data['module_aridiuscallback_emailvalid'] = $this->config->get('module_aridiuscallback_emailvalid');
		}
		
		if (isset($this->request->post['module_aridiuscallback_placeholderemail'])) {
			$data['module_aridiuscallback_placeholderemail'] = $this->request->post['module_aridiuscallback_placeholderemail'];
		} else {
			$data['module_aridiuscallback_placeholderemail'] = $this->config->get('module_aridiuscallback_placeholderemail');
		}
		
		if (isset($this->request->post['module_aridiuscallback_commentshow'])) {
			$data['module_aridiuscallback_commentshow'] = $this->request->post['module_aridiuscallback_commentshow'];
		} else {
			$data['module_aridiuscallback_commentshow'] = $this->config->get('module_aridiuscallback_commentshow');
		}
		
		if (isset($this->request->post['module_aridiuscallback_placeholdercomment'])) {
			$data['module_aridiuscallback_placeholdercomment'] = $this->request->post['module_aridiuscallback_placeholdercomment'];
		} else {
			$data['module_aridiuscallback_placeholdercomment'] = $this->config->get('module_aridiuscallback_placeholdercomment');
		}
		
		if (isset($this->request->post['module_aridiuscallback_description'])) {
			$data['module_aridiuscallback_description'] = $this->request->post['module_aridiuscallback_description'];
		} else {
			$data['module_aridiuscallback_description'] = $this->config->get('module_aridiuscallback_description');
		}
		
		if (isset($this->request->post['module_aridiuscallback_description2'])) {
			$data['module_aridiuscallback_description2'] = $this->request->post['module_aridiuscallback_description2'];
		} else {
			$data['module_aridiuscallback_description2'] = $this->config->get('module_aridiuscallback_description2');
		}

		if (isset($this->request->post['module_aridiuscallback_placeholdertimein'])) {
			$data['module_aridiuscallback_placeholdertimein'] = $this->request->post['module_aridiuscallback_placeholdertimein'];
		} else {
			$data['module_aridiuscallback_placeholdertimein'] = $this->config->get('module_aridiuscallback_placeholdertimein');
		}
		
		if (isset($this->request->post['module_aridiuscallback_placeholdertimeoff'])) {
			$data['module_aridiuscallback_placeholdertimeoff'] = $this->request->post['module_aridiuscallback_placeholdertimeoff'];
		} else {
			$data['module_aridiuscallback_placeholdertimeoff'] = $this->config->get('module_aridiuscallback_placeholdertimeoff');
		}
		
		if (isset($this->request->post['module_aridiuscallback_timetshow'])) {
			$data['module_aridiuscallback_timetshow'] = $this->request->post['module_aridiuscallback_timetshow'];
		} else {
			$data['module_aridiuscallback_timetshow'] = $this->config->get('module_aridiuscallback_timetshow');
		}

		if (isset($this->request->post['module_aridiuscallback_status'])) {
			$data['module_status'] = $this->request->post['module_aridiuscallback_status'];
		} else {
			$data['module_status'] = $this->config->get('module_aridiuscallback_status');
		}

		$this->response->setOutput($this->load->view('extension/module/aridiuscallback', $data));
	}

	private function validate() {
		
		if (!$this->user->hasPermission('modify', 'extension/module/aridiuscallback')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function install($data) {
		
		$this->load->model('catalog/aridiuscallback');
		$this->load->model('setting/setting');
		$this->model_catalog_aridiuscallback->install();
	}

	public function uninstall() {
		
		$this->load->model('catalog/aridiuscallback');
		$this->load->model('setting/setting');
	}
	
}
