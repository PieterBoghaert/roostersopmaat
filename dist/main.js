function z(s) {
  return s && s.__esModule && Object.prototype.hasOwnProperty.call(s, "default") ? s.default : s;
}
var m = { exports: {} };
var Y = m.exports, S;
function M() {
  return S || (S = 1, (function(s, g) {
    (function(h, u) {
      s.exports = u();
    })(Y, function() {
      function h() {
        return typeof window < "u";
      }
      function u() {
        var t = !1;
        try {
          var e = {
            // eslint-disable-next-line getter-return
            get passive() {
              t = !0;
            }
          };
          window.addEventListener("test", e, e), window.removeEventListener("test", e, e);
        } catch {
          t = !1;
        }
        return t;
      }
      function b() {
        return !!(h() && (function() {
        }).bind && "classList" in document.documentElement && Object.assign && Object.keys && requestAnimationFrame);
      }
      function n(t) {
        return t.nodeType === 9;
      }
      function l(t) {
        return t && t.document && n(t.document);
      }
      function d(t) {
        var e = t.document, i = e.body, c = e.documentElement;
        return {
          /**
           * @see http://james.padolsey.com/javascript/get-document-height-cross-browser/
           * @return {Number} the scroll height of the document in pixels
           */
          scrollHeight: function() {
            return Math.max(
              i.scrollHeight,
              c.scrollHeight,
              i.offsetHeight,
              c.offsetHeight,
              i.clientHeight,
              c.clientHeight
            );
          },
          /**
           * @see http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript
           * @return {Number} the height of the viewport in pixels
           */
          height: function() {
            return t.innerHeight || c.clientHeight || i.clientHeight;
          },
          /**
           * Gets the Y scroll position
           * @return {Number} pixels the page has scrolled along the Y-axis
           */
          scrollY: function() {
            return t.pageYOffset !== void 0 ? t.pageYOffset : (c || i.parentNode || i).scrollTop;
          }
        };
      }
      function C(t) {
        return {
          /**
           * @return {Number} the scroll height of the element in pixels
           */
          scrollHeight: function() {
            return Math.max(
              t.scrollHeight,
              t.offsetHeight,
              t.clientHeight
            );
          },
          /**
           * @return {Number} the height of the element in pixels
           */
          height: function() {
            return Math.max(t.offsetHeight, t.clientHeight);
          },
          /**
           * Gets the Y scroll position
           * @return {Number} pixels the element has scrolled along the Y-axis
           */
          scrollY: function() {
            return t.scrollTop;
          }
        };
      }
      function B(t) {
        return l(t) ? d(t) : C(t);
      }
      function x(t, e, i) {
        var c = u(), w, v = !1, f = B(t), p = f.scrollY(), o = {};
        function E() {
          var a = Math.round(f.scrollY()), O = f.height(), L = f.scrollHeight();
          o.scrollY = a, o.lastScrollY = p, o.direction = a > p ? "down" : "up", o.distance = Math.abs(a - p), o.isOutOfBounds = a < 0 || a + O > L, o.top = a <= e.offset[o.direction], o.bottom = a + O >= L, o.toleranceExceeded = o.distance > e.tolerance[o.direction], i(o), p = a, v = !1;
        }
        function y() {
          v || (v = !0, w = requestAnimationFrame(E));
        }
        var T = c ? { passive: !0, capture: !1 } : !1;
        return t.addEventListener("scroll", y, T), E(), {
          destroy: function() {
            cancelAnimationFrame(w), t.removeEventListener("scroll", y, T);
          }
        };
      }
      function H(t) {
        return t === Object(t) ? t : { down: t, up: t };
      }
      function r(t, e) {
        e = e || {}, Object.assign(this, r.options, e), this.classes = Object.assign({}, r.options.classes, e.classes), this.elem = t, this.tolerance = H(this.tolerance), this.offset = H(this.offset), this.initialised = !1, this.frozen = !1;
      }
      return r.prototype = {
        constructor: r,
        /**
         * Start listening to scrolling
         * @public
         */
        init: function() {
          return r.cutsTheMustard && !this.initialised && (this.addClass("initial"), this.initialised = !0, setTimeout(
            function(t) {
              t.scrollTracker = x(
                t.scroller,
                { offset: t.offset, tolerance: t.tolerance },
                t.update.bind(t)
              );
            },
            100,
            this
          )), this;
        },
        /**
         * Destroy the widget, clearing up after itself
         * @public
         */
        destroy: function() {
          this.initialised = !1, Object.keys(this.classes).forEach(this.removeClass, this), this.scrollTracker.destroy();
        },
        /**
         * Unpin the element
         * @public
         */
        unpin: function() {
          (this.hasClass("pinned") || !this.hasClass("unpinned")) && (this.addClass("unpinned"), this.removeClass("pinned"), this.onUnpin && this.onUnpin.call(this));
        },
        /**
         * Pin the element
         * @public
         */
        pin: function() {
          this.hasClass("unpinned") && (this.addClass("pinned"), this.removeClass("unpinned"), this.onPin && this.onPin.call(this));
        },
        /**
         * Freezes the current state of the widget
         * @public
         */
        freeze: function() {
          this.frozen = !0, this.addClass("frozen");
        },
        /**
         * Re-enables the default behaviour of the widget
         * @public
         */
        unfreeze: function() {
          this.frozen = !1, this.removeClass("frozen");
        },
        top: function() {
          this.hasClass("top") || (this.addClass("top"), this.removeClass("notTop"), this.onTop && this.onTop.call(this));
        },
        notTop: function() {
          this.hasClass("notTop") || (this.addClass("notTop"), this.removeClass("top"), this.onNotTop && this.onNotTop.call(this));
        },
        bottom: function() {
          this.hasClass("bottom") || (this.addClass("bottom"), this.removeClass("notBottom"), this.onBottom && this.onBottom.call(this));
        },
        notBottom: function() {
          this.hasClass("notBottom") || (this.addClass("notBottom"), this.removeClass("bottom"), this.onNotBottom && this.onNotBottom.call(this));
        },
        shouldUnpin: function(t) {
          var e = t.direction === "down";
          return e && !t.top && t.toleranceExceeded;
        },
        shouldPin: function(t) {
          var e = t.direction === "up";
          return e && t.toleranceExceeded || t.top;
        },
        addClass: function(t) {
          this.elem.classList.add.apply(
            this.elem.classList,
            this.classes[t].split(" ")
          );
        },
        removeClass: function(t) {
          this.elem.classList.remove.apply(
            this.elem.classList,
            this.classes[t].split(" ")
          );
        },
        hasClass: function(t) {
          return this.classes[t].split(" ").every(function(e) {
            return this.classList.contains(e);
          }, this.elem);
        },
        update: function(t) {
          t.isOutOfBounds || this.frozen !== !0 && (t.top ? this.top() : this.notTop(), t.bottom ? this.bottom() : this.notBottom(), this.shouldUnpin(t) ? this.unpin() : this.shouldPin(t) && this.pin());
        }
      }, r.options = {
        tolerance: {
          up: 0,
          down: 0
        },
        offset: 0,
        scroller: h() ? window : null,
        classes: {
          frozen: "headroom--frozen",
          pinned: "headroom--pinned",
          unpinned: "headroom--unpinned",
          top: "headroom--top",
          notTop: "headroom--not-top",
          bottom: "headroom--bottom",
          notBottom: "headroom--not-bottom",
          initial: "headroom"
        }
      }, r.cutsTheMustard = b(), r;
    });
  })(m)), m.exports;
}
var k = M();
const q = /* @__PURE__ */ z(k);
document.addEventListener("DOMContentLoaded", () => {
  if (!CSS.supports("container-type", "scroll-state")) {
    var s = document.querySelector(".site-header"), g = new q(s);
    g.init();
  }
  const h = document.querySelectorAll(
    ".info-block, .process-grid .card"
  ), u = new IntersectionObserver(
    (n, l) => {
      n.forEach((d, C) => {
        d.isIntersecting && (d.target.classList.add("in-view"), l.unobserve(d.target));
      });
    },
    { threshold: 0.15 }
  );
  h.forEach((n) => u.observe(n)), document.querySelectorAll(".email-protected").forEach((n) => {
    const l = n.parentElement.getAttribute("href")?.replace("mailto:", "");
    l && (n.parentElement.setAttribute("href", "mailto:" + atob(l)), n.textContent = atob(l));
  });
});
