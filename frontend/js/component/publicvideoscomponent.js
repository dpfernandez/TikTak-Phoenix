class PublicVideosComponent extends Fronty.ModelComponent {
  constructor(videosModel, userModel, router) {
    super(Handlebars.templates.publicvideos, videosModel, null, null);
	
	
    this.videosModel = videosModel;
	this.userModel = userModel;
	this.addModel('user', userModel);
	this.router = router;
	
	this.videosService = new VideosService();

}
  
  onStart() {
    this.updateVideos();
  }

  updateVideos() {
    this.videosService.findAllVideos().then((data) => {

      this.videosModel.setVideos(
        // create a Fronty.Model for each item retrieved from the backend
        data.map(
          (item) => new VideoModel(item.id, item.autor, item.nombre, item.texto, item.ubicacion, item.fecha_subida, item.n_likes, item.visible)
      ));
    });
  }
  
  // Override
  createChildModelComponent(className, element, id, modelItem) {
    return new PublicVideoComponent(modelItem, this.userModel, this.router, this);
  }
}

class PublicVideoComponent extends Fronty.ModelComponent {
  constructor(videoModel, userModel, router, publicVideosComponent) {
    super(Handlebars.templates.publicvideo, videoModel, null, null);
    
    this.publicVideosComponent = publicVideosComponent;
    
    this.userModel = userModel;
    this.addModel('user', userModel); // a secondary model
    
    this.router = router;
	
	 this.addEventListener('click', '.watch-button', (event) => {
      var videoId = event.target.getAttribute('item');
      this.router.goToPage('watch-video?id=' + videoId);
    });
	
  }
}
  
