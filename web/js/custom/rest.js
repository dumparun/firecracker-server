(function($) {
	$.fn.restService = function(config) {

		var service = {
			defaults : {
				baseUrl : getServerURL(),
				serviceUrl : "action",
				type : "GET",
				contentType : "application/x-www-form-urlencoded; charset=UTF-8",
				crossDomain : false,
				dataType : "json",
				timeout : 10000,
				data : "",
				
				loadingText : "Fetching Data .....",
				maskClass: ".body-outer",
				
				onSuccess : function() {
				},
				onError : function() {
				}
			}
		};

		var defaults = $.extend({}, service.defaults, config);

		// show loader
		$(defaults.maskClass).mask("");

		$.ajax({
			type : defaults.type,
			url : defaults.baseUrl + defaults.serviceUrl,

			dataType : defaults.dataType,
			contentType : defaults.contentType,
			crossDomain : defaults.crossDomain,

			timeout : defaults.timeout,
			data : defaults.data

		}).done(function(response, textStatus, jqXHR) {
			$(defaults.maskClass).unmask();
			defaults.onSuccess.call(this, response);
			

		}).fail(function(jqXHR, textStatus, errorThrown) {
			$(defaults.maskClass).unmask();
			defaults.onError.call(this, jqXHR);
			
		}).always(function() {
			// This function is called after a slight delay, use
			// with caution
			// console.log("Always called for cleaning up
			// activity");
			$(defaults.maskClass).unmask();
		});

		return;
	};
}(jQuery));