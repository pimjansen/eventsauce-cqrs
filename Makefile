DOCKER_BRIDGE_IP=$(shell docker network inspect bridge --format='{{(index .IPAM.Config 0).Gateway}}')
.EXPORT_ALL_VARIABLES:
GROUP_ID=${id -g}
USER_ID=${id -u}

help:
	@grep -E '^[a-zA-Z0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

install: ## Install all third party references
	docker-compose exec -T app composer install

setup-azure: ## Logs into Azure & Senet container repository
	az login
	az acr login --name senet

up: ## Start the application
	docker-compose up --detach

down: ## Stop the application
	docker-compose down --remove-orphans

login: ## Login to the docker php container
	docker-compose exec app bash

run: ## Runs console command for application (provide cmd="[cmd]" parameter) or lists all console commands
	docker-compose exec -T app ./bin/console ${cmd}

logs: ## Display container logs (defaults to all containers, provide optional parameter container=[container] to follow just one)
	docker-compose logs --tail=0 --follow ${container}
