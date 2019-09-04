
.PHONY: help
help:
	"test		Run the tests"

.PHONY: test
test:
	@vendor/bin/atoum -f tests/VaCentralTest.php
