<?php

class ModelPaymentxhopenalipay extends Model
{

    public function getMethod($address)
    {
        $this->load->language('payment/xhopenalipay');
        
        $status = $this->validate($address);
        if (! $status) {
            return array();
        }
        
        return array(
            'code' => 'xhopenalipay',
            'title' => $this->language->get('text_title'),
            'terms' => '',
            'sort_order' => intval($this->config->get('xhopenalipay_sort_order'))
        );
    }

    private function validate($address)
    {
        if (! $this->config->get('xhopenalipay_status')) {
            return false;
        }
        
        if (! $this->config->get('xhopenalipay_geo_zone_id')) {
            return true;
        }
        
        $query = $this->db->query("SELECT geo_zone_id FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int) $this->config->get('xhopenalipay_geo_zone_id') . "' AND country_id = '" . (int) $address['country_id'] . "' AND (zone_id = '" . (int) $address['zone_id'] . "' OR zone_id = '0')");
        return $query->num_rows;
    }
}
?>