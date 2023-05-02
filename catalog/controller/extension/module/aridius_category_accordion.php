 <?php
class ControllerExtensionModuleAridiusCategoryaccordion extends Controller
{
    public function index()
    {
        $this->load->language('extension/module/aridius_category_accordion');

        $data['language_id']         = $this->config->get('config_language_id');
        $data['deluxe_menu_special'] = $this->config->get('deluxe_menu_special');
        $data['deluxe_link_special'] = $this->config->get('deluxe_link_special');
        $check                       = array();
        $check                       = $this->config->get('module_aridius_category_accordion_child_visible');
        if (isset($this->request->get['path'])) {
            $parts = explode('_', (string) $this->request->get['path']);
        } else {
            $parts = array();
        }
        if (isset($parts[0])) {
            $data['category_id'] = $parts[0];
        } else {
            $data['category_id'] = 0;
        }
        if (isset($parts[1])) {
            $data['child_id'] = $parts[1];
        } else {
            $data['child_id'] = 0;
        }
        if (isset($parts[2])) {
            $data['sisters_id'] = $parts[2];
        } else {
            $data['sisters_id'] = 0;
        }
        if ($this->config->get('theme_deluxe_see_amenu') == 1) {
            $this->load->model('catalog/category');
            $this->load->model('catalog/product');
            $data['categories'] = array();
            $categories         = $this->model_catalog_category->getCategories(0);
            foreach ($categories as $category) {
                $children_data = array();
                $sister_data   = array();
                $children      = $this->model_catalog_category->getCategories($category['category_id']);
                foreach ($children as $child) {
                    $filter_data = array(
                        'filter_category_id' => $child['category_id'],
                        'filter_sub_category' => true
                    );
                    $sister_data = array();
                    $sisters     = $this->model_catalog_category->getCategories($child['category_id']);
                    if ($sisters) {
                        foreach ($sisters as $sisterMember) {
                            $child_filter_data = array(
                                'filter_category_id' => $sisterMember['category_id'],
                                'filter_sub_category' => true
                            );
                            if (isset($check) && (in_array($category['category_id'], $check))) {
                                $sister_data[] = array(
                                    'category_id' => $sisterMember['category_id'],
                                    'name' => $sisterMember['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($child_filter_data) . ')' : ''),
                                    'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'] . '_' . $sisterMember['category_id'])
                                );
                            }
                        }
                        if (isset($check) && (in_array($category['category_id'], $check))) {
                            $children_data[] = array(
                                'category_id' => $child['category_id'],
                                'sister_id' => $sister_data,
                                'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
                                'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
                            );
                        }
                    } else {
                        if (isset($check) && (in_array($category['category_id'], $check))) {
                            $children_data[] = array(
                                'category_id' => $child['category_id'],
                                'sister_id' => '',
                                'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
                                'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
                            );
                        }
                    }
                }
                $filter_data = array(
                    'filter_category_id' => $category['category_id'],
                    'filter_sub_category' => true
                );
                if (isset($check) && (in_array($category['category_id'], $check))) {
                    $data['categories'][] = array(
                        'category_id' => $category['category_id'],
                        'name' => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
                        'children' => $children_data,
                        'sister' => $sister_data,
                        'href' => $this->url->link('product/category', 'path=' . $category['category_id'])
                    );
                }
            }
        } else {
            $data['categories'] = array();
            $this->load->model('catalog/aridiusmenu');
            $categories = $this->model_catalog_aridiusmenu->getCategories(0);
            foreach ($categories as $category) {
                if ($category['image']) {
                    $image_main = $this->model_tool_image->resize($category['image'], $this->config->get('deluxe_photos_width_image_main'), $this->config->get('deluxe_photos_height_image_main'));
                } else {
                    $image_main = '';
                }
                ;
                if ($category['image_menu_ico']) {
                    $image_menu_icol = $this->model_tool_image->resize($category['image_menu_ico'], 22, 22);
                } else {
                    $image_menu_icol = '';
                }
                ;
                // Level 2
                $children_data = array();
                $children      = $this->model_catalog_aridiusmenu->getCategories($category['aridiusmenu_id']);
                foreach ($children as $child) {
                    if ($child['image']) {
                        $image = $this->model_tool_image->resize($child['image'], $this->config->get('deluxe_photos_width_image_main'), $this->config->get('deluxe_photos_height_image_main'));
                    } else {
                        $image = '';
                    }
                    ;
                    $children_lv3_data = array();
                    $children_lv3      = $this->model_catalog_aridiusmenu->getCategories($child['aridiusmenu_id']);
                    foreach ($children_lv3 as $child_lv3) {
                        $children_lv3_data[] = array(
                            'name' => $child_lv3['name'],
                            'href' => $child_lv3['url'],
                            'category_id' => $child_lv3['aridiusmenu_id']
                        );
                    }
                    if ($child['image']) {
                        $img_lv2 = $this->model_tool_image->resize($child['image'], $this->config->get('deluxe_photos_menu_width'), $this->config->get('deluxe_photos_menu_height'));
                    } else {
                        $img_lv2 = '';
                    }
                    ;
                    $children_data[] = array(
                        'stickers' => $child['stickers'],
                        'sister_id' => $children_lv3_data,
                        'category_id' => $child['aridiusmenu_id'],
                        'image2' => $img_lv2,
                        'image_menu_ico2' => '',
                        'name' => $child['name'],
                        'href' => $child['url'],
                        'image' => $image
                    );
                }
                // Level 1
                $data['categories'][] = array(
                    'top' => 1,
                    'category_id' => $category['aridiusmenu_id'],
                    'image_main' => $image_main,
                    'image_menu_icol' => $image_menu_icol,
                    'stickers' => $category['stickers'],
                    'children' => $children_data,
                    'name' => $category['name'],
                    'column' => $category['columnn'] ? $category['columnn'] : 1,
                    'href' => $category['url'],
                    'image' => $image_main
                );
            }
        }
        ;
        return $this->load->view('extension/module/aridius_category_accordion', $data);
    }
} 