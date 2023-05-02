<?php
class ControllerExtensionModuleAridiusSpecial extends Controller {
	
	private $error = array();

	public function index() {
		
		$this->load->language('extension/module/aridius_special');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
				if (!isset($this->request->get['module_id'])) {
					$this->model_setting_module->addModule('aridius_special', $this->request->post);
				} else {
					$this->model_setting_module->editModule($this->request->get['module_id'], $this->request->post);
				}
				$this->session->data['success'] = $this->language->get('text_success');
				if (isset($this->request->post['apply'])) {
				$this->response->redirect($this->url->link('extension/module/aridius_special', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true));
				} else {
				$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
				}
		}

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

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/aridius_special', 'user_token=' . $this->session->data['user_token'], true)
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/aridius_special', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true)
			);
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('extension/module/aridius_special', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/aridius_special', 'user_token=' . $this->session->data['user_token'] . '&module_id=' . $this->request->get['module_id'], true);
		}

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_setting_module->getModule($this->request->get['module_id']);
		}
		
        $data['user_token'] = $this->session->data['user_token'];

		$this->load->model('catalog/product');

		$data['products'] = array();

		if (isset($this->request->post['product'])) {
			$products = $this->request->post['product'];
		} elseif (!empty($module_info)) {
			$products = $module_info['product'];
		} else {
			$products = array();
		}
		
		if ($products) {
				foreach ($products as $product_id) {
					$product_info = $this->model_catalog_product->getProduct($product_id);

					if ($product_info) {
						$data['products'][] = array(
							'product_id' => $product_info['product_id'],
							'name'       => $product_info['name']
						);
					}
				}
		}		

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['limit'])) {
			$data['limit'] = $this->request->post['limit'];
		} elseif (!empty($module_info)) {
			$data['limit'] = $module_info['limit'];
		} else {
			$data['limit'] = 15;
		}

		if (isset($this->request->post['rat'])) {
			$data['rat'] = $this->request->post['rat'];
		} elseif (!empty($module_info)) {
			$data['rat'] = $module_info['rat'];
		} else {
			$data['rat'] = 1;
		}
		
		if (isset($this->request->post['qt'])) {
			$data['qt'] = $this->request->post['qt'];
		} elseif (!empty($module_info)) {
			$data['qt'] = $module_info['qt'];
		} else {
			$data['qt'] = 1;
		}
		
				
		if (isset($this->request->post['qtmax'])) {
			$data['qtmax'] = $this->request->post['qtmax'];
		} elseif (!empty($module_info)) {
			$data['qtmax'] = $module_info['qtmax'];
		} else {
			$data['qtmax'] = 10;
		}
		
		if (isset($this->request->post['wish'])) {
			$data['wish'] = $this->request->post['wish'];
		} elseif (!empty($module_info)) {
			$data['wish'] = $module_info['wish'];
		} else {
			$data['wish'] = 1;
		}
		
		if (isset($this->request->post['comp'])) {
			$data['comp'] = $this->request->post['comp'];
		} elseif (!empty($module_info)) {
			$data['comp'] = $module_info['comp'];
		} else {
			$data['comp'] = 1;
		}
		
		if (isset($this->request->post['quickview'])) {
			$data['quickview'] = $this->request->post['quickview'];
		} elseif (!empty($module_info)) {
			$data['quickview'] = $module_info['quickview'];
		} else {
			$data['quickview'] = 1;
		}
		
		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($module_info)) {
			$data['width'] = $module_info['width'];
		} else {
			$data['width'] = 200;
		}

		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($module_info)) {
			$data['height'] = $module_info['height'];
		} else {
			$data['height'] = 200;
		}

		if (isset($this->request->post['navigation'])) {
			$data['navigation'] = $this->request->post['navigation'];
		} elseif (!empty($module_info)) {
			$data['navigation'] = $module_info['navigation'];
		} else {
			$data['navigation'] = 1;
		}
		
		if (isset($this->request->post['autoplay'])) {
			$data['autoplay'] = $this->request->post['autoplay'];
		} elseif (!empty($module_info)) {
			$data['autoplay'] = $module_info['autoplay'];
		} else {
			$data['autoplay'] = 4000;
		}

		if (isset($this->request->post['autoplay_on'])) {
			$data['autoplay_on'] = $this->request->post['autoplay_on'];
		} elseif (!empty($module_info)) {
			$data['autoplay_on'] = $module_info['autoplay_on'];
		} else {
			$data['autoplay_on'] = 1;
		}
		
		if (isset($this->request->post['items'])) {
			$data['items'] = $this->request->post['items'];
		} elseif (!empty($module_info)) {
			$data['items'] = $module_info['items'];
		} else {
			$data['items'] = 5;
		}

		if (isset($this->request->post['rew_speed'])) {
			$data['rew_speed'] = $this->request->post['rew_speed'];
		} elseif (!empty($module_info)) {
			$data['rew_speed'] = $module_info['rew_speed'];
		} else {
			$data['rew_speed'] = 1000;
		}
		
		if (isset($this->request->post['stophover'])) {
			$data['stophover'] = $this->request->post['stophover'];
		} elseif (!empty($module_info)) {
			$data['stophover'] = $module_info['stophover'];
		} else {
			$data['stophover'] = 1;
		}
		
		if (isset($this->request->post['carusel'])) {
			$data['carusel'] = $this->request->post['carusel'];
		} elseif (!empty($module_info)) {
			$data['carusel'] = $module_info['carusel'];
		} else {
			$data['carusel'] = 1;
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

		$this->response->setOutput($this->load->view('extension/module/aridius_special', $data));
	}

	protected function validate() {
		
		if (!$this->user->hasPermission('modify', 'extension/module/aridius_special')) {
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