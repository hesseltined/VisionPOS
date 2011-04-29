<?php

class Mledger extends Model {



	function Mledger()

	{

		parent::Model();

	}



	function get_client_balance ()

	{
		$this->db->select('balance, trans_date');
		$this->db->where('client_id', $this->uri->segment(3));
		$this->db->orderby('trans_date', 'desc');
		$this->db->limit(1);
		$query = $this->db->get('ledger');
		if ($query->num_rows() > 0) 
		{
			$row = $query->row();
			$balance = $row->balance;
			//$date = $row->trans_date;
			return $balance;
		} else {
			return 0;
		}
	}
	
	function write_to_ledger ( $amount, $type )	{
		//something goes here	
		echo 'amount: ' . $amount . ' --- type: ' . $type;
	}

}



//   mysql_insert_id();   --  To get the last auto_increment number inserted



?>