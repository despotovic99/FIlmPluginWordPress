<?php
require_once plugin_dir_path(__FILE__) . '../repositories/BaseRepository.php';

class InvoiceService {

    public function get_all_invoices_for_list_table() {

        $invoices =BaseRepository::get_base_repository()->get_invoice_repository()->get_all_invoices();
        for ($i=0;$i<count($invoices);$i++){
            try{
                $order = get_post($invoices[$i]['order_id']);
                $invoices[$i]['order_name']=$order->post_name;
            }catch (Exception $e){

            }
        }
        return $invoices;
    }

    public function create_invoice($order_id){

        //todo nastavi sa kreiranjem fakture
        // servis treba da spremi podatke za cuvanje u bazi
        $order = get_post($order_id);
        $user = get_currentuserinfo();


    }

}