jQuery.validator.addMethod("passwordStrength", function(value, element) {

	return /^[A-Za-z0-9\d=!\-@._*&#]*$/.test(value); // consists of only
	// these

	/*
	 * return /^[A-Za-z0-9\d=!\-@._*&#]*$/.test(value) // consists of only these &&
	 * /[a-z]/.test(value) // has a lowercase letter && /\d/.test(value) // has
	 * a digit && /[A-Z]/.test(value) // has an uppercase letter &&
	 * /[!\-@._*&#]/.test(value); // one special character
	 */

});

jQuery.validator.addMethod("confirmPassword",
		function(value, element, selector) {
			if ($(selector).val() == value) {
				return true;
			}
			return false;
		});
jQuery.validator.addMethod("verifysameChangePassword", function(value, element,
		selector) {
	if ($(selector).val() == value) {
		return false;
	}
	return true;
});
