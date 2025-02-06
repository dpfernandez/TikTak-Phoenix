class VideoModel extends Fronty.Model {

  constructor(id, autor, nombre, texto, ubicacion, fecha_subida, n_likes, visible) {
    super('VideoModel'); //call super
    
    if (id) {
      this.id = id;
    }
    
    if (autor) {
      this.autor = autor;
    }
    
    if (nombre) {
      this.nombre = nombre;
    }
	
	if (texto) {
      this.texto = texto;
    }
	
	if (ubicacion) {
      this.ubicacion = ubicacion;
    }
	
	if (fecha_subida) {
      this.fecha_subida = fecha_subida;
    }
	
	if (n_likes) {
      this.n_likes = n_likes;
    }
	
	if (visible) {
      this.visible = visible;
    }
  }

  setLogin(login) {
    this.set((self) => {
      self.login = login;
    });
  }

  setNombre(nombre) {
    this.set((self) => {
      self.nombre = nombre;
    });
  }
  
  setTexto(texto) {
    this.set((self) => {
      self.texto = texto;
    });
  }
  
  setUbicacion(ubicacion) {
    this.set((self) => {
      self.ubicacion = ubicacion;
    });
  }
  
  setFechaSubida(fecha_subida) {
    this.set((self) => {
      self.fecha_subida = fecha_subida;
    });
  }
  
  setNLikes(n_likes) {
    this.set((self) => {
      self.n_likes = n_likes;
    });
  }
  
  setVisible(visible) {
    this.set((self) => {
      self.visible = visible;
    });
  }
}
