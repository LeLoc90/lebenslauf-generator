### Lebenslauf Generator

#### "fresh setup / never worked on the project"-Workflow

* clone this repository
* create local environment file`cp .env.example .env`

* Check if the Node.js is installed in the environment
  `node -v ` should print example `v20.xx.xx`
* Check if the NPM is installed in the environment
  `npm -v ` should print example `10.xx.xx`

* if not installed, or the version of **_node_** is under `v20.xx.xx`, follow the steps below:
    * installs nvm (Node Version Manager)
      `curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash`
    * download and install Node.js (you may need to restart the terminal)
      `nvm install --lts`

* install required dependencies via `make install`
* run `make database`
* run `make migrations`
* run `make migrate`
* run `make fixtures`
* run `make start`

* the project is now up & running!
    * webapp:  `http://localhost:8500`

#### daily life recipes

* `make start` start server (detached/background)
* `make stop` stop server