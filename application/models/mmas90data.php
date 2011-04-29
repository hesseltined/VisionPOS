<?php
class Mmas90data extends Model {

	function Mmas90data()
	{
		parent::Model();
	}
		
	function getSalesReport ($begindate, $enddate, $maxrecords, $minamount, $maxamount, $store_id, $zipcodes, $destination)
	{
	
//		if ( strtoupper($destination) <> strtoupper('PDF') )
//		{	//Only pull these values for the preview, not the export (to prevent duplicate labels)
//			$select_fields = 'data.customer_number, trans.amount, trans.period, data.phone';
//		} else {
			$select_fields = 'data.customer_name as customer_name, data.address1 as address1, data.address2 as address2, data.address3 as address3, data.city, data.state, data.zipcode, data.customer_number, trans.amount, trans.period, data.phone';
//		}
		
		if ( $store_id <> 'all' ) 	//build store number like statement for use in main query
		{
			$store_like_statement = " AND trans.customer_number LIKE '" . substr($store_id,0,2) . "%' ";
		} else {
			$store_like_statement = '';
		}
		
		if ( strtoupper($zipcodes) <> strtoupper('all') )	//build zipcode piece of main query
		{
			$sqlzipcodes = str_replace(',', ' ', $zipcodes);
			$sqlzipcodes = str_replace(' ', ',', $zipcodes);	//separate by commas  
			//$sqlzipcodes = str_replace('\\', '', $sqlzipcodes); //remove slashes put in	
			$zipcode_like = " zipcode IN ( " . $sqlzipcodes . " ) ";
		}	else  { 
			$zipcode_like = '';
		}
		
		if ( $maxamount <> '' )
		{
			$maxamount_statement = " AND trans.amount <= " . $maxamount . " " ;
		} else {
			$maxamount_statement = ' ';
		}
		
		if ( $minamount <> '' )
		{
			$minamount_statement = " trans.amount >= " . $minamount . " " ;
		} else {
			$minamount_statement = ' ';
		}	
		
		if ( $begindate <> '' )
		{
			$begindate_statement = " AND trans.period >= '" . $begindate . "' ";
		} else {
			$begindate_statement = ' ';
		}
		
		if ( $enddate <> '' )
		{
			$enddate_statement = " AND trans.period <= '" . $enddate . "' ";
			$exclusion_statement = " trans.period > '" . $enddate . "' ";
		} else {
			$enddate_statement = ' ';
			$exclusion_statement = ' ';
		}
		
		if ( $maxrecords <> '' )
		{
			$maxrecords_statement = " LIMIT " . $maxrecords . " ";
		} else {
			$maxrecords_statement = ' ';
		}
		
		$not_in_statement = ' AND trans.customer_number NOT IN ( SELECT trans.customer_number FROM mas90trans trans WHERE ' . $exclusion_statement . ' )'; 
			
		$myquery = 'SELECT DISTINCT ' . $select_fields . ' FROM mas90data data JOIN mas90trans trans ON trans.customer_number = data.customer_number WHERE archive = 0 AND ' . $minamount_statement . $maxamount_statement . $begindate_statement . $enddate_statement . $store_like_statement . $not_in_statement . ' GROUP BY data.address1 ' . $maxrecords_statement;
		
		
		$query = $this->db->query($myquery);
		
		//echo $myquery; 
		
		if ( strtoupper($destination) == 'CSV' )
		{
			$this->load->dbutil();
			return $this->dbutil->csv_from_result($query,",","\n");
		} else {
			return $query->result_array();
		}
	}
	
	function getmas90ClientRecord()
	{
	
		$this->db->where('customer_number', $this->uri->segment(3));
		$query = $this->db->get('mas90data');
		if ($query->num_rows() > 0) 
		{	
			$this->db->select('mas90data.customer_name as clientfirstname, mas90data.address1,  mas90data.address2,  mas90data.address3, mas90data.city, mas90data.state, mas90data.zipcode, mas90data.phone' );
			$this->db->where('customer_number', $this->uri->segment(3));
			$query = $this->db->get('mas90data','','1');
			if ($query->num_rows() > 0) 
			{
				return $query->result_array(); 
			}
		} else {
			$this->db->select('*');
			$this->db->where('client_id', $this->uri->segment(3));
			$this->db->join('doctors', 'doctors.doctor_id = clients.doctor_id', 'left');
			$query = $this->db->get('clients','','1');
			if ($query->num_rows() > 0) 
			{
				return $query->result_array(); 
			}
		}
	}
	
	function editClient_mas90()
	{
		$data = array( 
		'customer_name' => $_POST['firstname'], 
		'address1' => $_POST['address1'],
		'address2' => $_POST['address2'],
		'address3' => $_POST['address3'],
		'city' => $_POST['city'],
		'state' => $_POST['state'],
		'zipcode' => 