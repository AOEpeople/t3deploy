#########
t3deploy
#########
:Author: Oliver Hader, Daniel Poetzinger, Michael Klapper |extensionIcon|
:Version: 0.0.0
:Description: TYPO3 dispatcher for database related operations.

***************************************
Overview
***************************************

Available Commands
================================

Add New Database Definitions
--------------------------------------------------
::

    php typo3/cli_dispatch.phpsh t3deploy database updateStructure --verbose --execute

Remove Old Database Definitions
--------------------------------------------------
::

    php typo3/cli_dispatch.phpsh t3deploy database updateStructure --remove --verbose --execute


.. |extensionIcon| image:: https://raw.github.com/AOEmedia/t3deploy/master/ext_icon.gif