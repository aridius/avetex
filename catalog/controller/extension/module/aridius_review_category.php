<?php
class ControllerExtensionModuleAridiusReviewCategory extends Controller {

	public function index($setting) {
		
		$this->load->language('extension/module/aridius_review_category');
		$this->load->model('extension/module/aridiusstorereview');

        $data['aridius_newslist'] = $this->url->link('information/aridius_news');

	    $chars = $this->config->get('module_aridius_review_category_chars');

	   		$data['navigation'] = $this->config->get('module_aridius_review_category_navigation');
	   		$data['limit'] = $this->config->get('module_aridius_review_category_limit');
	   		$data['autoplay'] = $this->config->get('module_aridius_review_category_autoplay');
			$data['autoplay_on'] = $this->config->get('module_aridius_review_category_autoplayon');
	   		$data['items'] = $this->config->get('module_aridius_review_category_items');
			$data['rew_speed'] = $this->config->get('module_aridius_review_category_rew_speed');
			$data['stophover'] = $this->config->get('module_aridius_review_category_stop');
			$data['date'] = $this->config->get('module_aridius_review_category_date');
					
	    $data['aridius_rewlist'] = $this->url->link('extension/module/aridius_store_review');
		
		$data['reviews'] = array();
		
        $data['review_total'] = $this->model_extension_module_aridiusstorereview->getTotalReview();
		$review_total = $this->model_extension_module_aridiusstorereview->getTotalReview();
		
       	$data['rating_avr'] = $this->model_extension_module_aridiusstorereview->getTotalReviewAverage();
	   
	    $results = $this->model_extension_module_aridiusstorereview->getReviewsById();
		
			$one = 0;
            $two = 0;
            $three = 0;
            $four = 0;
            $five = 0;
            $rating_sum = 0;

	    foreach ($results as $result) {

		$aridius_review_length = strlen(utf8_decode($result['text']));

		if ($aridius_review_length > $chars) {
				$text = utf8_substr(strip_tags(html_entity_decode($result['text'], ENT_QUOTES, 'UTF-8')), 0, $chars) . '..';
				} else {
				$text = html_entity_decode($result['text'], ENT_QUOTES, 'UTF-8');
		}
			
            $data['reviews'][] = array(
                'author'     => $result['author'],
                'review_id'  => $result['review_id'],
                'text'       => $text,
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


		return $this->load->view('extension/module/aridius_review_category', $data);
	}
}