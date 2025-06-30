<template>
  <div class="px-6">
    <h1 class="text-3xl font-bold mb-6 text-center">Lista ogłoszeń</h1>
    <div v-if="loading" class="text-center py-8">
      <div class="text-gray-600 text-lg">Ładowanie...</div>
    </div>
    <div v-else>
      <div v-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 max-w-4xl mx-auto">
        Błąd podczas ładowania ogłoszeń: {{ error }}
      </div>
      <div v-else-if="ads.length === 0" class="text-center py-12 text-gray-600 text-lg">
        Brak ogłoszeń.
      </div>
      <div v-else class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
        <div v-for="ad in ads" :key="ad.id" class="bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden">
          <!-- Miniaturka zdjęcia -->
          <div class="relative h-48 bg-gray-200">
            <img 
              v-if="ad.images && ad.images.length > 0" 
              :src="getImageUrl(ad.images[0])" 
              :alt="ad.name"
              class="w-full h-full object-cover"
              @error="onImageError"
            />
            <div v-else class="w-full h-full flex items-center justify-center text-gray-500">
              <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
              </svg>
            </div>
            <!-- Badge z liczbą zdjęć -->
            <div v-if="ad.images && ad.images.length > 1" class="absolute top-2 right-2 bg-black bg-opacity-70 text-white px-2 py-1 rounded-full text-xs">
              {{ ad.images.length }} zdjęć
            </div>
          </div>
          
          <!-- Treść ogłoszenia -->
          <div class="p-4">
            <h2 class="text-xl font-semibold mb-2 text-gray-900 line-clamp-2">{{ ad.name }}</h2>
            <p class="text-gray-600 mb-3 text-sm line-clamp-3">{{ ad.description }}</p>
            <div class="flex justify-between items-center mb-4">
              <p class="font-bold text-green-600 text-lg">{{ formatPrice(ad.price) }} zł</p>
            </div>
            <router-link 
              :to="`/ogloszenia/${ad.id}`" 
              class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium"
            >
              Zobacz szczegóły
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { getAds } from '@/api.js'

const ads = ref([])
const loading = ref(true)
const error = ref(null)

// Formatowanie ceny z separatorami tysięcy
const formatPrice = (price) => {
  return new Intl.NumberFormat('pl-PL').format(price)
}

// Generowanie pełnego URL do obrazka
const getImageUrl = (imagePath) => {
  return `http://localhost:8080/storage/${imagePath}`
}

// Obsługa błędu ładowania obrazka
const onImageError = (event) => {
  event.target.style.display = 'none'
  event.target.parentElement.innerHTML = `
    <div class="w-full h-full flex items-center justify-center text-gray-500">
      <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
      </svg>
    </div>
  `
}

onMounted(async () => {
  try {
    const response = await getAds()
    // API zwraca dane w formacie { data: [...] }
    ads.value = response.data.data || []
  } catch (e) {
    console.error('Błąd podczas ładowania ogłoszeń:', e)
    error.value = e.message || 'Nie udało się załadować ogłoszeń'
    ads.value = []
  } finally {
    loading.value = false
  }
})
</script>

<style scoped>
/* Ograniczenie liczby linii tekstu */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style> 