<template>
  <div>
     <div class="row">
      <div class="col-md-8 offset-md-2" style="background-color: white;
box-shadow: 1px 1px 10px 1px;">
        <div class="d-flex justify-content-evenly">
            <div style="align-self: center;">
                <router-link class="btn btn-outline-primary"  :to="{ name: 'Route'}"><i class="fa fa-arrow-left"></i></router-link>
            </div>
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
    <div class="d-flex align-items-center" v-if="loading">
      <strong>Loading...</strong>
      <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
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