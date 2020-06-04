
.PHONY: help
help:
	"test		Run the tests"

.PHONY: test
test:
	@vendor/bin/phpunit --verbose
