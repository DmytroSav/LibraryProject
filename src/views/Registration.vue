<template>
  <div>
    <div class="sidenav">
      <div class="login-main-text text-left">
        <h2>Library App <br/> Registration page </h2>
        <p>Login or register here to start storing your books</p>
      </div>
    </div>
    <div class="main">
      <div class="col-md-6 col-sm-12">
        <div class="login-form">
          <form>
            <div class="form-group" v-if="registration">
              <label>User Name</label>
              <input type="text"
                     class="form-control"
                     :class="{'is-invalid': invalidName}"
                     placeholder="User Name"
                     v-model="form.name">
              <div class="invalid-feedback">
                this field's required
              </div>
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email"
                     class="form-control"
                     :class="{'is-invalid': invalidEmail}"
                     placeholder="User Email"
                     v-model="form.email">
              <div class="invalid-feedback">
                this field's required
              </div>
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password"
                     class="form-control"
                     :class="{'is-invalid': invalidPassword}"
                     placeholder="Password"
                     v-model="form.password">
              <div class="invalid-feedback">
                this field's required
              </div>
            </div>
            <div class="form-group" v-if="registration">
              <label>Confirm Password</label>
              <input type="password"
                     class="form-control"
                     :class="{'is-invalid': invalidPasswordConf || passwordMismatch }"
                     placeholder="Confirm Password"
                      v-model="form.conf">
              <div class="invalid-feedback" v-if="invalidPasswordConf">
                this field's required
              </div>
              <div class="invalid-feedback" v-if="passwordMismatch">
                password confirmation does not match
              </div>
            </div>
            <button type="submit"
                    class="btn m-1"
                    :class="{'btn-black': !registration, 'btn-secondary': registration}"
                    @click="login">Login</button>
            <button type="submit"
                    class="btn m-1"
                    :class="{'btn-black': registration, 'btn-secondary': !registration}"
                    @click="register">Register</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {},
      invalidName: false,
      registration: false,
      invalidEmail: false,
      invalidPassword: false,
      passwordMismatch: false,
      invalidPasswordConf: false
    }
  },
  created(){
    let token = localStorage.getItem('user_token');
      if(token) this.$router.push(({ name: "Library"}));
  },

  methods: {
    register() {
      if (this.registration) {
        this.submitRegistrationForm();
      } else {
        this.registration = true;
        this.form = {};
      }
    },

    login() {
      if (!this.registration) {
        this.submitLoginForm();
      } else {
        this.registration = false;
        this.form = {};
      }
    },

    submitRegistrationForm(){
      // this.validateRegistration();
      let data = {
        name: this.form.name,
        email: this.form.email,
        password: this.form.password
      }
      this.axios.post(process.env.VUE_APP_API_URL + 'register/', data)
      .then(res => {
        localStorage.setItem('user_token', res.data)
        this.$router.push(({ name: "Library"}));
      });
    },

    submitLoginForm(){
      this.validateLogin();

      let data = {
        email: this.form.email,
        password: this.form.password
      }
      this.axios.put(process.env.VUE_APP_API_URL + 'login', data)
          .then(res => {
            if(res.data.status == 404) alert('your email or password is incorrect. ' +
                'Please double-check them or register a new account');
            else{
              localStorage.setItem('user_token', res.data);
              this.$router.push(({ name: "Library"}));
            }
          });

    },

    validateRegistration(){
      this.checkEmailValid();
      this.checkNameValid();
      this.checkPasswordValid();
      this.checkPasswordConfValid();
    },

    checkEmailValid(){
      this.invalidEmail = !this.form.email;
    },

    checkNameValid(){
      this.invalidName = !this.form.name;
    },

    checkPasswordValid(){
      this.invalidPassword = !this.form.password;
    },
    checkPasswordConfValid(){
       this.invalidPasswordConf = !this.form.conf;
       this.passwordMismatch = this.form.conf !== this.form.password;
    },

    validateLogin(){
      this.checkEmailValid();
      this.checkPasswordValid();
    }
  }
}
</script>
<style src="../assets/styles/registration.css">

</style>