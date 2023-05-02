<?php
class ControllerExtensionModuleAridiusNews extends Controller {
	
		public function loadMore() {

		if (isset($this->request->post['setting'])) {
		$setting = unserialize(base64_decode($this->request->post['setting']));
		}
		
		$results_product = $this->index($setting);

		$this->response->setOutput($results_product);
		
	}

	public function index($setting) {
		
		static $module_id = 0;	

		$this->load->language('extension/module/aridius_news');

		$data['header'] = $this->config->get('module_aridius_news_header');

		$setting['limit'] = $this->config->get('module_aridius_news_home_limit');
        $setting['numchars']= $this->config->get('module_aridius_news_home_chars');
        $data['limit']  = $this->config->get('module_aridius_news_home_limit');
	    
		$this->load->model('catalog/aridiusnews');
		$this->load->model('tool/image');
			
		$data['aridius_news_count'] = $this->model_catalog_aridiusnews->getTotalaridius_news();

		$data['aridius_news_limit'] = $setting['limit'];

		$data['aridius_news_show_date'] = $this->config->get('module_aridius_news_show_date');
		$data['aridius_news_show_img'] = $this->config->get('module_aridius_news_show_img');
		$data['aridius_news_show_description'] = $this->config->get('module_aridius_news_show_description');
		$data['aridius_news_home_limit'] = $this->config->get('module_aridius_news_home_limit');
        $data['deluxe_lazy'] = $this->config->get('theme_deluxe_lazy');
		$data['width'] = $this->config->get('module_aridius_news_thumb_width');
		$data['height'] = $this->config->get('module_aridius_news_thumb_height');

		$page = 1;

		if(isset($this->request->post['page'])) {
			$page = $this->request->post['page'];
		} else {
			$page = 1;
		}		

		if ($data['aridius_news_count'] > $data['aridius_news_limit']) {
			$data['showbutton'] = true;
		} else {
			$data['showbutton'] = false;
		}

		$data['aridius_newslist'] = $this->url->link('information/aridius_news');

		$data['show_headline'] = $this->config->get('module_aridius_news_headline_module');

		$data['numchars'] = $setting['numchars'];

		if (isset($data['numchars'])) {
			$chars = $data['numchars'];
		} else {
			$chars = 100;
		}

		$data['aridius_news'] = array();
		
		$data['product_total'] = $this->model_catalog_aridiusnews->getTotalaridius_news();
        $data['last_page'] = ceil($data['product_total'] / $this->config->get('module_aridius_news_home_limit'));
		
		$results = array();
		
		$get_results = $this->model_catalog_aridiusnews->getaridius_newsShort((int)$setting['limit'] * $data['product_total']);

		$product_pages = array_chunk($get_results, (int)$setting['limit']);

			        if (!empty($product_pages[$page - 1])) {
					    foreach ($product_pages[$page - 1] as $product_id) {
	                     $results[] = $product_id;
					    }  
			        }

		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $this->config->get('module_aridius_news_thumb_width'), $this->config->get('module_aridius_news_thumb_height'));     
			} else {
				$image = false;
			}

			$aridius_news_length = strlen(utf8_decode($result['description']));

			if ($aridius_news_length > $chars) {
				$description = utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $chars) . '..';
			} else {
				$description = html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8');
			}

			$data['aridius_news'][] = array(
				'title'        		=> $result['title'],
				'image'			=> $image,
				'description'	=> $description,
				'href'         		=> $this->url->link('information/aridius_news', 'aridius_news_id=' . $result['aridius_news_id']),
				'posted'   		=> date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}
		
		if(isset($this->request->post['module_id'])) {
			$data['module_id'] = $this->request->post['module_id'];
		} else {
			$data['module_id'] = $module_id++;
		}
		
		$setting['name'] = '';
	    $data['setting'] = base64_encode(serialize($setting));	

       return $this->load->view('extension/module/aridius_news', $data);
	
	}
}
