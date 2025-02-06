class VideoUploadComponent extends Fronty.ModelComponent {
  constructor(videosModel, userModel, router) {
    super(Handlebars.templates.videoupload, videosModel);
    this.videosModel = videosModel; 
    
    this.userModel = userModel; 
    this.addModel('user', userModel);
    this.router = router;

    this.videosService = new VideosService();

    this.addEventListener('click', '#uploadbutton', () => {
		if(($('#texto').val() == "")){
			alert(I18n.translate('Select your video and write something for us!'))
		}
		else{
			var data = new FormData($('#form-video')[0]);
			data.append('file', $('file')[0]);
			data.append('text', $('#texto').val());
		
			this.videosService.addVideo(data)
				.then(() => {
				  this.router.goToPage('videos');
				  this.router.updateHashtags();
				})
				.fail((xhr, errorThrown, statusText) => {
				  if (xhr.status == 400) {
					this.videosModel.set(() => {
					  this.videosModel.errors = xhr.responseJSON;
					});
				  } else {
					alert('an error has occurred during request: ' + statusText + '.' + xhr.responseText);
				  }
				});
		}
    });
  }
}