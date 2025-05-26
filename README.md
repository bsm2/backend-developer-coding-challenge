# backend developer coding challenge

a simplified content scheduling application that lets users create and schedule posts
across multiple social platforms.

## Requirements

-   PHP >= 8.1
-   Composer
-   Laravel >= 12.x
-   MySQL
-   Node.js 22.12.0 and NPM 10.9.0 (for frontend assets, if applicable)

## Getting Started

### 1. Clone the repository

```bash
git clone https://github.com/bsm2/backend-developer-coding-challenge.git
cd backend-developer-coding-challenge
```

### 2. Install PHP & JavaScript dependencies

```bash
composer install
npm install
```

### 2. Copy the environment file:

```bash
cp .env.example .env
```

### 2. Generate application key

```bash
   php artisan key:generate
```

### 2. Run database migrations

```bash
   php artisan artisan migrate --seed
```

### 2. Build frontend assets

```bash
  npm run dev or npm run build On production
```

### 2. Serve App

```bash
  php artisan artisan serve
```

# Social Media Scheduler - Technical Approach

Maintainability: Clear separation of concerns

Performance: Optimized for scheduling operations

## Performance Considerations
- Optimizations Implemented
- Eager loading for post relationships

- caching for posts and platforms metadata

- Cron Jobs for scheduled posts


## Known Limitations

- Large media uploads require proper server configuration

- Social API rate limits may delay some operations

## Security Implementation
- CSRF protection via Sanctum

- Input validation using FormRequest classes

- API rate limiting (60 requests/minute)

