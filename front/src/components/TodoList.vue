<template>
  <div class="max-w-2xl mx-auto p-6">
    <header class="text-center mb-8">
      <h1 class="text-3xl font-bold text-gray-800 mb-2">Lista Zadań</h1>
      <p class="text-gray-600">Zarządzaj swoimi zadaniami efektywnie</p>
    </header>

    <!-- Formularz dodawania nowego zadania -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
      <form @submit.prevent="addTask" class="flex gap-3">
        <input
          v-model="newTask"
          type="text"
          placeholder="Dodaj nowe zadanie..."
          class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          required
        />
        <button
          type="submit"
          class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
        >
          Dodaj
        </button>
      </form>
    </div>

    <!-- Lista zadań -->
    <div class="space-y-3">
      <div
        v-if="tasks.length === 0"
        class="text-center py-12 text-gray-500"
      >
        <div class="text-5xl mb-4">📝</div>
        <p>Brak zadań. Dodaj pierwsze zadanie!</p>
      </div>
      
      <div
        v-for="task in tasks"
        :key="task.id"
        class="bg-white rounded-lg shadow-md p-4 flex items-center gap-4 transition-all hover:shadow-lg"
        :class="{ 'opacity-60': task.completed }"
      >
        <input
          type="checkbox"
          :checked="task.completed"
          @change="toggleTask(task.id)"
          class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500"
        />
        
        <span
          class="flex-1 text-gray-800"
          :class="{ 'line-through text-gray-500': task.completed }"
        >
          {{ task.title }}
        </span>
        
        <span class="text-sm text-gray-400">
          {{ formatDate(task.created_at) }}
        </span>
        
        <button
          @click="deleteTask(task.id)"
          class="px-3 py-1 text-red-600 hover:bg-red-50 rounded-md transition-colors"
          title="Usuń zadanie"
        >
          🗑️
        </button>
      </div>
    </div>

    <!-- Statystyki -->
    <div class="mt-8 bg-gray-50 rounded-lg p-4">
      <div class="grid grid-cols-3 gap-4 text-center">
        <div>
          <div class="text-2xl font-bold text-blue-600">{{ totalTasks }}</div>
          <div class="text-sm text-gray-600">Wszystkie</div>
        </div>
        <div>
          <div class="text-2xl font-bold text-green-600">{{ completedTasks }}</div>
          <div class="text-sm text-gray-600">Ukończone</div>
        </div>
        <div>
          <div class="text-2xl font-bold text-orange-600">{{ pendingTasks }}</div>
          <div class="text-sm text-gray-600">Do zrobienia</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

const newTask = ref('')
const tasks = ref([])

// Computed properties
const totalTasks = computed(() => tasks.value.length)
const completedTasks = computed(() => tasks.value.filter(task => task.completed).length)
const pendingTasks = computed(() => tasks.value.filter(task => !task.completed).length)

// Funkcje
const addTask = () => {
  if (newTask.value.trim()) {
    const task = {
      id: Date.now(),
      title: newTask.value.trim(),
      completed: false,
      created_at: new Date().toISOString()
    }
    tasks.value.unshift(task)
    newTask.value = ''
    saveTasks()
  }
}

const toggleTask = (id) => {
  const task = tasks.value.find(t => t.id === id)
  if (task) {
    task.completed = !task.completed
    saveTasks()
  }
}

const deleteTask = (id) => {
  tasks.value = tasks.value.filter(t => t.id !== id)
  saveTasks()
}

const formatDate = (dateString) => {
  const date = new Date(dateString)
  return date.toLocaleDateString('pl-PL', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

// Local storage functions
const saveTasks = () => {
  localStorage.setItem('vue-tasks', JSON.stringify(tasks.value))
}

const loadTasks = () => {
  const saved = localStorage.getItem('vue-tasks')
  if (saved) {
    tasks.value = JSON.parse(saved)
  }
}

// Lifecycle
onMounted(() => {
  loadTasks()
})
</script>

<style scoped>
/* Dodatkowe style dla animacji */
.transition-all {
  transition: all 0.3s ease;
}
</style> 