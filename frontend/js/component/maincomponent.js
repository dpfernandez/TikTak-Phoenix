class MainComponent extends Fronty.RouterComponent {
  constructor() {
    super('frontyapp', Handlebars.templates.main, 'maincontent');

    // models instantiation
    // we can instantiate models at any place
    this.userModel = new UserModel();
	this.usersModel = new UsersModel();
	this.hashtagsModel = new HashtagsModel();
	this.videosModel = new VideosModel();
    this.userService = new UserService();
	this.videosService = new VideosService();

    super.setRouterConfig({
	  videos: {
		  component: new VideosComponent(this.videosModel, this.userModel, this),
		  title: 'My Videos'
	  },
	  'public-videos': {
		  component: new PublicVideosComponent(this.videosModel, this.userModel, this),
		  title: 'My Public Videos'
	  },
	  'user-videos': {
		  component: new UserVideosComponent(this.videosModel, this.userModel, this),
		  title: 'User Videos'
	  },
	  'watch-video': {
		  component: new VideoWatchComponent(this.videosModel, this.userModel, this),
		  title: 'Watch Video'
	  },
	 'upload-video': {
		  component: new VideoUploadComponent(this.videosModel, this.userModel, this),
		  title: 'Upload Video'
	  },
      login: {
        component: new LoginComponent(this.userModel, this),
        title: 'Login'
      },
	  register: {
        component: new RegisterComponent(this.userModel, this),
        title: 'Register'
      },
	  profile: {
        component: new EditComponent(this.userModel, this),
        title: 'Modify Profile'
      },
      defaultRoute: 'login'
    });

    Handlebars.registerHelper('currentPage', () => {
          return super.getCurrentPage();
    });

    this.addChildComponent(this._createUserBarComponent());
	this.addChildComponent(this._createHashtagsComponent());
	this.addChildComponent(this._createUsersComponent());
    this.addChildComponent(this._createLanguageComponent());

  }
  
  

  start() {
    // override the start() function in order to first check if there is a logged user
    // in sessionStorage, so we try to do a relogin and start the main component
    // only when login is checked
	
    this.userService.loginWithSessionData()
      .then((logged) => {
        if (logged != null) {
		  this.updateUser();
        }
        super.start(); // now we can call start
      });
	  
  }

  _createUserBarComponent() {
    var userbar = new Fronty.ModelComponent(Handlebars.templates.user, this.userModel, 'userbar');

    userbar.addEventListener('click', '#logoutbutton', () => {
      this.userModel.logout();
      this.userService.logout();
	  super.goToPage('login');
    });

    return userbar;
  }
  
  _createUsersComponent() {
    var users  = new Fronty.ModelComponent(Handlebars.templates.users, this.usersModel, 'users');
	
	users.addEventListener('click', '.userimage-button', (event) => {
      var userLogin = event.target.getAttribute('item');
	  if(userLogin == window.sessionStorage.getItem('login')){
		  super.goToPage('public-videos?currentuser=' + userLogin);
	  }
	  else{
		super.goToPage('user-videos?login=' + userLogin);
	  }
    });
	
	this.updateUsers();

    return users;
  }
  
   _createHashtagsComponent() {
    var hashtags  = new Fronty.ModelComponent(Handlebars.templates.hashtags, this.hashtagsModel, 'hashtags');
	
	
	this.updateHashtags();

    return hashtags;
  }

  _createLanguageComponent() {
    var languageComponent = new Fronty.ModelComponent(Handlebars.templates.language, this.routerModel, 'languagecontrol');
    // language change links
    languageComponent.addEventListener('click', '#englishlink', () => {
      I18n.changeLanguage('default');
      document.location.reload();
    });

    languageComponent.addEventListener('click', '#spanishlink', () => {
      I18n.changeLanguage('es');
      document.location.reload();
    });
	
	languageComponent.addEventListener('click', '#galicianlink', () => {
      I18n.changeLanguage('gal');
      document.location.reload();
    });

    return languageComponent;
  }
  
  
  // recogemos siempre los datos del usuario si está logueado
  updateUser(){
	  this.userService.getUser()
        .then((user) => {
          this.userModel.setLoggeduser(user);
        });
  }
  
  //recogemos todos los hashtags
  updateHashtags() {
      this.videosService.findAllHashtags().then((data) => {

      this.hashtagsModel.setHashtags(
        // create a Fronty.Model for each item retrieved from the backend
        data.map(
          (item) => new HashtagModel(item.id, item.nombre, item.n_veces, item.imagen, item.fecha)
      ));
    });
  }
  
  //recogemos todos los usuarios
  updateUsers() {
      this.userService.getAllUsers().then((data) => {

      this.usersModel.setUsers(
        // create a Fronty.Model for each item retrieved from the backend
        data.map(
          (item) => new UserModel(item.id, item.login, item.contrasena, item.rol, item.alias, item.email, item.nacimiento, item.foto_perfil, item.n_seguidores)
      ));
    });
  }
}
