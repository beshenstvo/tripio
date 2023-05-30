<template>
  <div class="forum">
    <h1>Форум</h1>

    <div class="filter">
      <label for="filterInput">Фильтр:</label>
      <input type="text" id="filterInput" v-model="filterText" placeholder="Введите текст для фильтрации">
    </div>

    <div class="topics">
      <div class="topic" v-for="topic in filteredTopics" :key="topic.id" @click="goToDiscussion(topic.id)">
        <h2>{{ topic.title }}</h2>
        <p>Автор: {{ topic.author }}</p>
        <p>Дата создания: {{ topic.createdAt }}</p>
        <p>Теги: {{ topic.tags.join(', ') }}</p>
        <button class="btn btn-primary" @click="editTopic(topic.id)">Редактировать</button>
        <button class="btn btn-danger" @click="deleteTopic(topic.id)">Удалить</button>
      </div>
    </div>

    <div class="add-topic">
      <h2>Добавить тему</h2>
      <form @submit.prevent="addTopic">
        <label for="titleInput">Заголовок:</label>
        <input type="text" id="titleInput" v-model="newTopic.title" required>

        <label for="authorInput">Автор:</label>
        <input type="text" id="authorInput" v-model="newTopic.author" required>

        <label for="tagsInput">Теги (через запятую):</label>
        <input type="text" id="tagsInput" v-model="newTopic.tags">

        <button type="submit" class="btn btn-success">Добавить</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      filterText: '',
      topics: [
        {
          id: 1,
          title: 'Тема 1',
          author: 'Автор 1',
          createdAt: '2023-05-15',
          tags: ['travel']
        },
        {
          id: 2,
          title: 'Тема 2',
          author: 'Автор 2',
          createdAt: '2023-05-16',
          tags: ['attraction']
        },
        // ...другие темы
      ],
      newTopic: {
        title: '',
        author: '',
        tags: ''
      }
    };
  },
  computed: {
    filteredTopics() {
      return this.topics.filter(topic => {
        // Фильтрация по тексту
        return topic.title.toLowerCase().includes(this.filterText.toLowerCase());
      });
    }
  },
  methods: {
    goToDiscussion(topicId) {
      // Переход на страницу обсуждения с передачей ID темы
      this.$router.push(`/discussion/${topicId}`);
    },
    addTopic() {
      // Генерация нового ID для темы
      const newId = this.topics.length + 1;

      // Разделение тегов по запятой и удаление пробелов
      const tagsArray = this.newTopic.tags.split(',').map(tag => tag.trim());

      // Создание новой темы
      const newTopic = {
        id: newId,
        title: this.newTopic.title,
        author: this.newTopic.author,
        createdAt: new Date().toISOString().slice(0, 10),
        tags: tagsArray
      };

      // Добавление новой темы в список
      this.topics.push(newTopic);

      // Очистка полей формы
      this.newTopic.title = '';
      this.newTopic.author = '';
      this.newTopic.tags = '';
    },
    editTopic(topicId) {
      // Найти индекс темы по ID
      const topicIndex = this.topics.findIndex(topic => topic.id === topicId);

      // Если тема найдена, открыть модальное окно для редактирования
      if (topicIndex !== -1) {
        const topic = this.topics[topicIndex];
        // Открыть модальное окно с данными для редактирования
        // Например, this.$modal.open(topic);
      }
    },
    deleteTopic(topicId) {
      // Найти индекс темы по ID
      const topicIndex = this.topics.findIndex(topic => topic.id === topicId);

      // Если тема найдена, удалить ее из списка
      if (topicIndex !== -1) {
        this.topics.splice(topicIndex, 1);
      }
    }
  }
};
</script>

<style scoped>
.forum {
  max-width: 800px;
  margin: 0 auto;
}

.filter {
  margin-bottom: 20px;
}

.topics {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  grid-gap: 20px;
}

.topic {
  border: 1px solid #ccc;
  padding: 10px;
  cursor: pointer;
}

.topic:hover {
  background-color: #f0f0f0;
}

.add-topic {
  margin-top: 30px;
}

.add-topic form {
  display: grid;
  grid-template-columns: 1fr;
  grid-gap: 10px;
}

.add-topic label {
  font-weight: bold;
}

.add-topic input[type="text"] {
  width: 100%;
  padding: 5px;
  font-size: 16px;
}

.add-topic button {
  padding: 5px 10px;
  font-size: 16px;
}
</style>