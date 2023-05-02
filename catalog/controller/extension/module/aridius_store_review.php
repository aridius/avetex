<?php
class ControllerExtensionModuleAridiusStoreReview extends Controller {

    public function index() {
    
        $this->load->language('extension/module/aridius_store_review');
		
        $this->load->model('extension/module/aridiusstorereview');

		
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
		
        $this->document->setTitle($this->language->get('heading_title'));
		
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );
		
        $url = '';
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/aridius_store_review', $url)
        );

		$this->document->setTitle($this->config->get('module_aridius_store_review_meta_title')[(int)$this->config->get('config_language_id')]);	
		$this->document->setDescription($this->config->get('module_aridius_store_review_meta_description')[(int)$this->config->get('config_language_id')]);	
		$this->document->setKeywords($this->config->get('module_aridius_store_review_meta_keyword')[(int)$this->config->get('config_language_id')]);

        $data['text_login'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true));
		$data['aridius_store_review_default_rating'] = $this->config->get('module_aridius_store_review_default_rating');
		$data['aridius_store_review_status'] = $this->config->get('module_aridius_store_review_status');
		$data['aridius_store_review_display_answer_button'] = $this->config->get('module_aridius_store_review_display_answer_button');
		$data['aridius_store_review_display_average_rating'] = $this->config->get('module_aridius_store_review_display_average_rating');
		$data['aridius_store_review_review_guest'] = $this->config->get('module_aridius_store_review_review_guest');
		
		$limit = $this->config->get('module_aridius_store_review_limite_page');
		
        $data['reviews'] = array();
		
        $review_total = $this->model_extension_module_aridiusstorereview->getTotalReview();
		
        $results = $this->model_extension_module_aridiusstorereview->getReviewsById2();
		
		    $one = 0;
            $two = 0;
            $three = 0;
            $four = 0;
            $five = 0;
            $rating_sum = 0;
		
		$data['rating_avr'] =$this->model_extension_module_aridiusstorereview->getTotalReviewAverage();
	
		
        foreach ($results as $result) {
			
            $parent = $this->model_extension_module_aridiusstorereview->getReviewsById(0,10,$result['review_id']);
            $parent_reviews=array();
			
            foreach($parent as $parents){
            $parent_reviews[] = array(
                'author'     => $parents['author'],
                'review_id'  => $parents['review_id'],
                'text'       => nl2br($parents['text']),
                'rating'     => (int)$parents['rating'],
                'date_added' => date($this->language->get('date_format_short'), strtotime($parents['date_added']))
                );
            }
			
            $data['reviews'][] = array(
                'author'     => $result['author'],
                'parent'     => $parent_reviews,
                'review_id'  => $result['review_id'],
                'text'       => nl2br($result['text']),
                'rating'     => (int)$result['rating'],
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
            );
			
			    ($result['rating'] == '1') && $one++;
                ($result['rating'] == '2') && $two++;
                ($result['rating'] == '3') && $three++;
                ($result['rating'] == '4') && $four++;
                ($result['rating'] == '5') && $five++;

        }
		
		if ($review_total) {
            $data['stack_rating'][] = array(
                'one' => round((100/$review_total) * $one),
                'two' => round((100/$review_total) * $two),
                'three' => round((100/$review_total) * $three),
                'four' => round((100/$review_total) * $four),
                'five' => round((100/$review_total) * $five),
                'total' => $review_total
            );
		} else {
			 $data['stack_rating'][] = array(
                'one' => $one,
                'two' => $two,
                'three' => $three,
                'four' => $four,
                'five' => $five,
                'total' => $review_total
            );
		  }

        $pagination = new Pagination();
        $pagination->total = $review_total;
        $pagination->page = $page;
        $pagination->limit = $limit;
        $pagination->url = $this->url->link('extension/module/aridius_store_review', $url . '&page={page}');
        
		$data['pagination'] = $pagination->render();
        
		$data['results'] = sprintf($this->language->get('text_pagination'), ($review_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($review_total - $limit)) ? $review_total : ((($page - 1) * $limit) + $limit), $review_total, ceil($review_total / $limit));
		
		// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
			if ($page == 1) {
			    $this->document->addLink($this->url->link('extension/module/aridius_store_review', '', true), 'canonical');
			} elseif ($page == 2) {
			    $this->document->addLink($this->url->link('extension/module/aridius_store_review', '', true), 'prev');
			} else {
			    $this->document->addLink($this->url->link('extension/module/aridius_store_review', $url . '&page='. ($page - 1), true), 'prev');
			}

			if ($limit && ceil($review_total / $limit) > $page) {
			    $this->document->addLink($this->url->link('extension/module/aridius_store_review', $url . '&page='. ($page + 1), true), 'next');
			}

		    if (($this->config->get('module_aridius_store_review_review_guest') !=1) || $this->customer->isLogged()) {
				$data['review_guest'] = true;
			} else {
				$data['review_guest'] = false;
			}

			if ($this->customer->isLogged()) {
				$data['customer_name'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();
			} else {
				$data['customer_name'] = '';
			}

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && ($this->config->get('module_aridius_store_review_display_captcha')!=1)) {
				$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'), $this->error);
		} else {
				$data['captcha'] = '';
		}

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');
		
		$this->response->setOutput($this->load->view('extension/module/aridius_store_review', $data));
		
    }
	
    public function reply(){
		
        $json=array();
		
        $this->load->language('extension/module/aridius_store_review');
		

		$data['text_login'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true));
        
		$data['parent']=(int)$this->request->post['parent'];

		 if (($this->config->get('module_aridius_store_review_review_guest') !=1) || $this->customer->isLogged()) {
				$data['review_guest'] = true;
		} else {
				$data['review_guest'] = false;
		}
		
		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && ($this->config->get('module_aridius_store_review_display_captcha')!=1)) {
				$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'), $this->error);
		} else {
				$data['captcha'] = '';
		}
			
		if (($this->config->get('module_aridius_store_review_review_guest') !=1) || $this->customer->isLogged()) {
				$data['review_guest'] = true;
		} else {
				$data['review_guest'] = false;
		}

		if ($this->customer->isLogged()) {
				$data['customer_name'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();
		} else {
				$data['customer_name'] = '';
		}
		
		$json['html'] = ($this->load->view('extension/module/aridius_store_review_form', $data));

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
	
    public function write(){
    
        $this->load->language('extension/module/aridius_store_review');
		
        $json = array();
		
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
                $json['error'] = $this->language->get('error_name');
            }
			
            if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
                $json['error'] = $this->language->get('error_text');
            }
			
            if ($this->request->post['parent']==0 && (empty($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5)) {
                $json['error'] = $this->language->get('error_rating');
            }
			
			// Captcha
		    if ($this->config->get($this->config->get('config_captcha') . '_status') && ($this->config->get('aridius_store_review_display_captcha')!=1)) {
			  $captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');

			   if ($captcha) {
				$this->error['captcha'] = $captcha;
			   }
		   }

            if (!isset($json['error'])) {
                $this->load->model('extension/module/aridiusstorereview');
                $this->model_extension_module_aridiusstorereview->addReview($this->request->post);
                $json['success'] = $this->language->get('text_success');
            }
        }
		
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
