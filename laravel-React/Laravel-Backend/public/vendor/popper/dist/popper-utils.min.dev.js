"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.computeAutoPlacement = A;
exports.findIndex = H;
exports.getBordersSize = o;
exports.getBoundaries = y;
exports.getBoundingClientRect = t;
exports.getClientRect = s;
exports.getOffsetParent = i;
exports.getOffsetRect = I;
exports.getOffsetRectRelativeToArbitraryNode = u;
exports.getOuterSizes = J;
exports.getParentNode = b;
exports.getPopperOffsets = L;
exports.getReferenceOffsets = M;
exports.getScroll = m;
exports.getScrollParent = c;
exports.getStyleComputedProperty = a;
exports.getSupportedPropertyName = N;
exports.getWindowSizes = q;
exports.isFixed = w;
exports.isFunction = O;
exports.isModifierEnabled = P;
exports.isModifierRequired = Q;
exports.isNumeric = R;
exports.removeEventListeners = T;
exports.runModifiers = U;
exports.setAttributes = V;
exports.setStyles = W;
exports.setupEventListeners = Y;
exports["default"] = exports.debounce = void 0;

/*
 Copyright (C) Federico Zivolo 2020
 Distributed under the MIT License (license terms are at http://opensource.org/licenses/MIT).
 */
function a(a, b) {
  if (1 !== a.nodeType) return [];
  var c = a.ownerDocument.defaultView,
      d = c.getComputedStyle(a, null);
  return b ? d[b] : d;
}

function b(a) {
  return 'HTML' === a.nodeName ? a : a.parentNode || a.host;
}

function c(d) {
  if (!d) return document.body;

  switch (d.nodeName) {
    case 'HTML':
    case 'BODY':
      return d.ownerDocument.body;

    case '#document':
      return d.body;
  }

  var _a = a(d),
      e = _a.overflow,
      f = _a.overflowX,
      g = _a.overflowY;

  return /(auto|scroll|overlay)/.test(e + g + f) ? d : c(b(d));
}

function d(a) {
  return a && a.referenceNode ? a.referenceNode : a;
}

var e = 'undefined' != typeof window && 'undefined' != typeof document && 'undefined' != typeof navigator;
var f = e && !!(window.MSInputMethodContext && document.documentMode),
    g = e && /MSIE 10/.test(navigator.userAgent);

function h(a) {
  return 11 === a ? f : 10 === a ? g : f || g;
}

function i(b) {
  if (!b) return document.documentElement;
  var c = h(10) ? document.body : null;
  var d = b.offsetParent || null;

  for (; d === c && b.nextElementSibling;) {
    d = (b = b.nextElementSibling).offsetParent;
  }

  var e = d && d.nodeName;
  return e && 'BODY' !== e && 'HTML' !== e ? -1 !== ['TH', 'TD', 'TABLE'].indexOf(d.nodeName) && 'static' === a(d, 'position') ? i(d) : d : b ? b.ownerDocument.documentElement : document.documentElement;
}

function j(a) {
  var b = a.nodeName;
  return 'BODY' !== b && ('HTML' === b || i(a.firstElementChild) === a);
}

function k(a) {
  return null === a.parentNode ? a : k(a.parentNode);
}

function l(a, b) {
  if (!a || !a.nodeType || !b || !b.nodeType) return document.documentElement;
  var c = a.compareDocumentPosition(b) & Node.DOCUMENT_POSITION_FOLLOWING,
      d = c ? a : b,
      e = c ? b : a,
      f = document.createRange();
  f.setStart(d, 0), f.setEnd(e, 0);
  var g = f.commonAncestorContainer;
  if (a !== g && b !== g || d.contains(e)) return j(g) ? g : i(g);
  var h = k(a);
  return h.host ? l(h.host, b) : l(a, k(b).host);
}

function m(a) {
  var b = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'top';
  var c = 'top' === b ? 'scrollTop' : 'scrollLeft',
      d = a.nodeName;

  if ('BODY' === d || 'HTML' === d) {
    var _b = a.ownerDocument.documentElement,
        _d = a.ownerDocument.scrollingElement || _b;

    return _d[c];
  }

  return a[c];
}

function n(a, b) {
  var c = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : !1;
  var d = m(b, 'top'),
      e = m(b, 'left'),
      f = c ? -1 : 1;
  return a.top += d * f, a.bottom += d * f, a.left += e * f, a.right += e * f, a;
}

function o(a, b) {
  var c = 'x' === b ? 'Left' : 'Top',
      d = 'Left' == c ? 'Right' : 'Bottom';
  return parseFloat(a["border".concat(c, "Width")]) + parseFloat(a["border".concat(d, "Width")]);
}

function p(a, b, c, d) {
  return Math.max(b["offset".concat(a)], b["scroll".concat(a)], c["client".concat(a)], c["offset".concat(a)], c["scroll".concat(a)], h(10) ? parseInt(c["offset".concat(a)]) + parseInt(d["margin".concat('Height' === a ? 'Top' : 'Left')]) + parseInt(d["margin".concat('Height' === a ? 'Bottom' : 'Right')]) : 0);
}

function q(a) {
  var b = a.body,
      c = a.documentElement,
      d = h(10) && getComputedStyle(c);
  return {
    height: p('Height', b, c, d),
    width: p('Width', b, c, d)
  };
}

var r = Object.assign || function (a) {
  for (var b, c = 1; c < arguments.length; c++) {
    for (var d in b = arguments[c], b) {
      Object.prototype.hasOwnProperty.call(b, d) && (a[d] = b[d]);
    }
  }

  return a;
};

function s(a) {
  return r({}, a, {
    right: a.left + a.width,
    bottom: a.top + a.height
  });
}

function t(b) {
  var c = {};

  try {
    if (h(10)) {
      c = b.getBoundingClientRect();

      var _a2 = m(b, 'top'),
          _d2 = m(b, 'left');

      c.top += _a2, c.left += _d2, c.bottom += _a2, c.right += _d2;
    } else c = b.getBoundingClientRect();
  } catch (a) {}

  var d = {
    left: c.left,
    top: c.top,
    width: c.right - c.left,
    height: c.bottom - c.top
  },
      e = 'HTML' === b.nodeName ? q(b.ownerDocument) : {},
      f = e.width || b.clientWidth || d.width,
      g = e.height || b.clientHeight || d.height;
  var i = b.offsetWidth - f,
      j = b.offsetHeight - g;

  if (i || j) {
    var _c = a(b);

    i -= o(_c, 'x'), j -= o(_c, 'y'), d.width -= i, d.height -= j;
  }

  return s(d);
}

function u(b, d) {
  var e = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : !1;
  var f = Math.max;
  var g = h(10),
      i = 'HTML' === d.nodeName,
      j = t(b),
      k = t(d),
      l = c(b),
      m = a(d),
      o = parseFloat(m.borderTopWidth),
      p = parseFloat(m.borderLeftWidth);
  e && i && (k.top = f(k.top, 0), k.left = f(k.left, 0));
  var q = s({
    top: j.top - k.top - o,
    left: j.left - k.left - p,
    width: j.width,
    height: j.height
  });

  if (q.marginTop = 0, q.marginLeft = 0, !g && i) {
    var _a3 = parseFloat(m.marginTop),
        _b2 = parseFloat(m.marginLeft);

    q.top -= o - _a3, q.bottom -= o - _a3, q.left -= p - _b2, q.right -= p - _b2, q.marginTop = _a3, q.marginLeft = _b2;
  }

  return (g && !e ? d.contains(l) : d === l && 'BODY' !== l.nodeName) && (q = n(q, d)), q;
}

function v(a) {
  var b = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : !1;
  var c = Math.max;
  var d = a.ownerDocument.documentElement,
      e = u(a, d),
      f = c(d.clientWidth, window.innerWidth || 0),
      g = c(d.clientHeight, window.innerHeight || 0),
      h = b ? 0 : m(d),
      i = b ? 0 : m(d, 'left'),
      j = {
    top: h - e.top + e.marginTop,
    left: i - e.left + e.marginLeft,
    width: f,
    height: g
  };
  return s(j);
}

function w(c) {
  var d = c.nodeName;
  if ('BODY' === d || 'HTML' === d) return !1;
  if ('fixed' === a(c, 'position')) return !0;
  var e = b(c);
  return !!e && w(e);
}

function x(b) {
  if (!b || !b.parentElement || h()) return document.documentElement;
  var c = b.parentElement;

  for (; c && 'none' === a(c, 'transform');) {
    c = c.parentElement;
  }

  return c || document.documentElement;
}

function y(a, e, f, g) {
  var h = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : !1;
  var i = {
    top: 0,
    left: 0
  };
  var j = h ? x(a) : l(a, d(e));
  if ('viewport' === g) i = v(j, h);else {
    var _d3;

    'scrollParent' === g ? (_d3 = c(b(e)), 'BODY' === _d3.nodeName && (_d3 = a.ownerDocument.documentElement)) : 'window' === g ? _d3 = a.ownerDocument.documentElement : _d3 = g;

    var _f = u(_d3, j, h);

    if ('HTML' === _d3.nodeName && !w(j)) {
      var _q = q(a.ownerDocument),
          _b3 = _q.height,
          _c2 = _q.width;

      i.top += _f.top - _f.marginTop, i.bottom = _b3 + _f.top, i.left += _f.left - _f.marginLeft, i.right = _c2 + _f.left;
    } else i = _f;
  }
  f = f || 0;
  var k = 'number' == typeof f;
  return i.left += k ? f : f.left || 0, i.top += k ? f : f.top || 0, i.right -= k ? f : f.right || 0, i.bottom -= k ? f : f.bottom || 0, i;
}

function z(_ref) {
  var a = _ref.width,
      b = _ref.height;
  return a * b;
}

function A(a, b, c, d, e) {
  var f = arguments.length > 5 && arguments[5] !== undefined ? arguments[5] : 0;
  if (-1 === a.indexOf('auto')) return a;
  var g = y(c, d, f, e),
      h = {
    top: {
      width: g.width,
      height: b.top - g.top
    },
    right: {
      width: g.right - b.right,
      height: g.height
    },
    bottom: {
      width: g.width,
      height: g.bottom - b.bottom
    },
    left: {
      width: b.left - g.left,
      height: g.height
    }
  },
      i = Object.keys(h).map(function (a) {
    return r({
      key: a
    }, h[a], {
      area: z(h[a])
    });
  }).sort(function (c, a) {
    return a.area - c.area;
  }),
      j = i.filter(function (_ref2) {
    var a = _ref2.width,
        b = _ref2.height;
    return a >= c.clientWidth && b >= c.clientHeight;
  }),
      k = 0 < j.length ? j[0].key : i[0].key,
      l = a.split('-')[1];
  return k + (l ? "-".concat(l) : '');
}

var B = function () {
  var a = ['Edge', 'Trident', 'Firefox'];

  for (var _b4 = 0; _b4 < a.length; _b4 += 1) {
    if (e && 0 <= navigator.userAgent.indexOf(a[_b4])) return 1;
  }

  return 0;
}();

function C(a) {
  var b = !1;
  return function () {
    b || (b = !0, window.Promise.resolve().then(function () {
      b = !1, a();
    }));
  };
}

function D(a) {
  var b = !1;
  return function () {
    b || (b = !0, setTimeout(function () {
      b = !1, a();
    }, B));
  };
}

var E = e && window.Promise;
var F = E ? C : D;
exports.debounce = F;

function G(a, b) {
  return Array.prototype.find ? a.find(b) : a.filter(b)[0];
}

function H(a, b, c) {
  if (Array.prototype.findIndex) return a.findIndex(function (a) {
    return a[b] === c;
  });
  var d = G(a, function (a) {
    return a[b] === c;
  });
  return a.indexOf(d);
}

function I(a) {
  var b;

  if ('HTML' === a.nodeName) {
    var _q2 = q(a.ownerDocument),
        _c3 = _q2.width,
        _d4 = _q2.height;

    b = {
      width: _c3,
      height: _d4,
      left: 0,
      top: 0
    };
  } else b = {
    width: a.offsetWidth,
    height: a.offsetHeight,
    left: a.offsetLeft,
    top: a.offsetTop
  };

  return s(b);
}

function J(a) {
  var b = a.ownerDocument.defaultView,
      c = b.getComputedStyle(a),
      d = parseFloat(c.marginTop || 0) + parseFloat(c.marginBottom || 0),
      e = parseFloat(c.marginLeft || 0) + parseFloat(c.marginRight || 0),
      f = {
    width: a.offsetWidth + e,
    height: a.offsetHeight + d
  };
  return f;
}

function K(a) {
  var b = {
    left: 'right',
    right: 'left',
    bottom: 'top',
    top: 'bottom'
  };
  return a.replace(/left|right|bottom|top/g, function (a) {
    return b[a];
  });
}

function L(a, b, c) {
  c = c.split('-')[0];
  var d = J(a),
      e = {
    width: d.width,
    height: d.height
  },
      f = -1 !== ['right', 'left'].indexOf(c),
      g = f ? 'top' : 'left',
      h = f ? 'left' : 'top',
      i = f ? 'height' : 'width',
      j = f ? 'width' : 'height';
  return e[g] = b[g] + b[i] / 2 - d[i] / 2, e[h] = c === h ? b[h] - d[j] : b[K(h)], e;
}

function M(a, b, c) {
  var e = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;
  var f = e ? x(b) : l(b, d(c));
  return u(c, f, e);
}

function N(a) {
  var b = [!1, 'ms', 'Webkit', 'Moz', 'O'],
      c = a.charAt(0).toUpperCase() + a.slice(1);

  for (var _d5 = 0; _d5 < b.length; _d5++) {
    var _e = b[_d5],
        _f2 = _e ? "".concat(_e).concat(c) : a;

    if ('undefined' != typeof document.body.style[_f2]) return _f2;
  }

  return null;
}

function O(a) {
  return a && '[object Function]' === {}.toString.call(a);
}

function P(a, b) {
  return a.some(function (_ref3) {
    var a = _ref3.name,
        c = _ref3.enabled;
    return c && a === b;
  });
}

function Q(a, b, c) {
  var d = G(a, function (_ref4) {
    var a = _ref4.name;
    return a === b;
  }),
      e = !!d && a.some(function (a) {
    return a.name === c && a.enabled && a.order < d.order;
  });

  if (!e) {
    var _a4 = "`".concat(b, "`"),
        _d6 = "`".concat(c, "`");

    console.warn("".concat(_d6, " modifier is required by ").concat(_a4, " modifier in order to work, be sure to include it before ").concat(_a4, "!"));
  }

  return e;
}

function R(a) {
  return '' !== a && !isNaN(parseFloat(a)) && isFinite(a);
}

function S(a) {
  var b = a.ownerDocument;
  return b ? b.defaultView : window;
}

function T(a, b) {
  return S(a).removeEventListener('resize', b.updateBound), b.scrollParents.forEach(function (a) {
    a.removeEventListener('scroll', b.updateBound);
  }), b.updateBound = null, b.scrollParents = [], b.scrollElement = null, b.eventsEnabled = !1, b;
}

function U(a, b, c) {
  var d = void 0 === c ? a : a.slice(0, H(a, 'name', c));
  return d.forEach(function (a) {
    a['function'] && console.warn('`modifier.function` is deprecated, use `modifier.fn`!');
    var c = a['function'] || a.fn;
    a.enabled && O(c) && (b.offsets.popper = s(b.offsets.popper), b.offsets.reference = s(b.offsets.reference), b = c(b, a));
  }), b;
}

function V(a, b) {
  Object.keys(b).forEach(function (c) {
    var d = b[c];
    !1 === d ? a.removeAttribute(c) : a.setAttribute(c, b[c]);
  });
}

function W(a, b) {
  Object.keys(b).forEach(function (c) {
    var d = '';
    -1 !== ['width', 'height', 'top', 'right', 'bottom', 'left'].indexOf(c) && R(b[c]) && (d = 'px'), a.style[c] = b[c] + d;
  });
}

function X(a, b, d, e) {
  var f = 'BODY' === a.nodeName,
      g = f ? a.ownerDocument.defaultView : a;
  g.addEventListener(b, d, {
    passive: !0
  }), f || X(c(g.parentNode), b, d, e), e.push(g);
}

function Y(a, b, d, e) {
  d.updateBound = e, S(a).addEventListener('resize', d.updateBound, {
    passive: !0
  });
  var f = c(a);
  return X(f, 'scroll', d.updateBound, d.scrollParents), d.scrollElement = f, d.eventsEnabled = !0, d;
}

var Z = {
  computeAutoPlacement: A,
  debounce: F,
  findIndex: H,
  getBordersSize: o,
  getBoundaries: y,
  getBoundingClientRect: t,
  getClientRect: s,
  getOffsetParent: i,
  getOffsetRect: I,
  getOffsetRectRelativeToArbitraryNode: u,
  getOuterSizes: J,
  getParentNode: b,
  getPopperOffsets: L,
  getReferenceOffsets: M,
  getScroll: m,
  getScrollParent: c,
  getStyleComputedProperty: a,
  getSupportedPropertyName: N,
  getWindowSizes: q,
  isFixed: w,
  isFunction: O,
  isModifierEnabled: P,
  isModifierRequired: Q,
  isNumeric: R,
  removeEventListeners: T,
  runModifiers: U,
  setAttributes: V,
  setStyles: W,
  setupEventListeners: Y
};
var _default = Z;
exports["default"] = _default;