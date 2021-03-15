#!make
.PHONY: help all run lint phpcs phpcs_app phpcs_lang phpcbf_app phpcbf_lang phpstan

help:
	@echo "Project aliases and shortcuts."

	@echo "\nCode style and quality"
	@echo "    make all                - Run Lint, CodeSniffer and strict codesniffer with PHP STAN"
	@echo "    make lint               - Run PHP linter"
	@echo "    make phpcs              - Run all CodeSniffer"
	@echo "    make phpcs_app          - Run CodeSniffer for app files"
	@echo "    make phpcs_lang         - Run CodeSniffer for language files"
	@echo "    make phpcbf_app         - Run CodeSniffer Beautifier for app files"
	@echo "    make phpcbf_lang        - Run CodeSniffer Beautifier for language files"
	@echo "    make phpstan            - Run PHP STAN"

all:
	make lint
	php artisan view:clear
	make phpcs
	make phpstan

run:
	make all

lint:
	php artisan view:cache
	./vendor/bin/parallel-lint ./app ./bootstrap/app.php ./config ./database ./resources/lang ./routes ./tests ./storage/framework/views

phpcs:
	make phpcs_app
	make phpcs_lang

phpcs_app:
	./vendor/bin/phpcs --standard=./phpcs.xml $(PARAMS)

phpcs_lang:
	./vendor/bin/phpcs --standard=./phpcs_lang.xml $(PARAMS)

phpcbf_app:
	./vendor/bin/phpcbf --standard=./phpcs.xml $(PARAMS)

phpcbf_lang:
	./vendor/bin/phpcbf --standard=./phpcs_lang.xml $(PARAMS)

phpstan:
	./vendor/bin/phpstan analyse --memory-limit=-1
