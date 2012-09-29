
# Ignition

## What does it do?

Ignition is a dead simple micro CMS for sites that are too small for WordPress and other CMS software. It takes seconds to set up, and works on just about any website with very little effort. For instance, I use it to quickly convert static websites into client-editable websites on a budget.

Ignition makes use of [Redbean](http://redbeanphp.com), a tiny ORM that automatically handles table creation and object management. The code is included as-is in redbean.php.

## How to use

### The files

1. Copy the ignition folder on your website. Its location does not matter, as long as you can include it in your pages.

### Setting up your database

1. Create an empty database in cPanel, phpMyAdmin or a tool of your choice
1. Edit the config.sample.php with your database credentials and save it as config.php

### Configuring Ignition

1. At the very beginning of your page, even before the doctype and PHP code, insert the following tag: <?php include('/path/to/ignition/ignition.php') ?>
1. To insert a block of text, use the following code: <?php TextBlock::show('my_text_area') ?>. There are other available types such as RawTextBlock (for plain HTML) and ParagraphBlock (converts line breaks to paragraphs).

## How to extend

The default Block class in block.php defines the structure of a typical block. You can define your own by extending existing Block classes, adding features such as rich text editors and even file uploads.

The login page is contained within login.php, and can also be edited. Considering how light the code is (just under 26kb, not counting Redbean), it's a breeze to edit and extend.