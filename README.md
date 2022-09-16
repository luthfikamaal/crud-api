# CRUD Rest API

## Getting started

```
git clone https://github.com/luthfikamaal/crud-api.git
cd crud-api
composer install
```

Configure your database in `.env`, then run this command

```
php artisan serve
```

## How to use

| Route                          | Method        |
| ------------------------------ | ------------- |
| GET `/api/post`                | get all posts |
| POST `/api/post`               | create a post |
| GET `/api/post/{post:slug}`    | read a post   |
| PUT `/api/post/{post:slug}`    | update a post |
| DELETE `/api/post/{post:slug}` | delete a post |

| Route                                  | Method             |
| -------------------------------------- | ------------------ |
| GET `/api/category`                    | get all categories |
| POST `/api/category`                   | create a category  |
| GET `/api/category/{category:slug}`    | read a category    |
| PUT `/api/category/{category:slug}`    | update a category  |
| DELETE `/api/category/{category:slug}` | delete a category  |

You can see all routes by running this command

```
php artisan route:list
```
