<div align="center">
    <h1>Laravel 12 API Auth System with Passport (Password Grant) 🔑</h1>
</div>

This project is a secure **API authentication system** built with **Laravel 12** using **Laravel Passport** with the **Password Grant** client. It provides user registration, login, password reset, email verification, and role-based access control.  

The project follows modern standards (**PSR-12**, ✅), includes **100% test coverage** 🧪, and is fully **Dockerized** 🐳 for consistent development, staging, and production environments.  

---

## ✨ Key Features

- **Authentication:** OAuth2 **Password Grant** token-based authentication with **Laravel Passport**. 🛡️  
- **User Management:** Routes for user registration ✍️, password reset 🔑, and email verification 📧.  
- **Role-Based Access:** Middleware ensures `Admin`, `User`, and `Subscriber` roles access the right endpoints 👮.  
- **Dockerized:** Preconfigured setup for local, staging, and production environments 🚀.  
- **Code Quality:**
  - 100% **PSR-12** compliance. ✅  
  - 100% **test coverage** with unit + feature tests. ✅  
  - Static analysis with **Larastan** 🧐.  
- **Postman Collection:** A ready-to-use collection is included at `src/Passport Token Auth.postman_collection.json` 📬.  

---

## 📂 Project Structure

```bash
📦passport_password_grant_auth
 ┣ 📂.github
 ┃ ┗ 📂workflows
 ┃ ┃ ┣ 📜database-migration-check.yml
 ┃ ┃ ┣ 📜larastan.yml
 ┃ ┃ ┣ 📜php-cs-fixer.yml
 ┃ ┃ ┣ 📜phpunit.yml
 ┣ 📂.vscode
 ┃ ┗ 📜launch.json
 ┣ 📂docker
 ┃ ┣ 📂nginx
 ┃ ┃ ┣ 📂html
 ┃ ┃ ┃ ┗ 📜maintenance.html
 ┃ ┃ ┗ 📂templates
 ┃ ┃ ┃ ┗ 📜default.conf.template
 ┃ ┗ 📂php-fpm
 ┃ ┃ ┣ 📜Dockerfile
 ┃ ┃ ┣ 📜entrypoint.sh
 ┃ ┃ ┗ 📜supervisor.conf
 ┣ 📂src
 ┃ ┣ 📂app
 ┃ ┃ ┣ 📂Http
 ┃ ┃ ┃ ┣ 📂Controllers
 ┃ ┃ ┃ ┣ 📂Middleware
 ┃ ┃ ┃ ┗ 📂Requests
 ┃ ┃ ┣ 📂Logging
 ┃ ┃ ┣ 📂Mixins
 ┃ ┃ ┣ 📂Models
 ┃ ┃ ┗ 📂Providersp
 ┃ ┣ 📂bootstrap
 ┃ ┣ 📂config
 ┃ ┣ 📂coverage-html
 ┃ ┣ 📂database
 ┃ ┃ ┣ 📂factoriesp
 ┃ ┃ ┣ 📂migrations
 ┃ ┃ ┣ 📂seeders
 ┃ ┃ ┗ 📜.gitignore
 ┃ ┣ 📂lang
 ┃ ┣ 📂public
 ┃ ┣ 📂resources
 ┃ ┣ 📂routes
 ┃ ┣ 📂storage
 ┃ ┃ ┣ 📂app
 ┃ ┃ ┃ ┣ 📂public
 ┃ ┃ ┣ 📂framework
 ┃ ┃ ┗ 📂logs
 ┃ ┣ 📂tests
 ┃ ┃ ┣ 📂Feature
 ┃ ┃ ┣ 📂Unit
 ┃ ┣ 📂vendor
 ┃ ┣ 📜.env
 ┃ ┣ 📜.env.example
 ┃ ┣ 📜.env.local
 ┃ ┣ 📜.env.prod
 ┃ ┣ 📜.env.staging
 ┃ ┣ 📜.gitignore
 ┃ ┣ 📜artisan
 ┃ ┣ 📜composer.json
 ┃ ┣ 📜composer.lock
 ┃ ┣ 📜package.json
 ┃ ┣ 📜phpstan.neon
 ┃ ┣ 📜phpunit.xml
 ┃ ┣ 📜Passport Toten Auth.postman_collection.json
 ┣ 📜.gitattributes
 ┣ 📜.gitignore
 ┣ 📜docker-compose.local.yml
 ┣ 📜docker-compose.prod.yml
 ┣ 📜docker-compose.staging.yml
 ┣ 📜docker-compose.yml
 ┗ 📜README.md
````

---

## ➡️ API Routes

All APIs are prefixed with `/v1`.

### 🔓 Public Routes (`/v1/auth`)

| Method | Path                                 | Description                                    |
| :----: | :----------------------------------- | :--------------------------------------------- |
| `POST` | `/v1/auth/register`                  | Register a new user. 📝                        |
| `POST` | `/oauth/token`                       | Obtain access token via **Password Grant**. 🔑 |
| `POST` | `/v1/auth/forgot-password`           | Send password reset link. 📩                   |
| `POST` | `/v1/auth/reset-password`            | Reset password using token. 🔄                 |
| `POST` | `/v1/auth/resend-verification-email` | Resend email verification. 📧                  |
| `POST` | `/v1/auth/verify-email/{id}/{hash}`  | Verify email link. ✅                           |
|  `GET` | `/v1/health`                         | Health check endpoint. ❤️‍🩹                   |

### 🔒 Protected Routes (`/v1/auth`)

Requires a valid Passport token and verified email (`auth:api`, `verified`).

| Method | Path              | Description                 |
| :----: | :---------------- | :-------------------------- |
| `POST` | `/v1/auth/logout` | Logout and revoke token. 🚪 |

### 🛡️ Role-Based Access Routes

| Method | Path             | Required Role(s)          |
| :----: | :--------------- | :------------------------ |
|  `GET` | `/v1/admin`      | `Admin`, `Super Admin` 👑 |
|  `GET` | `/v1/user`       | `User` 🧑‍💻              |
|  `GET` | `/v1/subscriber` | `Subscriber` 🔔           |

---

## 🚀 Getting Started

### ⚙️ Prerequisites

* Docker 🐳
* Git 🐙

### 🛠️ Installation Steps

1. **Clone repository**

   ```bash
   git clone [repository-url]
   cd passport_password_grant_auth
   ```

2. **Set up environment**

    Use the appropriate `docker-compose` and `.env` file for your desired environment.

    **For Local (Dev):**

    ```bash
    cp docker-compose.local.yml docker-compose.yml
    cd src && cp .env.local .env
    ```

    **For Staging:**

    ```bash
    cp docker-compose.staging.yml docker-compose.yml
    cd src && cp .env.staging .env
    ```

    **For Production:**

    ```bash
    cp docker-compose.prod.yml docker-compose.yml
    cd src && cp .env.prod .env
    ```

3. **Build containers**

   ```bash
   docker-compose up -d --build
   ```

4. **Run migrations and Passport setup**

   ```bash
   docker-compose exec app php artisan migrate --seed
   docker-compose exec app php artisan passport:keys --no-interaction
   docker-compose exec app php artisan passport:client --password --no-interaction
   ```

   Save the generated **Client ID** and **Client Secret** for login.

---

## 🔑 Example: Get Access Token

Send a `POST` request to `/oauth/token`:

```json
{
  "grant_type": "password",
  "client_id": "CLIENT_ID",
  "client_secret": "CLIENT_SECRET",
  "username": "user@example.com",
  "password": "password",
  "scope": "*"
}
```

Response:

```json
{
  "token_type": "Bearer",
  "expires_in": 31536000,
  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGci...",
  "refresh_token": "def50200c1aa7d..."
}
```

Use the `access_token` in the `Authorization` header:

```
Authorization: Bearer {token}
```

---

## 📬 Postman Collection

A **Postman Collection** is included at:

```
src/Passport Password Grant Auth.postman_collection.json
```

You can import this collection into Postman and test the full authentication flow

---

## 🧪 Running Tests & Code Quality Checks

To run the full test suite and code quality checks, execute the following commands.

### **PHPUnit**

To run the full test suite and check code coverage, execute the following command:

```bash
docker-compose exec app vendor/bin/phpunit --testdox --coverage-html
```

To generate an HTML report of the code coverage, which will be saved in the `src/coverage-html` directory, use this command:

```bash
docker-compose exec app vendor/bin/phpunit --testdox --coverage-html=coverage-html
```
To check coverage open `coverage-html/index.html` in a browser.


### **PHP-CS-Fixer** 🎨

PHP-CS-Fixer checks and fixes code style to ensure PSR-12 compliance.

  * **Check for code style violations:**
    ```bash
    docker-compose exec app vendor/bin/php-cs-fixer fix app --dry-run --diff --verbose
    ```
  * **Fix all code style violations:**
    ```bash
    docker-compose exec app vendor/bin/php-cs-fixer fix app
    ```

### **Larastan (PHPStan)** 🧐

Larastan performs static analysis to find potential bugs and code smells.

  * **Run a full static analysis:**
    ```bash
    docker-compose exec app vendor/bin/phpstan analyse
    ```
  * **Generate a baseline to ignore existing errors:**
    ```bash
    docker-compose exec app vendor/bin/phpstan analyse --generate-baseline
    ```
---

## 🤝 Contributing

We welcome contributions\! 🙏 Please ensure your pull requests meet the following criteria:

  - Adhere to **100% PSR-12** standards. ✅
  - Include comprehensive tests to maintain **100% test coverage**. ✅🧪
  - Ensure all **GitHub Actions** workflows pass successfully. 🚦

---

## 📜 License

Licensed under the **MIT license**. 📄