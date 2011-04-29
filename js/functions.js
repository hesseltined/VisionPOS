// JavaScript Document




		function updateTips( t ) {
			tips = $( ".validateTips" );
			tips
				.text( t )
				.addClass( "ui-state-highlight" );
			setTimeout(function() {
				tips.removeClass( "ui-state-highlight", 1500 );
			}, 500 );
		}

		function checkLength( o, n, min, max ) {
			
			o.removeClass( "ui-state-error" );
			
			if ( o.val().length > max || o.val().length < min ) {
				o.addClass( "ui-state-error" );
				updateTips( "Length of " + n + " must be between " +
					min + " and " + max + "." );
					o.focus();
				return false;
			} else {
				return true;
			}
		}
		
		function checkDropdown(o,n,tv)
		{
			o.removeClass( "ui-state-error" );
			
			if (o.val() == tv)
			{
				o.addClass( "ui-state-error" );	
				updateTips("Please select value for " + n);
				o.focus();
				return false;
			}
			return true;
		}

		function checkRegexp( o, regexp, n ) {
			if ( !( regexp.test( o.val() ) ) ) {
				o.addClass( "ui-state-error" );
				updateTips( n );
				return false;
			} else {
				return true;
			}
		}

$(function (){
	
	$("#select-per-page-inventory").change(function (){
		var val = $(this).val();
		$.post(BASE_URL + "inventory/pagination_per_page_set",{per_page:val}, function (){
		
			window.location.reload();
		
		});
	});
	
	$(".tooltip").tipsy({gravity: 's'});
});
		

