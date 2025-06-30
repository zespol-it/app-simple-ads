# Aplikacja Ogłoszeń – Laravel + Vue + Docker

Aplikacja do zarządzania ogłoszeniami z możliwością dodawania, przeglądania i zarządzania ogłoszeniami. Frontend w Vue.js 3 + Vite, backend w Laravel, wszystko uruchomione w Docker.

## Opis projektu

Napisać aplikację umożliwiającą dodawanie prostych ogłoszeń:
- Ogłoszenie powinno zawierać nazwę, opis, cenę a także możliwość dodania maksymalnie 5 zdjęć
- Można zrobić prosty formularz, listę ogłoszeń i podgląd ogłoszenia w maksymalnie prosty sposób
- Wszystkie pola muszą być walidowane. Sprawdzane będą zasady OOP, SOLID i DRY
- Testy jednostkowe i feature

## Technologie

### Frontend (Vue.js)
- **Vue 3** z Composition API
- **Vite** jako bundler
- **Tailwind CSS 3.x** do stylizacji
- **Vue Router** do nawigacji
- **Axios** do komunikacji z API

### Backend (Laravel)
- **Laravel 12** jako API i Web
- **MySQL** jako baza danych
- **Eloquent ORM**
- **Walidacja** (FormRequest)
- **Testy** (PHPUnit)

### DevOps
- **Docker** + **Docker Compose**
- **Nginx** jako reverse proxy
- **PHP-FPM**

## Szybki start

1. **Sklonuj repozytorium**
```bash
git clone <repository-url>
cd mobilem.nl
```

2. **Uruchom Docker Compose**
```bash
docker-compose up -d --build
```

3. **Dostęp do aplikacji**
- **Frontend (Vue)**: http://localhost:5173
- **Backend (Laravel)**: http://localhost:8080
- **API**: http://localhost:8080/api/ads

## Funkcjonalności

### System ogłoszeń (Full-stack)
- ✅ Lista ogłoszeń (API + Vue)
- ✅ Dodawanie ogłoszeń
- ✅ Upload zdjęć (max 5)
- ✅ Walidacja formularzy
- ✅ Zabezpieczenia (XSS, SQL Injection, CSRF)
- ✅ Responsywny design

### Dodatkowo: Todo List (Frontend)
- ✅ Dodawanie zadań
- ✅ Oznaczanie jako ukończone
- ✅ Usuwanie zadań
- ✅ Lokalne przechowywanie (localStorage)
- ✅ Statystyki zadań

## Struktura projektu

```
.
├── front/                    # Vue.js 3 + Vite
│   ├── src/
│   │   ├── components/      # Komponenty Vue
│   │   │   └── TodoList.vue # Komponent Todo
│   │   ├── views/           # Widoki
│   │   │   ├── AdsList.vue  # Lista ogłoszeń
│   │   │   ├── AddAd.vue    # Dodawanie ogłoszeń
│   │   │   └── AdView.vue   # Widok ogłoszenia
│   │   ├── api.js           # Konfiguracja API
│   │   ├── router.js        # Vue Router
│   │   └── App.vue          # Główny komponent
│   ├── Dockerfile           # Docker dla Vue
│   └── package.json
│
├── src/                     # Laravel 12
│   ├── app/
│   │   ├── Http/Controllers/
│   │   │   └── AdController.php
│   │   ├── Models/
│   │   │   └── Ad.php
│   │   └── Http/Requests/
│   │       └── StoreAdRequest.php
│   ├── routes/
│   │   ├── web.php          # Web routes
│   │   └── api.php          # API routes
│   └── resources/views/     # Blade templates
│
├── nginx/
│   └── default.conf         # Nginx config
├── Dockerfile               # Docker dla Laravel
└── docker-compose.yml       # Orchestracja kontenerów
```

## Kontenery Docker

| Serwis | Port | Opis |
|--------|------|------|
| `vue-front` | 5173 | Vue.js development server |
| `nginx` | 8080 | Nginx + Laravel |
| `app` | 9000 | PHP-FPM (Laravel) |
| `mysql` | 3306 | MySQL database |

## API Endpoints

### Ogłoszenia
- `GET /api/ads` - Lista ogłoszeń (JSON)
- `POST /api/ads` - Dodanie ogłoszenia
- `GET /api/ads/{id}` - Szczegóły ogłoszenia

### Web (Blade views)
- `GET /` - Przekierowanie do listy ogłoszeń
- `GET /ads` - Lista ogłoszeń (HTML)
- `GET /ads/create` - Formularz dodawania
- `POST /ads` - Dodanie ogłoszenia
- `GET /ads/{id}` - Widok ogłoszenia

## Dostęp do kontenerów

```bash
# Frontend Vue (npm commands)
docker-compose exec front sh

# Backend Laravel (artisan commands)
docker-compose exec app bash

# MySQL
docker-compose exec mysql mysql -u laravel -p laravel
```

## Przydatne komendy

```bash
# Rebuild i restart
docker-compose down
docker-compose up --build -d

# Sprawdź logi
docker-compose logs front
docker-compose logs app

# Migracje Laravel
docker-compose exec app php artisan migrate

# Testy Laravel
docker-compose exec app php artisan test
```

## Rozwój

### Frontend (Vue)
- Zmiany w `front/src/` są automatycznie przeładowywane (hot reload)
- Vite development server na porcie 5173
- API calls kierowane na http://localhost:8080

### Backend (Laravel)
- Zmiany w `src/` wymagają restartu kontenera app
- API dostępne na http://localhost:8080/api/
- Panel Laravel na http://localhost:8080

## Bezpieczeństwo

- CORS skonfigurowany dla komunikacji frontend-backend
- CSRF protection dla formularzy web
- Walidacja wszystkich danych wejściowych
- Zabezpieczenia przed XSS i SQL Injection

## Testy

```bash
# Backend Laravel
docker-compose exec app php artisan test

# Frontend Vue (jeśli skonfigurowane)
docker-compose exec front npm run test
```

## Zasady programowania

- **OOP** - Wykorzystanie klas, interfejsów, dziedziczenia
- **SOLID** - Przestrzeganie zasad Single Responsibility, Open/Closed, etc.
- **DRY** - Don't Repeat Yourself, reużywalność kodu
- **Walidacja** - Wszystkie pola formularzy są walidowane
- **Testy** - Unit i Feature testy dla backendu