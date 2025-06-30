# Ads Dashboard – Laravel + Vue.js + Docker

A modern classified ads management application with Vue.js 3 frontend, Laravel backend, and full Docker orchestration. Features include ads management, image uploads, real-time validation, and responsive design.

## Project Overview

Create an application for managing classified ads:
- Ads should contain name, description, price and up to 5 images
- Simple form, ads list and ad detail view in the most straightforward way
- All fields must be validated. OOP, SOLID and DRY principles will be evaluated
- Unit and feature tests

## Technology Stack

### Frontend (Vue.js 3)
- **Vue 3** with Composition API
- **Vite** as build tool and dev server
- **Tailwind CSS 3.x** for styling
- **Vue Router** for navigation
- **Axios** for API communication
- **Drag & Drop** file uploads
- **Real-time validation**

### Backend (Laravel 12)
- **Laravel 12** as API and Web framework
- **MySQL** database
- **Eloquent ORM**
- **Form Request Validation**
- **PHPUnit** testing
- **File uploads** with storage links

### DevOps & Infrastructure
- **Docker** + **Docker Compose**
- **Nginx** as reverse proxy
- **PHP-FPM** 
- **Node.js 20** for Vue development

## Quick Start

1. **Clone the repository**
```bash
git clone <repository-url>
cd mobilem.nl
```

2. **Run with Docker Compose**
```bash
docker-compose up -d --build
```

3. **Application URLs**
- **Frontend (Vue.js)**: http://localhost:5173
- **Backend (Laravel)**: http://localhost:8080
- **API Endpoints**: http://localhost:8080/api/ads

## Features Overview

### ✅ Ads Management System (Full-stack)
- **Ads List**: Responsive grid with image thumbnails
- **Add New Ad**: Modern form with drag & drop uploads
- **Ad Details**: Detailed view with image gallery and modal
- **Image Uploads**: Up to 5 images, drag & drop, preview
- **Form Validation**: Real-time validation with visual feedback
- **Responsive Design**: Mobile-first approach
- **Security**: XSS, SQL Injection, CSRF protection

### ✅ Additional: Todo List (Frontend Demo)
- **Add Tasks**: Quick task creation
- **Mark Complete**: Toggle task completion
- **Delete Tasks**: Remove unwanted tasks
- **Local Storage**: Persistent data storage
- **Task Statistics**: Progress tracking

## Project Structure

```
.
├── front/                    # Vue.js 3 + Vite + Tailwind
│   ├── src/
│   │   ├── components/      # Vue Components
│   │   │   └── TodoList.vue # Todo component
│   │   ├── views/           # Page Views
│   │   │   ├── AdsList.vue  # Ads listing (responsive grid)
│   │   │   ├── AddAd.vue    # Add ad form (modern UI)
│   │   │   └── AdView.vue   # Ad details (gallery + modal)
│   │   ├── api.js           # API configuration
│   │   ├── router.js        # Vue Router setup
│   │   └── App.vue          # Main app component
│   ├── Dockerfile           # Node.js 20 Alpine
│   └── package.json         # Dependencies
│
├── src/                     # Laravel 12
│   ├── app/
│   │   ├── Http/Controllers/
│   │   │   └── AdController.php  # CRUD operations
│   │   ├── Models/
│   │   │   └── Ad.php            # Eloquent model
│   │   └── Http/Requests/
│   │       └── StoreAdRequest.php # Form validation
│   ├── routes/
│   │   ├── web.php          # Web routes (Blade views)
│   │   └── api.php          # API routes (JSON)
│   ├── resources/views/     # Blade templates
│   └── database/            # Migrations, seeders
│
├── nginx/
│   └── default.conf         # Nginx configuration
├── Dockerfile               # PHP 8.3 + Laravel
└── docker-compose.yml       # Container orchestration
```

## Docker Services

| Service | Port | Description |
|---------|------|-------------|
| `vue-front` | 5173 | Vue.js development server with HMR |
| `nginx` | 8080 | Nginx reverse proxy + Laravel |
| `app` | 9000 | PHP-FPM (Laravel application) |
| `mysql` | 3306 | MySQL 8.0 database |

## API Endpoints

### Ads Management
- `GET /api/ads` - List all ads (JSON with pagination)
- `POST /api/ads` - Create new ad (with image uploads)
- `GET /api/ads/{id}` - Get ad details (JSON)

### Web Routes (Blade Views)
- `GET /` - Redirect to ads list
- `GET /ads` - Ads listing (HTML)
- `GET /ads/create` - Add ad form (HTML)
- `POST /ads` - Store new ad
- `GET /ads/{id}` - Ad details (HTML)

## Container Access

```bash
# Frontend Vue (npm commands)
docker-compose exec front sh

# Backend Laravel (artisan commands)
docker-compose exec app bash

# MySQL
docker-compose exec mysql mysql -u laravel -p laravel
```

## Useful Commands

```bash
# Full rebuild and restart
docker-compose down
docker-compose up --build -d

# View logs
docker-compose logs front
docker-compose logs app

# Laravel migrations
docker-compose exec app php artisan migrate

# Laravel tests
docker-compose exec app php artisan test
```

## Development

### Frontend (Vue.js)
- Changes in `front/src/` are automatically reloaded (hot reload)
- Vite development server on port 5173
- API calls directed to http://localhost:8080

### Backend (Laravel)
- Changes in `src/` require app container restart
- API available at http://localhost:8080/api/
- Laravel panel at http://localhost:8080

## Security

- CORS configured for frontend-backend communication
- CSRF protection for web forms
- Validation of all input data
- Protection against XSS and SQL Injection

## Testing

```bash
# Backend Laravel
docker-compose exec app php artisan test

# Frontend Vue (if configured)
docker-compose exec front npm run test
```

## Programming Principles

- **OOP** - Use of classes, interfaces, inheritance
- **SOLID** - Following Single Responsibility, Open/Closed, etc. principles
- **DRY** - Don't Repeat Yourself, code reusability
- **Validation** - All form fields are validated
- **Testing** - Unit and Feature tests for backend

## Design & UX Features

### Modern Vue.js Frontend
- **Responsive Grid**: 1→2→3→4→5 columns based on screen size
- **Image Thumbnails**: Automatic image optimization and display
- **Loading States**: Spinners and skeleton screens
- **Progress Bars**: Form completion indicators
- **Drag & Drop**: Intuitive file uploads
- **Real-time Validation**: Instant feedback
- **Modal Gallery**: Full-screen image viewing
- **Breadcrumb Navigation**: Easy navigation
- **Gradient Designs**: Modern visual aesthetics

### Form Features
- **Multi-step Visual Progress**: Progress bar showing completion
- **File Upload Area**: Drag & drop with preview thumbnails
- **Real-time Validation**: Field-by-field error checking
- **Character Counters**: Visual feedback on input limits
- **Price Formatting**: Automatic number formatting
- **Image Preview**: Immediate file preview with removal options

## Browser Compatibility

- Modern browsers (Chrome, Firefox, Safari, Edge)
- Mobile responsive design
- Progressive Web App features
- ES6+ JavaScript support

## Performance Features

- **Vite HMR**: Hot Module Replacement for fast development
- **Image Optimization**: Automatic image resizing and optimization
- **Lazy Loading**: Components and images loaded on demand
- **Caching**: Browser and server-side caching
- **Minification**: CSS and JS minification for production

---

## License

This project is open source and available under the [MIT License](LICENSE). 