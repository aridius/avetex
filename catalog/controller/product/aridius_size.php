<?php
class ControllerProductAridiusSize extends Controller {

public function index() {

		$this->load->model('catalog/aridiussize');
		
		if (isset($this->request->get['product_id'])) {
			$product_id = (int)$this->request->get['product_id'];
		} else {
			$product_id = 0;
		}

		$size_info = $this->model_catalog_aridiussize->getSizeProduct($product_id);
		if(!$size_info) {
			$size_info = $this->model_catalog_aridiussize->getSizeCategory($product_id);
		}

        if($size_info) {
		$data['aridius_size_name'] = $size_info['name'];
		$data['aridius_size_description'] = html_entity_decode($size_info['description'], ENT_QUOTES, 'UTF-8');
        }else{
		$data['aridius_size_name'] = '';
		$data['aridius_size_description'] = '';
        }

   return $this->load->view('product/aridius_size', $data);



	}
}