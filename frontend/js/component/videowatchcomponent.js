class VideoWatchComponent extends Fronty.ModelComponent {
  constructor(videosModel, userModel, router) {
    super(Handlebars.templates.videowatch, videosModel);
	this.videosModel = videosModel; // posts
    this.userModel = userModel; // global
    this.addModel('user', userModel);
    this.router = router;

    this.videosService = new VideosService();
	this.userService = new UserService();
 
  }

  onStart() {
    var selectedId = this.router.getRouteQueryParam('id');
	this.loadUser(selectedId);
    this.loadVideo(selectedId);
	window.scrollTo(0, 0);
  }

  loadVideo(videoId) {
    if (videoId != null) {
      this.videosService.watchVideo(videoId)
        .then((video) => {
          this.videosModel.setSelectedVideo(video);
        });
    }
  }
  
  loadUser(videoId) {
    if (videoId != null) {
      this.userService.findUserByVideoId(videoId)
        .then((user) => {
          this.userModel.setSelectedUser(user);
        });
    }
  }
}
