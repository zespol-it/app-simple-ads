<script setup>
// Usuń niepotrzebne importy
</script>

<template>
  <div class="min-h-screen bg-gray-100">
    <nav class="bg-white shadow-lg mb-6">
      <div class="px-6 py-4">
        <div class="flex items-center justify-between">
          <h1 class="text-xl font-bold text-gray-800">Ads Dashboard</h1>
          <div class="flex space-x-6">
            <router-link 
              to="/todos" 
              class="text-blue-600 hover:text-blue-800 font-medium transition-colors"
              active-class="text-blue-800 border-b-2 border-blue-800"
            >
              📝 Todo List
            </router-link>
            <router-link 
              to="/ogloszenia" 
              class="text-blue-600 hover:text-blue-800 font-medium transition-colors"
              active-class="text-blue-800 border-b-2 border-blue-800"
            >
              📋 Lista ogłoszeń
            </router-link>
            <router-link 
              to="/dodaj" 
              class="text-blue-600 hover:text-blue-800 font-medium transition-colors"
              active-class="text-blue-800 border-b-2 border-blue-800"
            >
              ➕ Dodaj ogłoszenie
            </router-link>
          </div>
        </div>
      </div>
    </nav>
    
    <main>
      <router-view />
    </main>
    
    <footer class="mt-12 py-6 bg-white border-t">
      <div class="px-6 text-center text-gray-600">
        <p>Ads Dashboard</p>
      </div>
    </footer>
  </div>
</template>

<style>
/* Dodatkowe globalne style */
.router-link-active {
  font-weight: 600;
}
</style>
