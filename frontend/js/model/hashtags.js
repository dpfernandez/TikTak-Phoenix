class HashtagsModel extends Fronty.Model {

  constructor() {
    super('HashtagsModel'); //call super

    // model attributes
    this.hashtags = [];
  }

  setSelectedHashtag(hashtag) {
    this.set((self) => {
      self.selectedHashtag = hashtag;
    });
  }

  setHashtags(hashtags) {
    this.set((self) => {
      self.hashtags = hashtags;
    });
  }
}
