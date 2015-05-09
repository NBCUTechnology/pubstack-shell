# Pubstack Shell

This project provides a convenient way to interact with the Pubstack VM.

## Quick Start

Make sure `~/.composer/vendor/bin` is in your `$PATH`, and then:

```
composer global require nbcutechnology/pubstack-shell
pubstack init
pubstack configure
# Your editor will open with the pubstack config. Make your changes and save it.
pubstack up
```

Done.

## Configurable variables.

You can change some behaviors of Pubstack Shell with environment variables.

* `export PUBSTACK_PATH='/home/youruser/path/to/your/pubstack` will allow you to use a custom Pubstack location.
* `export PUBSTACK_REPO="https://github.com/youruser/pubstack"` will let you choose which fork of Pubstack to use. This doesn't necessarily have to be Pubstack, but other vagrant environments are unsupported and we'll laugh at you if there are problems.
