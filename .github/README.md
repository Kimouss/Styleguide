# Kimouss - Styleguide
This project will make a styleguide doc and generate package to use in other projects

@TODO:
- Some css or scss
- Some js
- Transform to package npm or bundle
- Make a command to publish module
- 

## Requirements
- Docker
- Docker-compose
- Make

## Installation
- Edit variable ``PROJECT_PORT`` port in ``.env``
- ``make .env.local``
- Edit your ``.env.local``
- ``make install`` or ``make reset`` :)

## Usage
To generate template, use this command

``make template``

Then specify path of your template like:
- 1_-_one
- 1_-_one/1_-_one_sub_one

Then replace your code in twig files.
And go to url /my_template

![](https://github.com/Kimouss/Styleguide/blob/main/readme_gif/make_template.gif)


