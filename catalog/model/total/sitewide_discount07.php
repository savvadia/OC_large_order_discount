<?php

/**
 * Sitewide (Global) Discount extension for Opencart.
 *
 * @author Anthony Lawrence <freelancer@anthonylawrence.me.uk>
 * @version 1.0
 * @copyright © Anthony Lawrence 2011
 * @license Creative Common's ShareAlike License - http://creativecommons.org/licenses/by-sa/3.0/
 */


class ModelTotalSitewideDiscount07 extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
		if ($this->cart->getSubTotal() && ($this->cart->getSubTotal() >= $this->config->get('sitewide_discount07_total'))) {
                        // Check the dates!
                        if(date("Y-m-d") < $this->config->get("sitewide_discount07_date_start") || date("Y-m-d") >= $this->config->get("sitewide_discount07_date_end")){
                            return;
                        }

			$this->load->language('total/sitewide_discount');

                        // Calculate how much we have to take away from the total.
                        $remove = "0.00";
                        $subTotal = $total;
                        if($this->config->get("sitewide_discount07_type") == "P"){
                            $perc = $this->config->get("sitewide_discount07_amount")/100;
                            $remove = $subTotal-($subTotal*(1-$perc));
                        } else {
                            $remove = $this->config->get("sitewide_discount07_amount");

                        }

			$total_data[] = array(
                            'code'       => 'sitewide_discount07',
                            'title'      => $this->language->get('text_sitewide_discount') . "(>" . $this->currency->format($this->config->get('sitewide_discount07_total')) . ")",
                            'text'       => $this->currency->format(-$remove),
                            'value'      => -$remove,
                            'sort_order' => $this->config->get('sitewide_discount07_sort_order')
			);

                        $total -= $remove;
		}
	}
}
?>