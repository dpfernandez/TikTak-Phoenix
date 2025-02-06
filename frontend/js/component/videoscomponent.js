class VideosComponent extends Fronty.ModelComponent {
  constructor(videosModel, userModel, router) {
    super(Handlebars.templates.videos, videosModel, null, null);
	
	
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
    return new VideoComponent(modelItem, this.userModel, this.router, this);
  }
}

class VideoComponent extends Fronty.ModelComponent {
  constructor(videoModel, userModel, router, videosComponent) {
    super(Handlebars.templates.video, videoModel, null, null);
    
    this.videosComponent = videosComponent;
    
    this.userModel = userModel;
    this.addModel('user', userModel); // a secondary model
    
    this.router = router;
	
	this.addEventListener('click', '.delete-button', (event) => {
      if (confirm(I18n.translate('Are you sure?'))) {
        var videoId = event.target.getAttribute('item');
        this.videosComponent.videosService.deleteVideo(videoId)
          .fail(() => {
            alert('video cannot be deleted')
          })
          .always(() => {
            this.videosComponent.updateVideos();
			this.router.updateHashtags();
          });
      }
    });

    this.addEventListener('click', '.watch-button', (event) => {
      var videoId = event.target.getAttribute('item');
      this.router.goToPage('watch-video?id=' + videoId);
    });
	
	this.addEventListener('click', '.hideUnHide-button', (event) => {
		var videoId = event.target.getAttribute('item');
        this.videosComponent.videosService.hideUnHide(videoId)
          .fail(() => {
            alert('something has gone wrong')
          })
          .always(() => {
            this.videosComponent.updateVideos();
			this.router.updateHashtags();
          });
    });
  }
  
}
  
