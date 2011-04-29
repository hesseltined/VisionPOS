window.onload = function () {
	new Ajax.Autocompleter("function_name", "autocomplete_choices", base_url+"application/ajaxsearch/", {});

	$('function_search_form').onsubmit = function () {
		inline_results();
		return false;	
	}
}

function inline_results() {
	new Ajax.Updater ('function_description', base_url+'application/ajaxsearch', {method:'post', postBody:'description=true&function_name='+$F('function_name')});
	new Effect.Appear('function_description');

}