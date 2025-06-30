<template>
  <div class="px-6 py-4">
    <div v-if="loading" class="text-center py-12">
      <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
      <div class="text-gray-600 text-lg mt-4">Ładowanie szczegółów ogłoszenia...</div>
    </div>
    <div v-else-if="!ad" class="text-center py-12">
      <div class="text-red-600 text-xl mb-4">❌ Nie znaleziono ogłoszenia</div>
      <router-link 
        to="/ogloszenia" 
        class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
      >
        ← Powrót do listy
      </router-link>
    </div>
    <div v-else class="max-w-5xl mx-auto">
      <!-- Breadcrumb -->
      <nav class="mb-6 text-sm">
        <router-link to="/ogloszenia" class="text-blue-600 hover:text-blue-800">Lista ogłoszeń</router-link>
        <span class="mx-2 text-gray-500">›</span>
        <span class="text-gray-700">{{ ad.name }}</span>
      </nav>

      <div class="bg-white rounded-xl shadow-xl overflow-hidden">
        <!-- Header z tytułem i ceną -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-6">
          <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
              <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ ad.name }}</h1>
              <div class="flex items-center text-blue-100">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
                Dodano: {{ formatDate(ad.created_at) }}
              </div>
            </div>
            <div class="text-right">
              <div class="text-blue-100 text-sm mb-1">Cena</div>
              <div class="text-4xl font-bold">{{ formatPrice(ad.price) }} zł</div>
            </div>
          </div>
        </div>

        <div class="p-6">
          <!-- Galeria zdjęć -->
          <div v-if="ad.images && ad.images.length" class="mb-8">
            <h3 class="text-2xl font-semibold mb-4 flex items-center">
              <svg class="w-6 h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
              </svg>
              Galeria zdjęć ({{ ad.images.length }})
            </h3>
            
            <!-- Główne zdjęcie -->
            <div class="mb-4">
              <img 
                :src="getImageUrl(ad.images[currentImageIndex])" 
                :alt="`${ad.name} - główne zdjęcie`"
                class="w-full h-96 object-cover rounded-lg shadow-lg cursor-pointer"
                @click="openImageModal(ad.images[currentImageIndex])"
                @error="onImageError"
              />
            </div>
            
            <!-- Miniaturki -->
            <div v-if="ad.images.length > 1" class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-2">
              <img 
                v-for="(image, i) in ad.images" 
                :key="i" 
                :src="getImageUrl(image)" 
                :alt="`${ad.name} - miniaturka ${i + 1}`"
                class="w-full h-16 object-cover rounded cursor-pointer transition-all duration-200"
                :class="currentImageIndex === i ? 'ring-2 ring-blue-500 ring-offset-2' : 'hover:opacity-75'"
                @click="currentImageIndex = i"
                @error="onImageError"
              />
            </div>
          </div>

          <!-- Brak zdjęć -->
          <div v-else class="mb-8 text-center py-12 bg-gray-50 rounded-lg">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
            </svg>
            <p class="text-gray-500">Brak zdjęć dla tego ogłoszenia</p>
          </div>
          
          <!-- Opis -->
          <div class="mb-8">
            <h3 class="text-2xl font-semibold mb-4 flex items-center">
              <svg class="w-6 h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
              </svg>
              Opis ogłoszenia
            </h3>
            <div class="bg-gray-50 rounded-lg p-6">
              <p class="text-gray-700 text-lg leading-relaxed whitespace-pre-wrap">{{ ad.description }}</p>
            </div>
          </div>
          
          <!-- Akcje -->
          <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t">
            <router-link 
              to="/ogloszenia" 
              class="flex items-center justify-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors"
            >
              <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
              </svg>
              Powrót do listy
            </router-link>
            
            <button 
              @click="shareAd"
              class="flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
            >
              <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
              </svg>
              Udostępnij
            </button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Modal do powiększania zdjęć -->
    <div v-if="selectedImage" class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50" @click="closeImageModal">
      <div class="relative max-w-6xl max-h-full p-4">
        <button 
          @click="closeImageModal"
          class="absolute top-4 right-4 text-white hover:text-gray-300 z-10"
        >
          <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
        </button>
        <img :src="getImageUrl(selectedImage)" class="max-w-full max-h-full object-contain rounded-lg" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { getAd } from '@/api.js'

const route = useRoute()
const ad = ref(null)
const loading = ref(true)
const selectedImage = ref(null)
const currentImageIndex = ref(0)

// Formatowanie ceny z separatorami tysięcy
const formatPrice = (price) => {
  return new Intl.NumberFormat('pl-PL').format(price)
}

// Formatowanie daty
const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('pl-PL', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

// Generowanie pełnego URL do obrazka
const getImageUrl = (imagePath) => {
  return `http://localhost:8080/storage/${imagePath}`
}

// Obsługa błędu ładowania obrazka
const onImageError = (event) => {
  event.target.style.display = 'none'
}

// Modal zdjęć
const openImageModal = (image) => {
  selectedImage.value = image
}

const closeImageModal = () => {
  selectedImage.value = null
}

// Udostępnianie ogłoszenia
const shareAd = () => {
  if (navigator.share) {
    navigator.share({
      title: ad.value.name,
      text: ad.value.description,
      url: window.location.href,
    })
  } else {
    // Fallback - kopiowanie do schowka
    navigator.clipboard.writeText(window.location.href).then(() => {
      alert('Link skopiowany do schowka!')
    })
  }
}

onMounted(async () => {
  try {
    const res = await getAd(route.params.id)
    ad.value = res.data.data || res.data
  } catch (e) {
    console.error('Błąd podczas ładowania ogłoszenia:', e)
    ad.value = null
  } finally {
    loading.value = false
  }
})
</script> 