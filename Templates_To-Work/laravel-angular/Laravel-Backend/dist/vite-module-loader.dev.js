"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _promises = _interopRequireDefault(require("fs/promises"));

var _path = _interopRequireDefault(require("path"));

var _url = require("url");

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

function _getRequireWildcardCache() { if (typeof WeakMap !== "function") return null; var cache = new WeakMap(); _getRequireWildcardCache = function _getRequireWildcardCache() { return cache; }; return cache; }

function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } if (obj === null || _typeof(obj) !== "object" && typeof obj !== "function") { return { "default": obj }; } var cache = _getRequireWildcardCache(); if (cache && cache.has(obj)) { return cache.get(obj); } var newObj = {}; var hasPropertyDescriptor = Object.defineProperty && Object.getOwnPropertyDescriptor; for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) { var desc = hasPropertyDescriptor ? Object.getOwnPropertyDescriptor(obj, key) : null; if (desc && (desc.get || desc.set)) { Object.defineProperty(newObj, key, desc); } else { newObj[key] = obj[key]; } } } newObj["default"] = obj; if (cache) { cache.set(obj, newObj); } return newObj; }

function collectModuleAssetsPaths(paths, modulesPath) {
  var moduleStatusesPath, moduleStatusesContent, moduleStatuses, moduleDirectories, _iteratorNormalCompletion, _didIteratorError, _iteratorError, _iterator, _step, moduleDir, viteConfigPath, moduleConfigURL, moduleConfig;

  return regeneratorRuntime.async(function collectModuleAssetsPaths$(_context) {
    while (1) {
      switch (_context.prev = _context.next) {
        case 0:
          modulesPath = _path["default"].join(__dirname, modulesPath);
          moduleStatusesPath = _path["default"].join(__dirname, 'modules_statuses.json');
          _context.prev = 2;
          _context.next = 5;
          return regeneratorRuntime.awrap(_promises["default"].readFile(moduleStatusesPath, 'utf-8'));

        case 5:
          moduleStatusesContent = _context.sent;
          moduleStatuses = JSON.parse(moduleStatusesContent); // Read module directories

          _context.next = 9;
          return regeneratorRuntime.awrap(_promises["default"].readdir(modulesPath));

        case 9:
          moduleDirectories = _context.sent;
          _iteratorNormalCompletion = true;
          _didIteratorError = false;
          _iteratorError = undefined;
          _context.prev = 13;
          _iterator = moduleDirectories[Symbol.iterator]();

        case 15:
          if (_iteratorNormalCompletion = (_step = _iterator.next()).done) {
            _context.next = 36;
            break;
          }

          moduleDir = _step.value;

          if (!(moduleDir === '.DS_Store')) {
            _context.next = 19;
            break;
          }

          return _context.abrupt("continue", 33);

        case 19:
          if (!(moduleStatuses[moduleDir] === true)) {
            _context.next = 33;
            break;
          }

          viteConfigPath = _path["default"].join(modulesPath, moduleDir, 'vite.config.js');
          _context.prev = 21;
          _context.next = 24;
          return regeneratorRuntime.awrap(_promises["default"].access(viteConfigPath));

        case 24:
          // Convert to a file URL for Windows compatibility
          moduleConfigURL = (0, _url.pathToFileURL)(viteConfigPath); // Import the module-specific Vite configuration

          _context.next = 27;
          return regeneratorRuntime.awrap(Promise.resolve().then(function () {
            return _interopRequireWildcard(require("".concat(moduleConfigURL.href)));
          }));

        case 27:
          moduleConfig = _context.sent;

          if (moduleConfig.paths && Array.isArray(moduleConfig.paths)) {
            paths.push.apply(paths, _toConsumableArray(moduleConfig.paths));
          }

          _context.next = 33;
          break;

        case 31:
          _context.prev = 31;
          _context.t0 = _context["catch"](21);

        case 33:
          _iteratorNormalCompletion = true;
          _context.next = 15;
          break;

        case 36:
          _context.next = 42;
          break;

        case 38:
          _context.prev = 38;
          _context.t1 = _context["catch"](13);
          _didIteratorError = true;
          _iteratorError = _context.t1;

        case 42:
          _context.prev = 42;
          _context.prev = 43;

          if (!_iteratorNormalCompletion && _iterator["return"] != null) {
            _iterator["return"]();
          }

        case 45:
          _context.prev = 45;

          if (!_didIteratorError) {
            _context.next = 48;
            break;
          }

          throw _iteratorError;

        case 48:
          return _context.finish(45);

        case 49:
          return _context.finish(42);

        case 50:
          _context.next = 55;
          break;

        case 52:
          _context.prev = 52;
          _context.t2 = _context["catch"](2);
          console.error("Error reading module statuses or module configurations: ".concat(_context.t2));

        case 55:
          return _context.abrupt("return", paths);

        case 56:
        case "end":
          return _context.stop();
      }
    }
  }, null, null, [[2, 52], [13, 38, 42, 50], [21, 31], [43,, 45, 49]]);
}

var _default = collectModuleAssetsPaths;
exports["default"] = _default;