<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    function format_pagination()
    {
            $config['full_tag_open'] = '<ul class="pagination">';
            $config['full_tag_close'] = '</ul>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active">';
            $config['cur_tag_close'] = '</li>';
            $config['next_link'] = 'Next &raquo;';
            $config['next_tag_open'] = '<li class="next">';
            $config['next_tag_close'] = '</li>';
            $config['prev_link'] = 'Previous &laquo;';
            $config['prev_tag_open'] = '<li class="previous">';
            $config['prev_tag_close'] = '</li>';

            return $config;
    }
?>
