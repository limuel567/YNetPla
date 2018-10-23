<script type="text/javascript">
    $("body").delegate(".remove-data","click",function(e){
        e.preventDefault();
        // Set this selector
        var selector = $(this);
        // Set location
        var location = selector.data("location");
        // Content of sweet alert
		swal({
			title             : "Are you sure?",
			text              : "You will not be able to recover this file!",
			type              : "warning",
			showCancelButton  : true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText : "Yes, delete it!",
			cancelButtonText  : "No, cancel it!",
			closeOnConfirm    : false,
			closeOnCancel     : false 
		}, function(isConfirm){
			// Check if confirm is clicked
			if(isConfirm){
				// Redirect location
				setTimeout(function(){
                    window.location = location;
                }, 800);
			}
			else{
				swal("Cancelled", "Your content is safe.", "error");
			}
		});
    });
</script>