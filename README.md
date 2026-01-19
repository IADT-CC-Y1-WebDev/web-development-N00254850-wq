[![Review Assignment Due Date](https://classroom.github.com/assets/deadline-readme-button-22041afd0340ce965d47ae6ef1cefeee28c7c493a6346c4f15d667ab976d596c.svg)](https://classroom.github.com/a/xULqpsIs)
# Web Development Module

A Docker-based development environment for learning PHP and JavaScript.

## Quick Start

1. Make sure Docker Desktop is installed and running
2. Open a terminal in this folder
3. Start the containers:
   ```bash
   docker compose up -d
   ```
4. Open your browser:
   - **Web application:** http://localhost:8080
   - **phpMyAdmin:** http://localhost:8081

## Folder Structure

```
src/
├── examples/                    # Lecture code (organised by topic)
│   ├── 01-php-introduction/
│   ├── 02-php-classes-objects/
│   ├── 03-php-cookies-sessions/
│   ├── 04-php-forms/
│   ├── 05-php-database/
│   ├── 06-js-classes-objects/
│   ├── 07-js-dom/
│   ├── 08-js-events/
│   └── 09-js-form-validation/
├── exercises/                   # Your work goes here (organised by topic)
│   ├── 01-php-introduction/
│   ├── 02-php-classes-objects/
│   └── ...
└── capstone/                    # Final assignment
```

## Where to Put Your Work

- Put your exercise solutions in `exercises/<topic>/` for each topic
- Put your capstone project files in the `capstone/` folder

## Updating Examples from Your Instructor

Your instructor may add new examples and exercises throughout the module. To get the latest updates, run the update script:

**Windows:**
```
update-examples.bat
```

**Mac/Linux:**
```bash
./update-examples.sh
```

The script will automatically:
1. Add your instructor's repository as a remote (first time only)
2. Fetch and merge the latest updates

If you see merge conflicts, ask your instructor for help.

### Manual Update (alternative)

If you prefer to run the commands manually:

```bash
git fetch upstream
git merge upstream/main -m "Update examples from instructor"
```

| Command | What it does |
|---------|--------------|
| `git fetch upstream` | Downloads updates (doesn't apply them) |
| `git merge upstream/main` | Applies the updates to your code |
| `git status` | Shows if you have conflicts to resolve |

## Docker Commands

| What you want to do | Command |
|---------------------|---------|
| Start everything | `docker compose up -d` |
| Stop everything | `docker compose down` |
| See what's running | `docker ps` |
| View logs | `docker compose logs apache-php-container` |
| Restart a container | `docker compose restart apache-php-container` |

## Database Credentials

| Setting | Value |
|---------|-------|
| Host | `mysql-container` |
| Database | `testdb` |
| Username | `testuser` |
| Password | `mysecret` |

For more details on Docker, see [DOCKER.md](DOCKER.md).
