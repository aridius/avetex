<?php
class ControllerProductAridiusReview extends Controller {
	
			public function write() {
				$this->load->language('product/product');

				$json = array();

				if ($this->request->server['REQUEST_METHOD'] == 'POST') {
					if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
						$json['error'] = $this->language->get('error_name');
					}

					if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
						$json['error'] = $this->language->get('error_text');
					}

					if (empty($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {
						$json['error'] = $this->language->get('error_rating');
					}

					// Captcha
					if ($this->config->get('config_captcha') . '_status') {
						$captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');

						if ($captcha) {
							$json['error'] = $captcha;
						}
					}

					if (!isset($json['error'])) {
						$this->load->model('catalog/review');

						$this->model_catalog_review->addReview($this->request->get['product_id'], $this->request->post);

						$json['success'] = $this->language->get('text_success');
					}
				}

				$this->response->addHeader('Content-Type: application/json');
				$this->response->setOutput(json_encode($json));
			}	
	  

			public function reply_qa(){
				
				$json=array();
				
				$this->load->language('module/aridius_store_review');
				$this->load->language('extension/module/deluxe');
				
				$data['entry_name'] = $this->language->get('entry_name');

			   
				$data['parent']=(int)$this->request->post['parent'];
				
				// Captcha
				if ($this->config->get('config_captcha') . '_status') {
					$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'));
				} else {
					$data['captcha'] = '';
				}

				$json['html'] = $this->load->view('extension/module/aridius_questions_answers_form', $data);
			  
				
				$this->response->addHeader('Content-Type: application/json');
				$this->response->setOutput(json_encode($json));
			}
				
}