<?php
class ControllerToolInstalltheme extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('tool/installtheme');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('tool/installtheme');

		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('tool/installtheme', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['restore'] = $this->url->link('tool/installtheme/backup', 'user_token=' . $this->session->data['user_token'], true);
		$data['install'] = $this->url->link('tool/installtheme/install', 'user_token=' . $this->session->data['user_token'], true);
		$data['modification'] = $this->url->link('extension/modification', 'user_token=' . $this->session->data['user_token'], true);
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('tool/installtheme', $data));
	}
	public function backup() {
		$this->load->language('tool/installtheme');
		$this->load->model('tool/installtheme');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->user->hasPermission('modify', 'tool/installtheme')) {
			$opts = array(
			'http'=>array(
			'method'=>"GET",
			'header'=>"Accept-language: en\r\n" .
             "Cookie: foo=bar\r\n"
			)
			);
		$context = stream_context_create($opts);
		$file = file_get_contents(DIR_SYSTEM .'sql/restore.sql', false, $context);	
			if ($file) {
				$this->model_tool_installtheme->restore($file);
				$this->session->data['success'] = $this->language->get('text_success');
				$this->response->redirect($this->url->link('tool/installtheme', 'user_token=' . $this->session->data['user_token'], true));
				} else {
				$this->session->data['error'] = $this->language->get('error_empty');
				$this->response->redirect($this->url->link('tool/installtheme', 'user_token=' . $this->session->data['user_token'], true));
			}
		}
	}
	public function install() {
		$this->load->language('tool/installtheme');
		$this->load->model('tool/installtheme');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->user->hasPermission('modify', 'tool/installtheme')) {
			$opts = array(
			'http'=>array(
			'method'=>"GET",
			'header'=>"Accept-language: en\r\n" .
             "Cookie: foo=bar\r\n"
			)
			);
			
		$context = stream_context_create($opts);
		$file = file_get_contents(DIR_SYSTEM .'sql/install.sql', false, $context);	
			if ($file) {
				$this->model_tool_installtheme->restore($file);
				$this->session->data['success'] = $this->language->get('text_success');
				$this->response->redirect($this->url->link('tool/installtheme', 'user_token=' . $this->session->data['user_token'], true));
			} else {
				$this->session->data['error'] = $this->language->get('error_empty');
				$this->response->redirect($this->url->link('tool/installtheme', 'user_token=' . $this->session->data['user_token'], true));
			}
		}
	}	

}
