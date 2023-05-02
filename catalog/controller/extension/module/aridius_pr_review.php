<?php
class ControllerExtensionModuleAridiusPrReview extends Controller {
	
		public function loadMore() {

		if (isset($this->request->post['setting'])) {
		$setting = unserialize(base64_decode($this->request->post['setting']));
		}
		
		$results_product = $this->index($setting);

		$this->response->setOutput($results_product);
		
	}		
	
	public function index($setting) {
		
		static $module_id = 0;
		
		$this->load->language('extension/module/aridius_pr_review');

		$this->load->model('catalog/product');
        $this->load->model('catalog/aridiusprreview');
		$this->load->model('tool/image');

		$data['products'] = array();

		$data['language_id'] = $this->config->get('config_language_id');
		
		
		$data['deluxe_limit_symbolst'] = $this->config->get('theme_deluxe_limit_symbolst');
		$data['aridiusinstock_status'] = $this->config->get('module_aridiusinstock_status');
		$data['aridius_qckview_status'] = $this->config->get('module_aridius_qckview_status');
        $data['deluxe_lazy'] = $this->config->get('theme_deluxe_lazy');
		
	    $data['limit'] = $setting['limit'];
		$data['rat'] = $setting['rat'];
 		$data['width'] = $setting['width'];
		$data['height'] = $setting['height'];
 	
	   $page = 1;

		if(isset($this->request->post['page'])) {
			$page = $this->request->post['page'];
		} else {
			$page = 1;
		}		
		
		$data['product_total'] = $this->model_catalog_aridiusprreview->getTotalReviews();

        $data['last_page'] = ceil($data['product_total'] / (int)$setting['limit']);

            $results = array();
			
			$get_results = $this->model_catalog_aridiusprreview->getLastReviews((int)$setting['limit'] * $data['product_total']);

			$product_pages = array_chunk($get_results, (int)$setting['limit']);

			        if (!empty($product_pages[$page - 1])) {
					    foreach ($product_pages[$page - 1] as $product_id) {
	                     $results[] = $product_id;
					    }  
			        }

		if ($results) {
			foreach ($results as $result) {

				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
				}

				if ($this->config->get('config_review_status')) {
					$rating = $result['rating'];
				} else {
					$rating = false;
				}
	
				$data['products'][] = array(
				
				'product_id'  => $result['product_id'],
				'name'    => $result['name'],
   				'rating'  => $result['rating'],
				'text'    => utf8_substr(strip_tags(html_entity_decode($result['text'], ENT_QUOTES, 'UTF-8')), 0, 315) . '..',
        	    'stars'   => $rating,
				'author'     => $result['author'],
			    'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'thumb'   => $image, 
				'href'    => $this->url->link('product/product', 'product_id=' . $result['product_id'])
			);
			}
			
		if(isset($this->request->post['module_id'])) {
			$data['module_id'] = $this->request->post['module_id'];
		} else {
			$data['module_id'] = $module_id++;
		}
		
		$setting['name'] = '';
	    $data['setting'] = base64_encode(serialize($setting));	
	
		  return $this->load->view('extension/module/aridius_pr_review', $data);
		}
	}
}