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
                  class="form-control form-control-lg"
                  id="name"
                  placeholder="Иван Иванов"
                  v-model.trim="v$.name.$model" :class="{'is-invalid': v$.name.$error}"
                />
                <span class="invalid-feedback" style="text-align: left;" v-if="v$.name.required.$invalid">Поле обязательно для заполнения</span>
                <span class="invalid-feedback" style="text-align: left;" v-if="v$.name.customRegex.$invalid && !v$.name.required.$invalid">Поле может содержать буквы, пробелы и тире</span>
                <span class="text-danger" v-if="errors.name">
                  {{ errors.name[0] }}
                </span>
              </div>

              <div class="form-outline form-black mb-4">
                <input
                  type="email"
                  class="form-control form-control-lg"
                  id="email"
                  placeholder="Email"
                  v-model.trim="v$.email.$model" :class="{'is-invalid': v$.email.$error}"
                />
                <span class="invalid-feedback" style="text-align: left;" v-if="v$.email.required.$invalid">Поле должно быть заполнено</span>
                <span class="invalid-feedback" style="text-align: left;" v-if="v$.email.email.$invalid && !v$.email.required.$invalid">Поле должно содержать email в правильном формате</span>
                <span class="invalid-feedback" style="text-align: left;" v-if="v$.email.maxLength.$invalid && !v$.email.required.$invalid">Поле должно иметь длину не более 64 символов</span>
                <span class="text-danger" v-if="errors.email">
                  {{ errors.email[0] }}
                </span>
              </div>

              <div class="form-outline form-black mb-4">
                <input
                  :type="showpassword ? 'text' : 'password'"
                  class="form-control form-control-lg"
                  id="password"
                  placeholder="Пароль"
                  v-model.trim="v$.password.$model" :class="{'is-invalid': v$.password.$error}"
                />
                <span class="invalid-feedback" style="text-align: left;" v-if="v$.password.required.$invalid">Поле должно быть заполнено</span>
                <span class="invalid-feedback" style="text-align: left;" v-if="v$.password.minLength.$invalid && !v$.password.required.$invalid">Пароль должен быть длиной не менее 6 символов</span>
                <span class="invalid-feedback" style="text-align: left;" v-if="v$.password.customCheckPassword.$invalid && !v$.password.required.$invalid">Пароль должен содержать буквы, спецсимволы @$!%*?& и цифры</span>
                 <div class="form-check mt-2" style="text-align: left;">
                  <input class="form-check-input" type="checkbox" value="" id="checkPass" v-model="showpassword">
                  <label class="form-check-label" for="checkPass">
                    Показать пароль
                  </label>
                </div>
                <span class="text-danger" v-if="errors.password">
                  {{ errors.password[0] }}
                </span>
              </div>

              <div class="form-outline form-black mb-4">
                <input
                  :type="showConfirm_password ? 'text' : 'password'"
                  class="form-control form-control-lg"
                  id="confirm_password"
                  placeholder="Подтвердите пароль"
                  v-model.trim="v$.confirm_password.$model" :class="{'is-invalid': v$.confirm_password.$error}"
                />
                <span class="invalid-feedback" style="text-align: left;" v-if="v$.confirm_password.sameAsPassword.$invalid">Пароли должны совпадать</span>
                <div class="form-check mt-2" style="text-align: left;">
                  <input class="form-check-input" type="checkbox" value="" id="checkPassConfirm" v-model="showConfirm_password">
                  <label class="form-check-label" for="checkPassConfirm">
                    Показать пароль
                  </label>
                </div>
                <span class="text-danger" v-if="errors.confirm_password">
                  {{ errors.confirm_password[0] }}
                </span>
              </div>
              
              <button class="btn btn-outline-dark btn-lg px-5" 
                type="submit"
                @click.prevent="register" :disabled="!isDisabled">Зарегистрироваться</button>
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
import { useVuelidate } from '@vuelidate/core'
import { required, email, minLength, maxLength, sameAs } from '@vuelidate/validators'

function customRegex (value) {
  const regex = /^[a-zA-ZА-Яа-я\s-]+$/;
  return regex.test(value)
}

function customCheckPassword (value) {
  const regex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[a-zA-Z\d@$!%*?&]+$/;
  return regex.test(value)
}

export default {
  setup () {
    return { v$: useVuelidate() }
  },
  data() {
    return {
      name: "",
      email: "",
      password: "",
      confirm_password: "",
      errors: [],
      showpassword: false,
      showConfirm_password: false
    };
  },
  validations() {
    return {
      name: { required, customRegex },
      email: { required, email, maxLength: maxLength(64)},
      password: { required, minLength: minLength(6), customCheckPassword },
      confirm_password: { sameAsPassword: sameAs(this.password) }
    }
  },
  computed: {
    isDisabled() {
      return this.email !== '' && this.password !== '' && this.confirm_password !== '' && this.name !== '';
    }
  },
  methods: {
    register() {
      this.v$.$touch();
        if(this.v$.$anyError) {
          return;
        }
        if (!this.v$.$invalid) {
          const data = {
          name: this.name,
          email : this.email,
          password : this.password,
          confirm_password: this.confirm_password
          }
          axios.get('/sanctum/csrf-cookie');
          axios.post('/api/register', data).then((res) => {
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
          })
        }
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