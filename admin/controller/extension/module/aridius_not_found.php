<?php
class ControllerExtensionModulearidiusNotFound extends Controller {
	
	private $error = array();

	public function index() {

		$this->load->language('extension/module/aridius_not_found');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_aridius_not_found', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
		
            if (isset($this->request->post['apply'])) {
			$this->response->redirect($this->url->link('extension/module/aridius_not_found', 'user_token=' . $this->session->data['user_token'], true));
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
		
		$data['action'] = $this->url->link('extension/module/aridius_not_found', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);


		$data['lang'] = $this->language->get('lang');
		$data['user_token'] = $this->session->data['user_token'];	

		if (isset($this->request->post['module_aridius_not_found_message'])) {
			$data['module_aridius_not_found_message'] = $this->request->post['module_aridius_not_found_message'];
		} else {
			$data['module_aridius_not_found_message'] = $this->config->get('module_aridius_not_found_message');
		}
		
		$this->response->setOutput($this->load->view('extension/module/aridius_not_found', $data));
	}

	private function validate() {
		
		if (!$this->user->hasPermission('modify', 'extension/module/aridius_not_found')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	
	
	public function install() {

		// check not_found layout name
		$sql = "SELECT layout_id FROM `" . DB_PREFIX . "layout` WHERE `name` LIKE 'Page_404' LIMIT 1";

		$query_name = $this->db->query($sql);

		if ($query_name->num_rows == 0) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "layout` SET `name`= 'Page_404'");
		}

		// check not_found layout route by store
		$stores = array(0);

		$sql = "SELECT store_id FROM `" . DB_PREFIX . "store`";

		$query_store = $this->db->query($sql);

		foreach ($query_store->rows as $store) {
			$stores[] = $store['store_id'];
		}

		$newRoutes = array('error/not_found');

		foreach ($newRoutes as $newRoute) {
			foreach ($stores as $store_id) {
				$sql = "SELECT layout_id FROM `" . DB_PREFIX . "layout_route` WHERE `store_id`= '" . (int)$store_id . "' AND `route` LIKE '" . $newRoute . "' LIMIT 1";

				$query = $this->db->query($sql);

				if ($query->num_rows == 0) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "layout_route` SET `layout_id`= (SELECT layout_id FROM `" . DB_PREFIX . "layout` WHERE `name` LIKE 'Page_404' LIMIT 1), `store_id`='" . (int)$store_id . "', `route`='" . $newRoute . "'");
				}
			}
		}
	}
}
