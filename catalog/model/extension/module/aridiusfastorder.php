<?php

class ModelExtensionModuleAridiusFastorder extends Model
{
    public function addOrder($data)
    {
        $order_status_id = $this->config->get('module_aridiusfastorder_order_status_id');
        $this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET   invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) . "', store_id = '" . (int)$data['store_id'] . "', store_name = '" . $this->db->escape($data['store_name']) . "', store_url = '" . $this->db->escape($data['store_url']) . "', `firstname` = '', `lastname` = '" . $this->db->escape($data['formFastOrderName']) . "', `email` = '" . $this->db->escape($data['formFastOrderEmail']) . "', `telephone` = '" . $this->db->escape($data['formFastOrderTel']) . "',`comment` = '" . $this->db->escape($data['formFastOrderComment']) . "', `total` = '" . (float)$data['total'] . "', language_id = '" . (int)$data['language_id'] . "', `currency_id` = '" . (int)$data['currency_id'] . "', `currency_code` = '" . $this->db->escape($data['currency_code']) . "', `currency_value` = '" . (float)$data['currency_value'] . "',  `date_added` = NOW(), `date_modified` = NOW() , `order_status_id` = " . $order_status_id . " , ip = '" . $this->db->escape($data['ip']) . "', forwarded_ip = '" .  $this->db->escape($data['forwarded_ip']) . "', user_agent = '" . $this->db->escape($data['user_agent']) . "', accept_language = '" . $this->db->escape($data['accept_language']) . "', `customer_group_id` =" . $data['customer_group_id']);
        $order_id = $this->db->getLastId();

        if (isset($data['products'])) {

            foreach ($data['products'] as $product) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$product['product_id'] . "', `name` = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity'] . "', `price` = '" . (float)$product['price'] . "', total = '" . (float)$product['total'] . "', reward = '" . (int)$product['reward'] . "'");

                $order_product_id = $this->db->getLastId();

                if (isset($product['option'])) {
                    foreach ($product['option'] as $option) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "order_option SET order_id = '" . (int)$order_id . "', order_product_id = '" . (int)$order_product_id . "', product_option_id = '" . (int)$option['product_option_id'] . "', product_option_value_id = '" . (int)$option['product_option_value_id'] . "', name = '" . $this->db->escape($option['name']) . "', `value` = '" . $this->db->escape($option['value']) . "', `type` = '" . $this->db->escape($option['type']) . "'");
                    }
                }
            }

        }

		if (isset($data['totals'])) {
			foreach ($data['totals'] as $total) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET order_id = '" . (int)$order_id . "', code = '" . $this->db->escape($total['code']) . "', title = '" . $this->db->escape($total['title']) . "', `value` = '" . (float)$total['value'] . "', sort_order = '" . (int)$total['sort_order'] . "'");
			}
		} else {
			$data['totals'] = array();
		}

        return $order_id;

    }

    public function getProductOptionValue($product_option_value_id)
    {
        $query = $this->db->query("SELECT `price` FROM `" . DB_PREFIX . "product_option_value` WHERE `product_option_value_id` ='" . $product_option_value_id . "'");


        return $query->row['price'];
    }
	
	public function addOrderHistory($order_id) {

				// Stock subtraction
				$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

				foreach ($order_product_query->rows as $order_product) {
					$this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_id = '" . (int)$order_product['product_id'] . "' AND subtract = '1'");

				$order_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product['order_product_id'] . "'");

					foreach ($order_option_query->rows as $option) {
						$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity - " . (int)$order_product['quantity'] . ") WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' AND subtract = '1'");
					}
				}

			}
}