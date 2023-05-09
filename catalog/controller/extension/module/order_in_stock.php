<?php
class ControllerExtensionModuleOrderInStock extends Controller {

    public function index() {
    
        $this->load->language('extension/module/order_in_stock');
		
        $this->document->setTitle($this->language->get('heading_title'));
		
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );
		
        $url = '';
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/order_in_stock', $url)
        );

		

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');
		
		$this->response->setOutput($this->load->view('extension/module/order_in_stock', $data));
		
    }

    public function check() {
    
        $this->load->language('extension/module/order_in_stock');
		
        $json = array();
		
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
		
			$language_id = $this->config->get('config_language_id');
		
			if ((utf8_strlen($this->request->post['track_order_number']) < 1) || (utf8_strlen($this->request->post['track_order_number']) > 32) || !is_numeric($this->request->post['track_order_number'])) {
				$json['error']['number'] = $this->language->get('error_number');
			}

			if ((utf8_strlen($this->request->post['track_email']) < 3) || (utf8_strlen($this->request->post['track_email']) > 96) || (!preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['track_email']))) {
				$json['error']['email'] = $this->language->get('error_email');
			}


            if (!isset($json['error'])) {
				
                $this->load->model('extension/module/orderinstock');
                $name = $this->model_extension_module_orderinstock->CheckOrder($this->request->post, $language_id);

				if(isset($name)) {
					$json['success'] = sprintf($this->language->get('text_success'), $name);
				} else {
					$json['error']['check'] = $this->language->get('error_check');
				}
                
            }
        }
		
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
