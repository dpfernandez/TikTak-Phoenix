class UserModel extends Fronty.Model {
  constructor(id, login, contrasena, rol, alias, email, nacimiento, foto_perfil, n_seguidores) {
    super('UserModel');
    this.isLogged = false;
  
  if (id) {
      this.id = id;
    }
    
    if (login) {
      this.login = login;
    }
    
    if (contrasena) {
      this.contrasena = contrasena;
    }
	
	if (rol) {
      this.rol = rol;
    }
	
	if (alias) {
      this.alias = alias;
    }
	
	if (email) {
      this.email = email;
    }
	
	if (nacimiento) {
      this.nacimiento = nacimiento;
    }
	
	if (foto_perfil) {
      this.foto_perfil = foto_perfil;
    }
	
	if (n_seguidores) {
      this.n_seguidores = n_seguidores;
    }

}
	
  setContrasena(contrasena) {
    this.set((self) => {
      self.contrasena = contrasena;
    });
  }

  setAlias(alias) {
    this.set((self) => {
      self.alias = alias;
    });
  }
  
  setEmail(email) {
    this.set((self) => {
      self.email = email;
    });
  }
  
  setNacimiento(nacimiento) {
    this.set((self) => {
      self.nacimiento = nacimiento;
    });
  }
  
  setFotoPerfil(foto_perfil) {
    this.set((self) => {
      self.foto_perfil = foto_perfil;
    });
  }

  setLoggeduser(loggedUser) {
    this.set((self) => {
      self.currentUser = loggedUser;
      self.isLogged = true;
    });
  }
  
  setSelectedUser(user) {
    this.set((self) => {
      self.selectedUser = user;
    });
  }

  logout() {
    this.set((self) => {
      delete self.currentUser;
      self.isLogged = false;
    });
  }
}
