jQuery(function() {

	$(document).ready(function() {
		if ($('.locality-search').length !== 0) {
			// $("locality-search").autocomplete({});
			jQuery('.locality-search').attr('autocomplete', 'off');
		}
	});
	var delay = (function() {
		var timer = 0;
		return function(callback, ms) {
			clearTimeout(timer);
			timer = setTimeout(callback, ms);
		};
	})();

	jQuery('.locality-search').keyup(function(e) {

		selector = $(this);

		$(this).next("label.errorAdded").remove();

		delay(function() {
			searchForLocationMatches(selector, e);
		}, 500);

	});

	function searchForLocationMatches(selector, e) {

		var textBoxSelector = selector;
		var code = e.keyCode || e.which;
		if (code != 32 && code != 40 && code != 13) {

			var key = $.trim(selector.val());
			var keyLength = key.length;
			var id = selector.next().attr('id');
			if (keyLength < 2) {
				selector.next('#' + id + ' ul').remove();
				selector.next('#' + id).hide();
			} else {
				$(".location-search-result").empty();

				var opts = {
					serviceUrl : "Localitysearchdata/getLocalityMatches",
					type : "POST",
					maskClass : "",
					data : {
						key : key
					},
					onSuccess : function(data) {
						showLocationSearchResult(data, id, textBoxSelector);
					},
					onError : function(data) {
					},
					loadingText : "fetching subcategory...."
				};
				$().restService(opts);
			}
		}
		if (e.which === 40) {
			selector.next().children().find("li").first().focus().addClass(
					'selected-locality');
		}
		if (e.which === 8 || e.which === 46) {

			selector.prev('#pincodeSelect').val("");
			selector.val('');
		}

		if (e.which === 13) {
			var length = selector.val().length;
			if (length == 6) {
				setSelectedData.call(that = selector.next().children().find(
						"li").first());
			}

		}

	}
	;

	function showLocationSearchResult(data, id, textBoxSelector) {

		var selectorWidth = textBoxSelector.outerWidth();
		var selectorHeight = textBoxSelector.outerHeight();
		var pos = textBoxSelector.position();
		$('#' + id).addClass("absolute bg-white");
		$('#' + id).css({
			"width" : parseInt(selectorWidth) + 'px',
			"padding" : "5px",
			"max-height" : '200px',
			"overflow-y" : "auto",
			"top" : pos.top + selectorHeight,
			"left" : pos.left,
			"z-index" : '1',
			"border" : "1px solid #ddd"
		});

		$('#' + id + ' p').remove();
		$('#' + id + ' ul').remove();
		var htmlUL = '<ul class="not-list font-12" style="width:'
				+ (parseInt(selectorWidth) - 27) + 'px;"></ul>';
		$('#' + id).append(htmlUL);

		var parsedData = jQuery.parseJSON(data);
		if (parsedData === null) {
			var html = '<p class="not-available">No such Locality found</p>';
			$('#' + id).append(html);
			$('#' + id).show();
		} else {
			for ( var i in parsedData) {
				if (parsedData[i] !== null) {
					var locationName = parsedData[i].locality_name;
					var pincode = parsedData[i].pincode;
					var displayString = pincode + ' - ' + locationName;
					var highlightName = highlightSearchKey(displayString, id);
					var locality_id = parsedData[i].locality_id;
					var htmlLI = '<li tabindex="' + i + '" id="' + locality_id
							+ '" class="pad-5 pointer">' + highlightName
							+ '</li>';
					$('#' + id + ' ul').append(htmlLI);
					$('#' + id).show();
				}
			}
		}
	}

	function highlightSearchKey(productName, id) {
		var key = $('#' + id).prev().val();
		key = $.trim(key);

		var stringToReplace = "<span>" + key + "</span>";
		var splitArray = productName.replace(new RegExp(key, 'gi'),
				stringToReplace);
		return splitArray;
	}

	$('.location-search-result').on('keydown', 'li', function(e) {
		if (e.which == 40) {
			$(this).removeClass('selected-locality');
			$(this).next().focus().addClass('selected-locality');
		}
		if (e.which == 38) {
			$(this).removeClass('selected-locality');
			$(this).prev().focus().addClass('selected-locality');
		}
		if (e.which == 13) {
			setSelectedData.call(this);

		}
		return false;
	});

	$(".location-search-result").bind("clickoutside", function(event) {
		$(this).hide();
	});

	$(".location-search-result").on('click', 'li', function() {

		setSelectedData.call(this);

	});

	$('.location-search-result').on(
			"mouseenter",
			'li',
			function() {
				$(this).focus().addClass('selected-locality').siblings()
						.removeClass('selected-locality');
			});

	$('.location-search-result').on("click", 'li.not-available', function() {
		$(this).parent().parent().prev().val(" ");
	});

	// for adding validtion msg after pincode field
	/*
	 * jQuery('.locality-search').closest('form').submit( function(e) { if
	 * ($('.locality-search').is(":visible")) { if ($('.locality-search').val() == "" ||
	 * $("#pincodeSelect").val() == "") { message = "Pincode required"; var html = "<label
	 * class=\"error\">" + message + "</label>";
	 * $(".locality-search").next().after(html); e.preventDefault(); } }
	 * 
	 * });
	 */

});
function changeSelectedValue() { // function to change selected locality
	$(".search-result-box").hide();// hide product search result
	// remove the pincode and show the div for entering new pincode
	$('#selectedLocalityDiv #selectedPincodeDisplay').text('');
	$('#forSelectingLocalityDiv').show();
	$('#selectedLocalityDiv').hide();
	// ends here
	/* for hiding the price details */
	// $('.priceDisplayForShipping').hide();
	/* end here */

	$('.similarProductPrice').hide();

	$('#orderQuantityTextBox').attr('disabled', true);
	$(".addTocartImage").attr("disabled", true);
	$('.addTocartImage').removeClass('addToCartImageActive').addClass(
			'addToCartImageInActive');

	$("#shippingPriceArrayID").val('');

	$('.locality-search').prev().prev().prev().val('');
	$('.locality-search').prev().prev().val('');
	$('.locality-search').prev().val('');

	$('.location-selected').remove();
	$('.locality-search').val('');
	$('#customerLocality').show().val('');

	$('#shippingAvailable').val(' ');// for enable button after pincode
	// changed

	$('#forProductDescriptionShipping').attr("readonly", false);
	var opts = {
		serviceUrl : "homedata/setLocalityInSession",
		type : "POST",
		maskClass : "",
		data : {
			pincode : null,
			localityName : null
		},
		onSuccess : function() {
			// setLocality();
		},
		onError : function(data) {
		},
		loadingText : "setting Location...."
	};
	$().restService(opts);

	if ($('.forCart').length !== 0) {
		$('.change-button').hide();
		$('.check-button').show();
		updateCartWithData();
	}
}

function setSelectedData() {
	var selectedLocality = $(this).text();
	var selectedLocalityId = $.trim($(this).attr('id'));

	var customerLocation = selectedLocality.split('-');
	var pincode = $.trim(customerLocation[0]);
	var localityName = $.trim(customerLocation[1]);

	$('.locality-search').prev().val(pincode);
	$('.locality-search').prev().prev().val(selectedLocalityId);
	$('.locality-search').prev().prev().prev().val(localityName);

	$('.location-search-result').hide();
	$('.similarProductPrice').show();

	$('#orderQuantityTextBox').attr('disabled', false);
	if ($(this).closest('.location-search-result').prev().attr('id') == "customerLocality") {
		showCustomerLocality(pincode, localityName, selectedLocalityId);
		if ($('.locality-search').hasClass('forCart')) {
			changeLocalityInCart();

		} else if ($('.locality-search').length == 2) {
			if ($('#myProfile').length == 0) {
				showCustomerLocalityForShipping(pincode, localityName,
						selectedLocalityId);
			}

		}

	} else {

		$(this).parent().parent().prev().val(pincode);

	}

	if ($(this).closest('.location-search-result').prev().attr('id') == "forProductDescriptionShipping") {
		showCustomerLocality(pincode, localityName, selectedLocalityId);
		if ($('.locality-search').hasClass('forCart')) {
			changeLocalityInCart();
		} else {
			/*
			 * showCustomerLocalityForShipping(pincode, localityName,
			 * selectedLocalityId);
			 */
		}
	}
}

function showCustomerLocality(pincode, localityName, selectedLocalityId) {
	$('.location-selected').remove();
	var opts = {
		serviceUrl : "homedata/setLocalityInSession",
		type : "POST",
		maskClass : "",
		data : {
			pincode : pincode,
			localityName : localityName,
			localityId : selectedLocalityId
		},
		onSuccess : function() {
			setLocality(pincode, localityName);
		},
		onError : function(data) {
		},
		loadingText : "setting Location...."
	};
	$().restService(opts);

}

function showCustomerLocalityForShipping(pincode) {

	$('.location-selected').remove();
	$('#forSelectingLocalityDiv').hide();
	$('#selectedLocalityDiv').show();

	$('#selectedLocalityDiv #selectedPincodeDisplay').text(pincode);

	getShippingSlab();
}
function changeLocalityInCart() {
	$('.location-selected').remove();
	$('.change-button').show();
	$('.check-button').hide();
	updateCartWithData();
}
function setLocality(pincode, localityName) {
	$('#customerLocality').hide();
	var html = [
			'<p class="location-selected"><span class="location-text">Location :- </span>',
			'<span class="font-color location-display">&nbsp;' + localityName
					+ '</span>',
			'<a href="" class="small-close-button-image" id="changeLocation"></a></p>' ]
			.join('\n');
	$('#customerLocality').parent('li').append(html);
	$('.locality-search').val(pincode + '-' + localityName);
	if ($('#querystring').length != 0) {
		location.reload();
	}

}

function newClassForCartPage() {
	$('.locality-search').addClass('forCart');
}