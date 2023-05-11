<template>
  <div class="container">
        <div class='container d-flex flex-wrap justify-content-center'>
            <div class="card m-4" style='width: 70%'>
                <div class="card-header" style='background-color: rgba(61, 57, 108, 0.2)'>
                    <strong>Профиль</strong>
                </div>
                <div class="alert alert-danger" role="alert" v-if="errored">
                    Ошибка сохранения данных!
                </div>
                <div class="card-body" >
                    <div class="d-flex justify-content-start mb-3">
                      <div>
                        <label class="switch">
                        <input type="checkbox" @change="change" v-model="box">
                        <span class="slider round"></span>
                      </label>
                      </div>
                      <div style="align-self: center;">
                        <span class="text-switch ms-3"><strong>Редактировать профиль</strong></span>
                      </div>
                    </div>
        
                    <div style='width: 40%; margin-right: auto; margin-left: auto;'>
                        <div>
                          <div class="img">
                            <img :src="'/api/image/public/avatar.jpg'" alt="">
                          </div>
                          
                          <label for="name" class="form-label">Имя</label>
                          <div class="input-group mb-3">
                              <input id="name" type="text" class="form-control" v-model="currentUser.name" :disabled="isDisabled">
                          </div>
                          <label for="email" class="form-label">Email</label>
                          <div class="input-group mb-3">
                              <input id="email" type="email" class="form-control" v-model="currentUser.email" :disabled="isDisabled">
                          </div>
                          <div class="text-center">
                            <button class="btn btn-outline-primary" @click="saveUser()" :disabled="isDisabled">Сохранить</button>
                          </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-start mb-3">
                      <div>
                        <label class="switch">
                        <input type="checkbox" @change="changePassword" v-model="boxPass">
                        <span class="slider round"></span>
                      </label>
                      </div>
                      <div style="align-self: center;">
                        <span class="text-switch ms-3"><strong>Изменить пароль</strong></span>
                      </div>
                    </div>

                        <div style="color: grey">
                            <p>Пароль следует менять раз в 6 месяцев в целях безопасности.</p>
                        </div>
                        <div style='width: 40%; margin-right: auto; margin-left: auto;'>
                        <div>
                          <label for="name" class="form-label">Пароль</label>
                          <div class="input-group mb-3">
                              <input id="name" type="password" class="form-control" v-model="password" :disabled="isDisabledPassword">
                          </div>
                          <label for="email" class="form-label">Подтверждение пароля</label>
                          <div class="input-group mb-3">
                              <input id="email" type="password" class="form-control" v-model="confirm" :disabled="isDisabledPassword">
                          </div>
                          <div id="validationServerUsernameFeedback" class="text-danger text-center mb-3" v-if="passError">
                            Пароли не совпадают.
                          </div>
                          <div class="text-center">
                            <button class="btn btn-outline-primary" @click="saveNewPassword()" :disabled="isDisabledPassword">Сохранить</button>
                          </div>
                        </div>
                    </div>


                </div>
               
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
  data () {
    return {
      currentUser: '',
      errored: false,
      isLoggedIn: localStorage.getItem("isLoggedIn"),
      isDisabled: true, 
      isDisabledPassword: true,
      box: '',
      password: '',
      confirm: '',
      passError: false,
      boxPass: ''
    }
  }, 
  mounted() {
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
    if(this.isLoggedIn) {
      window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
      axios.get('api/user').then((response) => {
        this.currentUser = response.data;
        this.getUser()
      })
      .catch((e) => {
        console.log(e)
        this.errored = true;
      })
    }
  }, 
  methods: {
    getUser() {
      axios.get('api/users/'+this.currentUser.id).then((response) => {
        console.log(response.data)
      })
    },
    saveUser() {
      
      axios.post('api/users/'+this.currentUser.id, {
        _method: 'PUT',
        name: this.currentUser.name,
        email: this.currentUser.email
      }).then((response) => {
        console.log(response.data)
        if(response.data.message == 'Updated'){
          this.isDisabled = true;
          this.box = false;
          alert('Данные успешно обновлены!')
        } 
      }).catch((e) => {
        console.log(e)
      })
    }, 
    change() {
      this.isDisabled = !this.isDisabled
    },
    changePassword() {
      console.log('change password');
      this.isDisabledPassword = !this.isDisabledPassword
    }, 
    saveNewPassword() {
      if((this.password == this.confirm) && (this.confirm != '') && (this.password != '')) {
        axios.post('api/users/'+this.currentUser.id, {
          _method: 'PUT',
          password: this.password,
          password_confirmation: this.confirm
        }).then((response) => {
          console.log(response.data)
            if(response.data.message == 'Updated'){
              this.isDisabledPassword = true;
              this.boxPass = false;
              alert('Пароль успешно сменен!')
            } 
        }).catch((e) => {
          console.log(e)
        })
      } else {
        this.passError = true
      }
    }
  }
};
</script>

<style scoped>
.img {
  width: 150px;
  height: 150px;
  margin-left: auto;
  margin-right: auto;
}
img {
  max-width: 100%;
  height: auto;
  border-radius: 5%;
}
/* Переключатель - коробка вокруг ползунка */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Скрыть флажок HTML по умолчанию */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* Ползунок */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Закругленные ползунки */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>