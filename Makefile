include .env

install:
	@$(MAKE) -s down
	@$(MAKE) -s docker-build
	@$(MAKE) -s up
	@$(MAKE) -s composer-install

up:
	@docker compose -p calculator up -d

down:
	@docker compose -p calculator down --remove-orphans

ps:
	@docker compose -p calculator ps

restart: down up

logs:
	@docker compose -p calculator logs -f

docker-build: \
	docker-build-php-fpm \
	docker-build-nginx \
	docker-build-common-tools

docker-build-common-tools:
	@docker build --target=common-tools \
	-t localhost/calculator-common-tools:latest -f ./docker/Dockerfile .

docker-build-php-fpm:
	@docker build --target=fpm \
	--build-arg USER=1000 \
	--build-arg GROUP=1000 \
	-t localhost/calculator-php-fpm:latest -f ./docker/Dockerfile .

docker-build-nginx:
	@docker build --target=nginx \
	-t localhost/calculator-nginx:latest -f ./docker/Dockerfile .

composer-install:
	@docker compose -p calculator run --rm php-fpm composer install --no-cache

yii-run:
	@docker compose -p calculator run --rm php-fpm php ./yii $(cmd)
yii-migrate:
	@docker-compose -p calculator run --rm php-fpm php ./yii migrate

yii-migration-create:
	@docker-compose -p calculator run --rm php-fpm php ./yii migrate/create $(name)

spa-install:
	@docker build --target=node \
	--build-arg USER=1000 \
	--build-arg GROUP=1000 \
	-t localhost/calculator-spa:latest -f ./docker/Dockerfile .
	@docker run --rm -v "D:/calculator-yii2-master/frontend":/app localhost/calculator-spa:latest yarn install

spa-build:
	@docker run --rm -v "D:/calculator-yii2-master/frontend":/app -v "D:/calculator-yii2-master/web":/app-web \
		-e API_AUTH_KEY=${X_API_KEY} \
		-e API_BASE_URL=${API_BASE_URL} \
	localhost/calculator-spa:latest yarn run build

spa-dev-up:
	@$(MAKE) -s up
	@docker run --rm -d -v "D:/calculator-yii2-master/frontend":/app -v "D:/calculator-yii2-master/web":/app-web \
		--name calculator-spa-dev \
		-p 3000:5173 \
		-e API_AUTH_KEY=${X_API_KEY} \
		-e API_BASE_URL=${API_BASE_URL} \
	localhost/calculator-spa:latest yarn run dev && \
	echo "\033[0;32mSPA приложение запущено в режиме разработки по адресу http://localhost:3000\033[0m\n\033[0;33mПо готовности доработок завершите режим разработки командой make spa-dev-down\033[0m"

spa-dev-down:
	@$(MAKE) -s down
	@docker stop calculator-spa-dev && \
	echo "\033[0;32mРежим разработки SPA приложения остановлен.\033[0m\n\033[0;33mДля сборки production-ready SPA приложения выполните команду make spa-build\033[0m"

