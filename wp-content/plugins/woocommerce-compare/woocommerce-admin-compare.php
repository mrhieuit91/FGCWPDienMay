<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Compare' ) ) {
    /**
     * Manage all features of a YIT Theme
     */
    

    class Compare {
        private $compare;
        public function __construct() {
            parent::__construct();
            $this->load->library('session');
            $this->load->model('Products_model');
            $this->compare = $this->getCompare();
        }
        /**
         * @return redirect to method by action
         */
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
                    return $this->outputJson(['message'=>'Unknown action']);
                    break;
            }
        }
        /**
         * addtoCompare: add products to list compare products
         * @param  $update(boolean) - True will be reset compare
         * @return json
         */
        public function addtoCompare($update=false) {
            $product_id = $this->input->post('products');
            if(!$product_id) exit();
            if(is_array($product_id)) {
                if($update) $this->compare = null;
                foreach ($product_id as $id) {
                    if(!in_array($id,$this->compare)) $this->compare[] = $id;
                }
                $this->saveCompare($this->compare);
                $response['debug']['thiscompare'] = $this->compare;
            } else if(!in_array($product_id,$this->compare)) {
                $this->compare[] = $product_id;
            }

            $this->saveCompare(); // save list products to session compare

            $response['status'] = 1;
            $response['number'] = count($this->getCompare());
            return $this->outputJson($response);
        }
        /**
         * delete product from compare session
         * @return json
         */
        public function deleteProduct() {
            $id = $this->input->post('product_id');
            unset($this->compare[$id]);
            if(($key = array_search($id, $this->compare)) !== false) {
                unset($this->compare[$key]);
            }
            $this->saveCompare();
            $response = array('status' => 1);
            return $this->outputJson($response);
        }
        /**
         * print view Compare
         */
        public function viewCompare() {
            $data['title'] = 'So sánh';
            if(!empty($this->compare)) {
                $ids = $this->compare;
                $products = $this->Products_model->getProducts($ids);
                $compare = array();
                foreach ($products as $product) {
                    $id = $product['id'];
                    $compare['name'][$id] = $product['name'];
                    $compare['image'][$id] = $product['thumb'];
                    $compare['price'][$id] = $product['price'];
                    $compare['buys'][$id] = $product['buys'];
                    $compare['description'][$id] = $product['description'];
                    $compare['rate'][$id] = $product['rate'];
                }
                //var_dump($compare);exit;
                $data['compare'] = $compare;
            }
            $data['debug'] = $this->getCompare();
            $this->load->view('site/common/header', $data);
            $this->load->view('site/compare', $data);
            $this->load->view('site/common/footer', $data);
        }
        /**
         * save compare to session
         * @param  $compare(array) - products for compare
         * @return void
         */
        public function saveCompare($compare=null) {
            $compare = $compare ? $compare : $this->compare;
            $this->session->set_userdata("compare", $compare);
        }
        /**
         * get compare from session
         * @return array products
         */
        public function getCompare() {
            //$this->compare = json_decode(get_cookie('compare'),true);
            $this->compare = $this->session->userdata("compare");
            return (array)$this->compare;
        }
        /**
         * @param  $response(array) - notice success or not to browser
         * @return json
         */
        public function outputJson($response=null) {
            $response['status'] = $response['status'] || 0;
            $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                    ->_display();
            exit;
        }
    }
}