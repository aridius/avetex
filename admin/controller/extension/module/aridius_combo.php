<?php
class ControllerExtensionModuleAridiusCombo extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/aridius_combo');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');
	    $this->load->model('catalog/aridiuscombo');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_setting_module->addModule('aridius_combo', $this->request->post);
			} else {
				$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}
	        $this->getList();
	}

	public function add() {
			$this->load->language('extension/module/aridius_combo');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/aridiuscombo');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_aridiuscombo->addaridiuscombo($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('extension/module/aridius_combo', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('extension/module/aridius_combo');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/aridiuscombo');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_aridiuscombo->editaridiuscombo($this->request->get['aridiuscombo_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('extension/module/aridius_combo', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('extension/module/aridius_combo');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/aridiuscombo');

		//if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $aridiuscombo_id) {
				$this->model_catalog_aridiuscombo->deletearidiuscombo($aridiuscombo_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('extension/module/aridius_combo', 'user_token=' . $this->session->data['user_token'] . $url, true));
		//}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'od.name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/aridius_combo', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('extension/module/aridius_combo/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('extension/module/aridius_combo/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['aridiuscombos'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$aridiuscombo_total = $this->model_catalog_aridiuscombo->getTotalaridiuscombos();

		$results = $this->model_catalog_aridiuscombo->getaridiuscombos($filter_data);

		foreach ($results as $result) {
			$data['aridiuscombos'][] = array(
				'aridiuscombo_id'  => $result['aridiuscombo_id'],
				'name'       => $result['name'],
				'sort_order' => $result['sort_order'],
				'edit'       => $this->url->link('extension/module/aridius_combo/edit', 'user_token=' . $this->session->data['user_token'] . '&aridiuscombo_id=' . $result['aridiuscombo_id'] . $url, true)
			);
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('extension/module/aridius_combo', 'user_token=' . $this->session->data['user_token'] . '&sort=od.name' . $url, true);
		$data['sort_sort_order'] = $this->url->link('extension/module/aridius_combo', 'user_token=' . $this->session->data['user_token'] . '&sort=o.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $aridiuscombo_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/module/aridius_combo', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($aridiuscombo_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($aridiuscombo_total - $this->config->get('config_limit_admin'))) ? $aridiuscombo_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $aridiuscombo_total, ceil($aridiuscombo_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/aridius_combo_list', $data));
	}

	protected function getForm() {

		$data['text_form'] = !isset($this->request->get['aridiuscombo_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['aridiuscombo_value'])) {
			$data['error_aridiuscombo_value'] = $this->error['aridiuscombo_value'];
		} else {
			$data['error_aridiuscombo_value'] = array();
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/aridius_combo', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		if (!isset($this->request->get['aridiuscombo_id'])) {
			$data['action'] = $this->url->link('extension/module/aridius_combo/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('extension/module/aridius_combo/edit', 'user_token=' . $this->session->data['user_token'] . '&aridiuscombo_id=' . $this->request->get['aridiuscombo_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('extension/module/aridius_combo', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['aridiuscombo_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$aridiuscombo_info = $this->model_catalog_aridiuscombo->getaridiuscombo($this->request->get['aridiuscombo_id']);
		}

		$data['user_token'] = $this->session->data['user_token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['aridiuscombo_description'])) {
			$data['aridiuscombo_description'] = $this->request->post['aridiuscombo_description'];
		} elseif (isset($this->request->get['aridiuscombo_id'])) {
			$data['aridiuscombo_description'] = $this->model_catalog_aridiuscombo->getaridiuscomboDescriptions($this->request->get['aridiuscombo_id']);
		} else {
			$data['aridiuscombo_description'] = array();
		}

		if (isset($this->request->post['product_id'])) {
			$data['product_id'] = $this->request->post['product_id'];
		} elseif (!empty($aridiuscombo_info)) {
			$data['product_id'] = $aridiuscombo_info['product_id'];
		} else {
			$data['product_id'] = 0;
		}

		$this->load->model('catalog/product');

		if (isset($this->request->post['product'])) {
			$data['product'] = $this->request->post['product'];
		} elseif (!empty($aridiuscombo_info['product_id'])) {
			$data['product'] = $this->model_catalog_product->getProduct($aridiuscombo_info['product_id'])['name'];
		} else {
			$data['product'] = '';
		}

		if (isset($this->request->post['type'])) {
			$data['type'] = $this->request->post['type'];
		} elseif (!empty($aridiuscombo_info['type'])) {
			$data['type'] = $aridiuscombo_info['type'];
		} else {
			$data['type'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($aridiuscombo_info['status'])) {
			$data['status'] = $aridiuscombo_info['status'];
		} else {
			$data['status'] = 0;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($aridiuscombo_info['sort_order'])) {
			$data['sort_order'] = $aridiuscombo_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if (isset($this->request->post['aridiuscombo_value'])) {
			$aridiuscombo_values = $this->request->post['aridiuscombo_value'];
		} elseif (isset($this->request->get['aridiuscombo_id'])) {
			$aridiuscombo_values = $this->model_catalog_aridiuscombo->getaridiuscomboValueDescriptions($this->request->get['aridiuscombo_id']);
		} else {
			$aridiuscombo_values = array();
		}

		$data['aridiuscombo_values'] = array();

		foreach ($aridiuscombo_values as $aridiuscombo_value) {
			if(!empty($aridiuscombo_value['product_id'])) {
				$product = $this->model_catalog_product->getProduct($aridiuscombo_value['product_id'])['name'];
			} else {
				$product = '';
			}

			$data['aridiuscombo_values'][] = array(
				'aridiuscombo_value_id'          => $aridiuscombo_value['aridiuscombo_value_id'],
				'product'                => $product,
				'product_id'                => $aridiuscombo_value['product_id'],
				'discount'                    => $aridiuscombo_value['discount'],
				'sort_order'               => $aridiuscombo_value['sort_order']
			);
		}


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/aridius_combo_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'extension/module/aridius_combo')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['aridiuscombo_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 128)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}

		//if (($this->request->post['type'] == 'select' || $this->request->post['type'] == 'radio' || $this->request->post['type'] == 'checkbox') && !isset($this->request->post['aridiuscombo_value'])) {
		//	$this->error['warning'] = $this->language->get('error_type');
		//}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/module/aridius_combo')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		//$this->load->model('catalog/product');

		//foreach ($this->request->post['selected'] as $aridiuscombo_id) {
		//	$product_total = $this->model_catalog_product->getTotalProductsByaridiuscomboId($aridiuscombo_id);

		//	if ($product_total) {
		//		$this->error['warning'] = sprintf($this->language->get('error_product'), $product_total);
		//	}
		//}

		return !$this->error;
	}

		public function install() {
		
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "aridiuscombo` (`aridiuscombo_id` int(11) NOT NULL AUTO_INCREMENT, `product_id` int(11) NOT NULL, `type` int(3) NOT NULL, `sort_order` int(3) NOT NULL, `status` int(1) NOT NULL, PRIMARY KEY (`aridiuscombo_id`)) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "aridiuscombo_description` (`aridiuscombo_id` int(11) NOT NULL, `language_id` int(11) NOT NULL, `name` varchar(128) NOT NULL, PRIMARY KEY (`aridiuscombo_id`,`language_id`)) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "aridiuscombo_value` (`aridiuscombo_value_id` int(11) NOT NULL AUTO_INCREMENT, `aridiuscombo_id` int(11) NOT NULL, `product_id` int(11) NOT NULL, `discount` decimal(15,4) NOT NULL, `sort_order` int(3) NOT NULL, PRIMARY KEY (`aridiuscombo_value_id`)) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
	    $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "aridiuscombo_value_description` (`aridiuscombo_value_id` int(11) NOT NULL, `language_id` int(11) NOT NULL, `aridiuscombo_id` int(11) NOT NULL, `name` varchar(128) NOT NULL, PRIMARY KEY (`aridiuscombo_value_id`,`language_id`)) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "carttmp` (`carttmp_id` int(11) UNSIGNED NOT NULL, `api_id` int(11) NOT NULL, `customer_id` int(11) NOT NULL, `session_id` varchar(32) NOT NULL, `product_id` int(11) NOT NULL, `recurring_id` int(11) NOT NULL, `option` text NOT NULL, `quantity` int(5) NOT NULL, `set_id` varchar(255) NOT NULL, `set_discount` decimal(15,4) NOT NULL, `date_added` datetime NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
	
		$check_setid = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "cart LIKE 'set_id'");
		if ($check_setid->num_rows > 0) {
		} else {
		$this->db->query("ALTER TABLE `".DB_PREFIX."cart` ADD `set_id` varchar(255) NOT NULL AFTER `date_added`");
		}

		$check_setdiscount = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "cart LIKE 'set_discount'");
		if ($check_setdiscount->num_rows > 0) {
		} else {
		$this->db->query("ALTER TABLE `".DB_PREFIX."cart` ADD `set_discount` decimal(15,4) NOT NULL AFTER `date_added`");
		}
	}

}