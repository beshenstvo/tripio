<template>
  <div class="container mt-4" v-show="loaded">
    <div class="card p-4">
      <h2 v-show="isVerified ? !isVerified : !isSubmitted">Прохождение верификации</h2>
      <div class="myCard bg-light mb-3" v-show="isVerified ? !isVerified : !isSubmitted">
        <div class="card-body">
          <p class="m-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle me-2" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
            </svg>
            <span>Вам необходимо пройти верификацию, чтобы иметь возможность создавать услуги и принимать заявки от пользователей.
            После успешной верификации вы сможете начать использовать все функции нашей платформы.</span>
          </p>
        </div>
      </div>
      <div v-if="isSubmitted && !isVerified">
        <p v-if="(messageFromAdmin == null) || (messageFromAdmin.length == 0)" style="color: rgb(218, 200, 36);" class="fs-5 m-0 text-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
            <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"/>
            <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"/>
            <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
          </svg>
          Данные были отправлены, ожидайте проверку...</p>
         
          <p v-else-if="(messageFromAdmin != null) && (messageFromAdmin.length != 0)" class="fs-5 m-0 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-envelope-exclamation me-2" viewBox="0 0 16 16" style="color: red">
              <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2H2Zm3.708 6.208L1 11.105V5.383l4.708 2.825ZM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2-7-4.2Z"/>
              <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1.5a.5.5 0 0 1-1 0V11a.5.5 0 0 1 1 0Zm0 3a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z"/>
            </svg>
            <span v-if="(messageFromAdmin != null) && (messageFromAdmin.length != 0)"><span style="color: red">Вы не прошли верификацию:</span> {{ messageFromAdmin }} <br> Необходимо заполнить данные повторно!</span>
          </p>
      </div>
      <div v-else-if="isVerified">
        <p style="color: green" class="fs-5 m-0 text-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16" >
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
          </svg>
          Вы прошли верификацию, теперь вы можете начать использовать все функции нашей платформы.</p>
      </div>
      <div v-else>
        <form @submit.prevent="submitForm">
          <div class="mb-3">
            <label for="certificatePhoto" class="form-label">Загрузить фото сертификата</label>
            <input type="file" id="certificatePhoto" class="form-control" @change="sertificateChange" :class="{'is-invalid': errorFileCertificate}">
            <span class="invalid-feedback" v-if="errorFileCertificate">Изображение должно иметь размер меньше 1 Мб и должно иметь формат png, jpeg, jpg, svg</span>
          </div>
          <div class="mb-3">
            <label for="passportPhoto" class="form-label">Загрузить фото паспорта</label>
            <input type="file" id="passportPhoto" class="form-control" @change="passportChange" :class="{'is-invalid': errorFilePassport}">
            <span class="invalid-feedback" v-if="errorFilePassport">Изображение должно иметь размер меньше 1 Мб и должно иметь формат png, jpeg, jpg, svg</span>
          </div>
          <div class="mb-3">
            <label for="selfieWithPassport" class="form-label">Загрузить фото селфи с паспортом</label>
            <input type="file" id="selfieWithPassport" class="form-control" @change="selfieChange" :class="{'is-invalid': errorFileSelfie}">
            <span class="invalid-feedback" v-if="errorFileSelfie">Изображение должно иметь размер меньше 1 Мб и должно иметь формат png, jpeg, jpg, svg</span>
          </div>
          <button type="submit" class="btn btn-outline-primary" :disabled="!isDisabled">Отправить</button>
        </form>
      </div>
      <div v-if="!isVerified && (messageFromAdmin != null) && (messageFromAdmin.length != 0)">
        <form @submit.prevent="submitFormUpdate">
          <div class="mb-3">
            <label for="certificatePhoto" class="form-label">Загрузить фото сертификата</label>
            <input type="file" id="certificatePhoto" class="form-control" @change="sertificateChange" :class="{'is-invalid': errorFileCertificateUpdate}">
            <span class="invalid-feedback" v-if="errorFileCertificateUpdate">Изображение должно иметь размер меньше 1 Мб и должно иметь формат png, jpeg, jpg, svg</span>
          </div>
          <div class="mb-3">
            <label for="passportPhoto" class="form-label">Загрузить фото паспорта</label>
            <input type="file" id="passportPhoto" class="form-control" @change="passportChange" :class="{'is-invalid': errorFilePassportUpdate}">
            <span class="invalid-feedback" v-if="errorFilePassportUpdate">Изображение должно иметь размер меньше 1 Мб и должно иметь формат png, jpeg, jpg, svg</span>
          </div>
          <div class="mb-3">
            <label for="selfieWithPassport" class="form-label">Загрузить фото селфи с паспортом</label>
            <input type="file" id="selfieWithPassport" class="form-control" @change="selfieChange" :class="{'is-invalid': errorFileSelfieUpdate}">
            <span class="invalid-feedback" v-if="errorFileSelfieUpdate">Изображение должно иметь размер меньше 1 Мб и должно иметь формат png, jpeg, jpg, svg</span>
          </div>
          <button type="submit" class="btn btn-outline-primary" :disabled="!isDisabled">Отправить</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { maxSize, validFormat } from '../../validationsForImage'

export default {
  data() {
    return {
      isSubmitted: null,
      isVerified: null,
      sertificate: null,
      passport: null,
      selfie: null,
      errorFileSelfie: false,
      errorFileCertificate: false,
      errorFileCertificateUpdate: false,
      errorFileSelfieUpdate: false,
      errorFilePassportUpdate: false,
      errorFilePassport: false,
      isLoggedIn: localStorage.getItem('isLoggedIn'),
      currentUser: '',
      token: localStorage.getItem("token"),
      loaded: false,
      messageFromAdmin: '',
      idVerified: ''
    };
  },
  computed: {
    isDisabled() {
      return this.selfie != null && this.passport != null && this.sertificate != null;
    }
  },
  mounted() {
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
    axios.get('api/user')
    .then((response) => {
      this.currentUser = response.data;
      return Promise.all([
        this.getIsVerified(this.currentUser),
        this.getIsSubmitted(this.currentUser),
        this.getIsMessage(this.currentUser)
      ]);
    })
    .then(() => this.loaded = true)
    .catch((error) => {
      console.error(error);
    });
  },
  methods: {
    sertificateChange(e) {
      this.sertificate = e.target.files[0];
      console.log(this.sertificate);
    },
    passportChange(e) {
      this.passport = e.target.files[0];
      console.log(this.sertificate);
    },
    selfieChange(e) {
      this.selfie = e.target.files[0];
      console.log(this.selfie);
    },
    getIsVerified(user) {
      return axios.get('api/guide_verification/is_verified/'+user.id)
      .then(response => {
        console.log(response.data)
        this.isVerified = response.data === 1;
      })
      .catch(error => {
        console.error(error)
      })
    },
    getIsSubmitted(user) {
      return axios.get('api/guide_verification/is_submitted/'+user.id)
      .then(response => {
        console.log(response.data)
        this.isSubmitted = response.data === 1;
      })
      .catch(error => {
        console.error(error)
      })
    },
    getIsMessage(user) {
      return axios.get('api/guide_verification/has_is_message/'+user.id)
      .then((response) => { 
        if(response.status == 200 && response.data.length != 0) {
          this.messageFromAdmin = response.data[0].message_about_not_verified
          this.idVerified = response.data[0].id
        }
      })
      .catch((error) => {
        console.error(error)
      })
    },
    submitForm() {
      let formData = new FormData();
      formData.append('user_id', this.currentUser.id);
      formData.append('is_verified', 0);
      if((this.sertificate !== null)) {
        if(!validFormat(this.sertificate) || !maxSize(1024)(this.sertificate)) {
          this.errorFileCertificateUpdate = true;
          return;
        }
        formData.append('photo_certificate', this.sertificate);
      }
      if((this.passport !== null)) {
        if(!validFormat(this.passport) || !maxSize(1024)(this.passport)) {
          this.errorFilePassportUpdate = true;
          return;
        }
        formData.append('photo_passport', this.passport);
      }
      if((this.selfie !== null)) {
        if(!validFormat(this.selfie) || !maxSize(1024)(this.selfie)) {
          this.errorFileSelfieUpdate = true;
          return;
        }
        formData.append('photo_passport_with_selfie', this.selfie);
      }
      axios.post('/api/guide_verification', formData)
      .then((response) => {
        if(response.status == 200) {
          this.getIsVerified(this.currentUser),
          this.getIsSubmitted(this.currentUser)
          alert('Данные отправлены на проверку. Решение будет принято в течении дня. Спасибо за понимание!');
          return
        }
        })
        .catch( error => {
          console.log(error);
        })
    },
    submitFormUpdate() {
      let formData = new FormData();
      formData.append('_method', 'PUT');
      formData.append('user_id', this.currentUser.id);
      formData.append('is_verified', 0);
      if((this.sertificate !== null)) {
        if(!validFormat(this.sertificate) || !maxSize(1024)(this.sertificate)) {
          this.errorFileCertificate = true;
          return;
        }
        formData.append('photo_certificate', this.sertificate);
      }
      if((this.passport !== null)) {
        if(!validFormat(this.passport) || !maxSize(1024)(this.passport)) {
          this.errorFilePassport = true;
          return;
        }
        formData.append('photo_passport', this.passport);
      }
      if((this.selfie !== null)) {
        if(!validFormat(this.selfie) || !maxSize(1024)(this.selfie)) {
          this.errorFileSelfie = true;
          return;
        }
        formData.append('photo_passport_with_selfie', this.selfie);
      }
      axios.post('/api/guide_verification/updateSecondAfterGettingMessage/'+this.idVerified, formData)
      .then((response) => {
        if(response.status == 200) {
          alert('Данные отправлены на проверку. Решение будет принято в течении дня. Спасибо за понимание!');
          return Promise.all([
          this.getIsVerified(this.currentUser),
          this.getIsSubmitted(this.currentUser),
          this.getIsMessage(this.currentUser)
        ]);
        }
        })
        .catch( error => {
          console.log(error);
        })
    }
  }
};
</script>

<style scoped>
.myCard {
  border-radius: 10px;
  width: fit-content;
  color: white;
  background-color: #a14effc9 !important;
}
.center-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.center-content {
  text-align: center;
}
</style>