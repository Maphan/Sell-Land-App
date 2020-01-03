// login admin //
function btn() {
if (document.getElementById('user_name').value == ""
   || document.getElementById('user_pass').value == ""
   )
  {  
  alert("**คุณยังไม่กรอกข้อมูล");
  } 
else {
 document.getElementById('img_default').style.display = "none";
 document.getElementById('img_loading').style.display = "block";
 }
}



		$.validator.setDefaults( {
			submitHandler: function () {
//				alert( "submitted!" );
				HTMLFormElement("#signinForm").submit;
			}
		} );

		$( document ).ready( function () {

			$( "#signupForm" ).validate( {
				rules: {
					first_name: {
						required: true,
						maxlength:100
					},
					last_name: {
						required: true,
						maxlength:100
					},
					Email: {
						required: true,
						email: true
					},
					password: {
						required: true,
						minlength: 6
					},
					confirm_password: {
						required: true,
						minlength: 6,
						equalTo: "#password"
					},
					
					agree: "required"
				},
				messages: {
					first_name: {
						required: "*กรอกชื่อของคุณ",
						maxlength: "*มีความยาวมากเกินไป"
					},
					last_name:  {
						required: "*กรอกสกุลของคุณ",
						maxlength: "*มีความยาวมากเกินไป"
					},
					Email: "*กรอกอีเมลที่ถูกต้องของคุณ",
					password: {
						required: "*กรอกรหัสของคุณ",
						minlength: "*ต้องมีความยาวไม่น้อยกว่า 6 "
					},
					confirm_password: {
						required: "*กรอกชื่อของคุณ",
						minlength: "*ต้องมีความยาวไม่น้อยกว่า 6",
						equalTo: "*รหัสไม่ตรงกัน"
					},
					
					agree: "*ยอมรับเงื่อนไขการให้บริการ"
				},
				errorElement: "em",
				errorPlacement: function ( error, element ) {
					// Add the `help-block` class to the error element
					error.addClass( "help-block" );

					// Add `has-feedback` class to the parent div.form-group
					// in order to add icons to inputs
					element.parents( ".col-sm-5" ).addClass( "has-feedback" );

					if ( element.prop( "type" ) === "checkbox" ) {
						error.insertAfter( element.parent( "label" ) );
					} else {
						error.insertAfter( element );
					}

					// Add the span element, if doesn't exists, and apply the icon classes to it.
					if ( !element.next( "span" )[ 0 ] ) {
						$( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>" ).insertAfter( element );
					}
				},
				success: function ( label, element ) {
					// Add the span element, if doesn't exists, and apply the icon classes to it.
					if ( !$( element ).next( "span" )[ 0 ] ) {
						$( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $( element ) );
					}
				},
				highlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
					$( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );
				},
				unhighlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
					$( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );
				}
			} );
		} );