"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _vite = require("vite");

var _laravelVitePlugin = _interopRequireDefault(require("laravel-vite-plugin"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

var _default = (0, _vite.defineConfig)({
  plugins: [(0, _laravelVitePlugin["default"])({
    input: ['resources/sass/app.scss', 'resources/js/app.js'],
    refresh: true
  })]
});

exports["default"] = _default;