class VideosService {
  constructor() {

  }

  findAllVideos() {
    return $.get(AppConfig.backendServer+'/rest/video');
  }
  
  findUserVideosByLogin(login) {
    return $.get(AppConfig.backendServer+'/rest/video/videos/' + login);
  }
  
  findAllHashtags() {
	   return $.get(AppConfig.backendServer+'/rest/video/hashtag');
  }
  
  watchVideo(id) {
    return $.get(AppConfig.backendServer+'/rest/video/' + id);
  }
  
  deleteVideo(id) {
    return $.ajax({
      url: AppConfig.backendServer+'/rest/video/' + id,
      method: 'DELETE'
    });
  }
  
  hideUnHide(id){
	 return $.ajax({
      url: AppConfig.backendServer+'/rest/video/' + id,
      method: 'PUT'
    });
  }  
  
  addVideo(formData){
	 return $.ajax({
      url: AppConfig.backendServer+'/rest/video',
      method: 'POST',
	  type:'POST',
	  data: formData,
	  cache:false,
	  contentType: false,
	  processData: false
    });
  }

}
