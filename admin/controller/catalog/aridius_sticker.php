<?php
class ControllerCatalogAridiusSticker extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/aridius_sticker');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/aridiussticker');

		$this->getList();
	}
	
	public function add() {
		$this->load->language('catalog/aridius_sticker');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/aridiussticker');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_aridiussticker->addSticker($this->request->post);

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

			$this->response->redirect($this->url->link('catalog/aridius_sticker', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}
	
	public function edit() {
		$this->load->language('catalog/aridius_sticker');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/aridiussticker');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_aridiussticker->editSticker($this->request->get['sticker_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('catalog/aridius_sticker', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	
	public function delete() {
		$this->load->language('catalog/aridius_sticker');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/aridiussticker');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $sticker_id) {
				$this->model_catalog_aridiussticker->deleteSticker($sticker_id);
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

			$this->response->redirect($this->url->link('catalog/aridius_sticker', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

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
			'href' => $this->url->link('catalog/aridius_sticker', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/aridius_sticker/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/aridius_sticker/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['stickers'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$sticker_total = $this->model_catalog_aridiussticker->getTotalStickers();

		$results = $this->model_catalog_aridiussticker->getStickerValue($filter_data);

		foreach ($results as $result) {
			$data['stickers'][] = array(
				'sticker_id' => $result['sticker_id'],
				'name'       => $result['name'],
				'color'       => $result['color'],
				'background'       => $result['background'],
                'sort_order'       => $result['sort_order'],
				'edit'       => $this->url->link('catalog/aridius_sticker/edit', 'user_token=' . $this->session->data['user_token'] . '&sticker_id=' . $result['sticker_id'] . $url, true)
			);
		}


		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');
		$data['column_color'] = $this->language->get('column_color');
		$data['column_background'] = $this->language->get('column_background');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

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

		$data['sort_name'] = $this->url->link('catalog/aridius_sticker', 'user_token=' . $this->session->data['user_token'] . '&sort=od.name' . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/aridius_sticker', 'user_token=' . $this->session->data['user_token'] . '&sort=o.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $sticker_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/aridius_sticker', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($sticker_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($sticker_total - $this->config->get('config_limit_admin'))) ? $sticker_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $sticker_total, ceil($sticker_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/aridius_sticker_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['sticker_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_color'] = $this->language->get('entry_color');
		$data['entry_background'] = $this->language->get('entry_background');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_sticker_value_add'] = $this->language->get('button_sticker_value_add');
		$data['button_remove'] = $this->language->get('button_remove');

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
		
		if (isset($this->error['color'])) {
			$data['error_color'] = $this->error['color'];
		} else {
			$data['error_color'] = array();
		}
		
		if (isset($this->error['background'])) {
			$data['error_background'] = $this->error['background'];
		} else {
			$data['error_background'] = array();
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
			'href' => $this->url->link('catalog/aridius_sticker', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		if (!isset($this->request->get['sticker_id'])) {
			$data['action'] = $this->url->link('catalog/aridius_sticker/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/aridius_sticker/edit', 'user_token=' . $this->session->data['user_token'] . '&sticker_id=' . $this->request->get['sticker_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/aridius_sticker', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['sticker_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$sticker_info = $this->model_catalog_aridiussticker->getSticker($this->request->get['sticker_id']);
		}

		$data['user_token'] = $this->session->data['user_token'];


		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['aridius_sticker_description'])) {
			$data['aridius_sticker_description'] = $this->request->post['aridius_sticker_description'];
		} elseif (isset($this->request->get['sticker_id'])) {
			$data['aridius_sticker_description'] = $this->model_catalog_aridiussticker->getStickerDescriptions($this->request->get['sticker_id']);
		} else {
			$data['aridius_sticker_description'] = array();
		}
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($sticker_info)) {
			$data['sort_order'] = $sticker_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if (isset($this->request->post['color'])) {
			$data['color'] = $this->request->post['color'];
		} elseif (!empty($sticker_info)) {
			$data['color'] = $sticker_info['color'];
		} else {
			$data['color'] = '';
		}
		
		if (isset($this->request->post['background'])) {
			$data['background'] = $this->request->post['background'];
		} elseif (!empty($sticker_info)) {
			$data['background'] = $sticker_info['background'];
		} else {
			$data['background'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/aridius_sticker_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/aridius_sticker')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['aridius_sticker_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 64)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}

		if ((utf8_strlen($this->request->post['color']) < 4) || (utf8_strlen($this->request->post['color']) > 7)) {
			$this->error['color'] = $this->language->get('error_color');
		}
		
		if ((utf8_strlen($this->request->post['background']) < 4) || (utf8_strlen($this->request->post['background']) > 7)) {
			$this->error['background'] = $this->language->get('error_background');
		}
		
		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/aridius_sticker')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}

}