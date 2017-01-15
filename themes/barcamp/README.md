PražskýBarcamp theme
====================

Bootstrap 3 theme for PrazskyBarcamp with [Sass](http://sass-lang.com/) support and other plugins integration.

## Features

- automatically compiling Sass files
- dependencies managed by **[Yarn](https://yarnpkg.com/) and [Bower](https://bower.io/)**
- [FontAwesome](http://fontawesome.io/) and [Font Lato](http://www.latofonts.com/lato-free-fonts/) included
- theme config file prepared

## Sass compiling

Sass compiling is fully automatic. Just make change at your Sass files, save and reload your website.

For local development be sure, that you have `cms.enableAssetDeepHashing` config set to `true`!

At production you can set `cms.enableAssetMinify` to `true` for assets minification.

## Configure Bootstrap

You can find main file at `/assets/sass/site.scss`. This is the place where you should import all Sass files.

Bootstrap Sass components are imported at `/assets/sass/_settings.scss` - just uncommend component you need. Always use only component you really need to make your CSS smaller and your sites faster.

Bootstrap JS components are linked at the bottom of layout `/layouts/default.htm`. Please comment/delete lines you don't need.

At `/assets/sass/_settings.scss` you can find all Bootstrap configuration variables which can be changed. It's also great place for your own variables. It will override default Bootstrap variables, so it's means you always compile customized version of Bootstrap!

## Theme variables

Theme config file is placed at `/fields.yaml`. Just add your own variables and use it in the theme:

```
{{ this.theme.site_title }}
```

Variables can be changed at Backend > CMS > Themes > Customize.

## Add new font

- place your font to `/assets/fonts` directory
- create new Sass file at `/assets/sass/fonts`
- import this font Sass file to `/assets/sass/site.scss` like this:

```
@import "fonts/font-awesome";
```

## Updating

You can update theme dependencies by yourself, but it's not neccesary.

- update npm by `yarn update` or `npm update`
- update assets by `bower update`

## About

Bootstrap 3 Sass theme is made with [bootstrap-sass](https://github.com/twbs/bootstrap-sass) library, which is official Sass port of Bootstrap 3 framework by Twitter.
