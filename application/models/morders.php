<?php

class Morders extends Model {



	function Morders()

	{

		parent::Model();

	}
	
	function getOrders ( )
	{
		$query = $this->db->query('SELECT client_id, order_id, invoice_id, order_date, delivered_date, paid_in_full, order_type FROM orders  WHERE client_id = \'' . $this->session->userdata('current_client') .'\'' );
			
		if ($query->num_rows() > 0) 
		{
			return $query->result_array(); 
		}
	}

	function get_order ( $order_id )
	{
	
		$this->db->select('*, lm.material AS lens_material, lc.coating AS lens_coating, lc.retail_price AS lens_coating_price, lc.coating AS lens_type, lc.coating AS lens_treatment, lc.coating AS lens_design, lc.coating AS lens_coating, lc.coating AS lens_treatment_price ');  		//, lt.type AS lens_type
		$this->db->where( 'order_id', $order_id );
		$this->db->limit('1');
		$this->db->join('lens_materials lm', 'lm.id = o.material_id');
		$this->db->join('lens_coatings lc' , 'lc.id = o.coating_id');
	//	$this->db->join('lens_types lt', 'lt.id = o.type_id');
		
		$query = $this->db->get('orders o');
		
		if ($query->num_rows() > 0) 
		{
			return $query->result_array(); 
		}
	
	}


        public function lens_treatment_price($lt_id)
        {
            $treatments_price = 0;

            if (is_array($lt_id))
            {
                foreach ($lt_id as $i)
                {
                   $this->db->select_sum( 'retail_price' );
                    $this->db->where( 'id', $i ) ;

                    $query = $this->db->get('lens_treatments');

                    if ($query->num_rows() > 0)
                    {
                       $row = $query->row();
                       $treatments_price +=  $row->retail_price;
                    }
                }
            }
            else
            {
                $this->db->select_sum( 'retail_price' );
                $this->db->where( 'id', $lt_id ) ;

                $query = $this->db->get('lens_treatments');

		if ($query->num_rows() > 0)
		{
		   $row = $query->row();
		   $treatments_price =  $row->retail_price;
		}

            }

            return $treatments_price;
        }

        public function coating_price($lc_id)
        {
           
		$this->db->select_sum( 'retail_price' );
		$this->db->where( 'id', $lc_id ) ;
		$query = $this->db->get('lens_coatings');
		$coatings_price = 0;
		if ($query->num_rows() > 0)
		{
		   $row = $query->row(); 
		   $coatings_price =  $row->retail_price;
		}

                return $coatings_price;
        }

	function write_order ( )

	{

		if ( isset( $_POST['real_treatments_selected'] ) ) {
			$lens_treatment = $_POST['real_treatments_selected'];
		} else {
			$lens_treatment = '';
		}
		/*$this->db->select_sum( 'retail_price' );
		$this->db->where( 'id', $lens_treatment ) ;
		$query = $this->db->get('lens_treatments');
		
		if ($query->num_rows() > 0)
		{
		   $row = $query->row(); 
		   $treatments_price =  $row->retail_price;
		}*/
//		echo 'treatments price ' . $treatments_price;
//DOUG - NOT DONE - still need to get the total price of all items selected not just the one

                 if ( isset( $_POST['lens_coating'] ) ) {
			$lens_coating = $_POST['lens_coating'];
		} else {
			$lens_coating = '';
		}
                

		$treatments_price = $this->lens_treatment_price($lens_treatment);
                $coatings_price = $this->coating_price($lens_coating);
		
		
		$lens_price = 150;
		$frame_price = 250;
		
		$update_client = FALSE;
		if ( isset($_POST['insurance_id'])) $update_client = TRUE;
		if ( isset($_POST['doctor_id'])) $update_client = TRUE;
		if ( isset($_POST['dob'])) $update_client = TRUE;
		
		if ( $_POST['doctor_id'] == 'OTHER' ) {
			//other doctor selected so there should be an OTHER doctor value...set that value
			$other_doctor = $_POST['otherDoctor'];
			$doctor_id = 'OTHER';
		} else	{
			//a doctor from the list was selected so write that doctors ID to the DB
			$doctor_id = $_POST['doctor_id'];
			$other_doctor = '';
		}
		
		$order_data = array(
			'client_id' =>  $this->session->userdata('current_client') ,
			'dispencer_id' => $_POST['dis