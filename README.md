## GitHub User History

This app created to track 
the history of commits per user on daily basis.

To be able to use the app you need to create
GitHub Personal Access Token: [https://github.com/settings/tokens](https://github.com/settings/tokens)
and add it to .env

`GITHUB_PERSONAL_ACCESS_TOKEN=`

To be able to retrieve data about repo and user you need to grant 
permission to `repo` and `user`.

## API Documentation
[https://documenter.getpostman.com/view/12373103/Tzef93XZ](https://documenter.getpostman.com/view/12373103/Tzef93XZ)

## Technical Solution

As github has limitations on API calls, I decided 
to sync commits on daily basis, by querying past day commits and saving them under respective author inside our database.
That will prevent limit exceeding, as we will not be forced to query to GitHub API every time we need to retrieve the data.
## How to run the code

First, copy `.env.example` to `.env`

Create Database Table, ex. `github_api` and add DB Creds to .env

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=github_api
DB_USERNAME=root
DB_PASSWORD=
```

Run `php artisan migrate` to fill db tables

## How to fill Github Data

Run `php artisan sync:github`

This command will fill the user Organizations, Repos and Repo Authors into the DB

To fill the information about commits you need to run `php artisan sync:commits`

`sync:commits` command will run scheduled every day and will update past day information in the table. 

To run scheduler you need to set up cron job. 

Read moe in Laravel Running The Scheduler Official Doc. 
[https://laravel.com/docs/8.x/scheduling#running-the-scheduler](https://laravel.com/docs/8.x/scheduling#running-the-scheduler)

To run organizations, repos, authors syncing separately you can use following commands

```
php artisan sync:organizations
php artisan sync:repos
php artisan sync:authors
```
## What I would do if I have more time

1. I would create ability to set time range for getting commits for author.
2. Ability to set time range for sync:commits command to make the command more dynamic.
3. Ability to sync commits any time via api call
