<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * FusionInvoice
 * 
 * A free and open source web based invoicing system
 *
 * @package		FusionInvoice
 * @author		Jesse Terry
 * @copyright	Copyright (c) 2012 - 2013 FusionInvoice, LLC
 * @license		http://www.fusioninvoice.com/license.txt
 * @link		http://www.fusioninvoice.com
 * 
 */

class Ajax extends Admin_Controller {

	public $ajax_controller = TRUE;

	public function filter_invoices()
	{
		$this->load->model('invoices/mdl_invoices');

		$query = $this->input->post('filter_query');

		$keywords	 = explode(' ', $query);
		$params		 = array();

		foreach ($keywords as $keyword)
		{
			if ($keyword)
			{
				$this->mdl_invoices->like("CONCAT_WS('^',invoice_number,invoice_date_created,invoice_date_due,client_name,invoice_total,invoice_balance)", $keyword);
			}
		}

		$data = array(
			'invoices' => $this->mdl_invoices->get()->result(),
			'invoice_statuses' => $this->mdl_invoices->statuses()
		);

		$this->layout->load_view('invoices/partial_invoice_table', $data);
	}
    
	public function filter_quotes()
	{
		$this->load->model('quotes/mdl_quotes');

		$query = $this->input->post('filter_query');

		$keywords	 = explode(' ', $query);
		$params		 = array();

		foreach ($keywords as $keyword)
		{
			if ($keyword)
			{
				$this->mdl_quotes->like("CONCAT_WS('^',quote_number,quote_date_created,quote_date_expires,client_name,quote_total)", $keyword);
			}
		}

		$data = array(
			'quotes' => $this->mdl_quotes->get()->result(),
			'quote_statuses' => $this->mdl_quotes->statuses()
		);

		$this->layout->load_view('quotes/partial_quote_table', $data);
	}
	
	public function filter_clients()
	{
		$this->load->model('clients/mdl_clients');

		$query = $this->input->post('filter_query');

		$keywords	 = explode(' ', $query);
		$params		 = array();

		foreach ($keywords as $keyword)
		{
			if ($keyword)
			{
				$this->mdl_clients->like("CONCAT_WS('^',client_name,client_email,client_phone,client_active)", $keyword);
			}
		}

		$data = array(
			'records' => $this->mdl_clients->with_total_balance()->get()->result()
		);

		$this->layout->load_view('clients/partial_client_table', $data);
	}
	
	public function filter_payments()
	{
		$this->load->model('payments/mdl_payments');

		$query = $this->input->post('filter_query');

		$keywords	 = explode(' ', $query);
		$params		 = array();

		foreach ($keywords as $keyword)
		{
			if ($keyword)
			{
				$this->mdl_payments->like("CONCAT_WS('^',payment_date,invoice_number,payment_amount,payment_method_name,payment_note)", $keyword);
			}
		}

		$data = array(
			'payments' => $this->mdl_payments->get()->result()
		);

		$this->layout->load_view('payments/partial_payment_table', $data);
	}

}

?>