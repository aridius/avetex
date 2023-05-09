<?php
class ControllerExtensionModuleAridiusCatWall2 extends Controller {
	
    public function index($setting) {

        $this->load->language('extension/module/aridius_catwall2');

		
		$check=array();
	    $check = $setting['aridius_catwall2_cat'];
		
		
		
		

		
		$data['child_visible'] = $setting['child_visible'];
		$data['col_xs'] = $setting['col_xs'];
		$data['col_sm'] = $setting['col_sm'];
		$data['col_md'] = $setting['col_md'];
		$data['col_lg'] = $setting['col_lg'];
		$data['add_img'] = $setting['add_img'];
		$data['slides1'] = $setting['slides1'];
		$data['slides2'] = $setting['slides2'];
		$data['slides3'] = $setting['slides3'];
		$data['slides4'] = $setting['slides4'];
		$data['variant'] = $setting['variant'];
		$data['width'] = $setting['width'];
		$data['height'] = $setting['height'];
	 
	    $data['deluxe_lazy'] = $this->config->get('theme_deluxe_lazy');
		
		
        if (isset($this->request->get['path'])) {
            $parts = explode('_', (string) $this->request->get['path']);
        } else {
            $parts = array();
        }
		
        if (isset($parts[0])) {
            $data['manufacturer_id'] = $parts[0];
        } else {
            $data['manufacturer_id'] = 0;
        }
		
        if (isset($parts[1])) {
            $data['child_id'] = $parts[1];
        } else {
            $data['child_id'] = 0;
        }

    if ($this->config->get('theme_deluxe_see_amenu')==1) {
			$this->load->model('catalog/manufacturer');
        $this->load->model('catalog/category');
        $this->load->model('catalog/product');
        $data['categories'] = array();
        $categories = $this->model_catalog_manufacturer->getManufacturers();
		
		
	
		
		
        $this->load->model('tool/image');

        foreach ($categories as $category) {
				
		
		
		    if ($category['image']) {
                $image = $this->model_tool_image->resize($category['image'], $setting['width'], $setting['height']);
            } else {
                $image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
            }	
			




					
		if (isset($check) && (in_array($category['manufacturer_id'], $check ))) {	
                $data['categories'][] = array(
                'name' => $category['name']. ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),				
				
				 'image' => $image,
               	'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $category['manufacturer_id'])
            );
		       }
        }

		} else {  
	  
	  
	  
	  
	  
	  
	  
		$data['categories'] = array();
		$this->load->model('catalog/aridiusmenu');
		$categories = $this->model_catalog_aridiusmenu->getCategories(0);

	foreach ($categories as $category) {
		if ($category['image']) {
		$image_main = $this->model_tool_image->resize($category['image'],$this->config->get('theme_deluxe_photos_width_image_main'), $this->config->get('theme_deluxe_photos_height_image_main'));
		} else {
		$image_main = '';
		};
		
		if ($category['image_menu_ico']) {
			$image_menu_icol = $this->model_tool_image->resize($category['image_menu_ico'],22, 22);
			} else {		
			$image_menu_icol = '';
		};
		
		// Level 2
		$children_data = array();
		$children = $this->model_catalog_aridiusmenu->getCategories($category['aridiusmenu_id']);
		
	foreach (array_slice($children, 0, ($setting['limit_child'])) as $child) {
		if ($child['image']) {
		$image = $this->model_tool_image->resize($child['image'],$this->config->get('theme_deluxe_photos_width_image_main'), $this->config->get('theme_deluxe_photos_height_image_main'));
		} else {
		$image = '';
		};
		
		$children_lv3_data = array();
		$children_lv3 = $this->model_catalog_aridiusmenu->getCategories($child['aridiusmenu_id']);
		
		foreach ($children_lv3 as $child_lv3) {
		$children_lv3_data[] = array(
		'name'     => $child_lv3['name'],
		'href' => $child_lv3['url'],
		'manufacturer_id' => $child_lv3['aridiusmenu_id'],
		);
		}
		
		if ($child['image']) {
		$img_lv2 = $this->model_tool_image->resize($child['image'],$this->config->get('theme_deluxe_photos_menu_width'), $this->config->get('theme_deluxe_photos_menu_height'));
		} else {
		$img_lv2 = '';
		};
		
		$children_data[] = array(
		'stickers'     => $child['stickers'],
		'sister_id' => $children_lv3_data,
		'manufacturer_id' => $child['aridiusmenu_id'],
		'image2' => $img_lv2,
		'image_menu_ico2'     => '',
		'name'     => $child['name'],
		'href' => $child['url'],
		'image' => $image
		);
		}
		
		if ($category['image']) {
                $image_main = $this->model_tool_image->resize($category['image'], $setting['width'], $setting['height']);
        } else {
                $image_main = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
        }	
		
		// Level 1
		$data['categories'][] = array(
		'top'     => 1,
		'manufacturer_id' => $category['aridiusmenu_id'],
		'image_main' => $image_main,
		'image_menu_icol' => $image_menu_icol,
		'stickers'     => $category['stickers'],
		'children' => $children_data,
		'name'     => $category['name'],
		'column'   => $category['columnn'] ? $category['columnn'] : 1,
		'href' => $category['url'],
		'image' => $image_main
		);
	}	  
	};
		return $this->load->view('extension/module/aridius_catwall2', $data);
    }
}