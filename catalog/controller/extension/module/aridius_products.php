<?php
class ControllerExtensionModuleAridiusProducts extends Controller {
	public function loadMore() {

		if (isset($this->request->post['setting'])) {
		$setting = unserialize(base64_decode($this->request->post['setting']));
		}
		
		$results_product = $this->index($setting);

		$this->response->setOutput($results_product);
		
	}
	public function index($setting) {
        static $module_id = 0;		

		$this->load->language('extension/module/aridius_products');
	
        $data['language_id'] = $this->config->get('config_language_id');
 
		if (isset($setting['name_pr'][$this->config->get('config_language_id')])) {
		$data['name_pr'] = $setting['name_pr'][$this->config->get('config_language_id')];
		} else {
		$data['name_pr'] = '';	
		}

		$this->load->model('catalog/aridiusproducts');	

        $data['language_id'] = $this->config->get('config_language_id');
		$data['deluxe_name_sticker_product_new'] = $this->config->get('theme_deluxe_name_sticker_product_new');
		$data['deluxe_name_sticker_product_top'] = $this->config->get('theme_deluxe_name_sticker_product_top');		
		$data['deluxe_sticker_sale_product_auto'] = $this->config->get('theme_deluxe_sticker_sale_product_auto');	
		$data['deluxe_sticker_new_product_auto'] = $this->config->get('theme_deluxe_sticker_new_product_auto');
		$data['deluxe_sticker_product_new_day'] = $this->config->get('theme_deluxe_sticker_product_new_day');
		$data['deluxe_sticker_product_top_rating'] = $this->config->get('theme_deluxe_sticker_product_top_rating');
		$data['deluxe_sticker_product_top_viewed'] = $this->config->get('theme_deluxe_sticker_product_top_viewed');
		$data['deluxe_sticker_product_top_ratinr'] = $this->config->get('theme_deluxe_sticker_product_top_ratinr');
		$data['deluxe_sticker_top_product_auto'] = $this->config->get('theme_deluxe_sticker_top_product_auto');
		$data['deluxe_limit_symbolst'] = $this->config->get('theme_deluxe_limit_symbolst');
		
		$data['aridiusinstock_status'] = $this->config->get('module_aridiusinstock_status');
		$data['aridius_qckview_status'] = $this->config->get('module_aridius_qckview_status');
        $data['deluxe_lazy'] = $this->config->get('theme_deluxe_lazy');
		$data['deluxe_forder'] = $this->config->get('theme_deluxe_forder');	

		$data['limit']			= (int)$setting['limit'];
        $data['carusel']        = $setting['carusel'];
		$data['rat']            = $setting['rat'];
		$data['wish']           = $setting['wish'];
		$data['comp']           = $setting['comp'];
		$data['quickview']      = $setting['quickview'];
		$data['name']           = $setting['name'];
		$data['colleft']        = $setting['colleft'];
		$data['list']           = $setting['list'];
		
		$data['width']          = $setting['width'];
		$data['height']         = $setting['height'];	


$data['variant']         =$setting['modules']	;	


		if ($setting['carusel'] != '0') {
		$data['navigation'] = $setting['navigation'];
		$data['autoplay'] = $setting['autoplay'];
		$data['autoplay_on'] = $setting['autoplay_on'];
		$data['items'] = $setting['items'];
		$data['rew_speed'] = $setting['rew_speed'];
		$data['stophover'] = $setting['stophover'];
		$data['carusel'] = $setting['carusel'];	
        }

		if(isset($this->request->post['module_id'])) {
			$data['module_id'] = $this->request->post['module_id'];
		} else {
			$data['module_id'] = $module_id++;
		}

		$setting['name_pr'] = '';
		$setting['name'] = '';
	    $data['setting'] = base64_encode(serialize($setting));

		

	    $this->load->model('catalog/product');
        $this->load->model('catalog/aridiusproducts');
		
		$this->load->model('tool/image');

		$page = 1;

		if(isset($this->request->post['page'])) {
			$page = $this->request->post['page'];
		} else {
			$page = 1;
		}
        $data['products'] = array();
		$results = array();
		
    if ($setting['modules'] == 'featured') {
		
        if (!empty($setting['product'])) {			
			$data['product_total'] = count($setting['product']);
				} else {
		$data['product_total'] = 0;
		}
		
			if (!empty($setting['product'])) {
				
				$product_pages = array_chunk($setting['product'], (int)$setting['limit']);

				if (!empty($product_pages[$page - 1])) {
					foreach ($product_pages[$page - 1] as $product_id) {
						$product_info = $this->model_catalog_aridiusproducts->getProduct($product_id);

						if ($product_info) {
							$results[] = $product_info;
						}
					}
				}
	         }
			 
    } elseif ($setting['modules'] == 'special') {
		
            $data['product_total'] = $this->model_catalog_aridiusproducts->getTotalProductSpecials();
			
			$filter_data = array(
			'sort'  => 'pd.name',
			'order' => 'ASC',
			'start' => ($page - 1) * (int)$setting['limit'],
			'limit' => (int)$setting['limit']
			);

			$results = $this->model_catalog_aridiusproducts->getProductSpecials($filter_data);

    } elseif ($setting['modules'] == 'latest') {
			$data['product_total'] =(int)$setting['limit']*3;	
			
			$filter_data = array(
			'sort'  => 'p.date_added',
			'order' => 'DESC',
			'start' =>	($page - 1) * (int)$setting['limit'],
			'limit' => (int)$setting['limit']
			);

			$results = $this->model_catalog_aridiusproducts->getProducts($filter_data);
	
    } elseif ($setting['modules'] == 'bestseller') {
            $data['product_total'] = $this->model_catalog_aridiusproducts->getTotalBestSeller();
			
            $product_total = $this->model_catalog_aridiusproducts->getTotalBestSeller();
	
			$get_results = $this->model_catalog_aridiusproducts->getBestSellerProducts((int)$setting['limit'] * $product_total);

			$product_pages = array_chunk($get_results, (int)$setting['limit']);

			        if (!empty($product_pages[$page - 1])) {
					    foreach ($product_pages[$page - 1] as $product_id) {
	                     $results[] = $product_id;
					    }  
			        }
    } elseif ($setting['modules'] == 'viewed') {

			$aridius_aridius_viewedpr = array();

			if (isset($this->request->cookie['aridius_aridius_viewed'])) {
				$aridius_aridius_viewedpr = explode(',', $this->request->cookie['aridius_aridius_viewed']);
			} else if (isset($this->session->data['aridius_aridius_viewed'])) {
				$aridius_aridius_viewedpr = $this->session->data['aridius_aridius_viewed'];
			}

			if (isset($this->request->get['route']) && $this->request->get['route'] == 'product/product') {
				$product_id = $this->request->get['product_id'];
				$aridius_aridius_viewedpr = array_diff($aridius_aridius_viewedpr, array($product_id));
				array_unshift($aridius_aridius_viewedpr, $product_id);
				setcookie('aridius_aridius_viewed', implode(',',$aridius_aridius_viewedpr), time() + 60 * 60 * 24 * 30, '/', $this->request->server['HTTP_HOST']);
			}
			
			$data['results'] = array();
			
			$get_results = array_slice($aridius_aridius_viewedpr, 0, (int)$setting['limit']*3);
            $data['product_total'] = count($aridius_aridius_viewedpr);
			$product_pages = array_chunk($get_results, (int)$setting['limit']);
	   
	                if (!empty($product_pages[$page - 1])) {   
						foreach ($product_pages[$page - 1] as $product_id) {
	                    $results[] = $product_id;
					   } 
                    } 
	} elseif ($setting['modules'] == 'mostviewed') {
	        $data['product_total'] = count($this->model_catalog_aridiusproducts->getMostViewed((int)$setting['limit'] * 3));
			$get_results = $this->model_catalog_aridiusproducts->getMostViewed((int)$setting['limit'] * 3);
			
			$product_pages = array_chunk($get_results, (int)$setting['limit']);

				    if (!empty($product_pages[$page - 1])) {
					     foreach ($product_pages[$page - 1] as $product_id) {
						 $results[] = $product_id;
					   }
				    }
    } elseif ($setting['modules'] == 'mostreviewed') {
		    $data['product_total'] = $this->model_catalog_aridiusproducts->getTotalResults();
            $product_total = $this->model_catalog_aridiusproducts->getTotalResults();
			
			$get_results = $this->model_catalog_aridiusproducts->getMostRatedProducts((int)$setting['limit'] * $product_total);

			$product_pages = array_chunk($get_results, (int)$setting['limit']);

			        if (!empty($product_pages[$page - 1])) {
					    foreach ($product_pages[$page - 1] as $product_id) {
	                     $results[] = $product_id;
					    }  
			        }
					
	}	
	
        $data['last_page'] = ceil($data['product_total'] / (int)$setting['limit']);

		if ($results) {
		
		foreach ($results as $result) {
			
			if ($setting['modules'] == 'viewed') {
				$product_vieweed = isset($this->request->get['product_id']) ? $this->request->get['product_id'] : 0; 
			
				//if ($result != $product_vieweed ) {
					$result = $this->model_catalog_aridiusproducts->getProduct($result);
				//} else {
					//$result = false;
				//} 	
			}
			
			if ($setting['modules'] == 'mostviewed') {
				$result = $this->model_catalog_aridiusproducts->getProduct($result['product_id']);
			}
			
        if ($result) {
		if ($result['image']) {
			$image = $this->model_tool_image->resize($result['image'], (int)$setting['width'], (int)$setting['height']);
		} else {
			$image = $this->model_tool_image->resize('placeholder.png', (int)$setting['width'], (int)$setting['height']);
		}

		if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
			$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
		} else {
			$price = false;
		}

		if ((float)$result['special']) {
			$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
		} else {
			$special = false;
		}

		if ($this->config->get('config_tax')) {
			$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
		} else {
			$tax = false;
		}

		if ($this->config->get('config_review_status')) {
			$rating = $result['rating'];
		} else {
			$rating = false;
		}	

			$data['products'][] = array(
			     	'reviews' => $result['reviews'],
					'dateadded'  => $result['date_added'],
					'viewed'     => $result['viewed'],
					'rating'     => $result['rating'],
					'quantity'   => $result['quantity'],
					'price_sticker'        => $result['price'],
					'special_sticker'      => (isset($result['special']) ? $result['special'] : false),	
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
			        'stickers2' => $this->model_catalog_product->getProductStickerProductId($result['product_id']),
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $rating,
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id']),
		    );
          }				
		}
        if ($data['products']) {		
		return $this->load->view('extension/module/aridius_products', $data);
        } 		
		} 
	}
}