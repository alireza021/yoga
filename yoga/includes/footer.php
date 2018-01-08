
	<div class="container">

		<div class="footer_bottom">
			<div class="copy">
                <p>Copyright © 2018 Alireza Shafiei</p>
	        </div>
	    </div>
	</div>



<script>
function updateSizes(){
	var sizeString = '';

	for(var i=1; i<=12; i++) {
		if(jQuery('#size'+i).val() != ''){
			sizeString += jQuery('#size'+i).val() +',';
		}

	}
	jQuery('#size').val(sizeString);
}

function get_child_options(selected){
	if(typeof selected === 'undefined'){
		var selected = '';
	}
    var parentID = jQuery('#parent').val();
    jQuery.ajax({
     url: '/web/admin/parsers/child_categories.php',
     type: 'POST',
     data: {parentID : parentID, selected: selected},
     success: function(data){
      jQuery('#child').html(data);
     },
     error: function(){alert("Something went wrong with the child options.")},
    });

   }

   jQuery('select[name="parent"]').change(function(){
		 get_child_options();
	 });

</script>



</body>
</html>
