// function expand(id_variedad) {
	// // alert(id_variedad);
	// document.getElementById(id_variedad).style.display="none";
// } onClick=expand('{{id}}')

$(document).ready(function(){
	$('.variedad .medio').hide();
	$('.variedad .expand').click(function() {
		$(this).parent('.mini').hide();
		$(this).parent().parent('.variedad').find('.medio').show();
	});
	$('.variedad .cerrar').click(function() {
		$(this).parent().parent().parent('.medio').hide();
		$(this).parent().parent().parent().parent('.variedad').find('.mini').show();
	});
	
});


 // this will hide all instances of .editForm
   /* $('.variedad .expand').click(function() { //assign 1 handler for all cases
       $(this).parent('.variedad').siblings('.medio').show(); // show the sibling edit form
       $(this).parent('.mini').hide(); // hide the sibling contents element
    });
*/