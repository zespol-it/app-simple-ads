<template>
  <div class="px-6 py-4">
    <div class="max-w-4xl mx-auto">
      <!-- Breadcrumb -->
      <nav class="mb-6 text-sm">
        <router-link to="/ogloszenia" class="text-blue-600 hover:text-blue-800">Lista ogłoszeń</router-link>
        <span class="mx-2 text-gray-500">›</span>
        <span class="text-gray-700">Dodaj ogłoszenie</span>
      </nav>

      <!-- Header -->
      <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Dodaj nowe ogłoszenie</h1>
        <p class="text-gray-600">Wypełnij formularz aby dodać swoje ogłoszenie</p>
      </div>

      <div class="bg-white rounded-xl shadow-xl overflow-hidden">
        <!-- Progress bar -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-1">
          <div class="bg-blue-500 h-1 rounded-full transition-all duration-300" :style="`width: ${progress}%`"></div>
        </div>

        <form @submit.prevent="submitForm" class="p-8">
          <div class="grid md:grid-cols-2 gap-8">
            <!-- Lewa kolumna - dane podstawowe -->
            <div class="space-y-6">
              <h2 class="text-2xl font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                </svg>
                Podstawowe informacje
              </h2>

              <!-- Nazwa -->
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                  Nazwa ogłoszenia *
                </label>
                <input 
                  v-model="form.name" 
                  type="text"
                  class="form-input"
                  :class="{ 'border-red-500': errors.name, 'border-green-500': form.name && !errors.name }"
                  placeholder="Wpisz nazwę ogłoszenia..."
                  maxlength="255"
                  @blur="validateName"
                  @input="clearError('name')"
                />
                <div class="flex justify-between mt-1">
                  <span v-if="errors.name" class="text-red-500 text-sm">{{ errors.name }}</span>
                  <span class="text-gray-400 text-sm ml-auto">{{ form.name.length }}/255</span>
                </div>
              </div>

              <!-- Cena -->
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                  Cena *
                </label>
                <div class="relative">
                  <input 
                    v-model.number="form.price" 
                    type="number"
                    min="0"
                    step="0.01"
                    class="form-input pr-12"
                    :class="{ 'border-red-500': errors.price, 'border-green-500': form.price && !errors.price }"
                    placeholder="0.00"
                    @blur="validatePrice"
                    @input="clearError('price')"
                  />
                  <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">zł</span>
                </div>
                <span v-if="errors.price" class="text-red-500 text-sm">{{ errors.price }}</span>
                <div v-if="form.price" class="text-green-600 text-sm mt-1">
                  Cena: {{ formatPrice(form.price) }} zł
                </div>
              </div>

              <!-- Opis -->
              <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                  Opis ogłoszenia *
                </label>
                <textarea 
                  v-model="form.description" 
                  class="form-textarea"
                  :class="{ 'border-red-500': errors.description, 'border-green-500': form.description && !errors.description }"
                  placeholder="Opisz szczegółowo swoje ogłoszenie..."
                  rows="6"
                  maxlength="1000"
                  @blur="validateDescription"
                  @input="clearError('description')"
                ></textarea>
                <div class="flex justify-between mt-1">
                  <span v-if="errors.description" class="text-red-500 text-sm">{{ errors.description }}</span>
                  <span class="text-gray-400 text-sm ml-auto">{{ form.description.length }}/1000</span>
                </div>
              </div>
            </div>

            <!-- Prawa kolumna - zdjęcia -->
            <div class="space-y-6">
              <h2 class="text-2xl font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                </svg>
                Zdjęcia (max 5)
              </h2>

              <!-- Upload area -->
              <div 
                class="upload-area"
                :class="{ 'border-red-500': errors.photos, 'drag-over': isDragOver }"
                @dragover.prevent="isDragOver = true"
                @dragleave.prevent="isDragOver = false"
                @drop.prevent="onDrop"
                @click="$refs.fileInput.click()"
              >
                <input 
                  ref="fileInput"
                  type="file" 
                  multiple 
                  accept="image/*" 
                  class="hidden"
                  :disabled="form.photos.length >= 5"
                  @change="onFilesChange" 
                />
                
                <div class="text-center py-8">
                  <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                  </svg>
                  <p class="text-gray-600 mb-2">
                    <span class="font-semibold">Kliknij aby dodać</span> lub przeciągnij zdjęcia
                  </p>
                  <p class="text-gray-400 text-sm">PNG, JPG, JPEG do 5MB każde</p>
                  <p class="text-blue-600 text-sm mt-2">{{ form.photos.length }}/5 zdjęć</p>
                </div>
              </div>

              <span v-if="errors.photos" class="text-red-500 text-sm">{{ errors.photos }}</span>

              <!-- Podgląd zdjęć -->
              <div v-if="form.photos.length" class="space-y-3">
                <h3 class="font-medium text-gray-700">Podgląd zdjęć:</h3>
                <div class="grid grid-cols-2 gap-3">
                  <div 
                    v-for="(file, i) in form.photos" 
                    :key="i" 
                    class="relative group bg-gray-100 rounded-lg overflow-hidden"
                  >
                    <img 
                      :src="getFilePreview(file)" 
                      :alt="`Podgląd ${i + 1}`"
                      class="w-full h-24 object-cover"
                    />
                    <button 
                      type="button"
                      @click="removePhoto(i)"
                      class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity"
                    >
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                      </svg>
                    </button>
                    <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-1 truncate">
                      {{ file.name }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Error message -->
          <div v-if="error" class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center">
              <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
              </svg>
              <span class="text-red-700">{{ error }}</span>
            </div>
          </div>

          <!-- Akcje -->
          <div class="mt-8 flex flex-col sm:flex-row gap-4 pt-6 border-t">
            <router-link 
              to="/ogloszenia"
              class="flex items-center justify-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors"
            >
              <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
              </svg>
              Anuluj
            </router-link>
            
            <button 
              type="submit" 
              :disabled="isSubmitting || !isFormValid"
              class="flex items-center justify-center px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <svg v-if="isSubmitting" class="animate-spin w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M2 10a8 8 0 018-8v2a6 6 0 100 12v2a8 8 0 01-8-8z" clip-rule="evenodd" />
              </svg>
              <svg v-else class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
              </svg>
              {{ isSubmitting ? 'Dodawanie...' : 'Dodaj ogłoszenie' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { addAd } from '@/api.js'

const router = useRouter()

const form = ref({
  name: '',
  description: '',
  price: '',
  photos: []
})

const errors = ref({})
const error = ref('')
const isSubmitting = ref(false)
const isDragOver = ref(false)

// Progress bar
const progress = computed(() => {
  let completed = 0
  if (form.value.name) completed += 25
  if (form.value.description) completed += 25
  if (form.value.price) completed += 25
  if (form.value.photos.length) completed += 25
  return completed
})

// Form validation
const isFormValid = computed(() => {
  return form.value.name && 
         form.value.description && 
         form.value.price && 
         Object.keys(errors.value).length === 0
})

// Formatowanie ceny
const formatPrice = (price) => {
  return new Intl.NumberFormat('pl-PL').format(price)
}

// Walidacja pól
const validateName = () => {
  if (!form.value.name) {
    errors.value.name = 'Nazwa jest wymagana'
  } else if (form.value.name.length < 3) {
    errors.value.name = 'Nazwa musi mieć minimum 3 znaki'
  } else {
    delete errors.value.name
  }
}

const validateDescription = () => {
  if (!form.value.description) {
    errors.value.description = 'Opis jest wymagany'
  } else if (form.value.description.length < 10) {
    errors.value.description = 'Opis musi mieć minimum 10 znaków'
  } else {
    delete errors.value.description
  }
}

const validatePrice = () => {
  if (!form.value.price) {
    errors.value.price = 'Cena jest wymagana'
  } else if (form.value.price <= 0) {
    errors.value.price = 'Cena musi być większa od 0'
  } else {
    delete errors.value.price
  }
}

const clearError = (field) => {
  delete errors.value[field]
}

// Obsługa plików
const getFilePreview = (file) => {
  return URL.createObjectURL(file)
}

const removePhoto = (index) => {
  form.value.photos.splice(index, 1)
  clearError('photos')
}

const onDrop = (e) => {
  isDragOver.value = false
  const files = Array.from(e.dataTransfer.files)
  processFiles(files)
}

const onFilesChange = (e) => {
  const files = Array.from(e.target.files)
  processFiles(files)
}

const processFiles = (files) => {
  const imageFiles = files.filter(file => file.type.startsWith('image/'))
  
  if (imageFiles.length + form.value.photos.length > 5) {
    errors.value.photos = 'Możesz dodać maksymalnie 5 zdjęć'
    return
  }

  // Sprawdzanie rozmiaru plików (5MB max)
  const oversizedFiles = imageFiles.filter(file => file.size > 5 * 1024 * 1024)
  if (oversizedFiles.length > 0) {
    errors.value.photos = 'Każde zdjęcie może mieć maksymalnie 5MB'
    return
  }

  form.value.photos.push(...imageFiles)
  clearError('photos')
}

const submitForm = async () => {
  // Walidacja wszystkich pól
  validateName()
  validateDescription()
  validatePrice()

  if (!isFormValid.value) {
    error.value = 'Proszę poprawić błędy w formularzu'
    return
  }

  isSubmitting.value = true
  error.value = ''

  try {
    const data = new FormData()
    data.append('name', form.value.name)
    data.append('description', form.value.description)
    data.append('price', form.value.price)
    
    // Zmieniono na 'images[]' zgodnie z API
    form.value.photos.forEach((file) => {
      data.append('images[]', file)
    })

    await addAd(data)
    router.push('/ogloszenia')
  } catch (e) {
    console.error('Błąd podczas dodawania ogłoszenia:', e)
    error.value = 'Wystąpił błąd podczas dodawania ogłoszenia. Spróbuj ponownie.'
  } finally {
    isSubmitting.value = false
  }
}
</script>

<style scoped>
.form-input {
  @apply w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors;
}

.form-textarea {
  @apply w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none;
}

.upload-area {
  @apply border-2 border-dashed border-gray-300 rounded-lg cursor-pointer transition-colors hover:border-blue-400 hover:bg-blue-50;
}

.upload-area.drag-over {
  @apply border-blue-500 bg-blue-50;
}
</style>