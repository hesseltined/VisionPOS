window.onload = function () {
	new Ajax.Autocompleter("search_term", "autocomplete_choices", base_url+"main/ajaxsearch/", {});

	$('client_search_form').onsubmit = function () {
		inline_results();
		return false;	
	}
}

function inline_results() {
	new Ajax.Updater ('client_details', base_url+'main/ajaxsearch', {method:'post', postBody:'description=true&search_term='+$F('search_term')});
	new Effect.Appear('client_details');

}