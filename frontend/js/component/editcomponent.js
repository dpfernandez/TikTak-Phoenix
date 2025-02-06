class EditComponent extends Fronty.ModelComponent {
  constructor(userModel, router) {
    super(Handlebars.templates.useredit, userModel);
    this.userModel = userModel;
    this.router = router;

    this.userService = new UserService();

    this.addEventListener('click', '#savebutton', () => {
	  this.userService.saveUserData({
          alias: $('#alias').val(),
          email: $('#email').val(),
		  birthday: $('#birthday').val(),
		  password: $('#password').val(),
		  repeatPassword: $('#repeat-password').val()
        })
		.then(() => {
			this.router.updateUser();
			this.router.updateUsers();
			alert(I18n.translate('Changes succesfully saved!'));
		  })
		.fail((xhr, errorThrown, statusText) => {
		  if (xhr.status == 400) {
			this.userModel.set((model) => {
			  model.errors = xhr.responseJSON;
			});
		  } else {
			alert('an error has occurred during request: ' + statusText + '.' + xhr.responseText);
		  }
		})
    });
	
	this.addEventListener('click', '#photobutton', () => {
	  var userLogin = window.sessionStorage.getItem('login');
	  var data = new FormData($('#form-imagen')[0]);
	  data.append('foto', $('foto')[0]);
	  this.userService.saveUserPhoto(data,userLogin)
		.then(() => {
			this.router.updateUser();
			this.router.updateUsers();
		})
		.fail((xhr, errorThrown, statusText) => {
		  if (xhr.status == 400) {
			this.userModel.set((model) => {
			  model.errors = xhr.responseJSON;
			});
		  } else {
			alert('an error has occurred during request: ' + statusText + '.' + xhr.responseText);
		  }
		})
	  
    });
  }
}
