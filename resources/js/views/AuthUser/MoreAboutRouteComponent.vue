<template>
  <div class="container">
     <div class="row">
      <div style="align-self: center;" class="p-2">
          <router-link class="list-group-item-action link"  :to="{ name: 'Route'}">Маршруты </router-link><span>/ карточка маршрута</span>
      </div>
      <div class="col-md-8 offset-md-2 mb-2" style="background-color: white; box-shadow: 1px 1px 8px 1px rgba(0, 0, 0, .2); border-radius: 10px;">
        <div class="d-flex justify-content-evenly">
            <div>
                <h1 class="pt-3">{{ data.name }}</h1>
            </div>
        </div>
        <div class="mt-3 text-center">
          <img v-if="data" :src="'/api/image/public/'+data.photo" :alt="data.name" class="img-fluid rounded">
        </div>
        <div class="mt-3">
          <h5>Описание:</h5>
          <p>{{ data.description }}</p>
        </div>
        <div class="mt-3">
          <h5>Длительность:</h5>
          <p>{{ data.duration }}</p>
        </div>
        <div class="mt-3">
          <h5>Город:</h5>
          <p>{{ city }}</p>
        </div>
      </div>
    </div>


    <div class="alert alert-danger" role="alert" v-if="errored">
      Ошибка загрузки данных!
    </div>

    <!-- прогресс бар -->
    <div class="text-center" v-if="loading">
      <strong>Loading...</strong>
    </div>

  </div>
</template>

<script>
export default {
  name: 'MoreAboutRoute',
  props: ['id'],
  data() {
    return {
      data: '',
      city: '',
      errored: false,
      loading: true
    }
  },
  mounted() {
    console.log('mounted '+ this.id)
    // Выполнение действий при загрузке компонента
    this.loadData();
  },
  methods: {
    loadData() {
      axios.get('/api/routes/'+ this.id)
      .then((response) => {
        this.city = response.data.data.city.name;
        this.data = response.data.data;
      })
      .catch( error => {
        this.errored = true;
      })
      .finally( () => {
        this.loading = false;
      }); 
    }
  }
}
</script>

<style scoped>
.link {

}
</style>