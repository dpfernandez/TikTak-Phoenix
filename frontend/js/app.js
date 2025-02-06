

//load external resources
function loadTextFile(url) {
  return new Promise((resolve, reject) => {
    $.get({
      url: url,
      cache: false,
      dataType: 'text'
    }).then((source) => {
      resolve(source);
    }).fail(() => reject());
  });
}


// Configuration
var AppConfig = {
  backendServer: 'http://localhost/TK_21'
  //backendServer: '/mvcblog'
}

Handlebars.templates = {};
Promise.all([
    I18n.initializeCurrentLanguage('js/i18n'),
    loadTextFile('templates/components/main.hbs').then((source) =>
      Handlebars.templates.main = Handlebars.compile(source)),
	loadTextFile('templates/components/users.hbs').then((source) =>
      Handlebars.templates.users = Handlebars.compile(source)),
	loadTextFile('templates/components/hashtags.hbs').then((source) =>
      Handlebars.templates.hashtags = Handlebars.compile(source)),
    loadTextFile('templates/components/language.hbs').then((source) =>
      Handlebars.templates.language = Handlebars.compile(source)),
    loadTextFile('templates/components/user.hbs').then((source) =>
      Handlebars.templates.user = Handlebars.compile(source)),
	loadTextFile('templates/components/user-edit.hbs').then((source) =>
      Handlebars.templates.useredit = Handlebars.compile(source)),
    loadTextFile('templates/components/login.hbs').then((source) =>
      Handlebars.templates.login = Handlebars.compile(source)),
	loadTextFile('templates/components/register.hbs').then((source) =>
      Handlebars.templates.register = Handlebars.compile(source)),
	loadTextFile('templates/components/public-videos.hbs').then((source) =>
      Handlebars.templates.publicvideos = Handlebars.compile(source)),
	loadTextFile('templates/components/user-videos.hbs').then((source) =>
      Handlebars.templates.uservideos = Handlebars.compile(source)),
	loadTextFile('templates/components/videos.hbs').then((source) =>
      Handlebars.templates.videos = Handlebars.compile(source)),
	loadTextFile('templates/components/public-video.hbs').then((source) =>
      Handlebars.templates.publicvideo = Handlebars.compile(source)),
	loadTextFile('templates/components/video-watch.hbs').then((source) =>
      Handlebars.templates.videowatch = Handlebars.compile(source)),
	loadTextFile('templates/components/video-upload.hbs').then((source) =>
      Handlebars.templates.videoupload = Handlebars.compile(source)),
	loadTextFile('templates/components/public-video.hbs').then((source) =>
      Handlebars.templates.publicvideo = Handlebars.compile(source)),
	loadTextFile('templates/components/user-video.hbs').then((source) =>
      Handlebars.templates.uservideo = Handlebars.compile(source)),
	loadTextFile('templates/components/video.hbs').then((source) =>
      Handlebars.templates.video = Handlebars.compile(source))
  ])
  .then(() => {
    $(() => {
      new MainComponent().start();
    });
  }).catch((err) => {
    alert('FATAL: could not start app ' + err);
  });
