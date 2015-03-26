$('#select_date').on('click', function() {
	var name = $('#date').val();
	$.post('../shifts/show_day.php', {name: date}, function(data) {
		$('#day_view').text(data);
	});
});