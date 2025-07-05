"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _defaultTheme = _interopRequireDefault(require("tailwindcss/defaultTheme"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

/** @type {import('tailwindcss').Config} */
var _default = {
  content: ['./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php', './storage/framework/views/*.php', './resources/**/*.blade.php', './resources/**/*.js', './resources/**/*.vue'],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree'].concat(_toConsumableArray(_defaultTheme["default"].fontFamily.sans))
      }
    }
  },
  plugins: []
};
exports["default"] = _default;