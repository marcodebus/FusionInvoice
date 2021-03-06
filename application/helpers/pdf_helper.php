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

function generate_invoice_pdf($invoice_id, $stream = TRUE, $invoice_template = NULL)
{
    $CI = & get_instance();

    $CI->load->model('invoices/mdl_invoices');
    $CI->load->model('invoices/mdl_items');
    $CI->load->model('invoices/mdl_invoice_tax_rates');

    $invoice = $CI->mdl_invoices->get_by_id($invoice_id);

    if (!$invoice_template)
    {
        $CI->load->helper('template');
        $invoice_template = select_pdf_invoice_template($invoice);
    }

    $data = array(
        'invoice'           => $invoice,
        'invoice_tax_rates' => $CI->mdl_invoice_tax_rates->where('invoice_id', $invoice_id)->get()->result(),
        'items'             => $CI->mdl_items->where('invoice_id', $invoice_id)->get()->result(),
        'output_type'       => 'pdf'
    );

    $html = $CI->load->view('invoice_templates/pdf/' . $invoice_template, $data, TRUE);

    $CI->load->helper('mpdf');

    return pdf_create($html, lang('invoice') . '_' . $invoice->invoice_number, $stream);
}

function generate_quote_pdf($quote_id, $stream = TRUE, $quote_template = NULL)
{
    $CI = & get_instance();

    $CI->load->model('quotes/mdl_quotes');
    $CI->load->model('quotes/mdl_quote_items');
    $CI->load->model('quotes/mdl_quote_tax_rates');

    $quote = $CI->mdl_quotes->get_by_id($quote_id);

    if (!$quote_template)
    {
        $quote_template = $CI->mdl_settings->setting('pdf_quote_template');
    }

    $data = array(
        'quote'           => $quote,
        'quote_tax_rates' => $CI->mdl_quote_tax_rates->where('quote_id', $quote_id)->get()->result(),
        'items'           => $CI->mdl_quote_items->where('quote_id', $quote_id)->get()->result(),
        'output_type'     => 'pdf'
    );

    $html = $CI->load->view('quote_templates/pdf/' . $quote_template, $data, TRUE);

    $CI->load->helper('mpdf');

    return pdf_create($html, lang('quote') . '_' . $quote->quote_number, $stream);
}