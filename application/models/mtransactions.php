<?php

class Mtransactions extends Model {



	function Mtransactions()

	{

		parent::Model();

	}



	function writeToLog ($user_id, $client_id, $store_id, $doctor_id, $transtype, $transdetail, $transdetail2)

	{
		$this-db-set('user_id', $user_id);
		$this-db-set('client_id', $client_id);
		$this-db-set('store_id', $store_id);
		$this-db-set('doctor_id', $doctor_id);
		$this-db-set('transtype', $transtype);
		$this-db-set('transdetail', $transdetail);
		$this-db-set('transdetail2', $transdetail2);
		

		$query = $this->db->insert('transactions');

	}
}

?>