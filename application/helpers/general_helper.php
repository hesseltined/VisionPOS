<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

        function settings_get($setting)
        {
            $CI =& get_instance();
            $CI->db->select($setting);
            $CI->db->from("settings");

            $result = $CI->db->get();

            if ($result->num_rows() == 0)
                return NULL;
            else
                return $result->row()->$setting;
        }
?>
