<?php
class ControllerExtensionModuleAridiusSpecial extends Controller {
	
	public function loadMore() {

		if (isset($this->request->post['setting'])) {
		$setting = unserialize(base64_decode($this->request->post['setting']));
		}
		
		$results_product = $this->index($setting);

		$this->response->setOutput($results_product);
		
	}	
	
	public function index($setting) {
		
		static $module_id = 0;
		
		$this->load->language('extension/module/aridius_special');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['products'] = array();
		
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
		
		$data['qt'] = $setting['qt'];
		$data['rat'] = $setting['rat'];
		$data['wish'] = $setting['wish'];
		$data['comp'] = $setting['comp'];
		$data['quickview'] = $setting['quickview'];
		$data['name'] = $setting['name'];
		$data['navigation'] = $setting['navigation'];
		$data['autoplay'] = $setting['autoplay'];
		$data['autoplay_on'] = $setting['autoplay_on'];
		$data['items'] = $setting['items'];
		$data['rew_speed'] = $setting['rew_speed'];
		$data['stophover'] = $setting['stophover'];
		$data['carusel'] = $setting['carusel'];
		$data['limit']  = $setting['limit'];
		$data['width'] = $setting['width'];
		$data['height'] = $setting['height'];

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		
		$this->load->model('catalog/aridiusproducts');	
		
		$data['product_total'] = $this->model_catalog_aridiusproducts->getTotalProductSpecialsCounter();	
		$data['last_page'] = ceil($data['product_total'] / (int)$setting['limit']);
		
		$page = 1;

		if(isset($this->request->post['page'])) {
			$page = $this->request->post['page'];
		} else {
			$page = 1;
		}
        $data['products'] = array();
		$results = array();
		
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

		if ($results) {
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					$special_info = $this->model_catalog_product->getSpecialDates($result['product_id']);
					
					
                $special_difference = $this->currency->format($this->tax->calculate(($result['price'] - $result['special']), $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);					

					if ($special_info) {
					$special_date_end = $special_info['date_end'];
					$special_date_start = $special_info['date_start'];
				
					} else {
					$special_date_end = false;
					$special_date_start = false;
					$special_difference = false;
					}
				    } else {
					$special = false;
	                $special_date_end = false;
					$special_date_start = false;
	                $special_difference = false;
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
	
				$max_q = $setting['qtmax'];
				$all_q2 = ($result['quantity'] / $max_q) * 100;

				$success = 0;
				$info = 0;
				$warning = 0;

				if ($all_q2 <= 33.33) {
				$success = $all_q2;
				$info = 0;
				$warning = 0;
				}

				if ($all_q2 > 33.3 && $all_q2 <= 66.6 ) {
				$success = 33.3;
				$info = $all_q2 - 33.3;
				$warning = 0;
				}

				if ($all_q2 > 66.6) {
				$success = 33.3;
				$info = 33.3;
				$warning = $all_q2 - 66.6;

				if ($all_q2 > 100) {
				$warning = 33.3;
				}
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
				    'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
			        'stickers2' => $this->model_catalog_product->getProductStickerProductId($result['product_id']),
					'price'       => $price,
					'special'     => $special,
					'special_difference'     => $special_difference,
					'special_date_end'     => $special_date_end,
					'special_date_start'     => $special_date_start,
					'tax'         => $tax,
					'rating'      => $rating,
					'success'       => $success,
				    'info'       => $info,
				    'warning'       => $warning,
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
			}
			
		if(isset($this->request->post['module_id'])) {
			$data['module_id'] = $this->request->post['module_id'];
		} else {
			$data['module_id'] = $module_id++;
		}
		
		$setting['name'] = '';
	    $data['setting'] = base64_encode(serialize($setting));			

		   return $this->load->view('extension/module/aridius_special', $data);
		}
	}
}