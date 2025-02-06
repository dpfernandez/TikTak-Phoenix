class LoginComponent extends Fronty.ModelComponent {
  constructor(userModel, router) {
    super(Handlebars.templates.login, userModel);
    this.userModel = userModel;
    this.userService = new UserService();
    this.router = router;

    this.addEventListener('click', '#loginbutton', (event) => {
      this.userService.login($('#login').val(), $('#password').val())
        .then(() => {
          this.router.goToPage('public-videos?user=' +$('#login').val());
          this.userModel.setLoggeduser($('#login').val());
		  this.router.updateUser();
        })
        .catch((error) => {
          this.userModel.set((model) => {
            model.loginError = error.responseText;
          });
          this.userModel.logout();
        });
		
    });
  }
}
