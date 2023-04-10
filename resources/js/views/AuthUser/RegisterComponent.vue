<template>
<section class="vh-100 gradient-custom">
  <div class="container py-2 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase">Регистрация</h2>
              <p class="text-black-50 mb-5">Пожалуйста введите свои данные!</p>

              <div class="form-outline form-white mb-4">
                <input
                  type="text"
                  v-model="form.name"
                  class="form-control form-control-lg"
                  id="name"
                  placeholder="Иван Иванов"
                />
                <span class="text-danger" v-if="errors.name">
                  {{ errors.name[0] }}
                </span>
              </div>

              <div class="form-outline form-black mb-4">
                <input
                  type="email"
                  v-model="form.email"
                  class="form-control form-control-lg"
                  id="email"
                  placeholder="Email"
                />
                <span class="text-danger" v-if="errors.email">
                  {{ errors.email[0] }}
                </span>
              </div>

              <div class="form-outline form-black mb-4">
                <input
                  type="password"
                  v-model="form.password"
                  class="form-control form-control-lg"
                  id="password"
                  placeholder="Пароль"
                />
                <span class="text-danger" v-if="errors.password">
                  {{ errors.password[0] }}
                </span>
              </div>

              <div class="form-outline form-black mb-4">
                <input
                  type="password"
                  v-model="form.confirm_password"
                  class="form-control form-control-lg"
                  id="confirm_password"
                  placeholder="Подтвердите пароль"
                />
                <span class="text-danger" v-if="errors.confirm_password">
                  {{ errors.confirm_password[0] }}
                </span>
              </div>
              
              <button class="btn btn-outline-dark btn-lg px-5" 
                type="submit"
                @click.prevent="register">Зарегистрироваться</button>
            </div>
            <div>
              <p class="mb-0">Уже есть аккаунт? <router-link class="text-black-50 fw-bold" :to="{ name: 'Login' }">Войти</router-link>
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
        name: "",
        email: "",
        password: "",
        confirm_password: ""
      },
      errors: []
    };
  },
  methods: {
    register() {
      const data = {
          name: this.form.name,
          email : this.form.email,
          password : this.form.password,
          confirm_password: this.form.confirm_password
      }
      console.log(data)
        axios.get('/sanctum/csrf-cookie');
        axios.post('/api/register', data).then((res) => {
          console.log(res)
            if (res.data.success) {                        
                //working and redirect to the home page
                alert('Вы успешно зарегистрированы! Теперь можете войти в систему.')
                this.$router.push({ path: "/login" });
            } else {     
                //errors   
                console.log('errors')                                     
            }
        }).catch((e) => {
            this.errors = e.response.data.errors
            console.log(this.errors)
            console.log(e)
        })
    }
  }
};
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