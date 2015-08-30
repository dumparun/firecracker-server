function login(form) {
	var pwd = jQuery('#passwordInput').val();
	jQuery('#passwordInput').val("Ff3@skkf98jhHH1");
	jQuery('#passwordHidden').val(CryptoJS.SHA3(pwd));
	form.submit();
	return true;
};

function register() {
	var pwd = jQuery('#user-password').val();
	var cnfPwd = jQuery('#user-confirm-password').val();
	if (pwd !== '' && pwd == cnfPwd) {
		jQuery('#user-password').val(CryptoJS.SHA3(pwd));
		jQuery('#user-confirm-password').val(CryptoJS.SHA3(pwd));
	}
};

function adminLoginCheck(form) {
	var pwd = jQuery('#user-password').val();

	var newpwd = jQuery('#new-user-password').val();

	// this is done to clear the actual password.
	// the actual password is sent as hidden

	jQuery('#new-user-password').val("Ff3@skkf98jhHH1");
	jQuery('#user-password').val("Ff3@skkf98jhHH");
	jQuery('#confirm-user-password').val("Ff3@skkf98jhHH");

	jQuery('#userPassword').val(CryptoJS.SHA3(pwd));

	jQuery('#newuserPassword').val(CryptoJS.SHA3(newpwd));
	form.submit();
	return true;
};

function registerLoginCheck(form) {
	var pwd = jQuery('#register-user-password').val();

	var newpwd = jQuery('#confirm-user-password').val();

	// this is done to clear the actual password.
	// the actual password is sent as hidden

	jQuery('#register-user-password').val("Ff3@skkf98jhHH1");
	jQuery('#confirm-user-password').val("Ff3@skkf98jhHH");

	jQuery('#registerUserPassword').val(CryptoJS.SHA3(pwd));

	jQuery('#registerConfirmPassword').val(CryptoJS.SHA3(newpwd));
	form.submit();
	return true;
};

function guestRegisterCheck(form) {
	var pwd = jQuery('#register-guest-password').val();

	var newpwd = jQuery('#confirm-guest-password').val();

	// this is done to clear the actual password.
	// the actual password is sent as hidden

	jQuery('#register-guest-password').val("Ff3@skkf98jhHH1");
	jQuery('#confirm-guest-password').val("Ff3@skkf98jhHH");

	jQuery('#registerGuestPassword').val(CryptoJS.SHA3(pwd));

	jQuery('#guestRegisterConfirmPassword').val(CryptoJS.SHA3(newpwd));
	form.submit();
	return true;
};

function customerLoginCheck(form) {
	var pwd = jQuery('#user-reset-password').val();

	// this is done to clear the actual password.
	// the actual password is sent as hidden

	jQuery('#user-reset-password').val("Ff3@skkf98jhHH");
	jQuery('#confirm-user-reset-password').val("Ff3@skkf98jhHH");

	jQuery('#user-reset-password-actual').val(CryptoJS.SHA3(pwd));
	form.submit();
	return true;
};

function changePasswordCheck(form) {
	var pwd = jQuery('#passwordInput').val();
	var newpwd = jQuery('#newPasswordInput').val();
	var cnfPwd = jQuery('#confirmNewPasswordInput').val();

	// this is done to clear the actual password.
	// the actual password is sent as hidden

	jQuery('#passwordInput').val("Ff3@skkf98jhHH1$23s");
	jQuery('#newPasswordInput').val("Ff3@skkf98jhHH1$23s");
	jQuery('#confirmNewPasswordInput').val("Ff3@skkf98jhHH1$23s");

	if (pwd !== '' && newpwd == cnfPwd) {
		jQuery('#passwordHidden').val(CryptoJS.SHA3(pwd));
		jQuery('#newPasswordHidden').val(CryptoJS.SHA3(newpwd));
		jQuery('#newPasswordConfirmHidden').val(CryptoJS.SHA3(newpwd));
	}

	form.submit();
	return true;
};

function resetPasswordCheck(form) {
	var pwd = jQuery('#passwordInput').val();
	var cnfPwd = jQuery('#confirmPasswordInput').val();
	jQuery('#passwordInput').val("Ff3@skkf98jhHH1$23s");
	jQuery('#confirmPasswordInput').val("Ff3@skkf98jhHH1$23s");

	if (pwd !== '' && pwd == cnfPwd) {
		jQuery('#passwordHidden').val(CryptoJS.SHA3(pwd));
		jQuery('#passwordConfirmHidden').val(CryptoJS.SHA3(cnfPwd));
	}

	form.submit();
	return true;
};

function validateEmail(sEmail) {
	var reEmail = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;

	if (!sEmail.match(reEmail)) {
		return false;
	}

	return true;

};