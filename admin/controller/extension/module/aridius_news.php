<?php
class ControllerExtensionModuleAridiusNews extends Controller {
	
	private $error = array();
	
	public function index() {
		
		$this->load->language('extension/module/aridius_news');

		$this->load->model('catalog/aridiusnews');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$data['heading_title'] = $this->language->get('heading_title');

		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_aridius_news', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

        if (isset($this->request->post['apply'])) {
			$this->response->redirect($this->url->link('extension/module/aridius_news', 'user_token=' . $this->session->data['user_token'], true));
            } else {
	        $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
            }
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/aridius_news', 'user_token=' . $this->session->data['user_token'], true)
		);
		
		$data['aridius_news_reviews'] = $this->url->link('catalog/aridius_review_news', 'user_token=' . $this->session->data['user_token'], true);
		$data['aridius_news'] = $this->url->link('extension/module/aridius_news/listing', 'user_token=' . $this->session->data['user_token'], true);
		$data['action'] = $this->url->link('extension/module/aridius_news', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->getModule();
	}

	public function insert() {
		
		$this->load->language('extension/module/aridius_news');

		$this->load->model('catalog/aridiusnews');

		$this->document->setTitle($this->language->get('heading_title'));
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validateForm())) {
			$this->model_catalog_aridiusnews->addaridius_news($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->response->redirect($this->url->link('extension/module/aridius_news/listing', 'user_token=' . $this->session->data['user_token'], true));

		}

		$this->getForm();
	}

	public function update() {

		$this->load->language('extension/module/aridius_news');
		
		$this->load->model('catalog/aridiusnews');

		$this->document->setTitle($this->language->get('heading_title'));
		

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validateForm())) {
			$this->model_catalog_aridiusnews->editaridius_news($this->request->get['aridius_news_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->response->redirect($this->url->link('extension/module/aridius_news/listing', 'user_token=' . $this->session->data['user_token'], true));
			
		}

		$this->getForm();
	}

	public function delete() {

		$this->load->language('extension/module/aridius_news');

		$this->load->model('catalog/aridiusnews');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $aridius_news_id) {
				$this->model_catalog_aridiusnews->deletearidius_news($aridius_news_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->response->redirect($this->url->link('extension/module/aridius_news/listing', 'user_token=' . $this->session->data['user_token'], true));
			
		}

		$this->getList();
	}

	public function reset() {

		$this->load->language('extension/module/aridius_news');

		$this->load->model('catalog/aridiusnews');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->post['selected']) && $this->validateReset()) {
			foreach ($this->request->post['selected'] as $aridius_news_id) {
				$aridius_news_info = $this->model_catalog_aridiusnews->getaridius_newsStory($aridius_news_id);

				if ($aridius_news_info && ($aridius_news_info['viewed'] > 0)) {
					$this->model_catalog_aridiusnews->resetViews($aridius_news_id);
				}
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->response->redirect($this->url->link('extension/module/aridius_news/listing', 'user_token=' . $this->session->data['user_token'], true));

		}

		$this->getList();
	}

	public function listing() {

		$this->load->language('extension/module/aridius_news');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->getList();
	}

	private function getModule() {
		
		$this->load->language('extension/module/aridius_news');

		$this->load->model('catalog/aridiusnews');

		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['aridius_news_home_chars'])) {
			$data['error_home_numchars'] = $this->error['aridius_news_home_chars'];
		} else {
			$data['error_home_numchars'] = '';
		}

		if (isset($this->error['aridius_news_home_limit'])) {
			$data['error_home_limit'] = $this->error['aridius_news_home_limit'];
		} else {
			$data['error_home_limit'] = '';
		}

		if (isset($this->error['aridius_news_headline_chars'])) {
			$data['error_headline_chars'] = $this->error['aridius_news_headline_chars'];
		} else {
			$data['error_headline_chars'] = '';
		}

		if (isset($this->error['aridius_newspage_thumb'])) {
			$data['error_aridius_newspage_thumb'] = $this->error['aridius_newspage_thumb'];
		} else {
			$data['error_aridius_newspage_thumb'] = '';
		}
		
		if (isset($this->error['aridius_thumb'])) {
			$data['error_aridius_thumb'] = $this->error['aridius_thumb'];
		} else {
			$data['error_aridius_thumb'] = '';
		}
		
		if (isset($this->error['aridius_simthumb'])) {
			$data['error_aridius_simnews'] = $this->error['aridius_simthumb'];
		} else {
			$data['error_aridius_simnews'] = '';
		}
		
		if (isset($this->error['review_limit'])) {
			$data['error_limite_page'] = $this->error['review_limit'];
		} else {
			$data['error_limite_page'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/aridius_news', 'user_token=' . $this->session->data['user_token'], true)
		);
		
		$data['aridius_news_reviews'] = $this->url->link('catalog/aridius_review_news', 'user_token=' . $this->session->data['user_token'], true);
		$data['aridius_news'] = $this->url->link('extension/module/aridius_news/listing', 'user_token=' . $this->session->data['user_token'], true);
		$data['action'] = $this->url->link('extension/module/aridius_news', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
		
		// Module Villagedefrance & Aridius
		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();

		$data['languages'] = $languages;

		if (isset($this->request->post['module_aridius_news_thumb_width'])) {
			$data['module_aridius_news_thumb_width'] = $this->request->post['module_aridius_news_thumb_width'];
		} elseif ($this->config->get('module_aridius_news_thumb_width')) {
			$data['module_aridius_news_thumb_width'] = $this->config->get('module_aridius_news_thumb_width');
		} else {
			$data['module_aridius_news_thumb_width'] = 260;
		}
		
		if (isset($this->request->post['module_aridius_news_thumb_height'])) {
			$data['module_aridius_news_thumb_height'] = $this->request->post['module_aridius_news_thumb_height'];
		} elseif ($this->config->get('module_aridius_news_thumb_height')) {
			$data['module_aridius_news_thumb_height'] = $this->config->get('module_aridius_news_thumb_height');
		} else {
			$data['module_aridius_news_thumb_height'] = 167;
		}

		if (isset($this->request->post['module_aridius_news_width'])) {
			$data['module_aridius_news_width'] = $this->request->post['module_aridius_news_width'];
		} elseif ($this->config->get('module_aridius_news_width')) {
			$data['module_aridius_news_width'] = $this->config->get('module_aridius_news_width');
		} else {
			$data['module_aridius_news_width'] = 200;
		}
		
		if (isset($this->request->post['module_aridius_news_height'])) {
			$data['module_aridius_news_height'] = $this->request->post['module_aridius_news_height'];
		} elseif ($this->config->get('module_aridius_news_height')) {
			$data['module_aridius_news_height'] = $this->config->get('module_aridius_news_height');
		} else {
			$data['module_aridius_news_height'] = 200;
		}

		if (isset($this->request->post['module_aridius_news_simwidth'])) {
			$data['module_aridius_news_simwidth'] = $this->request->post['module_aridius_news_simwidth'];
		} elseif ($this->config->get('module_aridius_news_simwidth')) {
			$data['module_aridius_news_simwidth'] = $this->config->get('module_aridius_news_simwidth');
		} else {
			$data['module_aridius_news_simwidth'] = 270;
		}
		
		if (isset($this->request->post['module_aridius_news_simheight'])) {
			$data['module_aridius_news_simheight'] = $this->request->post['module_aridius_news_simheight'];
		} elseif ($this->config->get('module_aridius_news_simheight')) {
			$data['module_aridius_news_simheight'] = $this->config->get('module_aridius_news_simheight');
		} else {
			$data['module_aridius_news_simheight'] = 135;
		}

		if (isset($this->request->post['module_aridius_news_rat'])) {
			$data['module_aridius_news_rat'] = $this->request->post['module_aridius_news_rat'];
		} else {
			$data['module_aridius_news_rat'] = $this->config->get('module_aridius_news_rat');
		}
		
	    if (isset($this->request->post['module_aridius_news_wish'])) {
			$data['module_aridius_news_wish'] = $this->request->post['module_aridius_news_wish'];
		} else {
			$data['module_aridius_news_wish'] = $this->config->get('module_aridius_news_wish');
		}

		if (isset($this->request->post['module_aridius_news_comp'])) {
			$data['module_aridius_news_comp'] = $this->request->post['module_aridius_news_comp'];
		} else {
			$data['module_aridius_news_comp'] = $this->config->get('module_aridius_news_comp');
		}
				
	
		if (isset($this->request->post['module_aridius_news_quickview'])) {
			$data['module_aridius_news_quickview'] = $this->request->post['module_aridius_news_quickview'];
		} else {
			$data['module_aridius_news_quickview'] = $this->config->get('module_aridius_news_quickview');
		}
		
		if (isset($this->request->post['module_aridius_news_relnavigation'])) {
			$data['module_aridius_news_relnavigation'] = $this->request->post['module_aridius_news_relnavigation'];
		} else {
			$data['module_aridius_news_relnavigation'] = $this->config->get('module_aridius_news_relnavigation');
		}
		
		if (isset($this->request->post['module_aridius_news_relautoplay_on'])) {
			$data['module_aridius_news_relautoplay_on'] = $this->request->post['module_aridius_news_relautoplay_on'];
		} else {
			$data['module_aridius_news_relautoplay_on'] = $this->config->get('module_aridius_news_relautoplay_on');
		}
		
		if (isset($this->request->post['module_aridius_news_relstophover'])) {
			$data['module_aridius_news_relstophover'] = $this->request->post['module_aridius_news_relstophover'];
		} else {
			$data['module_aridius_news_relstophover'] = $this->config->get('module_aridius_news_relstophover');
		}

		if (isset($this->request->post['module_aridius_news_relautoplay'])) {
			$data['module_aridius_news_relautoplay'] = $this->request->post['module_aridius_news_relautoplay'];
		} elseif ($this->config->get('module_aridius_news_relautoplay')) {
			$data['module_aridius_news_relautoplay'] = $this->config->get('module_aridius_news_relautoplay');
		} else {
			$data['module_aridius_news_relautoplay'] = 4000;
		}
		
		if (isset($this->request->post['module_aridius_news_relitems'])) {
			$data['module_aridius_news_relitems'] = $this->request->post['module_aridius_news_relitems'];
		} elseif ($this->config->get('module_aridius_news_relitems')) {
			$data['module_aridius_news_relitems'] = $this->config->get('module_aridius_news_relitems');
		} else {
			$data['module_aridius_news_relitems'] = 5;
		}
		
		if (isset($this->request->post['module_aridius_news_relrew_speed'])) {
			$data['module_aridius_news_relrew_speed'] = $this->request->post['module_aridius_news_relrew_speed'];
		} elseif ($this->config->get('module_aridius_news_relrew_speed')) {
			$data['module_aridius_news_relrew_speed'] = $this->config->get('module_aridius_news_relrew_speed');
		} else {
			$data['module_aridius_news_relrew_speed'] = 1000;
		}

		if (isset($this->request->post['module_aridius_news_module_aridius_newspage_addthis'])) {
			$data['module_aridius_news_module_aridius_newspage_addthis'] = $this->request->post['module_aridius_news_module_aridius_newspage_addthis'];
		} else {
			$data['module_aridius_news_module_aridius_newspage_addthis'] = $this->config->get('module_aridius_news_module_aridius_newspage_addthis');
		}
		
		if (isset($this->request->post['module_aridius_news_show_date'])) {
			$data['module_aridius_news_show_date'] = $this->request->post['module_aridius_news_show_date'];
		} else {
			$data['module_aridius_news_show_date'] = $this->config->get('module_aridius_news_show_date');
		}

		if (isset($this->request->post['module_aridius_news_show_img'])) {
			$data['module_aridius_news_show_img'] = $this->request->post['module_aridius_news_show_img'];
		} else {
			$data['module_aridius_news_show_img'] = $this->config->get('module_aridius_news_show_img');
		}

		if (isset($this->request->post['module_aridius_news_show_description'])) {
			$data['module_aridius_news_show_description'] = $this->request->post['module_aridius_news_show_description'];
		} else {
			$data['module_aridius_news_show_description'] = $this->config->get('module_aridius_news_show_description');
		}
		
		if (isset($this->request->post['module_aridius_news_show_imgp'])) {
			$data['module_aridius_news_show_imgp'] = $this->request->post['module_aridius_news_show_imgp'];
		} else {
			$data['module_aridius_news_show_imgp'] = $this->config->get('module_aridius_news_show_imgp');
		}
		
		if (isset($this->request->post['module_aridius_news_home_chars'])) {
			$data['module_aridius_news_home_chars'] = $this->request->post['module_aridius_news_home_chars'];
		} elseif ($this->config->get('module_aridius_news_home_chars')) {
			$data['module_aridius_news_home_chars'] = $this->config->get('module_aridius_news_home_chars');
		} else {
			$data['module_aridius_news_home_chars'] = 135;
		}
		
		if (isset($this->request->post['module_aridius_news_headline_chars'])) {
			$data['module_aridius_news_headline_chars'] = $this->request->post['module_aridius_news_headline_chars'];
		} elseif ($this->config->get('module_aridius_news_headline_chars')) {
			$data['module_aridius_news_headline_chars'] = $this->config->get('module_aridius_news_headline_chars');
		} else {
			$data['module_aridius_news_headline_chars'] = 100;
		}

		if (isset($this->request->post['module_aridius_news_sim_chars'])) {
			$data['module_aridius_news_sim_chars'] = $this->request->post['module_aridius_news_sim_chars'];
		} elseif ($this->config->get('module_aridius_news_sim_chars')) {
			$data['module_aridius_news_sim_chars'] = $this->config->get('module_aridius_news_sim_chars');
		} else {
			$data['module_aridius_news_sim_chars'] = 100;
		}

		if (isset($this->request->post['module_aridius_news_home_limit'])) {
			$data['module_aridius_news_home_limit'] = $this->request->post['module_aridius_news_home_limit'];
		} elseif ($this->config->get('module_aridius_news_home_limit')) {
			$data['module_aridius_news_home_limit'] = $this->config->get('module_aridius_news_home_limit');
		} else {
			$data['module_aridius_news_home_limit'] = 4;
		}

		$data['modules'] = array();

		if (isset($this->request->post['module_aridius_news_module'])) {
			$data['modules'] = $this->request->post['module_aridius_news_module'];
		} elseif ($this->config->get('module_aridius_news_module')) {
			$data['modules'] = $this->config->get('module_aridius_news_module');
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		if (isset($this->request->post['module_aridius_news_status'])) {
			$data['module_aridius_news_status'] = $this->request->post['module_aridius_news_status'];
		} else {
			$data['module_aridius_news_status'] = $this->config->get('module_aridius_news_status');
		}	
		
		if (isset($this->request->post['module_aridius_news_meta_title'])) {
			$data['module_aridius_news_meta_title'] = $this->request->post['module_aridius_news_meta_title'];
		} else {
			$data['module_aridius_news_meta_title'] = $this->config->get('module_aridius_news_meta_title');
		}
		
		if (isset($this->request->post['module_aridius_news_meta_description'])) {
			$data['module_aridius_news_meta_description'] = $this->request->post['module_aridius_news_meta_description'];
		} else {
			$data['module_aridius_news_meta_description'] = $this->config->get('module_aridius_news_meta_description');
		}
		
		if (isset($this->request->post['module_aridius_news_meta_keyword'])) {
			$data['module_aridius_news_meta_keyword'] = $this->request->post['module_aridius_news_meta_keyword'];
		} else {
			$data['module_aridius_news_meta_keyword'] = $this->config->get('module_aridius_news_meta_keyword');
		}
		
		if (isset($this->request->post['module_aridius_news_review_guest'])) {
			$data['module_aridius_news_review_guest'] = $this->request->post['module_aridius_news_review_guest'];
		} else {
			$data['module_aridius_news_review_guest'] = $this->config->get('module_aridius_news_review_guest');
		}
		
		if (isset($this->request->post['module_aridius_news_status_review'])) {
			$data['module_aridius_news_status_review'] = $this->request->post['module_aridius_news_status_review'];
		} else {
			$data['module_aridius_news_status_review'] = $this->config->get('module_aridius_news_status_review');
		}
		
		if (isset($this->request->post['module_aridius_news_display_captcha'])) {
			$data['module_aridius_news_display_captcha'] = $this->request->post['module_aridius_news_display_captcha'];
		} else {
			$data['module_aridius_news_display_captcha'] = $this->config->get('module_aridius_news_display_captcha');
		}
		
		if (isset($this->request->post['module_aridius_news_display_answer_button'])) {
			$data['module_aridius_news_display_answer_button'] = $this->request->post['module_aridius_news_display_answer_button'];
		} else {
			$data['module_aridius_news_display_answer_button'] = $this->config->get('module_aridius_news_display_answer_button');
		}
		
		if (isset($this->request->post['module_aridius_news_limite_page'])) {
			$data['module_aridius_news_limite_page'] = $this->request->post['module_aridius_news_limite_page'];
		} elseif ($this->config->get('module_aridius_news_limite_page')) {
			$data['module_aridius_news_limite_page'] = $this->config->get('module_aridius_news_limite_page');
		} else {
			$data['module_aridius_news_limite_page'] = 10;
		}
		
		if (isset($this->request->post['module_aridius_news_mail'])) {
			$data['module_aridius_news_mail'] = $this->request->post['module_aridius_news_mail'];
		} else {
			$data['module_aridius_news_mail'] = $this->config->get('module_aridius_news_mail');
		}
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/aridius_news', $data));
	}

	private function getList() {
		
		$this->load->language('extension/module/aridius_news');
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'nd.title';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/aridius_news', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['module'] = $this->url->link('extension/module/aridius_news', 'user_token=' . $this->session->data['user_token'], true);

		$data['insert'] = $this->url->link('extension/module/aridius_news/insert', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['reset'] = $this->url->link('extension/module/aridius_news/reset', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('extension/module/aridius_news/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$this->load->model('catalog/aridiusnews');
		$this->load->model('tool/image');

		$data['aridius_news'] = array();

		$data_info = array(
		'sort'  	=> $sort,
		'order' 	=> $order,
		'start' 	=> ($page - 1) * $this->config->get('config_limit_admin'),
		'limit' 		=> $this->config->get('config_limit_admin')
		);

		$aridius_news_total = $this->model_catalog_aridiusnews->getTotalaridius_news();

		$data['totalaridius_news'] = $aridius_news_total;

		$results = $this->model_catalog_aridiusnews->getaridius_news($data_info);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
			'text'	=> $this->language->get('text_edit'),
			'href'	=> $this->url->link('extension/module/aridius_news/update', 'user_token=' . $this->session->data['user_token'] . '&aridius_news_id=' . $result['aridius_news_id'], true)
			);

			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}

			$data['aridius_news'][] = array(
			'aridius_news_id'		=> $result['aridius_news_id'],
			'title'				=> $result['title'],
			'image'			=> $image,
			'date_added'	=> date($this->language->get('date_format_short'), strtotime($result['date_added'])),
			'viewed'			=> $result['viewed'],
			'status'			=> $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
			'sort_order'     => $result['sort_order'],
			'selected'		=> isset($this->request->post['selected']) && in_array($result['aridius_news_id'], $this->request->post['selected']),
			'action'			=> $action
			);
		}
		


		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_title'] = $this->url->link('extension/module/aridius_news/listing', 'user_token=' . $this->session->data['user_token'] . '&sort=nd.title' . $url, true);
		$data['sort_date_added'] = $this->url->link('extension/module/aridius_news/listing', 'user_token=' . $this->session->data['user_token'] . '&sort=n.date_added' . $url, true);
		$data['sort_viewed'] = $this->url->link('extension/module/aridius_news/listing', 'user_token=' . $this->session->data['user_token'] . '&sort=n.viewed' . $url, true);
		$data['sort_status'] = $this->url->link('extension/module/aridius_news/listing', 'user_token=' . $this->session->data['user_token'] . '&sort=n.status' . $url, true);
		$data['sort_sort_order'] = $this->url->link('extension/module/aridius_news/listing', 'user_token=' . $this->session->data['user_token'] . '&sort=n.sort_order' . $url, true);
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $aridius_news_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('extension/module/aridius_news/listing', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);
		
		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($aridius_news_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($aridius_news_total - $this->config->get('config_limit_admin'))) ? $aridius_news_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $aridius_news_total, ceil($aridius_news_total / $this->config->get('config_limit_admin')));
		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/news/aridius_list', $data));
	}

	public function autocomplete() {
		
		$json = array();

		if (isset($this->request->get['filter_aname'])) {
			$this->load->model('catalog/aridiusnews');

			if (isset($this->request->get['filter_aname'])) {
				$filter_name = $this->request->get['filter_aname'];
			} else {
				$filter_name = '';
			}

			$data = array(
			'filter_name'  => $filter_name,
			'start'        => 0,
			'limit'        => 20
			);

			$results = $this->model_catalog_aridiusnews->getaridius_news($data);

			foreach ($results as $result) {
				
				$json[] = array(
				'aridius_news_id'    => $result['aridius_news_id'],
				'title'      => strip_tags(html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8'))
				);	
			}
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	private function getForm() {
	
		$this->load->language('extension/module/aridius_news');

		$this->load->model('catalog/aridiusnews');
$data['user_token'] = $this->session->data['user_token'];	

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['title'])) {
			$data['error_title'] = $this->error['title'];
		} else {
			$data['error_title'] = '';
		}

		if (isset($this->error['description'])) {
			$data['error_description'] = $this->error['description'];
		} else {
			$data['error_description'] = '';
		}
		
		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/aridius_news', 'user_token=' . $this->session->data['user_token'], true)
		);

		if (!isset($this->request->get['aridius_news_id'])) {
			$data['action'] = $this->url->link('extension/module/aridius_news/insert', 'user_token=' . $this->session->data['user_token'], true);
		} else {
			$data['action'] = $this->url->link('extension/module/aridius_news/update', 'user_token=' . $this->session->data['user_token'] . '&aridius_news_id=' . $this->request->get['aridius_news_id'], true);
		}

		$data['cancel'] = $this->url->link('extension/module/aridius_news/listing', 'user_token=' . $this->session->data['user_token'], true);


		if ((isset($this->request->get['aridius_news_id'])) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$aridius_news_info = $this->model_catalog_aridiusnews->getaridius_newsStory($this->request->get['aridius_news_id']);
		}

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['aridius_news_description'])) {
			$data['aridius_news_description'] = $this->request->post['aridius_news_description'];
		} elseif (isset($this->request->get['aridius_news_id'])) {
			$data['aridius_news_description'] = $this->model_catalog_aridiusnews->getaridius_newsDescriptions($this->request->get['aridius_news_id']);
		} else {
			$data['aridius_news_description'] = array();
		}

		$this->load->model('setting/store');

		$data['stores'] = array();
		
		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->language->get('text_default')
		);
		
		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$data['stores'][] = array(
				'store_id' => $store['store_id'],
				'name'     => $store['name']
			);
		}

		if (isset($this->request->post['aridius_news_store'])) {
			$data['aridius_news_store'] = $this->request->post['aridius_news_store'];
		} elseif (isset($this->request->get['aridius_news_id'])) {
			$data['aridius_news_store'] = $this->model_catalog_aridiusnews->getaridius_newsStores($this->request->get['aridius_news_id']);
		} else {
			$data['aridius_news_store'] = array(0);
		}

		if (isset($this->request->post['aridius_news_seo_url'])) {
			$data['aridius_news_seo_url'] = $this->request->post['aridius_news_seo_url'];
		} elseif (isset($this->request->get['aridius_news_id'])) {
			$data['aridius_news_seo_url'] = $this->model_catalog_aridiusnews->getaridius_newsSeoUrls($this->request->get['aridius_news_id']);
		} else {
			$data['aridius_news_seo_url'] = array();
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (isset($aridius_news_info)) {
			$data['status'] = $aridius_news_info['status'];
		} else {
			$data['status'] = '';
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($aridius_news_info)) {
			$data['sort_order'] = $aridius_news_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if (isset($this->request->post['date_added'])) {
			$data['date_added'] = $this->request->post['date_added'];
		} elseif (!empty($aridius_news_info)) {
			$data['date_added'] = $aridius_news_info['date_added'];
		} else {
			$data['date_added'] = date('Y-m-d');
		}
		
		if (isset($this->request->post['aridius_news_related'])) {
			$products = $this->request->post['aridius_news_related'];
		} elseif (isset($this->request->get['aridius_news_id'])) {		
			$products = $this->model_catalog_aridiusnews->getaridius_newsRelated($this->request->get['aridius_news_id']);
		} else {
			$products = array();
		}
		
		$data['aridius_news_related'] = array();
		
		$this->load->model('catalog/product');
		foreach ($products as $product_id) {
			$related_info = $this->model_catalog_product->getProduct($product_id);
			
			if ($related_info) {
				$data['aridius_news_related'][] = array(
				'product_id' => $related_info['product_id'],
				'name'       => $related_info['name']
				);
			}
		}

		if (isset($this->request->post['aridius_news_aridius_newsrelated'])) {
			$aridius_newsrelated = $this->request->post['aridius_news_aridius_newsrelated'];
		} elseif (isset($this->request->get['aridius_news_id'])) {		
			$aridius_newsrelated = $this->model_catalog_aridiusnews->getaridius_newsaridius_newsrelated($this->request->get['aridius_news_id']);
		} else {
			$aridius_newsrelated = array();
		}
		

		
			$data['aridius_news_aridius_newsrelated'] = array();
		
		foreach ($aridius_newsrelated as $narticle_id) {
			$article_related_info = $this->model_catalog_aridiusnews->getaridius_related_news($narticle_id);
			
			if ($article_related_info) {
				$data['aridius_news_aridius_newsrelated'][] = array(
				'aridius_news_id' => $article_related_info['aridius_news_id'],
				'title'       => $article_related_info['title']
				);
			}
		}	
		
		
		

		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($aridius_news_info)) {
			$data['image'] = $aridius_news_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($aridius_news_info) && is_file(DIR_IMAGE . $aridius_news_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($aridius_news_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/news/aridius_form', $data));
	}

	private function validate() {
		
		if (!$this->user->hasPermission('modify', 'extension/module/aridius_news')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['module_aridius_news_home_chars']) {
			$this->error['aridius_news_home_chars'] = $this->language->get('error_home_numchars');
		}
		
		if (!$this->request->post['module_aridius_news_home_limit']) {
			$this->error['aridius_news_home_limit'] = $this->language->get('error_home_limit');
		}
		if (!$this->request->post['module_aridius_news_headline_chars']) {
			$this->error['aridius_news_headline_chars'] = $this->language->get('error_headline_chars');
		}
		
		if (!$this->request->post['module_aridius_news_thumb_width'] || !$this->request->post['module_aridius_news_thumb_width']) {
			$this->error['aridius_newspage_thumb'] = $this->language->get('error_aridius_newspage_thumb');
		}
		
		if (!$this->request->post['module_aridius_news_width'] || !$this->request->post['module_aridius_news_width']) {
			$this->error['aridius_thumb'] = $this->language->get('error_aridius_newspage_thumb');
		}
		   
		
		if (!$this->request->post['module_aridius_news_simwidth'] || !$this->request->post['module_aridius_news_simwidth']) {
			$this->error['aridius_simthumb'] = $this->language->get('error_aridius_newspage_thumb');
		}
		
		if (!$this->request->post['module_aridius_news_limite_page']) {
			$this->error['review_limit'] = $this->language->get('error_limite');
		}
		

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateForm() {
		
		if (!$this->user->hasPermission('modify', 'extension/module/aridius_news')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['aridius_news_description'] as $language_id => $value) {

			if ((strlen($value['title']) < 3) || (strlen($value['title']) > 250)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}

			if (strlen($value['description']) < 3) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
			}

		}
		
		if ($this->request->post['aridius_news_seo_url']) {
			$this->load->model('design/seo_url');
			
			foreach ($this->request->post['aridius_news_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						if (count(array_keys($language, $keyword)) > 1) {
							$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_unique');
						}						
						
						$seo_urls = $this->model_design_seo_url->getSeoUrlsByKeyword($keyword);
						
						foreach ($seo_urls as $seo_url) {
							if (($seo_url['store_id'] == $store_id) && (!isset($this->request->get['aridius_news_id']) || ($seo_url['query'] != 'aridius_news_id=' . $this->request->get['aridius_news_id']))) {
								$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_keyword');
							}
						}
					}
				}
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		
		if (!$this->user->hasPermission('modify', 'extension/module/aridius_news')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateReset() {
		
		if (!$this->user->hasPermission('modify', 'extension/module/aridius_news')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function install() {
		
		// create aridius_news table
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "aridius_news`");
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "aridius_news` (`aridius_news_id` int(11) NOT NULL AUTO_INCREMENT, `image` varchar(255) DEFAULT NULL, `date_added` datetime NOT NULL, `viewed` int(11) NOT NULL DEFAULT '0', `sort_order` int(3) NOT NULL DEFAULT '0', `status` tinyint(1) NOT NULL, PRIMARY KEY (`aridius_news_id`)) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		// create aridius_news description table
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "aridius_news_description`");
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "aridius_news_description` (`aridius_news_id` int(11) NOT NULL, `language_id` int(11) NOT NULL, `title` varchar(255) NOT NULL, `meta_description` VARCHAR(255) NOT NULL, `meta_title` VARCHAR(255) NOT NULL, `description` text CHARACTER SET utf8 NOT NULL, `meta_keyword` varchar(255) NOT NULL,  PRIMARY KEY (`aridius_news_id`,`language_id`)) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		// create aridius_news store table
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "aridius_news_to_store`");
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "aridius_news_to_store` (`aridius_news_id` int(11) NOT NULL, `store_id` int(11) NOT NULL, PRIMARY KEY (`aridius_news_id`,`store_id`)) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		// create aridius_news related table
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "aridius_news_related`");	
		$this->db->query("CREATE TABLE IF NOT EXISTS ". DB_PREFIX . "aridius_news_related (`aridius_news_id` int(11) NOT NULL, `related_aridius_news_id` int(11) NOT NULL, PRIMARY KEY (`aridius_news_id`,`related_aridius_news_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin");
		// create aridius_news product related table	
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "aridius_news_product_related`");	
		$this->db->query("CREATE TABLE IF NOT EXISTS ". DB_PREFIX . "aridius_news_product_related (`aridius_news_id` int(11) NOT NULL,`product_id` int(11) NOT NULL,PRIMARY KEY (`aridius_news_id`,`product_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin");
		// seo
		
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		foreach ($languages as $language) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "seo_url` (query, keyword, language_id) VALUES ('information/aridius_news', 'all-news', '".(int)$language['language_id']."' )");	
      }

		// create aridius_review table
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "aridius_review_news`");
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "aridius_review_news` (`review_id` int(11) NOT NULL AUTO_INCREMENT, `parent_id` int(11) NOT NULL, `customer_id` int(11) NOT NULL, `news_id` int(11) NOT NULL, `author` varchar(64) NOT NULL, `text` text NOT NULL, `status` tinyint(1) NOT NULL DEFAULT '0', `date_added` datetime NOT NULL, `date_modified` datetime NOT NULL, PRIMARY KEY (`review_id`)) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
		
		// check aridius_news layout name
		$sql = "SELECT layout_id FROM `" . DB_PREFIX . "layout` WHERE `name` LIKE 'News' LIMIT 1";

		$query_name = $this->db->query($sql);

		if ($query_name->num_rows == 0) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "layout` SET `name`= 'News'");
		}

		// check aridius_news layout route by store
		$stores = array(0);

		$sql = "SELECT store_id FROM `" . DB_PREFIX . "store`";

		$query_store = $this->db->query($sql);

		foreach ($query_store->rows as $store) {
			$stores[] = $store['store_id'];
		}

		$newRoutes = array('information/aridius_news');

		foreach ($newRoutes as $newRoute) {
			foreach ($stores as $store_id) {
				$sql = "SELECT layout_id FROM `" . DB_PREFIX . "layout_route` WHERE `store_id`= '" . (int)$store_id . "' AND `route` LIKE '" . $newRoute . "' LIMIT 1";

				$query = $this->db->query($sql);

				if ($query->num_rows == 0) {
					$this->db->query("INSERT INTO `" . DB_PREFIX . "layout_route` SET `layout_id`= (SELECT layout_id FROM `" . DB_PREFIX . "layout` WHERE `name` LIKE 'News' LIMIT 1), `store_id`='" . (int)$store_id . "', `route`='" . $newRoute . "'");
				}
			}
		}
	}
}
