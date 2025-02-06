class HashtagModel extends Fronty.Model {

  constructor(id, nombre, n_veces, imagen, fecha) {
    super('HashtagModel'); //call super
    
    if (id) {
      this.id = id;
    }
    
    if (nombre) {
      this.nombre = nombre;
    }
    
    if (n_veces) {
      this.n_veces = n_veces;
    }
	
	if (imagen) {
      this.imagen = imagen;
    }
	
	if (fecha) {
      this.fecha = fecha;
    }
  }

  setNombre(nombre) {
    this.set((self) => {
      self.nombre = nombre;
    });
  }
  
  setNVeces(n_veces) {
    this.set((self) => {
      self.n_veces = n_veces;
    });
  }
  
  setImagen(imagen) {
    this.set((self) => {
      self.imagen = imagen;
    });
  }
  
  setFecha(fecha) {
    this.set((self) => {
      self.fecha = fecha;
    });
  }
}
