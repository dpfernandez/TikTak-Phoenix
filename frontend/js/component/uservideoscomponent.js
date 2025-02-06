class UserVideosComponent extends Fronty.ModelComponent {
  constructor(videosModel, userModel, router) {
    super(Handlebars.templates.uservideos, videosModel);
	this.videosModel = videosModel; // posts
    this.userModel = userModel; // global
	this.addModel('user', userModel);
    this.router = router;

    this.videosService = new VideosService();
	this.userService = new UserService();
 
  }

  onStart() {
    var selectedLogin = this.router.getRouteQueryParam('login');
    this.loadVideos(selectedLogin);
	this.loadUser(selectedLogin);
  }

  loadVideos(userLogin) {
    if (userLogin != null) {
       this.videosService.findUserVideosByLogin(userLogin).then((data) => {

      this.videosModel.setVideos(
        // create a Fronty.Model for each item retrieved from the backend
        data.map(
          (item) => new VideoModel(item.id, item.autor, item.nombre, item.texto, item.ubicacion, item.fecha_subida, item.n_likes, item.visible)
      ));
    });
    }
  }
  
  loadUser(userLogin) {
    if (userLogin != null) {
       this.userService.findUserByLogin(userLogin)
		.then((user) => {
          this.userModel.setSelectedUser(user);
        });
    }
  }
  
  // Override
  createChildModelComponent(className, element, id, modelItem) {
    return new UserVideoComponent(modelItem, this.userModel, this.router, this);
  }
}

class UserVideoComponent extends Fronty.ModelComponent {
  constructor(videoModel, userModel, router, userVideosComponent) {
    super(Handlebars.templates.uservideo, videoModel, null, null);
    
    this.userVideosComponent = userVideosComponent;
    
    this.userModel = userModel;
    this.addModel('user', userModel); // a secondary model
    
    this.router = router;
	
	 this.addEventListener('click', '.watch-button', (event) => {
      var videoId = event.target.getAttribute('item');
      this.router.goToPage('watch-video?id=' + videoId);
    });
	
  }
}