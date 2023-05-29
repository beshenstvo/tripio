<template>
  <div class="container">
    <h1>Проверка гида</h1>

    <div class="row">
      <p class="mb-1">Всего заявок <span class="badge rounded-pill bg-danger">{{ data ? data.length : 0}}</span></p>
      <div class="col-md-12 mb-2" v-for="item in data" :key="item.id">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h5 class="card-title">{{ item.user.name }}</h5>
                <p><a class="mail" :href="'mailto:'+item.user.email">{{ item.user.email }}</a></p>
              </div>
              <div>
                <span class="badge rounded-pill bg-success" v-if="(item.message_about_not_verified != null) && (item.message_about_not_verified.length != 0)">Обработано</span>
              </div>
            </div>
            <div class="d-flex justify-content-between">
              <div>
                <a class="link me-2" href="#" @click="showModal(item, 'showModalCertificate')">
                  Фото сертификата
                </a>
                <a class="link me-2" href="#" @click="showModal(item, 'showModalPassport')">
                  Фото паспорта
                </a>
                <a class="link" href="#" @click="showModal(item, 'showModalSelfie')">
                  Фото с селфи
                </a>
              </div>
              <div>
                <button type="button" class="btn btn-outline-danger me-2" @click="notAccept(item.id)">
                  Отклонить
                </button>
                <button type="button" class="btn btn-outline-success" @click="accept(item.id, item.user.name)">
                  Подтвердить
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  
    <!-- Модальное окно -->
    <div v-for="item in data" :key="item.id">
      <div class="outerModal" v-if="modalStates[item.id]">
        <div class="modal" tabindex="-1" role="dialog" style="display: block; background-color: rgba(0, 0, 0, 0.64);">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">{{ modalTitles[item.id] }}</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close" @click="closeModal(item.id)"></button>
              </div>
              <div class="modal-body">
                <div class="image-container" @mousemove="zoom">
                  <img :src="'/api/image/public/' + item[modalStates[item.id].imageProperty]" :alt="altText" ref="image" />
                  <p>{{ item[modalStates[item.id]] }}</p>
                  <div class="zoomed-image" :style="zoomedImageStyle"></div>
                </div>
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
  data() {
    return {
      imageSrc: '/api/image/public/sungur.JPG',
      altText: 'Image',
      zoomedImageStyle: {
        display: 'none',
        backgroundImage: '',
        backgroundPosition: '0% 0%',
        backgroundSize: '900%',
        left: 0,
        top: 0
      },
      modalStates: {},
      modalTitles: {},
      data: null
    };
  },
  async mounted() {
    await this.getData();
    this.initializeModalStates();
  },
  methods: {
    async getData() {
      try {
        const response = await axios.get('/api/guide_verification');
        this.data = response.data.data;
      } catch (error) {
        console.error(error);
      }
    },
    initializeModalStates() {
      this.data.forEach((item) => {
        this.modalStates[item.id] = null
        this.modalStates[item.id] = ''
      });
    },
    showModal(item, modalProperty) {
      console.log(item)
      console.log(modalProperty)
      let property = '';
      if(modalProperty == 'showModalSelfie') {
        property = 'photo_passport_with_selfie'
      } else if(modalProperty == 'showModalPassport') {
        property = 'photo_passport'
      } else {
        property = 'photo_certificate'
      }
      this.modalStates[item.id] = {
        showModal: true,
        imageProperty: property
      };
      this.modalTitles[item.id] = this.getModalTitle(modalProperty);
    },
    closeModal(itemId) {
      this.modalStates[itemId] = null;
    },
    getModalTitle(modalProperty) {
      switch (modalProperty) {
        case 'showModalCertificate':
          return 'Фото сертификата';
        case 'showModalPassport':
          return 'Фото паспорта';
        case 'showModalSelfie':
          return 'Фото с селфи';
        default:
          return '';
      }
    },
    zoom(event) {
      const zoomer = this.$refs.image[0];
      const { offsetX, offsetY } = event;

      const x = (offsetX / zoomer.offsetWidth) * 100;
      const y = (offsetY / zoomer.offsetHeight) * 100;

      this.zoomedImageStyle.left = `${offsetX}px`;
      this.zoomedImageStyle.top = `${offsetY}px`;
      this.zoomedImageStyle.display = 'block';
      this.zoomedImageStyle.backgroundImage = `url(${this.$refs.image[0].src})`;
      this.zoomedImageStyle.backgroundPosition = `${x}% ${y}%`;
    },
    accept(id, name) {
      console.log("accept");
      console.log(id);
      axios
        .post('/api/guide_verification/' + id, {
          _method: 'PUT',
          is_verified: 1
        })
        .then((response) => {
          console.log(response);
          if (response.status == 200) {
            alert(`Пользователь ${name} верифицирован!`);
            this.getData();
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    async notAccept(id) {
      let message = prompt('Введите причину отказа в верификации данного пользователя.');
      if (message == null) {
        return;
      } else {
        message = message.trim();
        if (message.length <= 0) {
          alert('Поле ввода причины отказа в верификации не должно быть пустым');
          return;
        }
      }

      try {
        const response = await axios.post(`/api/guide_verification/${id}`, {
          _method: 'PUT',
          is_verified: 0,
          message_about_not_verified: message
        });

        console.log(response);
        if (response.status === 200) {
          alert(`Ваше сообщение отправлено!`);
        }
      } catch (error) {
        console.error(error);
      }
    }
  }
};
</script>

<style scoped>
.mail {
  text-decoration: none;
  color: #9e9e9e;
}

.image-container {
  position: relative;
  display: inline-block;
  overflow: hidden;
  perspective: 1000px;
}

img {
  display: block;
  max-width: 100%;
  height: auto;
}

.image-container:hover {
  cursor: zoom-in;
}

.zoomed-image {
  position: absolute;
  width: 150px;
  height: 150px;
  border: 1px solid #ccc;
  background-repeat: no-repeat;
  pointer-events: none;
  z-index: 999;
  transform: translate(-50%, -50%);
  transform-origin: top left;
}
</style>
