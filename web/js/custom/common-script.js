$(function() {

	/* For Chosen */

	$(".chosen").chosen({
		search_contains : true
	});

	/* Ends here */

	/* For Nav Bar */

	if ($("#registerSchoolContent").length > 0) {

		$("#navBar li").removeClass("active");
		$("#registerSchool").addClass("active");
	}

	if ($("#viewSchoolContent").length > 0) {

		$("#navBar li").removeClass("active");
		$("#viewSchool").addClass("active");
	}
	if ($("#adminHomeContent").length > 0) {

		$("#navBar li").removeClass("active");
		$("#home").addClass("active");
	}

	/* Ends here */

	$("#userActionBadge").bind("clickoutside", function(event) {
		$("#userActions").hide();
		$("#userActionBadge").removeClass("rotateCounter180");
		$("#userActionBadge").addClass("rotate0");
	});

});

function displayUserActionsMenu(event) {

	$("#userActions").toggle();

	if ($("#userActions").is(":visible")) {

		$("#userActionBadge").addClass("rotateCounter180");
		$("#userActionBadge").removeClass("rotate0");

	} else {

		$("#userActionBadge").removeClass("rotateCounter180");
		$("#userActionBadge").addClass("rotate0");
	}

};
function validateChosenSelectInForm(formID, event) {

	$(".chosenNotSelectError").remove();

	var valid = true;

	if ($("#" + formID).valid()) {

		$("#" + formID + " .chosen.validate")
				.each(
						function() {

							if ($(this).next().is(":visible")
									&& $(this).is(':not(:disabled)')) {
								var val = $(this).val();
								if (val == -1 || val == null) {
									valid = false;

									$(this)
											.next()
											.after(
													'<label  class="errorAdded chosenNotSelectError">Select any value</label>');
								}
							}

						});
	}

	if (valid == false) {
		event.preventDefault();
	}
};

function checkIfPincodeValid(formID, e) {

	var valid = true;

	$(".pincodeNotSelectError").remove();

	if ($("#" + formID).valid()) {
		var pincode = $(".locality-search").val();
		if (pincode == "" || pincode.length < 6) {
			var errorHTML = '<label class="errorAdded pincodeNotSelectError">Pincode required</label>';
			$(".locality-search").after(errorHTML);
			valid = false;
		}
	}

	if (valid == false) {
		e.preventDefault();
	}

};

