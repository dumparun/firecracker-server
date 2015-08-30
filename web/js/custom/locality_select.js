jQuery(function() {

	$('.countryList').change(function() {

		var countryId = $(this).val();
		var stateSelector = $(this).data("child");
		if (countryId == 1) {
			$('.locationDetailsForIndia').show();
			$('.locationDetails').hide();
			$("#enterPincode").attr("checked", true);
			$('.forSelectLocalityEntry').hide();
			fetchStateListByCountryID(countryId, stateSelector);
		} else {
			$('.locationDetailsForIndia').hide();
			$('.locationDetails').show();
			$('.locationDetails input[type = "text"]').val("");
			$('.forSelectLocalityEntry').hide();
		}

	});
	jQuery('.stateList').change(function() {

		jQuery(".districtList").chosen().empty().trigger("chosen:updated");
		jQuery(".localityList").chosen().empty().trigger("chosen:updated");
		$('.pincode').val("");

		var stateId = $(this).val();
		var districtSelector = $(this).data("child");
		fetchDistrictListByStateID(stateId, districtSelector);
	});

	jQuery('.districtList').change(function() {

		jQuery(".localityList").chosen().empty().trigger("chosen:updated");
		$('.pincode').val("");

		var districtId = $(this).val();
		var localitySelector = $(this).data("child");
		fetchlocalityListByDistrictID(districtId, localitySelector);
	});

	jQuery('.localityList').change(function() {

		var pincodeHolder = $(this).data("child");
		var selected = $(this).find('option:selected');
		pincode = selected.data('pincode');
		$('#' + pincodeHolder).val(pincode).attr("readonly", true);
	});

	function clearLocalityRelatedFields() {

	}
	;

});

$(function() {
	$("input:radio[name=\"for-locality-select\"]").change(
			function() {

				var value = $(
						"input:radio[name=\"for-locality-select\"]:checked")
						.val();

				if (value == 0) {
					$(".forDropDownPincodeSelect").addClass("hide");
					$("#pincodeAutoFill").val("").attr("readonly", false);

				} else {

					$(".forDropDownPincodeSelect").removeClass("hide");

					$("#stateList").val('').trigger("chosen:updated");

					$("#stateList_chosen").css("width", "100%");

					$("#districtList").empty().val('')
							.trigger("chosen:updated");

					$("#districtList_chosen").css("width", "100%");

					$("#localityList").empty().val('')
							.trigger("chosen:updated");

					$("#localityList_chosen").css("width", "100%");

					$("#pincodeAutoFill").val("").attr("readonly", true);
				}
			});

	$(".countryHolder").change(function() {
		var selected = $(this).find('option:selected');
		countryCode = selected.data('code');
		$(".codeHolder").val(countryCode);
	});
});

var fetchStateListByCountryID = function(countryID, nextSelector) {
	var opts = {
		serviceUrl : "localitysearchdata/getAllState",
		type : "POST",
		data : {
			countryId : countryID
		},
		onSuccess : function(data) {
			showState(data, nextSelector);
		},
		onError : function() {
		},
		loadingText : "Fetching District...."
	};
	$().restService(opts);
};

var showState = function(data, stateSelector) {

	stateSelector = $('#' + stateSelector);
	var parsedData = jQuery.parseJSON(data);

	stateSelector.chosen().empty();
	var html = "<option value=\"-1\"></option>";
	stateSelector.append(html);
	for ( var i in parsedData) {
		if (parsedData[i] != null) {
			var stateName = parsedData[i].state_name;
			var stateID = parsedData[i].state_id;
			var html = "<option value=\"" + stateName + "\" data-id = \""
					+ stateID + "\">" + stateName + "</option>";

			stateSelector.append(html);
		}
	}
	stateSelector.trigger("chosen:updated");

};

var fetchDistrictListByStateID = function(stateID, nextSelector) {
	var opts = {
		serviceUrl : "localitysearchdata/getDistrict",
		type : "POST",
		data : {
			stateId : stateID
		},
		onSuccess : function(data) {

			showDistrict(data, nextSelector);
		},
		onError : function() {
		},
		loadingText : "Fetching District...."
	};
	$().restService(opts);
};

var showDistrict = function(data, districtSelector) {
	districtSelector = $('#' + districtSelector);
	var parsedData = jQuery.parseJSON(data);
	districtSelector.chosen().empty();
	var html = "<option value=\"-1\"></option>";
	districtSelector.append(html);

	for ( var i in parsedData) {
		if (parsedData[i] != null) {
			var districtName = parsedData[i].district_name;
			var districtId = parsedData[i].district_id;
			var html = "<option value=\"" + districtId + "\" data-id =\""
					+ districtId + "\">" + districtName + "</option>";

			districtSelector.append(html);
		}
	}

	districtSelector.trigger("chosen:updated");
};

var fetchlocalityListByDistrictID = function(districtID, nextSelector) {
	var opts = {
		serviceUrl : "localitysearchdata/getLocality",
		type : "POST",
		data : {
			districtId : districtID
		},
		onSuccess : function(data) {
			showLocality(data, nextSelector);
		},
		onError : function() {
		},
		loadingText : "Fetching Locality...."
	};
	$().restService(opts);
};
var showLocality = function(data, localitySelector) {
	var parsedData = jQuery.parseJSON(data);
	localitySelector = $('#' + localitySelector);
	localitySelector.chosen().empty();
	var html = "<option value=\"-1\"></option>";
	localitySelector.append(html);
	for ( var i in parsedData) {
		if (parsedData[i] != null) {
			var localityName = parsedData[i].locality_name;
			var localityId = parsedData[i].locality_id;
			var pincode = parsedData[i].pincode;
			var html = "<option value=\"" + localityId + "\" data-pincode=\""
					+ pincode + "\">" + localityName + "</option>";
			localitySelector.append(html);
		}
	}
	localitySelector.trigger("chosen:updated");
};