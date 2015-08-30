function fetchFacultyWithStatus(event) {
	var selector = event.target;
	var value = $(selector).val();

	if (value === "null") {
		var URL = getServerURL() + 'Faculty/manageFaculty'
	} else {
		var URL = getServerURL() + 'Faculty/manageFaculty?facultyStatus='
				+ value;
	}
	location.replace(URL);

};

jQuery(function() {

	var delay = (function() {
		var timer = 0;
		return function(callback, ms) {
			clearTimeout(timer);
			timer = setTimeout(callback, ms);
		};
	})();

	$("#searchFacultyByName").keyup(function(e) {

		var searchKey = $(this).val();

		var keyCode = e.keyCode;

		if (keyCode == 40) {

			changeFocusToResult();

		}

		var selector = $(this);

		var id = "#searchFacultyResult";

		if (searchKey.length <= 2) {

			return false
		}

		delay(function() {

			var opts = {
				serviceUrl : "Facultydata/searchFacultyByName",
				type : "POST",
				data : {
					searchkey : searchKey
				},
				onSuccess : function(data) {
					showFacultySearchResult(data, selector, id);
				},
				onError : function() {

				},
				maskClass : "",
			};
			$().restService(opts);

		}, 500);

	});

	function showFacultySearchResult(data, textBoxSelector, id) {
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
			var html = '<p class="not-available">No such Faculty found</p>';
			$(id).append(html);
			$(id).show();
		} else {
			for ( var i in parsedData) {
				if (parsedData[i] !== null) {
					console.log(parsedData[i]);
					var FacultyName = parsedData[i].faculty_name;
					var userID = parsedData[i].user_id;
					var htmlLI = '<li tabindex="'
							+ i
							+ '"class="pad-5 pointer"> <form action ="'
							+ getServerURL()
							+ 'Faculty/viewFaculty" method="post">'
							+ '<input type="hidden" name="userId" value="'
							+ userID
							+ '"/>'
							+ '<button type="submit" class="full-width no-border no-bg text-left">'
							+ FacultyName + '</button></form></li>';
					$(id + ' ul').append(htmlLI);
					$(id).show();
				}
			}
		}

	}
	;

	function changeFocusToResult(e) {

		$("#searchFacultyResult").find("li:first button").focus();
	}
	;

	$('#searchFacultyResult').on('keydown', 'li', function(e) {
		if (e.which == 40) {
			$(this).next().find("button").focus();
			return false;
		}

	});

	$('#searchFacultyResult').on('hover', 'li', function(e) {
		$(this).find("button").focus();
		return false;
	});

	$("#fetchMoreFaculty").click(function(e) {
		e.preventDefault();

		var pageNo = $(this).data("page");
		var status = $("#facultyListStatus").val();
		pageNo = pageNo + 1;

		var opts = {
			serviceUrl : "Facultydata/fetchMoreFaculties",
			type : "POST",
			data : {
				pageNo : pageNo,
				status : status
			},
			onSuccess : function(data) {
				displayMoreFaculties(data);
			},
			onError : function() {
			},
			loadingText : "Fetching More Faculties...."
		};
		$().restService(opts);
	});
	var displayMoreFaculties = function(data) {
		var parsedData = jQuery.parseJSON(data);
		var html = "";
		countOfData = parsedData.length;

		var itemsInPage = $("#itemsInPage").val();

		var slNo = parseInt(itemsInPage) + 1;

		for ( var i in parsedData) {

			var facultyID = parsedData[i].user_id;
			var facultyName = parsedData[i].faculty_name;
			var image = parsedData[i].imageURL;
			var email = parsedData[i].email_id;
			var mobileNumber = parsedData[i].mobile_number;
			var designation = parsedData[i].designation;
			var status = parsedData[i].status;

			var colorClass = 0;

			var form = '';

			if (status == 1) {

				form = '<form action="'
						+ getServerURL()
						+ 'Faculty/mangeFacultyStatus" method="post" class="inline" >'
						+ '<button type="submit" class="glyphicon glyphicon-ok-circle no-bg no-border font-size-20 gb-blue" role="button"></button>'
						+ '<input type="hidden" value="' + schoolID
						+ '"name="school_id" /> '
						+ '<input type="hidden" value="' + status
						+ '"name="status" /> ' + '</form>';
				var statusText = '<span class="green">Active</span>';

			} else if (status == 0) {

				form = '<form action="'
						+ getServerURL()
						+ 'Faculty/mangeFacultyStatus" method="post" class="inline" >'
						+ '<button type="submit" class="glyphicon  glyphicon-remove-circle  no-bg no-border font-size-20 gb-blue" role="button"></button>'
						+ '<input type="hidden" value="' + schoolID
						+ '"name="school_id" /> '
						+ '<input type="hidden" value="' + status
						+ '"name="status" /> ' + '</form>';
				var statusText = '<span class="red">Inactive </span>';

			} else if (status == 2) {

				var statusText = '<span class="green">New</span>';

			}

			if (status == 1) {

				colorClass = "green";
			}

			html += '<tr>' + '<td><a href="'
					+ getServerUrl()
					+ 'Faculty/addFaculty?userId='
					+ facultyID
					+ '"  ">'
					+ facultyName
					+ '</a></td>'

					+ '<td><a href="'
					+ getServerUrl()
					+ 'Faculty/addFaculty?userId='
					+ facultyID
					+ '"  ">'
					+ email
					+ '</a></td>'

					+ '<td><a href="'
					+ getServerUrl()
					+ 'Faculty/addFaculty?userId='
					+ facultyID
					+ '"  ">'
					+ mobileNumber
					+ '</a></td>'

					+ '<td><a href="'
					+ getServerUrl()
					+ 'Faculty/addFaculty?userId='
					+ facultyID
					+ '"  ">'
					+ designation
					+ '</a></td>'

					+ '<td>'
					+ statusText
					+ '</td>'

					+ '<td><div>'

					+ '<form action="'
					+ getServerURL()
					+ 'Faculty/addFaculty" method="post" class="inline" >'
					+ '<button type="submit" class="glyphicon glyphicon-edit no-bg no-border font-size-20 gb-blue" role="button"></button>'
					+ '<input type="hidden" value="'
					+ schoolID
					+ '"name="school_id" /> '
					+ '</form>'

					+ '<form action="'
					+ getServerURL()
					+ 'Faculty/viewFaculty" method="post" class="inline" >'
					+ '<button type="submit" class="glyphicon glyphicon-eye-open no-bg no-border font-size-20 gb-blue" role="button"></button>'
					+ '<input type="hidden" value="' + schoolID
					+ '"name="school_id" /> ' + '</form>' + form
					+ '</div></td></tr>';

		}

		$("#facultyListing").append(html);

		var pageNo = $("#fetchMoreFaculty").data("page");
		pageNo = pageNo + 1;
		$("#fetchMoreFaculty").data('page', pageNo);

		var totalCount = $("#totalfacultyCount").val();
		itemsInPage = parseInt(itemsInPage) + parseInt(countOfData);
		$("#itemsInPage").val(itemsInPage);
		if (itemsInPage == totalCount) {
			$("#fetchMoreFaculty").hide();
		}
	};

});