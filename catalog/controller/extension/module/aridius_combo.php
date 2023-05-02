<?php
class ControllerExtensionModuleAridiusCombo extends Controller {
	public function index($setting) {
		static $module = 0;

		//$this->load->model('catalog/product');
		//$this->load->model('tool/image');

		$this->load->language('extension/module/aridius_combo');


        $data['deluxe_options_prise'] = $this->config->get('deluxe_options_prise');
		$data['deluxe_limit_symbolst'] = $this->config->get('deluxe_limit_symbolst');

		/*
						$result = $this->model_catalog_product->getProduct($this->request->get['product_id']);

						if ($result['image']) {
							$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_related_width'), $this->config->get($this->config->get('config_theme') . '_image_related_height'));
							//$image = $this->model_tool_image->resize($result['image'], 228, 228);
						} else {
							$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_related_width'), $this->config->get($this->config->get('config_theme') . '_image_related_height'));
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
							$rating = (int)$result['rating'];
						} else {
							$rating = false;
						}

						$tg_options_data = array();

						foreach ($this->cartcombo->getProductOptions($this->request->get['product_id']) as $option) {
							$product_option_value_data = array();

							foreach ($option['product_option_value'] as $option_value) {
								if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
									if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
										$oprice = $this->currency->format($this->tax->calculate($option_value['price'], $result['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
									} else {
										$oprice = false;
									}

									$product_option_value_data[] = array(
										'product_option_value_id' => $option_value['product_option_value_id'],
										'option_value_id'         => $option_value['option_value_id'],
										'name'                    => $option_value['name'],
										'image'                   => $option_value['image'] ? $this->image->resize($option_value['image'], 50, 50) : '',
										'price'                   => $oprice,
										'price_prefix'            => $option_value['price_prefix']
									);
								}
							}

							$tg_options_data[] = array(
								'product_option_id'    => $option['product_option_id'],
								'product_option_value' => $product_option_value_data,
								'option_id'            => $option['option_id'],
								'name'                 => $option['name'],
								'type'                 => $option['type'],
								'value'                => $option['value'],
								'required'             => $option['required']
							);
						}


						$data['product'] = array(
							'product_id'  => $result['product_id'],
							'thumb'       => $image,
							'name'        => $result['name'],
							'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
							'price'       => $price,
							'special'     => $special,
							'tax'         => $tax,
							'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
							'rating'      => $rating,
							'options'      => $tg_options_data,
							'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
						);
*/


		$data['combo_sets'] = $this->cartcombo->doaridiuscombos($this->request->get['product_id']);

		$data['module'] = $module++;

		return $this->load->view('extension/module/aridius_combo', $data);
	}

}