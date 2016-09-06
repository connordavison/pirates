# Pirates

## Installation

```
~/ $ git clone https://github.com/connordavison/pirates.git
~/ $ cd pirates
~/pirates $ composer install
```

## Running Tests

```
~/pirates $ vendor/bin/phpunit
```

## Running CLI Game

```
~/pirates $ bin/console pirates:battle --help
~/pirates $ bin/console pirates:battle 15 5 5 15
```

## Notes

- **Defence points** - I have implemented defence points such that one defence point reduces damage by one point (this is done after application of critical hit bonus).
