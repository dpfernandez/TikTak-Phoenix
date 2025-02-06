class UsersModel extends Fronty.Model {

  constructor() {
    super('UsersModel'); //call super

    // model attributes
    this.users = [];
  }

  setUsers(users) {
    this.set((self) => {
      self.users = users;
    });
  }
}
