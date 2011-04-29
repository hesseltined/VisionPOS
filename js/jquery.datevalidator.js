/**
 * jQuery Date Validator
 * usage: $("#date").dateValidator();
 */
(function($){
	/**
	 * Checks if a given date is valid
	 * @param mixed year
	 * @param mixed month
	 * @param mixed day
	 * @return boolean
	 */
	var validDate = function(year, month, day) {
		year = parseInt(year);
		month = parseInt(month) - 1; //js months start from 0
		day = parseInt(day);
		
		var date = new Date(year, month, day),
			fullYear = new String(date.getFullYear()),
			shortYear = fullYear.charAt(fullYear.length-2) + fullYear.charAt(fullYear.length-1);
		
		fullYear = parseInt(fullYear);
		shortYear = parseInt(shortYear);
		
		// date must match all members of Date object, otherwise it isn't a valid date
		return (year === fullYear || year === shortYear) && month === date.getMonth() && day === date.getDate();
		
	},
	
	/**
	 * Checks if a month is valid or in range
	 * @param mixed month
	 * @return boolean
	 */
	validMonth = function(month) {
		return 0 < month && month < 13;
	},
		
	/**
	 * Checks if a string is in valid date format: xx/xx/xx
	 * @param date string
	 * @return boolean
	 */
	validDateFormat = function(date) {
//		return typeof(date) === "string" && date.length === 8 && date.split("/").length === 3;
		var pattern= new RegExp(/\b\d{1,2}[\/-]\d{1,2}[\/-]\d{4}\b/);

	   return pattern.test(date); 
	},
	
	/**
	 * Returns the current year
	 * @return int
	 */
	getCurrentYear = function() {
		return (new Date()).getFullYear();
	},
	
	/**
	 * Keyup Event Listener
	 * @param event e
	 * @return void
	 */
	onKeyUp = function(e) {
		var $this = $(this);
			
		// 191 == "/"
		if (e.which === 191) {
			var dateSegments = $this.val().split("/"),
				month = dateSegments[0],
				day = dateSegments[1];
				
			// make sure month is valid/in range
			if (validMonth(month)) {
				// prepend a zero if month is a single digit
				if (month.length === 1) {
					month = "0" + month;
					$this.val("0"+$this.val());
				}
				
				// if a day is supplied
				if (day !== "") {
					// prepend a zero if day is a single digit
					if (day.length === 1) {
						day = "0" + day;
						$this.val(month+"/"+day+"/");
					}
				
					if (validDate(getCurrentYear(), month, day) === false)
						alert("Invalid date.");
				}
			} else {
				alert("Invalid month.");
			}
		}
	},
	
	/**
	 * Blur Event Listener
	 * @return void
	 */
	onBlur = function() {
		var val = $(this).val();
			
		if (validDateFormat(val) === false)
			alert("Invalid date format. Expected date format: mm/dd/yy");
		else {
			var date = val.split("/"),
				month = date[0],
				day = date[1],
				year = date[2];
		
			if (validDate(year, month, day) === false)
				alert("Invalid date.");
		}
	},
	
	/**
	 * Click Event Listener
	 * @return void
	 */
	onClick = function() {
		var $this = $(this);
			
		if ($this.val() === "mm/dd/yy")
			$this.val("");
	};
	
	/**
	 * jQuery Method
	 * Turns an element field into a date validator, must be a text field
	 * @return jQuery Object
	 */
	$.fn.dateValidator = function() {
		return this.each(function(){
			$(this).keyup(onKeyUp).blur(onBlur).click(onClick).val("mm/dd/yy");
		});
	};
})(jQuery);