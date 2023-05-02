<?php
class ControllerExtensionModuleAridiusinstock extends Controller {

	public function index() {

		$this->load->language('extension/module/aridiusinstock');
	}

	public function success() {

		$this->load->language('extension/module/aridiusinstock');

		$data['language_id'] = $this->config->get('config_language_id');
		$data['aridiusinstock_description2'] = html_entity_decode ($this->config->get('module_aridiusinstock_description2')[$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');

		$this->response->setOutput($this->load->view('extension/module/aridiusinstock_success', $data));
	}

	public function getForm() {

		$this->load->model('catalog/product');
		$this->load->language('extension/module/aridiusinstock');
		$this->load->language('product/product');

		$data['language_id'] = $this->config->get('config_language_id');
		$data['aridiusinstock_descriptionshow'] = $this->config->get('module_aridiusinstock_descriptionshow');
		$data['aridiusinstock_adddescriptionshow'] = $this->config->get('module_aridiusinstock_adddescriptionshow');
		$data['aridiusinstock_img'] = $this->config->get('module_aridiusinstock_img');
		$data['aridiusinstock_placeholdertell'] = $this->config->get('module_aridiusinstock_placeholdertell');
		$data['aridiusinstock_tellvalid'] = $this->config->get('module_aridiusinstock_tellvalid');
		$data['aridiusinstock_tellshow'] = $this->config->get('module_aridiusinstock_tellshow');
		$data['aridiusinstock_placeholderfirstname'] = $this->config->get('module_aridiusinstock_placeholderfirstname');
		$data['aridiusinstock_placeholderemail'] = $this->config->get('module_aridiusinstock_placeholderemail');
		$data['aridiusinstock_placeholderlink'] = $this->config->get('module_aridiusinstock_placeholderlink');
		$data['aridiusinstock_mask'] = $this->config->get('module_aridiusinstock_mask');
		$data['aridiusinstock_emailvalid'] = $this->config->get('module_aridiusinstock_emailvalid');
		$data['aridiusinstock_linkvalid'] = $this->config->get('module_aridiusinstock_linkvalid');
		$data['aridiusinstock_firstnamevalid'] = $this->config->get('module_aridiusinstock_firstnamevalid');
		$data['aridiusinstock_firstnameshow'] = $this->config->get('module_aridiusinstock_firstnameshow');
		$data['aridiusinstock_emailshow'] = $this->config->get('module_aridiusinstock_emailshow');
		$data['aridiusinstock_linkshow'] = $this->config->get('module_aridiusinstock_linkshow');
		
		$data['aridiusinstock_imgw'] = $this->config->get('module_aridiusinstock_imgw');		
		$data['aridiusinstock_imgh'] = $this->config->get('module_aridiusinstock_imgh');
		$data['aridiusinstock_descchar'] = $this->config->get('module_aridiusinstock_descchar');
				
		$data['aridiusinstock_description'] = html_entity_decode ($this->config->get('module_aridiusinstock_description')[$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		$product_info = $this->model_catalog_product->getProduct($this->request->get['pr_id']);

		$data['product_name']= $product_info['name'];
		$data['product_id'] = $this->request->get['pr_id'];

		$data['product_description'] = utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0,280) . '...';

		$this->load->model('tool/image');

		if ($product_info['image']) {
			$data['popup'] = $this->model_tool_image->resize($product_info['image'], 150, 150);
		} else {
			$data['popup'] = '';
		}

		$this->response->setOutput($this->load->view('extension/module/aridiusinstock_form', $data));

	}

	public function write($settings = array()) {

		$this->load->language('extension/module/aridiusinstock');

		$this->load->model('extension/module/aridiusinstock');
		$this->load->model('setting/setting');

		$json = array();

		$contact   = (empty($this->request->post['aridiusinstock_contact']) ? '' : $this->request->post['aridiusinstock_contact']);
		$firstname = (empty($this->request->post['aridiusinstock_firstname']) ? '' : $this->request->post['aridiusinstock_firstname']);
		$email     = (empty($this->request->post['aridiusinstock_email']) ? '' : $this->request->post['aridiusinstock_email']);

		$product_id = $this->request->post['product_id'];

		if ($product_id) {

			$aridiusinstock_firstnamevalid = $this->config->get('module_aridiusinstock_firstnamevalid');
			$aridiusinstock_emailvalid = $this->config->get('module_aridiusinstock_emailvalid');
			$aridiusinstock_firstnameshow = $this->config->get('module_aridiusinstock_firstnameshow');
			$aridiusinstock_emailshow = $this->config->get('module_aridiusinstock_emailshow');
			$aridiusinstock_tellvalid = $this->config->get('module_aridiusinstock_tellvalid');
			$aridiusinstock_tellshow = $this->config->get('module_aridiusinstock_tellshow');

			if ( (!$aridiusinstock_tellshow == '1') && (!$aridiusinstock_tellvalid == '1') && (utf8_strlen($contact) < 1) || (utf8_strlen($contact) > 3200) ) {
				$json['error']['contact'] = $this->language->get('error_tell');
			}

			if ( (!$aridiusinstock_firstnameshow == '1') && (!$aridiusinstock_firstnamevalid == '1') && (utf8_strlen($firstname) < 1) || (utf8_strlen($firstname) > 3200) ) {
				$json['error']['firstname'] = $this->language->get('error_firstname');
			}

			if ((!$aridiusinstock_emailshow == '1') && (!$aridiusinstock_emailvalid == '1') && ((utf8_strlen($email) > 96) || (!preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)))) {

				$json['error']['email'] = $this->language->get('error_email');
			}

			if (!isset($json['error'])) {

				$this->load->model('catalog/product');

				$product_info = $this->model_catalog_product->getProduct($product_id);

				$href =$this->url->link('product/product', '&product_id=' . $product_id);

				$data = array(
				'contact' => $contact,
				'firstname' => $firstname,
				'email' => $email,
				'product_id' => $product_id,
				'product_name' => $product_info['name'],
				);

				$order_id = $this->model_extension_module_aridiusinstock->addOrder($data);


				$email_subject = sprintf($this->language->get('text_subject'), $this->language->get('buttoninstock_title'), $this->config->get('config_name'), $order_id);
				$email_text = sprintf($this->language->get('text_order'), $order_id) . "\n\n <br>";
				if($firstname){
					$email_text .= sprintf($this->language->get('text_firstname'), html_entity_decode($firstname), ENT_QUOTES, 'UTF-8') . "\n <br>";
				}
				if($contact){
					$email_text .= sprintf($this->language->get('text_contact'), html_entity_decode($contact), ENT_QUOTES, 'UTF-8') . "\n <br>";
				}
				if($email){
					$email_text .= sprintf($this->language->get('text_email'), html_entity_decode($email), ENT_QUOTES, 'UTF-8') . "\n <br>";
				}
				$email_text .= sprintf($this->language->get('text_product'),$href, html_entity_decode($product_info['name']), ENT_QUOTES, 'UTF-8') . "\n <br>";
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
