# Backend Laravel API

## Installation Process

-   Clone this repo using `git clone https://github.com/bappi2097/backend-laravel-api.git`
-   Enter the dir using `cd backend_laravel_api`
-   create a `.env` file and enter the required value see `.env.example`
-   For running project you will need some api key

    ```php
      # news api url & key
      NEWS_API_URL=https://newsapi.org/v2/
      NEWS_API_KEY=

      # the guardian api url & key
      GUARDIAN_API_URL=https://content.guardianapis.com/
      GUARDIAN_API_KEY=

      # the new york times api url & key
      NY_TIMES_API_URL=https://api.nytimes.com/svc/search/v2/articlesearch.json/
      NY_TIMES_API_KEY=
    ```

## (Docker)

-   Run command on terminal `docker-compose up --build`

    **There some issue with docker installation. But it's okay in local environment**

## Locally Run

-   Run `php artisan migrate:fresh --seed`
-   Run `php artisan serve`

    Project is running on <http://localhost:8000/>

**For any query please contact with me. bappi35-2097@diu.edu.bd**
