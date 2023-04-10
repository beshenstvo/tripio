<template>
  <section class="vh-100 gradient-custom">
  <div class="container py-2 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase">Авторизация</h2>
              <p class="text-black-50 mb-5">Пожалуйста введите свою почту и пароль!</p>

              <div class="form-outline form-white mb-4">
                <input 
                  type="email" 
                  id="email" 
                  class="form-control form-control-lg" 
                  placeholder="Email"
                  v-model="form.email"
                />
                <span class="text-danger" v-if="errors.email">
                  {{ errors.email[0] }}
                </span>
                <!-- <label class="form-label" for="typeEmailX">Email</label> -->
              </div>

              <div class="form-outline form-black mb-4">
                <input 
                  type="password" 
                  id="typePasswordX" 
                  class="form-control form-control-lg" 
                  placeholder="Пароль"
                  v-model="form.password"
                />
                <span class="text-danger" v-if="errors.password">
                  {{ errors.password[0] }}
                </span>
              </div>

              <!-- <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#!">Forgot password?</a></p> -->
              <div class="mb-2">
                <span class="text-danger" v-if="errors">
                  {{ errors }}
                </span>
              </div>

              <button class="btn btn-outline-dark btn-lg px-5" @click.prevent="login">Войти</button>

            </div>

            <div>
              <p class="mb-0">Еще нет аккаунта? <router-link class="text-black-50 fw-bold" :to="{ name: 'Register' }">Зарегистрируйся</router-link>
              </p>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</template>

<script>
export default {
  data() {
    return {
      form: {
        email: "",
        password: ""
      },
      errors: ''
    };
  },
  methods: {
    login(e){
      const data = {
          email : this.form.email,
          password : this.form.password
      }
        axios.get('/sanctum/csrf-cookie');
        axios.post('/api/login', data).then((res) => {
            if (res.data.success) {                      
                localStorage.setItem('token', res.data);
                localStorage.setItem('isLoggedIn', true);
                localStorage.setItem('role', 'user');
                this.$router.push({ path: "/" });
            } else {     
                console.log('errors')                                     
            }
        }).catch((e) => {
            this.errors = e.response.data.message
        })  
    }
  }
}
</script>

<style scoped>
.form-control {
  background-color: white;
}
.gradient-custom {
/* fallback for old browsers */
background: #6a11cb;

/* Chrome 10-25, Safari 5.1-6 */
background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
}
</style>