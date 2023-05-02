<?php
class ControllerCommonAridiusletters extends Controller {
	
	private $error = array();

	public function index() {
		
		$this->language->load('extension/module/aridius_letters');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->getList();
	}

	public function delete() {
		
		$this->language->load('module/aridius_letters');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('common/aridiusletters');

	    if (isset($this->request->post['selected']) ) {
		
		foreach ($this->request->post['selected'] as $email_id) {
				$this->model_common_aridiusletters->deleteAridiusnewsletters($email_id);
	    }

		$this->session->data['success'] = $this->language->get('text_success');

		$url = '';

		if (isset($this->request->get['filter_email_id'])) {
			$url .= '&filter_email_id=' . $this->request->get['filter_email_id'];
		}

		if (isset($this->request->get['filter_email_user'])) {
			$url .= '&filter_email_user=' . $this->request->get['filter_email_user'];
		}

		if (isset($this->request->get['filter_email_date'])) {
			$url .= '&filter_email_date=' . $this->request->get['filter_email_date'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
	
		$this->response->redirect($this->url->link('common/aridius_letters', 'user_token=' . $this->session->data['user_token'] . $url, true));
		
		}

		$this->getList();
	}

	protected function getList() {

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

	    if (isset($this->request->get['filter_email_id'])) {
		    $url .= '&filter_email_id=' . $this->request->get['filter_email_id'];
		}

		if (isset($this->request->get['filter_email_user'])) {
		    $url .= '&filter_email_user=' . $this->request->get['filter_email_user'];
		}
		
	    if (isset($this->request->get['filter_email_date'])) {
		    $url .= '&filter_email_date=' . $this->request->get['filter_email_date'];
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
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('extension/module/aridius_letters', 'user_token=' . $this->session->data['user_token'], true)
		);


		$data['user_token'] = $this->session->data['user_token'];
		$data['cancel'] = $this->url->link('extension/module/aridius_letters', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['aridius_letters2'] = $this->url->link('common/aridius_letters_send', 'user_token=' . $this->session->data['user_token'], true);
		 
		if (isset($this->request->post['selected']) ) {
		foreach ($this->request->post['selected'] as $newsletter_id) {
		$this->model_catalog_newsletter->deleteAridiusnewsletters($newsletter_id);
		}
		$url = '';
		$data['delete'] = $this->response->redirect($this->url->link('common/aridius_letters', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

		$data['delete'] = $this->url->link('common/aridius_letters/delete', 'user_token=' . $this->session->data['user_token'], true);
			
		if (isset($this->request->post['selected']) ) {
		foreach ($this->request->post['selected'] as $newsletter_id) {
		$this->model_catalog_newsletter->deleteAridiusnewsletters($newsletter_id);
		}
		$url = '';
		$data['delete'] = $this->response->redirect($this->url->link('common/aridius_letters', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        if (isset($this->request->get['filter_email_id'])) {
				$filter_email_id = $this->request->get['filter_email_id'];
			} else {
				$filter_email_id = null;
	    }

	    if (isset($this->request->get['filter_email_user'])) {
				$filter_email_user = $this->request->get['filter_email_user'];
			} else {
				$filter_email_user = null;
	    }

	    if (isset($this->request->get['filter_email_date'])) {
				$filter_email_date = $this->request->get['filter_email_date'];
			} else {
				$filter_email_date = null;
		 }

		$data_filter = array(
			    'filter_email_id' => $filter_email_id,
			    'filter_email_user' => $filter_email_user,
				'filter_email_date' => $filter_email_date,
				'start' => ($page - 1) * $this->config->get('config_limit_admin'),
				'limit' => $this->config->get('config_limit_admin')
		);



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
		if (isset($this->request->get['filter_email_id'])) {
			$url .= '&filter_email_id=' . $this->request->get['filter_email_id'];
		}

		if (isset($this->request->get['filter_email_user'])) {
			$url .= '&filter_email_user=' . $this->request->get['filter_email_user'];
		}
		
		if (isset($this->request->get['filter_email_date'])) {
			$url .= '&filter_email_date=' . $this->request->get['filter_email_date'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$url = '';

		if (isset($this->request->get['filter_email_id'])) {
			$url .= '&filter_email_id=' . $this->request->get['filter_email_id'];
		}

		if (isset($this->request->get['filter_email_user'])) {
			$url .= '&filter_email_user=' . $this->request->get['filter_email_user'];
		}
		
		if (isset($this->request->get['filter_email_date'])) {
			$url .= '&filter_email_date=' . $this->request->get['filter_email_date'];
		}
		
		$this->load->model('common/aridiusletters');
		$order_total = $this->model_common_aridiusletters->getTotalMails($data_filter);
		$results = $this->model_common_aridiusletters->getMails($data_filter);
		
		$data['letters'] = array();
		
		foreach($results as $result)
		{
			$data['letters'][] = array(
			'email_id' => $result['email_id'],
			'email_user' => $result['email_user'],
			'email_date' => $result['email_date']
			);
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('common/aridius_letters', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

		$data['filter_email_id'] = $filter_email_id;
		$data['filter_email_user'] = $filter_email_user;
		$data['filter_email_date'] = $filter_email_date;
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('common/aridius_letters', $data));
	}
}	