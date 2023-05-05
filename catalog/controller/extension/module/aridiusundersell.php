<?php
class ControllerExtensionModuleAridiusundersell extends Controller {

	public function index() {

		$this->load->language('extension/module/aridiusundersell');
	}

	public function success() {

		$this->load->language('extension/module/aridiusundersell');

		$data['language_id'] = $this->config->get('config_language_id');
		$data['aridiusundersell_description2'] = html_entity_decode ($this->config->get('module_aridiusundersell_description2')[$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');

		$this->response->setOutput($this->load->view('extension/module/aridiusundersell_success', $data));

	}

	public function getForm() {

		$this->load->model('catalog/product');

		$this->load->language('extension/module/aridiusundersell');
		$this->load->language('product/product');

		$data['language_id'] = $this->config->get('config_language_id');
		$data['aridiusundersell_descriptionshow'] = $this->config->get('module_aridiusundersell_descriptionshow');
		$data['aridiusundersell_adddescriptionshow'] = $this->config->get('module_aridiusundersell_adddescriptionshow');
		$data['aridiusundersell_img'] = $this->config->get('module_aridiusundersell_img');
		$data['aridiusundersell_price'] = $this->config->get('module_aridiusundersell_price');
		$data['aridiusundersell_placeholdertell'] = $this->config->get('module_aridiusundersell_placeholdertell');
		$data['aridiusundersell_placeholderfirstname'] = $this->config->get('module_aridiusundersell_placeholderfirstname');
		$data['aridiusundersell_placeholderemail'] = $this->config->get('module_aridiusundersell_placeholderemail');
		
		$data['aridiusundersell_placeholdercomment'] = $this->config->get('module_aridiusundersell_placeholdercomment');
		$data['aridiusundersell_placeholdercomment'] = $this->config->get('module_aridiusundersell_placeholdercomment');
		$data['aridiusundersell_mask'] = $this->config->get('module_aridiusundersell_mask');
		$data['aridiusundersell_emailvalid'] = $this->config->get('module_aridiusundersell_emailvalid');
		
		$data['aridiusundersell_firstnamevalid'] = $this->config->get('module_aridiusundersell_firstnamevalid');
		$data['aridiusundersell_firstnameshow'] = $this->config->get('module_aridiusundersell_firstnameshow');
		$data['aridiusundersell_emailshow'] = $this->config->get('module_aridiusundersell_emailshow');
		
		$data['aridiusundersell_commentshow'] = $this->config->get('module_aridiusundersell_commentshow');

		$data['aridiusundersell_imgw'] = $this->config->get('module_aridiusundersell_imgw');		
		$data['aridiusundersell_imgh'] = $this->config->get('module_aridiusundersell_imgh');
		$data['aridiusundersell_descchar'] = $this->config->get('module_aridiusundersell_descchar');

		$data['aridiusundersell_description'] = html_entity_decode ($this->config->get('module_aridiusundersell_description')[$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');

		$product_info = $this->model_catalog_product->getProduct($this->request->get['pr_id']);

		$data['product_name']=$product_info['name'];

		$data['product_description'] = utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0,280) . '...';

		$currency_code = !empty($this->session->data['currency']) ? $this->session->data['currency'] : $this->config->get('config_currency');

		$formated_special=str_replace($this->currency->getSymbolRight($currency_code),'',$this->request->get['formated_special']);
		$formated_special=str_replace($this->currency->getSymbolLeft($currency_code),'',$formated_special);

		$formated_special = (float)str_replace(" ","", $formated_special);
		$data['not_formated_special'] =$formated_special;
		$data['formated_special'] =$this->request->get['formated_special'];
		$data['quantity'] =$this->request->get['quantity'];

		$formated_price=str_replace($this->currency->getSymbolRight($currency_code),'',$this->request->get['formated_price']);
		$formated_price=str_replace($this->currency->getSymbolLeft($currency_code),'',$formated_price);
		$formated_price=(float)str_replace(' ','',$formated_price);
		$data['not_formated_price'] =$formated_price;
		$data['formated_price'] =$this->request->get['formated_price'];

		$this->load->model('tool/image');

		if ($product_info['image']) {
			$data['popup'] = $this->model_tool_image->resize($product_info['image'], 150, 150);
		} else {
			$data['popup'] = '';
		}

		$this->response->setOutput($this->load->view('extension/module/aridiusundersell_form', $data));

	}

	public function write($settings = array()) {

		$this->load->language('extension/module/aridiusundersell');

		$this->load->model('extension/module/aridiusundersell');
		$this->load->model('setting/setting');

		$json = array();

		$contact = $this->request->post['aridiusundersell_contact'];
		$firstname = (empty($this->request->post['aridiusundersell_firstname']) ? '' : $this->request->post['aridiusundersell_firstname']);
		$email = (empty($this->request->post['aridiusundersell_email']) ? '' : $this->request->post['aridiusundersell_email']);
		$comment = (empty($this->request->post['aridiusundersell_comment']) ? '' : $this->request->post['aridiusundersell_comment']);
		

		$product_id = $this->request->post['product_id'];

		if ($product_id) {

			$aridiusundersell_firstnamevalid = $this->config->get('module_aridiusundersell_firstnamevalid');
			$aridiusundersell_emailvalid = $this->config->get('module_aridiusundersell_emailvalid');
			$aridiusundersell_firstnameshow = $this->config->get('module_aridiusundersell_firstnameshow');
			$aridiusundersell_emailshow = $this->config->get('module_aridiusundersell_emailshow');
			$aridiusundersell_quantity = $this->config->get('module_aridiusundersell_quantity');
			
			$this->load->model('catalog/product');
			$product_info = $this->model_catalog_product->getProduct($product_id);
			$quantity_formated = $this->request->post['quantity'];
			$quantity = $product_info['quantity'];

			if (($aridiusundersell_quantity == '1') && (($quantity_formated) > ($quantity)))  {
				$json['error']['quantity'] = $this->language->get('error_quantity');
			}

			if ((utf8_strlen($contact) < 3) || (utf8_strlen($contact) > 32)) {
				$json['error']['contact'] = $this->language->get('error_tell');
			}

			if ( (!$aridiusundersell_firstnameshow == '1') && (!$aridiusundersell_firstnamevalid == '1') && (utf8_strlen($firstname) < 1) || (utf8_strlen($firstname) > 3200) ) {
				$json['error']['firstname'] = $this->language->get('error_firstname');
			}
	

			if ((!$aridiusundersell_emailshow == '1') && (!$aridiusundersell_emailvalid == '1') && ((utf8_strlen($email) > 96) || (!preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)))) {

				$json['error']['email'] = $this->language->get('error_email');
			}

			if (!isset($json['error'])) {

				$this->load->model('catalog/product');

				$product_info = $this->model_catalog_product->getProduct($product_id);

				if (isset($this->request->post['option'])) {
					$option = array_filter($this->request->post['option']);
				} else {
					$option = array();
				}
				$option_txt = array();
				$product_options = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);

				foreach ($product_options as $product_option) {
					if (isset($option[$product_option['product_option_id']]) && ($product_option['type']=='select' || $product_option['type']=='radio' || $product_option['type']=='image')) {
						foreach($product_option['product_option_value'] as $product_option_value ){
							if(in_array($product_option_value['product_option_value_id'],$option)){
								$option_txt[]=$product_option['name'].': '.$product_option_value['name'];
							}
						}
					}elseif (isset($option[$product_option['product_option_id']]) && $product_option['type']=='checkbox') {
						foreach($product_option['product_option_value'] as $product_option_value ){
							foreach($option[$product_option['product_option_id']] as $checkbox){
								if($product_option_value['product_option_value_id']==$checkbox){
									$option_txt[]=$product_option['name'].': '.$product_option_value['name'];
								}
							}
						}
					}elseif (isset($option[$product_option['product_option_id']]) && ($product_option['type']=='textarea' || $product_option['type']=='text' || $product_option['type']=='date' || $product_option['type']=='time' || $product_option['type']=='datetime')) {
						$option_txt[]=$product_option['name'].': '.$option[$product_option['product_option_id']];
					}
				}

				if($option_txt){
					$format_option=implode(', ',$option_txt);
				}else{
					$format_option='';
				}

				$price = $this->request->post['fo_total_price'];
				$quantity = $this->request->post['quantity'];
				$total = $price.$this->session->data['currency'];

				$href =$this->url->link('product/product', '&product_id=' . $product_id);

				$data = array(
				'contact' => $contact,
				'firstname' => $firstname,
				'email' => $email,
				'comment' => $comment,
				
				'product_id' => $product_id,
				'quantity' => $quantity,
				'product_name' => $product_info['name'],
				'format_option' => $format_option,
				'total' => (float)$price,
				'currency_id' => $this->currency->getId($this->session->data['currency']),
				'currency_code' => $this->session->data['currency'],
				'currency_value' => $this->currency->getValue($this->session->data['currency'])
				);

				$order_id = $this->model_extension_module_aridiusundersell->addOrder($data);

				$email_subject = sprintf($this->language->get('text_subject'), $this->language->get('buttonundersell_title'), $this->config->get('config_name'), $order_id);
				$email_text = sprintf($this->language->get('text_order'), $order_id) . "\n\n <br>";
				if($firstname){
					$email_text .= sprintf($this->language->get('text_firstname'), html_entity_decode($firstname), ENT_QUOTES, 'UTF-8') . "\n <br>";
				}
				$email_text .= sprintf($this->language->get('text_contact'), html_entity_decode($contact), ENT_QUOTES, 'UTF-8') . "\n <br>";
				if($email){
					$email_text .= sprintf($this->language->get('text_email'), html_entity_decode($email), ENT_QUOTES, 'UTF-8') . "\n <br>";
				}
		
				if($comment){
					$email_text .= sprintf($this->language->get('text_comment'), html_entity_decode($comment), ENT_QUOTES, 'UTF-8') . "\n <br>";
				}
				$email_text .= sprintf($this->language->get('text_product'),$href, html_entity_decode($product_info['name']), ENT_QUOTES, 'UTF-8') . "\n <br>";
				if($option_txt){
					$email_text .= sprintf($this->language->get('text_product_option'), html_entity_decode(implode(', ',$option_txt)), ENT_QUOTES, 'UTF-8') . "\n <br>";
				}
				$email_text .= sprintf($this->language->get('text_quantity'), $quantity, ENT_QUOTES, 'UTF-8') . "\n\n <br>";
				$email_text .= sprintf($this->language->get('text_price'), $total, ENT_QUOTES, 'UTF-8') . "\n <br>";
				$email_text .= sprintf($this->language->get('text_date_order'), date('d.m.Y H:i'), ENT_QUOTES, 'UTF-8') . "\n\n <br>";

				$mail = new Mail($this->config->get('config_mail_engine'));
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
		}

		$this->response->setOutput(json_encode($json));
	}

	public function validOrder() {

		$this->load->language('checkout/cart');

		$json = array();

		if (isset($this->request->post['product_id'])) {
			$product_id = (int)$this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			if (isset($this->request->post['quantity']) && ((int)$this->request->post['quantity'] >= $product_info['minimum'])) {
				$quantity = (int)$this->request->post['quantity'];
			} else {
				$quantity = $product_info['minimum'] ? $product_info['minimum'] : 1;
			}

			if (isset($this->request->post['option'])) {
				$option = array_filter($this->request->post['option']);
			} else {
				$option = array();
			}

			$product_options = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);

			foreach ($product_options as $product_option) {
				if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
					$json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
				}
			}

			if (isset($this->request->post['recurring_id'])) {
				$recurring_id = $this->request->post['recurring_id'];
			} else {
				$recurring_id = 0;
			}

			$recurrings = $this->model_catalog_product->getProfiles($product_info['product_id']);

			if ($recurrings) {
				$recurring_ids = array();

				foreach ($recurrings as $recurring) {
					$recurring_ids[] = $recurring['recurring_id'];
				}

				if (!in_array($recurring_id, $recurring_ids)) {
					$json['error']['recurring'] = $this->language->get('error_recurring_required');
				}
			}

			if (!$json) {
				$json['success'] = true;
			} else {
				$json['success'] = false;
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}

