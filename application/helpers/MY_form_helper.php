<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
if( ! function_exists('form_ajax'))
{
        function form_ajax($form_id, $method = 'POST', $update = '', $create = true)
        {
                $automake_div = (!empty($update) && $create);
                $method = ($method === 'POST') ? 'POST' : 'GET';
                return
                ($automake_div ? '<div id="'.$update.'"></div>' : '').'
                <script type="text/javascript" src="http://yui.yahooapis.com/combo?2.7.0/build/yahoo-dom-event/yahoo-dom-event.js&2.7.0/build/connection/connection-min.js&2.7.0/build/selector/selector-min.js"></script>
                <script type="text/javascript" charset="utf-8">
                var doNotSubmit = function(e) {
                        YAHOO.util.Event.preventDefault(e);
                        makeRequest();
                }
                YAHOO.util.Event.addListener(YAHOO.util.Selector.query("#'.$form_id.' input[type=submit]"), "click", doNotSubmit);
 
                '.($automake_div ? 'var div = document.getElementById("'.$update.'");' : '').'
                var callback = {
                        success: function(o) {
                                if(o.responseText !== undefined) {
                                        div.innerHTML = o.responseText;
                                }
                        }
                }
                var sUrl = document.getElementById("'.$form_id.'").action;
                               
                function makeRequest() {
                        YAHOO.util.Connect.setForm("'.$form_id.'");
                        YAHOO.util.Connect.asyncRequest("'.$method.'", sUrl, callback);
                }
                </script>
                ';
        }
}
 
/* End of MY_form_helper.php */
/* Location: ./system/application/helpers/MY_form_helper.php */

?>