class UserService {
  constructor() {

  }

  loginWithSessionData() {
    var self = this;
    return new Promise((resolve, reject) => {
      if (window.sessionStorage.getItem('login') &&
        window.sessionStorage.getItem('pass')) {
        self.login(window.sessionStorage.getItem('login'), window.sessionStorage.getItem('pass'))
          .then(() => {
            resolve(window.sessionStorage.getItem('login'));
          })
          .catch(() => {
            reject();
          });
      } else {
        resolve(null);
      }
    });
  }

  login(login, pass) {
    return new Promise((resolve, reject) => {

      $.get({
          url: AppConfig.backendServer+'/rest/user/' + login,
          beforeSend: function(xhr) {
            xhr.setRequestHeader("Authorization", "Basic " + btoa(login + ":" + pass));
          }
        })
        .then(() => {
          //keep this authentication forever
          window.sessionStorage.setItem('login', login);
          window.sessionStorage.setItem('pass', pass);
          $.ajaxSetup({
            beforeSend: (xhr) => {
              xhr.setRequestHeader("Authorization", "Basic " + btoa(login + ":" + pass));
            }
          });
          resolve();
        })
        .fail((error) => {
          window.sessionStorage.removeItem('login');
          window.sessionStorage.removeItem('pass');
          $.ajaxSetup({
            beforeSend: (xhr) => {}
          });
          reject(error);
        });
    });
  }

  logout() {
    window.sessionStorage.removeItem('login');
    window.sessionStorage.removeItem('pass');
    $.ajaxSetup({
      beforeSend: (xhr) => {}
    });
  }
  
  getAllUsers() {
    return $.get(AppConfig.backendServer+'/rest/user/users');
  }
  
  getUser() {
    return $.get(AppConfig.backendServer+'/rest/user');
  }
  
  findUserByLogin(login) {
    return $.get(AppConfig.backendServer+'/rest/user/login/' + login);
  }
  
  findUserByVideoId(id) {
    return $.get(AppConfig.backendServer+'/rest/user/idvideo/' + id);
  }

  register(user) {
    return $.ajax({
      url: AppConfig.backendServer+'/rest/user',
      method: 'POST',
      data: JSON.stringify(user),
      contentType: 'application/json'
    });
  }
  
  saveUserData(data) {
    return $.ajax({
      url: AppConfig.backendServer+'/rest/user',
      method: 'PUT',
      data: JSON.stringify(data),
      contentType: 'application/json'
    });
  }
  
  saveUserPhoto(formData, login){
	 return $.ajax({
      url: AppConfig.backendServer+'/rest/user/' + login,
      method: 'POST',
	  type:'POST',
	  data: formData,
	  cache:false,
	  contentType: false,
	  processData: false
    });
  }
	  
}
