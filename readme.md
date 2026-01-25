This is the notetaking app created using Laravel and Vue using TailwindCSS to style the forms 

It is using PHP Version 8.4 and Node Version 20

ENV Variables need adding to the .env file

Example:
PROJECT_NAME=notetakingapp
PHP_VERSION=8.4
NODE_VERSION=20
PROJECT_BASE_URL=notetakingapp.local #change this to your local domain
DOCKER_ENV=dev #change this to dev or prod
USER_ID=1001 #change this to your user id


It was setup via Docker.

### Getting Started

1. **Clone the repository**
2. **Install dependencies:**
   ```bash
   docker compose up --build -d
   ```
3. **Initialize environment:**
   ```bash
   docker compose exec -it app bash
   cp .env.example .env 
   composer install
   php artisan key:generate
   php artisan migrate
   php artisan storage:link
   ```
5. **Run the application:**
   - The application will be available at [http://localhost](http://localhost).
   - To watch for frontend changes, run:
     ```bash
     npm run dev
     
     
