function fetchStudentWithStatus(event) {
	var selector = event.target;
	var value = $(selector).val();

	if (value === "null") {
		var URL = getServerURL() + 'Students/manageStudents'
	} else {
		var URL = getServerURL() + 'Students/manageStudents?studentStatus='
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

	$("#searchStudentByName").keyup(function(e) {

		var searchKey = $(this).val();

		var keyCode = e.keyCode;

		if (keyCode == 40) {

			changeFocusToResult();

		}

		var selector = $(this);

		var id = "#searchStudentResult";

		if (searchKey.length <= 2) {

			return false
		}

		delay(function() {

			var opts = {
				serviceUrl : "Studentdata/searchStudentByName",
				type : "POST",
				data : {
					searchkey : searchKey
				},
				onSuccess : function(data) {
					showStudentSearchResult(data, selector, id);
				},
				onError : function() {

				},
				maskClass : "",
			};
			$().restService(opts);

		}, 500);

	});

	function showStudentSearchResult(data, textBoxSelector, id) {
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
					console.log(parsedData[i]);
					var StudentName = parsedData[i].student_name;
					var userID = parsedData[i].user_id;
					var htmlLI = '<li tabindex="'
							+ i
							+ '"class="pad-5 pointer"> <form action ="'
							+ getServerURL()
							+ 'Students/viewStudent" method="post">'
							+ '<input type="hidden" name="student_id" value="'
							+ userID
							+ '"/>'
							+ '<button type="submit" class="full-width no-border no-bg text-left">'
							+ StudentName + '</button></form></li>';
					$(id + ' ul').append(htmlLI);
					$(id).show();
				}
			}
		}

	}
	;

	function changeFocusToResult(e) {

		$("#searchStudentResult").find("li:first button").focus();
	}
	;

	$('#searchStudentResult').on('keydown', 'li', function(e) {
		if (e.which == 40) {
			$(this).next().find("button").focus();
			return false;
		}

	});

	$('#searchStudentResult').on('hover', 'li', function(e) {
		$(this).find("button").focus();
		return false;
	});

	$("#fetchMoreStudents").click(function(e) {
		e.preventDefault();

		var pageNo = $(this).data("page");
		var status = $("#studentListStatus").val();
		pageNo = pageNo + 1;

		var opts = {
			serviceUrl : "studentdata/fetchMoreStudents",
			type : "POST",
			data : {
				pageNo : pageNo,
				status : status
			},
			onSuccess : function(data) {
				displayMoreStudents(data);
			},
			onError : function() {
			},
			loadingText : "Fetching More Students...."
		};
		$().restService(opts);
	});
	var displayMoreStudents = function(data) {
		var parsedData = jQuery.parseJSON(data);
		var html = "";
		countOfData = parsedData.length;

		var itemsInPage = $("#itemsInPage").val();

		var slNo = parseInt(itemsInPage) + 1;

		for ( var i in parsedData) {

			var studentId = parsedData[i].user_id;
			var studentName = parsedData[i].student_name;
			var email = parsedData[i].email_id;
			var mobileNumber = parsedData[i].mobile_number;
			var status = parsedData[i].status;

			var colorClass = 0;

			var form = '';

			if (status == 1) {

				form = '<form action="'
						+ getServerURL()
						+ 'Students/mangeStudentStatus" method="post" class="inline" >'
						+ '<button type="submit" class="glyphicon glyphicon-ok-circle no-bg no-border font-size-20 gb-blue" role="button"></button>'
						+ '<input type="hidden" value="' + studentId
						+ '"name="school_id" /> '
						+ '<input type="hidden" value="' + status
						+ '"name="status" /> ' + '</form>';
				var statusText = '<span class="green">Active</span>';

			} else if (status == 0) {

				form = '<form action="'
						+ getServerURL()
						+ 'Students/mangeStudentStatus" method="post" class="inline" >'
						+ '<button type="submit" class="glyphicon  glyphicon-remove-circle  no-bg no-border font-size-20 gb-blue" role="button"></button>'
						+ '<input type="hidden" value="' + studentId
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
					+ studentId
					+ '"  ">'
					+ studentName
					+ '</a></td>'

					+ '<td><a href="'
					+ getServerUrl()
					+ 'Faculty/addFaculty?userId='
					+ studentId
					+ '"  ">'
					+ email
					+ '</a></td>'

					+ '<td><a href="'
					+ getServerUrl()
					+ 'Faculty/addFaculty?userId='
					+ studentId
					+ '"  ">'
					+ mobileNumber
					+ '</a></td>'

					+ '<td>'
					+ statusText
					+ '</td>'

					+ '<td><div>'
					+ '<form action="'
					+ getServerURL()
					+ 'Students/addStudents" method="post" class="inline" >'
					+ '<button type="submit" class="glyphicon glyphicon-edit no-bg no-border font-size-20 gb-blue" role="button"></button>'
					+ '<input type="hidden" value="'
					+ studentId
					+ '"name="userId" /> '
					+ '</form>'

					+ '<form action="'
					+ getServerURL()
					+ 'Students/viewStudent" method="post" class="inline" >'
					+ '<button type="submit" class="glyphicon glyphicon-eye-open no-bg no-border font-size-20 gb-blue" role="button"></button>'
					+ '<input type="hidden" value="' + studentId
					+ '"name="student_id" /> ' + '</form>' + form
					+ '</div></td></tr>';

		}

		$("#studentListing").append(html);

		var pageNo = $("#fetchMoreStudents").data("page");
		pageNo = pageNo + 1;
		$("#fetchMoreStudents").data('page', pageNo);

		var totalCount = $("#totalStudentsCount").val();
		itemsInPage = parseInt(itemsInPage) + parseInt(countOfData);
		$("#itemsInPage").val(itemsInPage);
		if (itemsInPage == totalCount) {
			$("#fetchMoreStudents").hide();
		}
	};

});