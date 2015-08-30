jQuery(function() {

	$('#imgPreview').on('click', function() {
		$('#uploadPhotoID').click();
	});

	$(function() {
		$("#uploadPhotoID").on("change", function() {
			var files = !!this.files ? this.files : [];
			if (!files.length || !window.FileReader)
				return; // no file selected, or no FileReader support

			if (/^image/.test(files[0].type)) { // only image file
				var reader = new FileReader(); // instance of the FileReader
				reader.readAsDataURL(files[0]); // read the local file
				reader.onloadend = function() { // set image data as background
					// of div
					$("#imgPreview").attr("src", this.result);

					$('html, body').animate({
						scrollTop : $(document).height()
					}, 'slow');
				}
			}
		});
	});

	$('#select-faculty-student').change(function() {
		$('.error-message').remove();
		$(".selectAllFaculty").attr("checked", "checked");
		$(".selectAllStudent").attr("checked", "checked");
		$('.student-selection').hide();
		$('.faculty-selection').hide();
		$('.student-view-in-send-notification').hide();
		$('.faculty-view-in-send-notification').hide();
		var selectedOption = $(this).val();
		if (selectedOption == 1) {

			$('.faculty-selection').removeClass("hide");
			$('.faculty-selection').show();
		} else if (selectedOption == 2) {

			$('.student-selection').removeClass("hide");
			$('.student-selection').show();
		}
	});
	$('.inlineRadioOptions').change(function() {
		$('input[type="checkbox"]').attr('checked', false);
		$('.error-message').remove();
		$('.student-view-in-send-notification').hide();
		$('.faculty-view-in-send-notification').hide();
		var selectedOption = $(this).val();
		if (selectedOption == 2) {
			$('.faculty-view-in-send-notification').removeClass("hide");
			$('.faculty-view-in-send-notification').show();

		} else if (selectedOption == 4) {
			$('.student-view-in-send-notification').removeClass("hide");
			$('.student-view-in-send-notification').show();

		}
	});
	$("#notification-submit")
			.click(
					function(e) {
						$('.error-message').remove();
						var errorMessage = "";
						var selectedOptionStudent = $(
								'input[name="inlineRadioOptionStudent"]:checked')
								.val();
						var selectedOptionFaculty = $(
								'input[name="inlineRadioOptionFaculty"]:checked')
								.val();
						var value = 0;
						if (selectedOptionStudent == 4) {

							$('input[name="check_student_list[]"]').each(
									function() {
										if ($(this).is(':checked')) {
											value = 1;
										}
									});

							if (value == 0) {

								e.preventDefault();
								var errorMessage = "Please Select Atleast One Student";

							}

						} else if (selectedOptionFaculty == 2) {
							$('input[name="check_faculty_list[]"]').each(
									function() {
										if ($(this).is(':checked')) {
											value = 1;
										}
									});

							if (value == 0) {

								e.preventDefault();
								var errorMessage = "Please Select Atleast One Faculty";

							}
						}

						var html = '<label  class="error-message">'
								+ errorMessage + '</label>';
						$('.student-faculty-ckeck').append(html);
					});
	$('input[name="select-all-student"]').change(function() {
		$('.student-list').attr('checked', false);
		if ($(this).is(':checked')) {
			$('.student-list').attr("checked", "checked");
		}
	});
	$('input[name="select-all-faculty"]').change(function() {
		$('.faculty-list').attr('checked', false);
		if ($(this).is(':checked')) {
			$('.faculty-list').attr("checked", "checked");
		}
	});
	$('.student-list').change(function() {
		$('input[name="select-all-student"]').attr('checked', false);
		var value = 0;
		$('input[name="check_student_list[]"]').each(function() {
			if (!$(this).is(':checked')) {
				value = 1;
			}
		});
		if (value == 0) {
			$('input[name="select-all-student"]').attr("checked", "checked");
		}
	});
	$('.faculty-list').change(function() {
		$('input[name="select-all-faculty"]').attr('checked', false);
		var value = 0;
		$('input[name="check_faculty_list[]"]').each(function() {
			if (!$(this).is(':checked')) {
				value = 1;
			}
		});
		if (value == 0) {
			$('input[name="select-all-faculty"]').attr("checked", "checked");
		}
	});

	$("#fetchMoreResults").click(function(e) {
		e.preventDefault();

		var pageNo = $(this).data("page");
		var status = $("#schoolListStatus").val();
		pageNo = pageNo + 1;

		var opts = {
			serviceUrl : "Schoolmanagedata/fetchMoreSchools",
			type : "POST",
			data : {
				pageNo : pageNo,
				status : status
			},
			onSuccess : function(data) {
				displayMoreSchools(data);
			},
			onError : function() {
			},
			loadingText : "Fetching District...."
		};
		$().restService(opts);
	});

	var displayMoreSchools = function(data) {
		var parsedData = jQuery.parseJSON(data);
		var html = "";
		countOfData = parsedData.length;

		var itemsInPage = $("#itemsInPage").val();

		var slNo = parseInt(itemsInPage) + 1;

		for ( var i in parsedData) {

			var schoolID = parsedData[i].user_id;
			var schoolName = parsedData[i].school_name;
			var schooImage = parsedData[i].imageURL;
			var schoolEmail = parsedData[i].authentication.email_id;

			if (parsedData[i].school_type == 1) {
				var schoolType = "KG";
			}

			var mobileNumber = parsedData[i].mobile_number;
			var principalName = parsedData[i].principal_name;
			var principalNumber = parsedData[i].principal_number;

			var schoolStatus = parsedData[i].statusText;

			var status = parsedData[i].authentication.status;

			var colorClass = 0;

			if (status == 0) {

				colorClass = "red";

				var btnText = "Activate";
				var btnType = "btn-success";
				var formURL = "schoolmanage/activateSchool";
				var actionType = 0;

			} else {
				var btnText = "Inactivate";
				var btnType = "btn-danger";
				var formURL = "schoolmanage/deactivateSchool";
				var actionType = 1;
			}

			if (status == 1) {

				colorClass = "green";
			}

			html += '<tr id="viewSchool'
					+ schoolID
					+ '" class="pointer viewSchoolRow"><td>'
					+ slNo
					+ '</td><td>'
					+ schoolName
					+ '</td>'
					+ '<td>'
					+ schoolEmail
					+ '</td>'
					+ '<td class="text-center">'
					+ schoolType
					+ '</td>'
					+ '<td  class="text-center">'
					+ mobileNumber
					+ '</td>'
					+ '<td>'
					+ principalName
					+ '</td>'
					+ '<td  class="text-center">'
					+ principalNumber
					+ '</td>'
					+ '<td><span class="'
					+ colorClass
					+ '">'
					+ schoolStatus
					+ '</span>'
					+ '</td>'
					+ '<td><div>'
					+ '<form action="'
					+ getServerURL()
					+ 'schoolmanage/viewSchool"method="post" class="inline" id="viewSchoolDetailsForm'
					+ schoolID
					+ '" >'
					+ '<input type="hidden" value="'
					+ schoolID
					+ '"name="school_id" /> '
					+ '<input type="submit" class="btn btn-primary btn-sm" value="View" />'
					+ '</form>' + '<form action="' + getServerURL() + formURL
					+ '"method="post" class="inline">'
					+ '<input type="hidden" value="' + schoolID
					+ '"name="school_id" /> '
					+ '<button type="submit" data-buttontype="' + actionType
					+ '" data-name="' + schoolName + '"	class="btn ' + btnType
					+ ' btn-sm action-button" role="button">' + btnText
					+ '</button>' + '</form>' + '</div>' + '</td>' + '</tr>';

			slNo++;
		}

		$("#schoolListing").append(html);

		var pageNo = $("#fetchMoreResults").data("page");
		pageNo = pageNo + 1;
		$("#fetchMoreResults").data('page', pageNo);

		var totalCount = $("#totalSchoolCount").val();
		itemsInPage = parseInt(itemsInPage) + parseInt(countOfData);
		$("#itemsInPage").val(itemsInPage);
		if (itemsInPage == totalCount) {
			$("#fetchMoreResults").hide();
		}
	};

	$("#notification-link").click(function(e) {
		$(".notification-box ").hide();
		$(".notification-list ").removeClass("hide");
		var schoolId = $(this).val();
		var opts = {
			serviceUrl : "Schoolmanagedata/changeNotificationStatus",
			type : "POST",
			data : {
				schoolId : schoolId
			},
			onSuccess : function(data) {

			},
			onError : function() {

			},
			loadingText : "Fetching District...."
		};
		$().restService(opts);

	});
	// $("#notification-link").trigger("click");
	$(".notification-list ").click(function(e) {
		$(".notification-list ").addClass("hide");
	});

	$("body").on("click", ".viewSchoolRow", function(event) {

		event.preventDefault();

		var id = $(this).attr("id");

		schoolId = id.split('viewSchool');

		schoolId = schoolId[1];

		$("#viewSchoolDetailsForm" + schoolId).submit();
	});

	$("body").on("click", ".viewSchoolRow button", function(event) {

		var schoolName = $(this).data("name");
		var form = $(this).parent();
		var buttonType = $(this).data("buttontype");
		if (buttonType == 1) {
			var msg = "Do you want to inactivate " + schoolName + " ?";
		}
		if (buttonType == 0) {
			var msg = "Do you want to activate " + schoolName + " ?";
		}
		showSchoolInactivateMsgAlert(msg, form);

		event.preventDefault();
		event.stopPropagation();
	});

	function showSchoolInactivateMsgAlert(msg, form) {

		$.msgBox({
			title : "Kindergarten",
			content : msg,
			type : "confirm",
			buttons : [ {
				type : 'submit',
				value : 'OK'
			}, {
				type : 'cancel',
				value : 'Cancel'
			} ],
			success : function(result) {
				if (result === "OK") {
					$(form).submit();
				}
			}

		});
	}
	;
});

function getDayFromNumber(number) {

	switch (number) {
	case 1:
		day = "Monday";
		break;
	case 2:
		day = "Tuesday";
		break;
	case 3:
		day = "Wednesday";
		break;
	case 4:
		day = "Thursday";
		break;
	case 5:
		day = "Friday";
		break;
	case 6:
		day = "Saturday";
		break;
	case 7:
		day = "Sunday";
		break;
	}

	return day;
};

function addMoreWorkingDays(event) {
	event.preventDefault();
	addMoreFiledsForWorkingDays();
};

function addMoreFiledsForWorkingDays() {

	var days = [];

	$(".workingDaysSelector").each(function() {

		if ($(this).val() == null) {

			days = null;

		} else {

			days = days.concat($(this).val());
		}

	});

	days = $('input[name="working_days[]"]:checked').map(function() {
		return $(this).val();
	}).get();

	if (days.length === 0) {
		showAlert("Select Any Value");
		return false;
	}

	if (days.length != 7) {

		var selectHTML = "";

		for ( var i = 1; i < 8; i++) {

			var day = getDayFromNumber(i);

			var valueExists = days.indexOf("" + i + "");

			var selector = "#addedCheckBox" + i;
			if (valueExists == -1 && $(selector).length == 0) {

				selectHTML += '<div class="col-md-12 addedCheckBox" id="addedCheckBox'
						+ i
						+ '"><div class="pad-top-btm-10"><div class="checkbox">'

				selectHTML += '<label> <input type="checkbox" value="' + i
						+ '" 	name="working_days_single[]"> ' + day
						+ '</label>	</div>';

				selectHTML += '	<select class="select chosen newChosenAdded" style="width: 100px;" name="working_starting_hours'
						+ i + '">';

				selectHTML = getOptionsForHourSelect(selectHTML);

				selectHTML += '</select>';

				selectHTML += '	<select class="select chosen newChosenAdded" style="width: 100px;" name="working_starting_minutes'
						+ i + '">';

				selectHTML = getOptionsForMinuteSelect(selectHTML);

				selectHTML += '</select> <span class="font-11 bold">TO</span>';

				selectHTML += '	<select class="select chosen newChosenAdded" style="width: 100px;" name="working_ending_hours'
						+ i + '">';

				selectHTML = getOptionsForHourSelect(selectHTML);

				selectHTML += '</select>';

				selectHTML += '	<select class="select chosen newChosenAdded " style="width: 100px;" name="working_ending_minutes'
						+ i + '">';

				selectHTML = getOptionsForMinuteSelect(selectHTML);

				selectHTML += '</select></div></div>';

			}
		}

		$("#workingDaysHolder").append(selectHTML);

		$(".newChosenAdded").chosen();

	}

};

function getOptionsForHourSelect(selectHTML) {
	for ( var a = 0; a <= 24; a++) {

		if (parseInt(a) < 10) {
			changeFormat = "0" + a;
		} else {
			changeFormat = a;
		}

		selectHTML += '<option value="' + a + '">' + changeFormat + '</option>'

	}
	return selectHTML;
};

function getOptionsForMinuteSelect(selectHTML) {
	for ( var a = 0; a <= 60; a++) {

		if (parseInt(a) < 10) {
			changeFormat = "0" + a;
		} else {
			changeFormat = a;
		}

		selectHTML += '<option value="' + a + '">' + changeFormat + '</option>'

	}

	return selectHTML;
};

$(function() {
	$('input[name="working_days[]"]').click(function(e) {

		if ($(this).is(':checked')) {

			var value = $(this).val();
			var selector = "#addedCheckBox" + value;

			$(selector).remove();
		} else {
			if ($(".addedCheckBox").length > 0) {

				addMoreFiledsForWorkingDays();
			}
		}
	});
});

function fetchSchoolWithStatus(event) {
	var selector = event.target;
	var value = $(selector).val();

	if (value === "null") {
		var URL = getServerURL() + 'Schoolmanage/viewAllSchools'
	} else {
		var URL = getServerURL() + 'Schoolmanage/viewAllSchools?schools='
				+ value;
	}
	location.replace(URL);

};

/* ==========SEARCH SCHOOL BY NAME================ */

jQuery(function() {

	var delay = (function() {
		var timer = 0;
		return function(callback, ms) {
			clearTimeout(timer);
			timer = setTimeout(callback, ms);
		};
	})();

	$("#searchSchoolByName").keyup(function(e) {

		var searchKey = $(this).val();

		var keyCode = e.keyCode;

		if (keyCode == 40) {

			changeFocusToResult();

		}

		var selector = $(this);

		var id = "#searchSchoolResult";

		if (searchKey.length <= 2) {

			return false
		}

		delay(function() {

			var opts = {
				serviceUrl : "Schoolmanagedata/searchBySchoolName",
				type : "POST",
				data : {
					searchkey : searchKey
				},
				onSuccess : function(data) {
					showSchoolSearchResult(data, selector, id);
				},
				onError : function() {

				},
				maskClass : "",
			};
			$().restService(opts);

		}, 500);

	});

	function showSchoolSearchResult(data, textBoxSelector, id) {
		var parsedData = jQuery.parseJSON(data);

		var selectorWidth = textBoxSelector.outerWidth();
		var selectorHeight = textBoxSelector.outerHeight();
		var pos = textBoxSelector.position();

		$(id).addClass("absolute bg-white text-left");
		$(id).css({
			"width" : parseInt(selectorWidth) + 'px',
			"padding" : "5px",
			"max-height" : '200px',
			"overflow-y" : "auto",
			"top" : pos.top + selectorHeight,
			"left" : pos.left,
			"z-index" : '1',
			"border" : "1px solid #ddd"
		});

		$(id + ' p').remove();
		$(id + ' ul').remove();
		var htmlUL = '<ul class="not-list font-12" style="margin:0;padding:0;width:'
				+ (parseInt(selectorWidth) - 27) + 'px;"></ul>';
		$(id).append(htmlUL);

		if (parsedData === null) {
			var html = '<p class="not-available">No such School found</p>';
			$(id).append(html);
			$(id).show();
		} else {
			for ( var i in parsedData) {
				if (parsedData[i] !== null) {
					var schoolName = parsedData[i].school_name;
					var userID = parsedData[i].user_id;
					var htmlLI = '<li tabindex="'
							+ i
							+ '"class="pad-5 pointer"> <form action ="'
							+ getServerURL()
							+ 'schoolmanage/viewSchool" method="post">'
							+ '<input type="hidden" name="school_id" value="'
							+ userID
							+ '"/>'
							+ '<button type="submit" class="full-width no-border no-bg text-left">'
							+ schoolName + '</button></form></li>';
					$(id + ' ul').append(htmlLI);
					$(id).show();
				}
			}
		}

	}
	;

	function changeFocusToResult(e) {

		$("#searchSchoolResult").find("li:first button").focus();
	}
	;

	$('#searchSchoolResult').on('keydown', 'li', function(e) {
		if (e.which == 40) {
			$(this).next().find("button").focus();
			return false;
		}

	});

	$('#searchSchoolResult').on('hover', 'li', function(e) {
		$(this).find("button").focus();
		return false;
	});

});

/* ================ENDS HERE====================== */