$('#exampleModalCenter').on('shown.bs.modal', function () {
  $('#myInput').trigger('focus')
})

/* 

$(document).ready(function () {
		$('.editbtn').on('click', function() {
			$('#exampleModalCenter').modal('show');
			$tr = $(this).closest('tr');

			var data = $tr.children("td").map(function () {
				return $(this).text();
			}).get();
			console.log(data);
		});

*/