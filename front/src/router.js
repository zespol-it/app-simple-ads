import { createRouter, createWebHistory } from 'vue-router'
import AdsList from './views/AdsList.vue'
import AddAd from './views/AddAd.vue'
import AdView from './views/AdView.vue'
import TodoList from './components/TodoList.vue'

const routes = [
  { path: '/', redirect: '/todos' },
  { path: '/todos', name: 'TodoList', component: TodoList },
  { path: '/ogloszenia', name: 'AdsList', component: AdsList },
  { path: '/dodaj', name: 'AddAd', component: AddAd },
  { path: '/ogloszenia/:id', name: 'AdView', component: AdView, props: true },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router 