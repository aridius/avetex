<?php

class ControllerExtensionModuleAridiusFastorder extends Controller {

    public function getForm() {
    
        $this->load->language('extension/module/aridius_fastorder');

        $data['heading_title_fastorder'] = $this->language->get('heading_title_fastorder');
        $data['enter_firstname'] = $this->language->get('enter_firstname');
        $data['enter_phone'] = $this->language->get('enter_phone');
        $data['enter_email'] = $this->language->get('enter_email');
        $data['enter_comment'] = $this->language->get('enter_comment');
        $data['enter_load'] = $this->language->get('enter_load');
        $data['button_send'] = $this->language->get('button_send');
        $data['text_maximum'] = $this->language->get('text_maximum');

        $this->load->model('catalog/product');

        $this->load->model('setting/setting');
        $settings = array();

        $settings = $this->model_setting_setting->getSetting('module_aridiusfastorder');
        $data['language_id'] = $this->config->get('config_language_id');

        $data['aridiusfastorder_descriptionshow'] = $settings['module_aridiusfastorder_descriptionshow'];
        $data['aridiusfastorder_adddescriptionshow'] = $settings['module_aridiusfastorder_adddescriptionshow'];
        $data['aridiusfastorder_img'] = $settings['module_aridiusfastorder_img'];

        $data['aridiusfastorder_placeholdertell'] = $settings['module_aridiusfastorder_placeholdertell'];
        $data['aridiusfastorder_placeholderfirstname'] = $settings['module_aridiusfastorder_placeholderfirstname'];
        $data['aridiusfastorder_placeholderemail'] = $settings['module_aridiusfastorder_placeholderemail'];
        $data['aridiusfastorder_placeholdercomment'] = $settings['module_aridiusfastorder_placeholdercomment'];
        $data['aridiusfastorder_mask'] = $settings['module_aridiusfastorder_mask'];
        $data['aridiusfastorder_emailvalid'] = $settings['module_aridiusfastorder_emailvalid'];
        $data['aridiusfastorder_firstnamevalid'] = $settings['module_aridiusfastorder_firstnamevalid'];
        $data['aridiusfastorder_firstnameshow'] = $settings['module_aridiusfastorder_firstnameshow'];
        $data['aridiusfastorder_emailshow'] = $settings['module_aridiusfastorder_emailshow'];
        $data['aridiusfastorder_commentshow'] = $settings['module_aridiusfastorder_commentshow'];
        $data['aridiusfastorder_description'] = html_entity_decode($settings['module_aridiusfastorder_description'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		$data['theme_deluxe_options_mainimg'] = $this->config->get('theme_deluxe_options_mainimg');
		$data['theme_deluxe_options_prise'] = $this->config->get('theme_deluxe_options_prise');
        $data['autocalc_select_first'] = $this->config->get('config_autocalc_select_first');

        $aridiusfastorder_imgw = $settings['module_aridiusfastorder_imgw'];
        $aridiusfastorder_imgh = $settings['module_aridiusfastorder_imgh'];
        $aridiusfastorder_descchar = $settings['module_aridiusfastorder_descchar'];
        $aridiusfastorder_imgoptw  = $this->config->get('theme_deluxe_product_optionimg_width');
        $aridiusfastorder_imgopth  = $this->config->get('theme_deluxe_product_optionimg_height');
		
		$data['config_stock'] = $this->config->get('config_stock_checkout');

        $product_id = json_decode(file_get_contents("php://input"), true); 

        if ($product_id) {

            $this->load->model('setting/setting');

            $product_info = $this->model_catalog_product->getProduct($product_id);
            
			$data['text_minimum'] = sprintf($this->language->get('text_minimum'), $product_info['minimum']);
            
		    $data['minimum'] = $product_info['minimum'];
			
			$data['quantity'] = $product_info['quantity'];

            $data['product_id'] = $product_info['product_id'];

            $data['product_name'] = $product_info['name'];

            $this->load->model('tool/image');

            if ($product_info['image']) {
                $data['popup'] = $this->model_tool_image->resize($product_info['image'], $aridiusfastorder_imgw, $aridiusfastorder_imgh);
            } else {
                $data['popup'] = '';
            }
			
			$this->load->model('catalog/product');	
		
		    $discounts = $this->model_catalog_product->getProductDiscounts($product_id);
		
            $data['dicounts_unf'] = $discounts;

            $data['options'] = array();

            foreach ($this->model_catalog_product->getProductOptions($product_id) as $option) {
                $product_option_value_data = array();

                foreach ($option['product_option_value'] as $option_value) {
                    if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
                        if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
                            $price = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
                        $options_price_n = ($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false));
					   } else {
                            $price = false;
							 $options_price_n = false;
                        }

                        $product_option_value_data[] = array(
                            'product_option_value_id' => $option_value['product_option_value_id'],
                            'option_value_id' => $option_value['option_value_id'],
                            'name' => $option_value['name'],
							'image' => $option_value['image'] ? $this->model_tool_image->resize($option_value['image'], $aridiusfastorder_imgoptw, $aridiusfastorder_imgopth) : '',
							'image_opt' => $option_value['image_opt'] ? $this->model_tool_image->resize($option_value['image_opt'], $aridiusfastorder_imgw, $aridiusfastorder_imgh) : '',
                            'opt_thumb' => $this->model_tool_image->resize($option_value['image'], $aridiusfastorder_imgw, $aridiusfastorder_imgh),
							'price' => $price,
							'price_n' => $options_price_n,
                            'price_prefix' => $option_value['price_prefix']
                        );
                    }
                }

                $data['options'][] = array(
                    'product_option_id' => $option['product_option_id'],
                    'product_option_value' => $product_option_value_data,
                    'option_id' => $option['option_id'],
                    'name' => $option['name'],
                    'type' => $option['type'],
                    'value' => $option['value'],
                    'required' => $option['required']
                );
            }

            $data['product_description'] = utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $aridiusfastorder_descchar) . '...';

            $currency_code = !empty($this->session->data['currency']) ? $this->session->data['currency'] : $this->config->get('config_currency');

   				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					 $data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $this->config->get('config_tax')), $this->session->data['currency']);
					 $data['price_calck'] = ($this->tax->calculate($product_info['price'], $this->config->get('config_tax')));
				} else {
					 $data['price'] = false;
					  $data['price_calck'] = false;
				}	
		
			
				if ((float)$product_info['special']) {
					$data['special'] = $this->currency->format($this->tax->calculate($product_info['special'], $this->config->get('config_tax')), $this->session->data['currency']);
					$data['special_calck'] = ($this->tax->calculate($product_info['special'], $this->config->get('config_tax')));
				} else {
					 $data['special'] = false;
					  $data['special_calck'] = false;
				}
             } else {
			 $data['product_id'] = false;
			 $data['options'] = false;
    }

        $json = ($this->load->view('extension/module/aridiusfastorder_form', $data));
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function write()   {
  
        $data = json_decode(file_get_contents("php://input"), true);

        $this->load->language('extension/module/aridius_fastorder');
        $this->load->model('catalog/product');
        $this->load->model('extension/module/aridiusfastorder');
        $this->load->model('setting/setting');

        $settings = array();

        $settings = $this->model_setting_setting->getSetting('module_aridiusfastorder');

        $json = array();
        $aridiusfastorder_firstname = $settings['module_aridiusfastorder_firstnameshow'];
        $aridiusfastorder_firstnamevalid = $settings['module_aridiusfastorder_firstnamevalid'];

        $aridiusfastorder_email = $settings['module_aridiusfastorder_emailshow'];
        $aridiusfastorder_email_valid = $settings['module_aridiusfastorder_emailvalid'];


        $aridiusfastorder_comment = $settings['module_aridiusfastorder_commentshow'];
        if ($aridiusfastorder_comment == 1) {
            $data['formFastOrderComment'] = ' ';
        }
        if ((utf8_strlen($data['formFastOrderTel']) < 3) || (utf8_strlen($data['formFastOrderTel']) > 32)) {
            $json['error']['formFastOrderTel'] = $this->language->get('error_tell');
        }
		
		//DA
        if ($aridiusfastorder_firstname != 1) {
    
		if ($aridiusfastorder_firstnamevalid != 1) {
		     if (((utf8_strlen($data['formFastOrderName'])) < 1) || (utf8_strlen($data['formFastOrderName']) > 32)) {
                $json['error']['formFastOrderName'] = $this->language->get('error_firstname');
             }
        }
        } else {
				 $data['formFastOrderName'] = '';

        }
		
	    if ($aridiusfastorder_email != 1) {
    
		if ($aridiusfastorder_email_valid != 1) {
			if (((utf8_strlen($data['formFastOrderEmail']) > 96) || (!preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $data['formFastOrderEmail'])))) {
					$json['error']['formFastOrderEmail'] = $this->language->get('error_email');
			}
        }
        } else {
				 $data['formFastOrderEmail'] = '';

        }

        if ($data['formFastOrderID']) {

            $product_options = $this->model_catalog_product->getProductOptions($data['formFastOrderID']);
            $product_info = $this->model_catalog_product->getProduct($data['formFastOrderID']);
            $option_id = preg_replace("/[^0-9]/", '', key($data['option']));
            foreach ($product_options as $product_option) {
                if ($product_option['required'] && empty($data['option']['option[' . $option_id . '][]'])) {
                    $json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
                }
            }
			/*
			    if (($product_info['quantity'] < 1) && (!$this->config->get('config_stock_checkout'))) {
                    $json['error']['formFastOrderQuantity'] = $this->language->get('error_quantity');
                }
            */
	   }   

        if (!isset($json['error'])) {

           $data['customer_group_id'] = $this->config->get('config_customer_group_id');
		   
			$data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
			$data['store_id'] = $this->config->get('config_store_id');
			$data['store_name'] = $this->config->get('config_name');

			if ($data['store_id']) {
				$data['store_url'] = $this->config->get('config_url');
			} else {
				if ($this->request->server['HTTPS']) {
					$data['store_url'] = HTTPS_SERVER;
				} else {
					$data['store_url'] = HTTP_SERVER;
				}
			}
			
			$data['ip'] = $this->request->server['REMOTE_ADDR'];
			
			if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
				$data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];	
			} elseif(!empty($this->request->server['HTTP_CLIENT_IP'])) {
				$data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];	
			} else {
				$data['forwarded_ip'] = '';
			}
			
			$data['user_agent'] = isset($this->request->server['HTTP_USER_AGENT']) ? $this->request->server['HTTP_USER_AGENT'] : '';	
			$data['accept_language'] = isset($this->request->server['HTTP_ACCEPT_LANGUAGE']) ? $this->request->server['HTTP_ACCEPT_LANGUAGE'] : '';	

// Totals
			$this->load->model('setting/extension');

			$totals = array();
			$taxes = $this->cart->getTaxes();
			$total = 0;
			
			// Because __call can not keep var references so we put them into an array. 			
			$total_data = array(
				'totals' => &$totals,
				'taxes'  => &$taxes,
				'total'  => &$total
			);

				$sort_order = array();

				$results = $this->model_setting_extension->getExtensions('total');

				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get('total_' . $value['code'] . '_sort_order');
				}

				array_multisort($sort_order, SORT_ASC, $results);

				foreach ($results as $result) {
					if ($this->config->get('total_' . $result['code'] . '_status')) {
						$this->load->model('extension/total/' . $result['code']);
						
						// We have to put the totals in an array so that they pass by reference.
						$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
					}
				}

				$sort_order = array();

				foreach ($totals as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}
				
                if(is_array($totals)) {
				array_multisort($sort_order, SORT_ASC, $totals);
		        }

            if ($data['formFastOrderID']) {

                if ($product_info['special']) {
                    $price = (float)$data['price2'];
                } else {
                    $price = (float)$data['price'];
                }
                $addToPrice=0;

                foreach($totals as $key=>$total){
                    if($total['code']!='tax'){
                        $totals[$key]['value']=$price+$addToPrice;
                    }elseif($total['code']=='tax'){
                        $addToPrice=$total['value'];
                    }

                }

                $data['totals'] = $totals;

   			/*
			    if (($product_info['quantity'] < 1) && (!$this->config->get('config_stock_checkout'))) {
                    $json['error']['formFastOrderQuantity'] = $this->language->get('error_quantity');
                }
            */

                $href = $this->url->link('product/product', '&product_id=' . $data['formFastOrderID']);

                $data['products'][] = $product_info;

                $options = array();

                if (isset($data['option'])) {
                    foreach ($data['option'] as $option) {
                        foreach ($product_options as $product_option) {
                            foreach ($product_option['product_option_value'] as $option_value) {
                                foreach ($option as $id_option) {
                                    if ($id_option == $option_value['product_option_value_id']) {
                                        $options[] = array(
                                            'product_option_id' => $product_option['product_option_id'],
                                            'name' => $option_value['name'], 'type' => $product_option['type'],
                                            'value' => $product_option['value'],
                                            'product_option_value_id' => $option_value['product_option_value_id'],
                                        );
                                    }
                                }
                            }
                        }
                    }
                    $data['products'][0] += array(
                        'option' => $options,
                    );
                }
				
                $data['products'][0] = array(
                        "total" => (float)$price,
                        "price" => (float)$price/$data['quantity'],
                        "quantity" => $data['quantity'],
                    ) + $data['products'][0];

                $data['price'] = (float)$price;
                $data['total'] = (float)$price+$addToPrice;
				$data['language_id'] = $this->config->get('config_language_id');
                $data['currency_id'] = $this->currency->getId($this->session->data['currency']);
                $data['currency_code'] = $this->session->data['currency'];
                $data['currency_value'] = $this->currency->getValue($this->session->data['currency']);

                $order_id = $this->model_extension_module_aridiusfastorder->addOrder($data);

                $this->model_extension_module_aridiusfastorder->addOrderHistory($order_id);	
	
            } else {

                $data['total'] = 0;

                foreach ($this->cart->getProducts() as $product) {

					$unit_price = $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'));
						$boc_unit_tax = $this->tax->getTax($unit_price, $product['tax_class_id']);

						$boc_unit_tax2 = $unit_price + $boc_unit_tax  ;
						
						
                    $data['total']+= ($boc_unit_tax2 * $product['quantity']);
			    /*
				$product_info = $this->model_catalog_product->getProduct($data['formFastOrderID']);
                 if (($product_info['quantity'] < 1) && (!$this->config->get('config_stock_checkout'))) {
                    $json['error']['formFastOrderQuantity'] = $this->language->get('error_quantity');
                }
				 */
				
                }

                foreach ($this->cart->getProducts() as $product) {
                    $option_data = array();

                    foreach ($product['option'] as $option) {
                        $option_data[] = array(
                            'product_option_id'       => $option['product_option_id'],
                            'product_option_value_id' => $option['product_option_value_id'],
                            'option_id'               => $option['option_id'],
                            'option_value_id'         => $option['option_value_id'],
                            'name'                    => $option['name'],
                            'value'                   => $option['value'],
                            'type'                    => $option['type']
                        );
                    }

                    $data['products'][] = array(
                        'product_id' => $product['product_id'],
                        'name'       => $product['name'],
                        'model'      => $product['model'],
                        'option'     => $option_data,
                        'download'   => $product['download'],
                        'quantity'   => $product['quantity'],
                        'subtract'   => $product['subtract'],
                        'price'      => $product['price'],
                        'total'      => $product['total'],
                        'tax'        => $this->tax->getTax($product['price'], $product['tax_class_id']),
                        'reward'     => $product['reward']
                    );
                }
                $totals = array();
                $taxes = $this->cart->getTaxes();
                $total = 0;

                $total_data = array(
                    'totals' => &$totals,
                    'taxes'  => &$taxes,
                    'total'  => &$total
                );

                $this->load->model('setting/extension');

                $sort_order = array();

                $results = $this->model_setting_extension->getExtensions('total');

                foreach ($results as $key => $value) {
                    $sort_order[$key] = $this->config->get('total_' . $value['code'] . '_sort_order');
                }

                array_multisort($sort_order, SORT_ASC, $results);

                foreach ($results as $result) {
                    if ($this->config->get('total_' . $result['code'] . '_status')) {
                        $this->load->model('extension/total/' . $result['code']);
                        $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
                    }
                }

                $sort_order = array();

                foreach ($totals as $key => $value) {
                    $sort_order[$key] = $value['sort_order'];
                    $data['total']=$value['value'];
                }

                array_multisort($sort_order, SORT_ASC, $totals);

                $data['totals'] = $totals;
				$data['language_id'] = $this->config->get('config_language_id');
                $data['currency_id'] = $this->currency->getId($this->session->data['currency']);
                $data['currency_code'] = $this->session->data['currency'];
                $data['currency_value'] = $this->currency->getValue($this->session->data['currency']);
                $data['products'] = $this->cart->getProducts();
                $order_id = $this->model_extension_module_aridiusfastorder->addOrder($data);
                			
				//$json['total'] = sprintf($this->language->get('text_items'),0, $this->currency->format(0, $this->session->data['currency']));

                $this->model_extension_module_aridiusfastorder->addOrderHistory($order_id);	

                $this->cart->clear();
            }

            $email_subject = sprintf($this->language->get('text_subject'), $this->language->get('heading_title_fastorder'), $this->config->get('config_name'), $order_id);
            $email_text = sprintf($this->language->get('text_order'), $order_id) . "\n\n <br>";
            if ($aridiusfastorder_firstname != 1 || $aridiusfastorder_firstnamevalid != 1) {

                if ($data['formFastOrderName']) {
                    $email_text .= sprintf($this->language->get('text_firstname'), html_entity_decode($data['formFastOrderName']), ENT_QUOTES, 'UTF - 8') . "\n <br>";
                }
            }
            $email_text .= sprintf($this->language->get('text_contact'), html_entity_decode($data['formFastOrderTel']), ENT_QUOTES, 'UTF - 8') . "\n <br>";
            if ($aridiusfastorder_email != 1 || $aridiusfastorder_email_valid != 1) {

                if ($data['formFastOrderEmail']) {
                    $email_text .= sprintf($this->language->get('text_email'), html_entity_decode($data['formFastOrderEmail']), ENT_QUOTES, 'UTF - 8') . "\n <br>";
                }
            }
            if ($aridiusfastorder_comment != 1) {
                if ($data['formFastOrderComment']) {
                    $email_text .= sprintf($this->language->get('text_comment'), html_entity_decode($data['formFastOrderComment']), ENT_QUOTES, 'UTF - 8') . "\n <br>";
                }
            } else {
                $data['formFastOrderComment'] = ' ';
            }
            $data['products'] = array();

            $this->load->model('checkout/order');
            $order_info=$this->model_checkout_order->getOrder($order_id);
            $order_products = $this->model_checkout_order->getOrderProducts($order_id);

            foreach ($order_products as $order_product) {
                $option_data = array();

                $order_options = $this->model_checkout_order->getOrderOptions($order_info['order_id'], $order_product['order_product_id']);

                foreach ($order_options as $order_option) {
                    if ($order_option['type'] != 'file') {
                        $value = $order_option['value'];
                    } else {
                        $upload_info = $this->model_tool_upload->getUploadByCode($order_option['value']);

                        if ($upload_info) {
                            $value = $upload_info['name'];
                        } else {
                            $value = '';
                        }
                    }

                    $option_data[] = array(
                        'name'  => $order_option['name'],
                        'value' =>  $value
                    );
                }

                $data['products'][] = array(
                    'name'     => $order_product['name'],
                    'model'    => $order_product['model'],
                    'quantity' => $order_product['quantity'],
                    'option'   => $option_data,
                    'price'=>$order_product['price'],
                    'total'    => html_entity_decode($this->currency->format($order_product['total'] + ($this->config->get('config_tax') ? ($order_product['tax'] * $order_product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']), ENT_NOQUOTES, 'UTF-8')
                );
            }
            // Order Totals
            $data['totals'] = array();

            $order_totals = $this->model_checkout_order->getOrderTotals($order_info['order_id']);

            foreach ($order_totals as $order_total) {
                $data['totals'][] = array(
                    'title' => $order_total['title'],
                    'text'  => $this->currency->format($order_total['value'], $order_info['currency_code'], $order_info['currency_value']),
                );
            }
			
			$data['text_productf'] = $this->language->get('text_productf');
			$data['text_modelf'] = $this->language->get('text_modelf');
			$data['text_quantityf'] = $this->language->get('text_quantityf');
			$data['text_pricef'] = $this->language->get('text_pricef');			
			$data['text_totalf'] = $this->language->get('text_totalf');	

            $email_text.=$this->load->view('mail/aridiud_fastorder_products', $data);

			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
			$mail->smtp_username = $this->config->get('config_mail_smtp_username');
			$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->smtp_port = $this->config->get('config_mail_smtp_port');
			$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
			$mail->setTo($this->config->get('config_email'));
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender($this->config->get('config_name'));
			$mail->setSubject($email_subject);
			$mail->setHtml($email_text);
			$mail->send();

			// Send to additional alert emails
			$emails = explode(',', $this->config->get('config_mail_alert_email'));

			foreach ($emails as $email) {
				if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$mail->setTo($email);
					$mail->send();
				}
			}

            $json['success'] = $this->language->get('text_success');
        }

        $this->response->addHeader('Content-Type: application / json');
        $this->response->setOutput(json_encode($json));
    }

	public function success() {

		$this->load->language('extension/module/aridius_fastorder');

		$data['language_id'] = $this->config->get('config_language_id');
		$data['aridiusfastorder_description2'] = html_entity_decode ($this->config->get('module_aridiusfastorder_description2')[$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');

		$this->response->setOutput($this->load->view('extension/module/aridiusfastorder_success', $data));
	}

}
