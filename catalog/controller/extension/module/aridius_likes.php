<?php

class ControllerExtensionModuleAridiusLikes extends Controller
{
    private $error = array();

    public function likes()
    {
        $this->load->model('extension/module/aridiuslikes');
        $json_content = json_decode(file_get_contents('php://input'), true);
        $ip = 0;
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        if ($json_content['name_btn'] == "likes") {
            $name_btn = "dislikes";
        } else if ($json_content['name_btn'] == "dislikes") {
            $name_btn = "likes";
        }

        $check_opposite = $this->model_extension_module_aridiuslikes->checkLikesOpposite($json_content['review_id'], $ip, $name_btn);

        if ($check_opposite == 0) {
            $check = $this->model_extension_module_aridiuslikes->checkLikes($json_content['review_id'], $ip, $json_content['name_btn']);
            $json_res['status'] = 0;
            if ($check == 0) {
                $this->model_extension_module_aridiuslikes->addLikes($json_content['review_id'], $ip, $json_content['name_btn']);
                $json_res['status'] = 1;
            } else {
                $this->model_extension_module_aridiuslikes->deleteLikes($json_content['review_id'], $ip, $json_content['name_btn']);
            }
        }

        $json = $this->model_extension_module_aridiuslikes->sumLikes($json_content['review_id']);

        if ($json_content['name_btn'] == "likes") {
            foreach ($json as $item) {
                $json_res['sum'] = $item['SUM(likes)'];
            }
        } else if ($json_content['name_btn'] == "dislikes") {
            foreach ($json as $item) {
                $json_res['sum'] = $item['SUM(dislikes)'];
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json_res));

    }


}