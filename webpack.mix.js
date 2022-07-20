const mix = require("laravel-mix");

mix
  .setPublicPath("public/static")
  .setResourceRoot("resources");

mix
  .ts("resources/assets/ts/app.ts", "js")
  .sass("resources/assets/scss/style.scss", "css");

// mix.extract();
