<?php
class Mclients extends Model {

	function Mclients()
	{
		parent::Model();
	}

	function getSearchResults ($search)
	{
	//echo print_r($search) . '<BR><BR>';
		$this->load->helper('format_phone_number');

		//if includemas90 checked then search mas90 otherwise do normal search
		if ( $search['includemas90'] == 'includemas90' )	{
			$this->db->select('customer_number as client_id, customer_name as firstname, propercase as lastname, address1 as address, city, state, phone, propercase as clientstatus, customer_number, archive');
			$this->db->like('customer_name', $search['search_term']);
			$this->db->order_by('customer_name');
			$query = $this->db->get('mas90data');
		} else 	{
			$this->db->select('client_id, firstname, lastname, address, city, state, phone, clientstatus');	
		
			if ( $search['searchoptionsname'] == 'nameonly' ) { 
				if  ( $search['namelike']  == 'like' )	{
					$this->db->or_like('lastname', $search['search_term']); 
					$this->db->or_like('firstname', $search['search_term']);
				} else {
					$this->db->or_where('lastname', $search['search_term']); 
					$this->db->or_where('firstname', $search['search_term']);
				}	
			}
			if ( $search['searchoptionsphone'] == 'phoneonly' ) { 
				$this->db->or_like('phone', $search['search_term']); 
				$this->db->or_like('phone2', $search['search_term']);
				$this->db->or_like('phone3', $search['search_term']);
			}
	
			if ( $search['searchoptionsaddress'] == 'addressonly' ) { 
				if ($search['addresslike'] == 'like' ) 	{
					$this->db->or_like('address', $search['search_term']); 
					$this->db->or_like('address2', $search['search_term']);
				} else {
					$this->db->or_where('address', $search['search_term']); 
					$this->db->or_where('address2', $search['search_term']);			
				}
			}
			
			if ( $search['searchoptionseverything'] == 'everything' ) { 
				$array = array('lastname' => $search['search_term'], 'firstname' => $search['search_term'], 'phone' => $search['search_term'], 'phone2' => $search['search_term'], 'phone3' => $search['search_term'], 'address' => $search['search_term'], 'city' => $search['search_term'], 'notes' => $search['search_term'] )  ;  //added notes to search everything 10-27 - Doug
				$this->db->or_like($array);
			}
			if (!$search['includearchived'] == 'includearchived' ) {	//if not include archive then...require clientstatus=1
				$this->db->having('clientstatus  =', 1);
			} 
	
			//$this->db->limit(50);	//removed at request of Pat.
					
			$this->db->orderby('lastname, firstname');
			$query = $this->db->get('clients');
		
		}

		if ($query->num_rows() > 0) {	
			$searchresults =  $query->result_array();
			return $searchresults;

		} 
	}
	
	function getClientRecord()
	{
	
		$this->db->select('doctor_id');
		$this->db->where('client_id', $this->uri->segment(3));
		$query = $this->db->get('clients');
		if ($query->num_rows() > 0) 
		{	
			$this->db->select('clients.firstname as clientfirstname, clients.doctor_id, clients.store_id, clients.lastname as clientlastname, doctors.firstname as doctorfirstname, doctors.lastname as doctorlastname, clients.address, clients.address2, clients.city, clients.state, clients.zip, clients.phone, clients.phone2, clients.phone3, clients.email, examtype.examtype as examtype, clients.examdate, clients.recalldate, clients.examdue, clients.lastcontact, clients.clientstatus, stores.name as storename, notes as notes');
			$this->db->where('client_id', $this->uri->segment(3));
			$this->db->join('doctors', 'doctors.doctor_id = clients.doctor_id', 'left');
			$this->db->join('stores', 'stores.store_id = clients.store_id', 'left');
			$this->db->join('examtype', 'clients.examtype = examtype.examtype_id', 'right');
			$query = $this->db->get('clients','','1');
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
	