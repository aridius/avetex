<?php
class ControllerExtensionModuleAridiusLiveSearch extends Controller {
	
    public function index($setting) {

        $this->load->language('extension/module/aridius_livesearch');

	    $data['aridius_livesearch_symbol'] = $this->config->get('module_aridius_livesearch_symbol');
		$data['aridius_livesearch_img'] = $this->config->get('module_aridius_livesearch_img');

		return $this->load->view('extension/module/aridius_livesearch', $data);
    }

	public function livesearch() {
		
		$json = array();

		if (isset($this->request->get['search'])) {
			$this->load->model('catalog/product');
            $this->load->model('tool/image');
			if (isset($this->request->get['search'])) {
				$filter_name = $this->request->get['search'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['search'])) {
				$filter_tag = $this->request->get['search'];
			} else {
				$filter_tag = '';
			}
			
			if (isset($this->request->get['search'])) {
				$filter_model = $this->request->get['search'];
			} else {
				$filter_model = '';
			}
			
			if (isset($this->request->get['search'])) {
				$filter_sku = $this->request->get['search'];
			} else {
				$filter_sku = '';
			}
			
			if (isset($this->request->get['search'])) {
				$filter_description = $this->request->get['search'];
			} else {
				$filter_description = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 5;	
			}			

			$data = array(
				'filter_name'         => $filter_name,
				'filter_tag'          => ($this->config->get('module_aridius_livesearch_tag')) ? false : $filter_tag,
				'filter_model'        => ($this->config->get('module_aridius_livesearch_livesearch_model')) ? false : $filter_model,
				'filter_sku'          => ($this->config->get('module_aridius_livesearch_sku')) ? false : $filter_sku,
				'filter_description'  => ($this->config->get('module_aridius_livesearch_description')) ? false : $filter_description,
				'start'               => 0,
				'limit'               => $this->config->get('module_aridius_livesearch_limit')
			);

			$results = $this->model_catalog_product->liveSearch($data);

			foreach ($results as $result) {
				
			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
			  $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
		    } else {
			  $price = '';
			}

			if ((float)$result['special']) {
			  $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
			} else {
			  $special = '';
			}

			if ($result['image']) {
			  $image = $this->model_tool_image->resize($result['image'], $this->config->get('module_aridius_livesearch_width'), $this->config->get('module_aridius_livesearch_height'));
			} else {
			  $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('module_aridius_livesearch_width'), $this->config->get('module_aridius_livesearch_height'));
			}

			$json[] = array(
					'product_id' => $result['product_id'],
				    'price'      => $price,
					'special'    => $special,
		            'image'      => ($this->config->get('module_aridius_livesearch_img')) ? false : $image,
                    'href'       => $this->url->link('product/product', '&product_id=' . $result['product_id']),
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$this->response->setOutput(json_encode($json));
	}
}
