function editHoliday(holidayId) {

	$('#editHolidays' + holidayId).hide();
	$('#viewHolidayEvent' + holidayId).hide();
	$('#viewHolidayDate' + holidayId).hide();
	$('#saveHolidays' + holidayId).show();
	$('#editHolidayEvent' + holidayId).show();
	$('#datepicker' + holidayId).show();

};