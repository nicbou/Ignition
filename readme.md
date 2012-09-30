
# Ignition

## What does it do?

Ignition is a dead simple micro CMS for sites that are too small for WordPress and other CMS software. It takes seconds to set up, and works on just about any website with very little effort. For instance, I use it to quickly convert static websites into client-editable websites on a budget.

Ignition makes use of [Redbean](http://redbeanphp.com), a tiny ORM that automatically handles table creation and object management. The code is included as-is in redbean.php.

## How to use

### Requirements

Ignition requires PHP 5.3 and a database to run, that's it.

Although a fallback function is present, the strings used by Ignition use gettext for easy translation.

### The files

1. Copy the ignition folder on your website. Its location does not matter, as long as you can include it in your pages.

### Setting up your database

1. Create an empty database in cPanel, phpMyAdmin or a tool of your choice
1. Edit the config.sample.php with your database credentials and save it as config.php

### Configuring Ignition

1. At the very beginning of your page, even before the doctype and PHP code, insert the following tag: *<?php include('/path/to/ignition/ignition.php') ?>*
1. To insert a block of text, use the following code: *<?php TextBlock::show('name_of_your_block') ?>*. There are other available types such as RawTextBlock (for plain HTML) and ParagraphBlock (converts line breaks to paragraphs).

The name of the block is simply used to identify the block. This also means you can reuse a block at different places on your site.

### Editing blocks of text

1. Add ?login at the end of your URL to connect
1. Once logged in, you will be able to edit your blocks.
1. To log out, add ?logout at the end of the URL

### Built-in block types

Currently, Ignition offers the following block types:

* **RawTextBlock** supports raw HTML and doesn't escape tags.
* **TextBlock** handles plain text, but escapes HTML.
* **ParagraphBlock** converts double line breaks to paragraphs, and line breaks to <br> tags.

## How to extend

The default Block class in block.php defines the structure of a typical block. You can define your own by extending existing Block classes, adding features such as rich text editors and even file uploads.

The login page is contained within login.php, and can also be edited. Considering how light the code is (just under 26kb, not counting Redbean), it's a breeze to edit and extend.

### Creating new blocks

Creating a new block is as simple as extending a class and redefining the required functions. The abstrack Block class under /ignition/blocks/block.php is an example of a working block. Once you are done, you must save your block under the blocks folder with a name ending with .block.php .