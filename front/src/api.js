import axios from 'axios'

// Konfiguracja base URL dla API Laravel
const api = axios.create({
  baseURL: 'http://localhost:8080',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
})

export function getAds() {
  return api.get('/api/ads')
}

export function getAd(id) {
  return api.get(`/api/ads/${id}`)
}

export function addAd(data) {
  // Dla FormData (pliki) używamy specjalnych nagłówków
  return api.post('/api/ads', data, {
    headers: {
      'Content-Type': 'multipart/form-data',
      'Accept': 'application/json'
    }
  })
} 