class RegisterComponent extends Fronty.ModelComponent {
  constructor(userModel, router) {
    super(Handlebars.templates.register, userModel);
    this.userModel = userModel;
    this.userService = new UserService();
    this.router = router;
	
	this.addEventListener('click', '#registerbutton', () => {
		  if($('#registerlogin').val()=="" || $('#registeralias').val()=="" || $('#registeremail').val()=="" || $('#registernacimiento').val()=="" || $('#registercontrasena').val()==""){
			  alert(I18n.translate('Complete all the fields please!'));
		  }
		  else{
			  if($('#registercontrasena').val() != $('#registercontrasenarepeat').val()){
				   alert(I18n.translate('Passwords are not equal!'));
			  }
			  else{
				  this.userService.register({
				  login: $('#registerlogin').val(),
				  alias: $('#registeralias').val(),
				  email: $('#registeremail').val(),
				  nacimiento: $('#registernacimiento').val(),
				  contrasena: $('#registercontrasena').val()
			})
			.then(() => {
			  this.router.goToPage('login');
			  alert(I18n.translate('User registered! Please login'));
			})
			.fail((xhr, errorThrown, statusText) => {
			  if (xhr.status == 400) {
				this.userModel.set(() => {
				  this.userModel.registerErrors = xhr.responseJSON;
				});
			  } else {
				alert('an error has occurred during request: ' + statusText + '.' + xhr.responseText);
			  }
			});
		   }
		 }
    });
   }
}