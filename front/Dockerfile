# Użyj Node.js 20 Alpine - najnowsza stabilna wersja
FROM node:20-alpine

# Ustaw katalog roboczy
WORKDIR /app

# Skopiuj pliki package.json i package-lock.json
COPY package*.json ./

# Zainstaluj zależności (wszystkie, nie tylko production)
RUN npm install

# Skopiuj kod źródłowy
COPY . .

# Ustaw port
EXPOSE 5173

# Komenda do uruchomienia dev serwera
CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0"] 