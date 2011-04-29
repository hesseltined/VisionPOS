<?php

class Minvoices extends Model {



	function Minvoices()

	{

		parent::Model();

	}



	function create_invoice( $frame_price, $lens_price, $subtotal, $discount, $tax, $total, $deposit )

	{
		$invoice_data = array(
			'client_id' =>  $this->session->userdata('current_client') ,
//			'store_id' => $this->session->userdata('store_id'),
			'order_id' => $this->session->userdata('order_id'),
			'invoice_date' => date('Y-m-d'),
			'frame_price' => $frame_price,
			'lens_price' => $lens_price,
			'discount' => $discount,
			'subtotal' => $subtotal,
			'tax' => $tax,
			'total' => $total,
			'deposit' => $deposit,
			);
		$this->db->insert(  'invoices', $invoice_data  );
		return $this->db->insert_id();

	}
	
	function invoice_already_created()
	{
		$this->db->select('order_id');
		$this->db->where('order_id', $this->session->userdata('order_id') );
		$num_rows = $this->db->count_all_results('invoices');
		
		if ( $num_rows > 0 ) 
		{	//A record returned indicates there is already an invoice for that order number
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function print_invoice( $invoice_id ) 
	{
//		$query = $this->db->query(' select c.firstname AS firstname, c.lastname AS lastname, c.address AS address, c.address2 AS address2, c.city AS city, c.state AS state, c.zip AS zipcode, i.lens_price AS lens_price, i.frame_price AS frame_price, i.discount AS discount, i.tax AS tax, i.total AS total,  i.paid_in_full AS pif, u.username AS dispencer, s.name AS store_name, o.order_date AS order_date, d.lastname AS doctor, o.lens_color AS lens_color, o.lens_type AS lens_type, o.lens_design AS lens_design, o.lens_material AS lens_material, o.lens_treatment AS lens_treatment, o.lens_coating AS lens_coating, o.special_instructions AS spec_inst, o.diag_code AS diag_code, f.frame_name , f.frame_mfg AS frame_mfg, l.amount AS deposit FROM invoices i, orders o, clients c, users u, stores s, doctors d, frames f, ledger l WHERE c.client_id = i.client_id AND u.id = o.dispencer_id AND s.store_id = i.store_id AND d.doctor_id = o.doctor_id AND f.frame_id = o.frame_id AND i.invoice_id = ' . $invoice_id );
		
//		if ($query->num_rows() > 0) 
//		{
//			return $query->result_array(); 
//		}
	
	}
	
	function get_invoice_id( $order_id )
	{
		$this->db->select('id AS invoice_id');
		$this->db->where('order_id', $order_id);
		$this->db->limit(1);
		$query = $this->db->get('invoices');	
		if ($query->num_rows() > 0) 
		{
			$row = $query->row();
			$invoice_id =  $row->invoice_id;				return $invoice_id;
		} 
		
	}
	
	
	
	

}

?>