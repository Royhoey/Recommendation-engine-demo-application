$(document).ready(function(){
	$('.rec-table').DataTable({
		"bPaginate": true,
		"order": [[ 3, "desc" ]]
	 });
});