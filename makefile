brain-games:
	./bin/brain-games
validate:
	composer validate
linter:
	phpcs --standard=PSR12 bin src
