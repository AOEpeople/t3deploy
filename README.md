# t3deploy

TYPO3 dispatcher for database related operations.

## Usage

### Add new database definitions

php typo3/cli_dispatch.phpsh t3deploy database updateStructure --verbose --execute

### Remove old database definitions

php typo3/cli_dispatch.phpsh t3deploy database updateStructure --remove --verbose --execute

### Only report new database definitions and removals

php typo3/cli_dispatch.phpsh t3deploy database updateStructure --remove --verbose

### Only report new database definitions and removals to file

php typo3/cli_dispatch.phpsh t3deploy database updateStructure --remove --verbose --dump-file update_dump.sql

### Options
* --verbose (-v): Report changes
* --execute (-e): Execute changes (updates, removals)
* --remove (-r): Include structure differences for removal
* --drop-keys: Removes key modifications that will cause errors
* --dump-file: Dump changes to file

## Requirements

TYPO3 6.2+

## Authors

Oliver Hader, Daniel Poetzinger, Michael Klapper

See also the list of [contributors](https://github.com/AOEpeople/t3deploy/contributors) who participated in this project.

## Copyright / License

Copyright: (c) 2012 - 2016, AOE GmbH
License: GPLv3, <http://www.gnu.org/licenses/gpl-3.0.en.html>