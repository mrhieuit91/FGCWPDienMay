<?php

/**
 * Plugin Name: FGC Compare Products
 * Plugin URI: http://vanhieu.wdev.fgct.net/FGCWPDienMay
 * Description: Plugin compare product
 * Version: 1.0
 * Author: Phạm Hiếu
 * Author URI: http://vanhieu.wdev.fgct.net
 */
class FGCCompareProducts extends WP_Query {

    public function __construct($query = '') {
        parent::__construct($query);
    }

    public function actionCompare() {
        $type = $this->input->post('type');
        switch ($type) {
            case 'addtocompare':
                return $this->addtoCompare();
                break;
            case 'deleteProduct':
                return $this->deleteProduct();
                break;
            case 'updateCompare':
                return $this->addtoCompare(true);
                break;

            default:
                return $this->outputJson(['message' => 'Unknown action']);
                break;
        }
    }

    public function addtoCompare($update = false) {
        
    }

    public function deleteCompareProducts() {
        
    }

    public function saveCompare($compare = null) {
        $compare = $compare ? $compare : $this->compare;
        $this->session->set_userdata("compare", $compare);
    }

    public function set_userdata($data, $value = NULL) {
        if (is_array($data)) {
            foreach ($data as $key => &$value) {
                $_SESSION[$key] = $value;
            }

            return;
        }

        $_SESSION[$data] = $value;
    }

}
