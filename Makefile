#!/usr/bin/make -f

.PHONY: all clean clean-all check test coverage

# ---------------------------------------------------------------------

all: test

clean:
	git clean -Xfq build

clean-all: clean
	rm -rf ./vendor
	rm -rf ./composer.lock

check:
	php vendor/bin/phpcs

test: clean check
	php -dxdebug.mode=coverage vendor/bin/phpunit --testdox

coverage: test
	@if [ "`uname`" = "Darwin" ]; then open build/coverage/index.html; fi

bench:
	XDEBUG_MODE=off php vendor/bin/phpbench run tests/Benchmark --report=default
