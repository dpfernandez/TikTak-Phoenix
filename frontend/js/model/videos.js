class VideosModel extends Fronty.Model {

  constructor() {
    super('VideosModel'); //call super

    // model attributes
    this.videos = [];
  }

  setSelectedVideo(video) {
    this.set((self) => {
      self.selectedVideo = video;
    });
  }

  setVideos(videos) {
    this.set((self) => {
      self.videos = videos;
    });
  }
}
