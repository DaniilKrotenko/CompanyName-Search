## A simple app to search for a company by its name and address


## Installation

1. Clone repository
2. Clone .env.example as .env
3. Run `docker-compose up -d` from /docker/docker-compose.yml
4. Run `php artisan serve`
5. Run `php artisan migrate`
6. Run `php artisan data:parse`
7. Run tests from /tests/Integration/DataParsing

## API 

http://localhost:8000/api/companies/ - Shows all companies that are in the database

http://localhost:8000/api/companies/search?query=man - Finds a company by name or part of a name.
