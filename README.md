# 🪙 Coin Inventory Service

The **Coin Inventory Service** is a microservice for managing an inventory of investment coins. It is built using a layered architecture approach in **PHP 8.4**, with **Redis** as its primary data store. The service is optimized for high performance and deployable via **FrankenPHP** and **Helm**.

---

## 📦 Features

- Layered architecture with clear separation of concerns (Application, Domain, Infrastructure, Presentation)
- Uses Redis for fast, in-memory data operations
- REST-like API powered by Symfony 7.1 components
- Release process with changelog generation
- Containerized for local development via Docker Compose
- Includes CI-friendly test and code quality tooling
- Deployable via Helm chart

---

## 🚀 Getting Started

### 🧰 Prerequisites

- Docker & Docker Compose
- Make
- PHP 8.4+
- Redis (used internally via Docker)
- Helm (for Kubernetes deployments)

---

### 🔧 Makefile Commands

Run these from the root of the project:

| Command           | Description                             |
|-------------------|-----------------------------------------|
| `make build`      | Builds container images                 |
| `make start`      | Starts application in development mode  |
| `make stop`       | Stops running containers                |
| `make restart`    | Restarts the application                |
| `make shell`      | Opens a shell inside the app container  |
| `make test`       | Runs PHPUnit and Behat tests            |
| `make code-style` | Checks code style with PHP_CodeSniffer  |
| `make release`    | Creates a new release tag and changelog |
| `make help`       | Displays available make targets         |

---

## 📦 Dependencies

### 🧱 Runtime

- `guzzlehttp/guzzle` – HTTP client
- `kevinrob/guzzle-cache-middleware` – Caching middleware for Guzzle
- `predis/predis` – Redis client
- `moneyphp/money` – Value object for monetary calculations
- `ramsey/uuid` – UUID generation
- `symfony/*` – Framework and support components

### 🧪 Dev & Tooling

- `phpunit/phpunit` – Unit testing
- `behat/behat` – BDD framework
- `squizlabs/php_codesniffer` – Code style checks
- `captainhook/captainhook` – Git hooks automation
- `php-conventional-changelog` – Conventional changelog generator

---

## 🛠 Architecture

The project follows a **Layered Architecture** pattern:

This approach ensures loose coupling between business logic and infrastructure, enabling better maintainability and testing.

---

## 🧪 Testing & Quality

All commits go through automated checks defined in [CaptainHook](https://captainhookphp.github.io):

- ✅ Pre-commit linting
- ✅ Code style checks
- ✅ Full test suite execution
- ✅ Commit message validation (Conventional Commits)

---

## 📝 Release Notes

To create a new release:

```bash
make release
git push origin main --tags
