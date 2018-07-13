//form-validation.js
$(document).ready(function(){
$('.form').validate({ // initialize plugin
			ignore:":not(:visible)",			
			rules: {
				phone     : "required",
				lname     : "required",
				email    : {required : true, email:true},
				username : "required",
				alevel : "required",
				assignment : "required",
				phone : "required",
				medic : "required",
				rpassword: { required : true, equalTo: "#password"},
			},
	    });
}