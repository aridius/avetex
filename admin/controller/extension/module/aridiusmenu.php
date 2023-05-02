	<?php
class ControllerExtensionModuleAridiusMenu extends Controller {
  
  private $error = array();
  public function index() {
		
	$this->load->language('extension/module/aridiusmenu');
	$this->document->setTitle($this->language->get('heading_title'));
	$this->load->model('setting/setting');
	
	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
	$this->model_setting_setting->editSetting('module_aridiusmenu', $this->request->post);
	$this->session->data['success'] = $this->language->get('text_success');
	$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], 'SSL'));
	}
	
	$this->load->model('localisation/language');
	
	$data['languages'] = $this->model_localisation_language->getLanguages();
	$data['user_token'] = $this->session->data['user_token'];
	
	if (isset($this->error['warning'])) {
	$data['error_warning'] = $this->error['warning'];
	} else {
	$data['error_warning'] = '';
	}
	
	if (isset($this->error['name'])) {
	$data['error_name'] = $this->error['name'];
	} else {
	$data['error_name'] = array();
	}
	
	$data['breadcrumbs'] = array();
	$data['breadcrumbs'][] = array(
	'text' => $this->language->get('text_home'),
	'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], 'SSL')
	);
	$data['breadcrumbs'][] = array(
	'text' => $this->language->get('text_module'),
	'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], 'SSL')
	);
	$data['breadcrumbs'][] = array(
	'text' => $this->language->get('heading_title'),
	'href' => $this->url->link('extension/module/aridiusmenu', 'user_token=' . $this->session->data['user_token'], 'SSL')
	);
	
	$this->load->model('tool/image');
	$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
	$data['action'] = $this->url->link('extension/module/aridiusmenu', 'user_token=' . $this->session->data['user_token'], 'SSL');
	$data['add'] = $this->url->link('extension/module/aridiusmenu/addMenu', 'user_token=' . $this->session->data['user_token'], 'SSL');
	$data['update'] = $this->url->link('extension/module/aridiusmenu/updateMenu', 'user_token=' . $this->session->data['user_token'], 'SSL');
	$data['editItem'] = $this->url->link('extension/module/aridiusmenu/editItem', 'user_token=' . $this->session->data['user_token'], 'SSL');
	$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], 'SSL');
	
	$data['header'] = $this->load->controller('common/header');
	$data['column_left'] = $this->load->controller('common/column_left');
	$data['footer'] = $this->load->controller('common/footer');
	
	$this->response->setOutput($this->load->view('extension/module/aridiusmenu', $data));
  }
	

  public function addItem(){
	  
	$this->load->model('catalog/aridiusmenu');
	$json = array();
	
	if(isset($this->request->post)){
	$this->model_catalog_aridiusmenu->addCategory($this->request->post);
	$json['success'] = $this->language->get('text_success');
	}
	$this->response->addHeader('Content-Type: application/json');
	$this->response->setOutput(json_encode($json));
  }

  public function updateMenu(){
	  
	$this->load->model('catalog/aridiusmenu');
	$json = array();
	
	if(isset($this->request->post)){
	$menu = $this->request->post['menu'];
	$this->model_catalog_aridiusmenu->sortOrderCategory($menu,0);
	$json['success'] = $this->language->get('text_success');
	}
	$this->response->addHeader('Content-Type: application/json');
	$this->response->setOutput(json_encode($json));
  }

  public function updateItem(){
	  
	$this->load->model('catalog/aridiusmenu');
	
	$json = array();
	
	if(isset($this->request->get['id']) && $this->request->post){
	$data['aridiusmenu_id'] = $this->request->get['id'];
	$data['menu'] = $this->request->post;
	
	if (isset($this->request->post['stickerst'])) {
	$data['stickerst'] = $this->request->post['stickerst'];
	} else {
	$data['stickerst'] = 0;
	}
	if (isset($this->request->post['columnnt'])) {
	$data['columnnt'] = $this->request->post['columnnt'];
	} else {
	$data['columnnt']= 0;
	}
	
	if (isset($this->request->post['topt'])) {
	$data['topt'] = $this->request->post['topt'];
	} else {
	$data['topt']= 0;
	}
	
	if (isset($this->request->post['imaget'])) {
	$data['imaget'] = $this->request->post['imaget'];
	} else {
	$data['imaget'] = "";
	}
	if (isset($this->request->post['image_menu_icot'])) {
	$data['image_menu_icot'] = $this->request->post['image_menu_icot'];
	} else {
	$data['image_menu_icot'] = "";
	}
	
	$this->model_catalog_aridiusmenu->updateCategory($data);
	$json['message'] = $this->language->get('text_success');
	}else{
	$json['message'] = $this->language->get('text_error');
	}
	
	$this->response->addHeader('Content-Type: application/json');
	$this->response->setOutput(json_encode($json));
  }
	
  public function deleteItem(){
	  
	$this->load->model('catalog/aridiusmenu');
	$json = array();
	
	if(isset($this->request->get['id'])){
	$aridiusmenu_id = $this->request->get['id'];
	$this->model_catalog_aridiusmenu->deleteCategory($aridiusmenu_id);
	$json['success'] = $this->language->get('text_success');
	}else{
	$json['error'] = $this->language->get('text_error');
	}
	
	$this->response->addHeader('Content-Type: application/json');
	$this->response->setOutput(json_encode($json));
  }


  public function deleteItemall(){
	  
	$this->load->model('catalog/aridiusmenu');
	$json = array();
	
    $this->model_catalog_aridiusmenu->deleteCategoryall();
	
	$this->response->addHeader('Content-Type: application/json');
	$this->response->setOutput(json_encode($json));
  }
  
   public function copyItemall(){
	  
	$this->load->model('catalog/aridiusmenu');
	$json = array();
	
    $this->model_catalog_aridiusmenu->copyCategoryall();
	
	$this->response->addHeader('Content-Type: application/json');
	$this->response->setOutput(json_encode($json));
  } 
  

  public function menuBuild(){
	  
	$this->load->model('catalog/aridiusmenu');
	$json = array();
	
	$results = $this->model_catalog_aridiusmenu->getMenu();
	$menu = array();
	foreach($results as $result){
	$aridiusmenu_title_data = array();
	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aridiusmenu_description WHERE aridiusmenu_id = '" . (int)$result['aridiusmenu_id'] . "'");
	foreach ($query->rows as $val) {
	$aridiusmenu_title_data[$val['language_id']] = array(
	'name'            => $val['name']
	);
	}
	$aridiusmenu_url_data = array();
	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "aridiusmenu_description WHERE aridiusmenu_id = '" . (int)$result['aridiusmenu_id'] . "'");
	foreach ($query->rows as $val) {
	$aridiusmenu_url_data[$val['language_id']] = array(
	'url'            => $val['url']
	);
	}
	
	$menu[] = array(
	'aridiusmenu_id' => $result['aridiusmenu_id'],
	'parent_id' => $result['parent_id'],
	'columnn' => $result['columnn'],
	'top' => $result['top'],
	'image' => $result['image'],
	'image_menu_ico' => $result['image_menu_ico'],
	'stickers' => $result['stickers'],
	'url' => $result['url'],
	'name' => $result['name'],
	'menu_title_data' => $aridiusmenu_title_data,
	'menu_url_data' => $aridiusmenu_url_data,
	);
	}
	
	$json['menu'] = $this->buildMenu($menu,0);
	echo $json['menu'];
  }
	
  public function buildMenu($menu, $parentid){
	  
	  
	$this->load->model('tool/image');
	$this->load->model('localisation/language');
	$languages = $this->model_localisation_language->getLanguages();
	$this->load->model('catalog/aridiusmenu');
	
	$this->load->language('extension/module/aridiusmenu');

	
	$menu_description = $this->model_catalog_aridiusmenu->getcustommenuDesc();
	$html = null;
	
	foreach ($menu as $item){
	if ($item['parent_id'] == $parentid) {
	$html .= '
	<li class="dd-item" data-id="' . $item['aridiusmenu_id'] . '">
	   <div class="dd-handle" id="' . $item['aridiusmenu_id'] . '">'. $item['name'] . '<span class="pull-right"><a class="btn btn-success btn-xs btn-edit btn-group dd-nodrag" style="cursor:pointer;" onclick="$(\'#item_'. $item['aridiusmenu_id'] .'\').css(\'display\',\'block\');" ><i class="fa fa-pencil"></i></a> <a style="cursor:pointer;" class="btn btn-danger btn-xs btn-edit btn-group btn-loading dd-nodrag" onclick="deleteItem(' . $item['aridiusmenu_id'] . ');"><i class="fa fa-trash-o"></i></a></span></div>
	   ';
	   if($item['menu_title_data']){
	   $html .= '
	   <div style="display:none;" class="row" id="item_'. $item['aridiusmenu_id'] .'">
		  <form id="form_' . $item['aridiusmenu_id'] . '" class="item_detail" >
			 ';
			 $html .= '
			 <div class="col-sm-12">';
					$html .= '<label class="control-label">' . $this->language->get('text_name') . '</label>';  
				$html .= '
			 </div>
			 ';
			 if (!empty($item['image']) && is_file(DIR_IMAGE . $item['image'])) {
			 $dthumb = $this->model_tool_image->resize($item['image'], 100, 100);
			 } else {
			 $dthumb =  $this->model_tool_image->resize('no_image.png', 100, 100);
			 }

			 if (!empty($item['image_menu_ico']) && is_file(DIR_IMAGE . $item['image_menu_ico'])) {
			 $dthumb2 = $this->model_tool_image->resize($item['image_menu_ico'], 100, 100);
			 } else {
			 $dthumb2 =  $this->model_tool_image->resize('no_image.png', 100, 100);
			 }
			 
			 $placeholder = $this->model_tool_image->resize('no_image.png', 100, 100);
			 foreach ($languages as $language) {
			 $html .= '
			 <div class="col-sm-12">
				';
				$html .= '
				<div class="input-group"><span class="input-group-addon"><img src="language/' . $language["code"] . '/' . $language['code'] . '.png' . '" title="' . $language['name'] . '" /></span>';
				   $html .= '<input type="text" name="information_menut[' . $language['language_id'] .'][name]" value="' . $menu_description[$item['aridiusmenu_id']][$language['language_id']]['name']. '" class="form-control" />';
				   $html .= '
				</div>
				';
				$html .= '
			 </div>
			 ';
			 }
			 $html .= '
			 <div class="col-sm-12">';
				$html .= '<label class="control-label">' . $this->language->get('text_url') . '</label>';  
				$html .= '
			 </div>
			 ';
			 foreach ($languages as $language) {
			 $html .= '
			 <div class="col-sm-12">
				';
				$html .= '
				<div class="input-group"><span class="input-group-addon"><img src="language/' . $language["code"] . '/' . $language['code'] . '.png' . '" title="' . $language['name'] . '" /></span>';
				   $html .= '<input type="text" name="information_menut[' . $language['language_id'] .'][url]" value="' . $menu_description[$item['aridiusmenu_id']][$language['language_id']]['url']. '" class="form-control" />';
				   $html .= '
				</div>
				';
				$html .= '
			 </div>
			 ';      
			 }
			 $html .= '
			 <div class="col-sm-12">';
				$html .= '<label class="control-label">' . $this->language->get('text_col') . '</label>';  
				$html .= '
			 </div>
			 ';
			 $html .= ' 
			 <div class="col-sm-12">';
				$html .= ' <input type="text" name="columnnt" value="'. $item['columnn'] . '" placeholder="" id="input-columnn' . $item['aridiusmenu_id'] . '" class="form-control" />';
				$html .= '
			 </div>
			 ';
			 $html .= ' 
			 
             <div class="col-sm-12">';
				$html .= '<label class="control-label">' . $this->language->get('text_top') . '</label>'; 
				$html .= '
			 </div>
			 ';
			 $html .= ' 			 
			 
			 
			 <div class="col-sm-12">
				';
				$html .= ' 
				<select name="topt" class="form-control">
				   ';
				   if ($item['top'] < 1) { $html .= '
				   <option value="0" selected="selected">no</option>
				   '; } else if ($item['top'] != 0) { $html .= '
				   <option value="0">no</option>
				   ';}
				   if ($item['top'] == 1) { $html .= '
				   <option value="1" selected="selected">yes</option>
				   '; } else if ($item['top'] != 1) { $html .= '
				   <option value="1">yes</option>
				   ';}
				   $html .= '
				</select>
				';
				$html .= '
			 </div>
			 ';
			 $html .= '
			 
			 <div class="col-sm-12">';
			 	$html .= '<label class="control-label">' . $this->language->get('text_img') . '</label>';  
				$html .= '
			 </div>
			 ';
			 $html .= ' 
			 <div class="col-sm-12"><a href="" id="thumb-imaget' . $item['aridiusmenu_id'] . '" data-toggle="image" class="img-thumbnail"><img src="'. $dthumb . '" alt="" title="" data-placeholder="'. $placeholder . '" /></a>';
				$html .= ' <input type="hidden" name="imaget" value="'. $item['image'] . '" id="input-imaget' . $item['aridiusmenu_id'] . '" />';
				$html .= ' 
			 </div>
			 ';
			 $html .= '

			 <div class="col-sm-12">';
				$html .= '<label class="control-label">' . $this->language->get('text_img2') . '</label>';  
				$html .= '
			 </div>
			 ';
			 $html .= ' 
			 <div class="col-sm-12"><a href="" id="thumb-image_menu_icot' . $item['aridiusmenu_id'] . '" data-toggle="image" class="img-thumbnail"><img src="'. $dthumb2 . '" alt="" title="" data-placeholder="'. $placeholder . '" /></a>';
				$html .= ' <input type="hidden" name="image_menu_icot" value="'. $item['image_menu_ico'] . '" id="input-image_menu_icot' . $item['aridiusmenu_id'] . '" />';
				$html .= ' 
			 </div>
			 ';
			 $html .= '			 

			 <div class="col-sm-12">';
				$html .= '<label class="control-label">' . $this->language->get('text_stickers') . '</label>'; 
				$html .= '
			 </div>
			 ';
			 $html .= ' 
			 <div class="col-sm-12">
				';
				$html .= ' 
				<select name="stickerst" class="form-control">
				   ';
				   if ($item['stickers'] < 1) { $html .= '
				   <option value="0" selected="selected">no</option>
				   '; } else if ($item['stickers'] != 0) { $html .= '
				   <option value="0">no</option>
				   ';}
				   if ($item['stickers'] == 1) { $html .= '
				   <option value="1" selected="selected">new</option>
				   '; } else if ($item['stickers'] != 1) { $html .= '
				   <option value="1">new</option>
				   ';}
				   if ($item['stickers'] == 2) { $html .= '
				   <option value="2" selected="selected">sale</option>
				   '; } else if ($item['stickers'] != 2) { $html .= '
				   <option value="2">sale</option>
				   ';}
				   if ($item['stickers'] == 3) { $html .= '
				   <option value="3" selected="selected">top</option>
				   '; } else if ($item['stickers'] != 3) { $html .= '
				   <option value="3">top</option>
				   ';}
				   $html .= '
				</select>
				';
				$html .= '
			 </div>
			 ';
			 $html .= '
			 <div class="row"></div>
			 ';
			 $html .= '
			 <br /><div class="col-sm-12"><a class="btn btn-primary active" onclick="updateItem(' . $item['aridiusmenu_id'] . ');">' . $this->language->get('text_save') . '</a><br /><br /></div>
			 ';
			 $html .= '
		  </form>
	   </div>
	   ';
	   }
	   $html .= $this->buildMenu($menu, $item['aridiusmenu_id']);
	   $html .= "
	</li>
	";
	}
	}
	return $html ?  "\n
	<ol class=\"dd-list\">\n$html</ol>
	\n" :  null;
  }
	
  protected function validate() {
	  
	foreach ($this->request->post['information_menu'] as $language_id => $value) {
	if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 128)) {
	$this->error['name'][$language_id] = $this->language->get('error_name');
	 }
	}
		
	if (!$this->user->hasPermission('modify', 'extension/module/aridiusmenu')) {
	$this->error['warning'] = $this->language->get('error_permission');
	}
	return !$this->error;
  }

  	public function install() {
  		// create aridiusmenu table
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "aridiusmenu` (`aridiusmenu_id` int(11) NOT NULL AUTO_INCREMENT, `parent_id` int(11) NOT NULL DEFAULT '0', `image` varchar(255) DEFAULT NULL, `image_menu_ico` varchar(255) DEFAULT NULL, `stickers` tinyint(1) NOT NULL, `sort_order` int(3) NOT NULL DEFAULT '0', `columnn` int(3) NOT NULL, `top` int(3) NOT NULL, PRIMARY KEY (`aridiusmenu_id`)) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "aridiusmenu_description` (`aridiusmenu_id` int(11) NOT NULL DEFAULT '0', `language_id` int(11) NOT NULL DEFAULT '0', `name` varchar(64) NOT NULL DEFAULT '', `url` VARCHAR(255) NOT NULL DEFAULT '', PRIMARY KEY (`aridiusmenu_id`,`language_id`)) ENGINE=MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");
  }
  
 }
