<?php
class ControllerExtensionModuleAridiusCategoryfooter extends Controller {
	
	public function index() {

		$check=array();
	    $check = $this->config->get('module_aridius_category_footer_visible');

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['category_id'] = $parts[0];
		} else {
			$data['category_id'] = 0;
		}

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {

			$filter_data = array(
				'filter_category_id'  => $category['category_id'],
				'filter_sub_category' => true
			);
            if (isset($check) && (in_array($category['category_id'], $check ))) {	
			$data['categories'][] = array(
				'category_id' => $category['category_id'],
		
				'name'        => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
			);
		  }
        }
	
		return $this->load->view('extension/module/aridius_category_footer', $data);
	}
}