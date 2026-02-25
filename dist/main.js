const style = "";
var commonjsGlobal = typeof globalThis !== "undefined" ? globalThis : typeof window !== "undefined" ? window : typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : {};
function getDefaultExportFromCjs(x) {
  return x && x.__esModule && Object.prototype.hasOwnProperty.call(x, "default") ? x["default"] : x;
}
var headroom = { exports: {} };
/*!
 * headroom.js v0.12.0 - Give your page some headroom. Hide your header until you need it
 * Copyright (c) 2020 Nick Williams - http://wicky.nillia.ms/headroom.js
 * License: MIT
 */
(function(module, exports) {
  (function(global2, factory) {
    module.exports = factory();
  })(commonjsGlobal, function() {
    function isBrowser() {
      return typeof window !== "undefined";
    }
    function passiveEventsSupported() {
      var supported = false;
      try {
        var options = {
          // eslint-disable-next-line getter-return
          get passive() {
            supported = true;
          }
        };
        window.addEventListener("test", options, options);
        window.removeEventListener("test", options, options);
      } catch (err) {
        supported = false;
      }
      return supported;
    }
    function isSupported() {
      return !!(isBrowser() && (function() {
      }).bind && "classList" in document.documentElement && Object.assign && Object.keys && requestAnimationFrame);
    }
    function isDocument(obj) {
      return obj.nodeType === 9;
    }
    function isWindow(obj) {
      return obj && obj.document && isDocument(obj.document);
    }
    function windowScroller(win) {
      var doc = win.document;
      var body = doc.body;
      var html = doc.documentElement;
      return {
        /**
         * @see http://james.padolsey.com/javascript/get-document-height-cross-browser/
         * @return {Number} the scroll height of the document in pixels
         */
        scrollHeight: function() {
          return Math.max(
            body.scrollHeight,
            html.scrollHeight,
            body.offsetHeight,
            html.offsetHeight,
            body.clientHeight,
            html.clientHeight
          );
        },
        /**
         * @see http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript
         * @return {Number} the height of the viewport in pixels
         */
        height: function() {
          return win.innerHeight || html.clientHeight || body.clientHeight;
        },
        /**
         * Gets the Y scroll position
         * @return {Number} pixels the page has scrolled along the Y-axis
         */
        scrollY: function() {
          if (win.pageYOffset !== void 0) {
            return win.pageYOffset;
          }
          return (html || body.parentNode || body).scrollTop;
        }
      };
    }
    function elementScroller(element) {
      return {
        /**
         * @return {Number} the scroll height of the element in pixels
         */
        scrollHeight: function() {
          return Math.max(
            element.scrollHeight,
            element.offsetHeight,
            element.clientHeight
          );
        },
        /**
         * @return {Number} the height of the element in pixels
         */
        height: function() {
          return Math.max(element.offsetHeight, element.clientHeight);
        },
        /**
         * Gets the Y scroll position
         * @return {Number} pixels the element has scrolled along the Y-axis
         */
        scrollY: function() {
          return element.scrollTop;
        }
      };
    }
    function createScroller(element) {
      return isWindow(element) ? windowScroller(element) : elementScroller(element);
    }
    function trackScroll(element, options, callback) {
      var isPassiveSupported = passiveEventsSupported();
      var rafId;
      var scrolled = false;
      var scroller = createScroller(element);
      var lastScrollY = scroller.scrollY();
      var details = {};
      function update() {
        var scrollY = Math.round(scroller.scrollY());
        var height = scroller.height();
        var scrollHeight = scroller.scrollHeight();
        details.scrollY = scrollY;
        details.lastScrollY = lastScrollY;
        details.direction = scrollY > lastScrollY ? "down" : "up";
        details.distance = Math.abs(scrollY - lastScrollY);
        details.isOutOfBounds = scrollY < 0 || scrollY + height > scrollHeight;
        details.top = scrollY <= options.offset[details.direction];
        details.bottom = scrollY + height >= scrollHeight;
        details.toleranceExceeded = details.distance > options.tolerance[details.direction];
        callback(details);
        lastScrollY = scrollY;
        scrolled = false;
      }
      function handleScroll() {
        if (!scrolled) {
          scrolled = true;
          rafId = requestAnimationFrame(update);
        }
      }
      var eventOptions = isPassiveSupported ? { passive: true, capture: false } : false;
      element.addEventListener("scroll", handleScroll, eventOptions);
      update();
      return {
        destroy: function() {
          cancelAnimationFrame(rafId);
          element.removeEventListener("scroll", handleScroll, eventOptions);
        }
      };
    }
    function normalizeUpDown(t) {
      return t === Object(t) ? t : { down: t, up: t };
    }
    function Headroom2(elem, options) {
      options = options || {};
      Object.assign(this, Headroom2.options, options);
      this.classes = Object.assign({}, Headroom2.options.classes, options.classes);
      this.elem = elem;
      this.tolerance = normalizeUpDown(this.tolerance);
      this.offset = normalizeUpDown(this.offset);
      this.initialised = false;
      this.frozen = false;
    }
    Headroom2.prototype = {
      constructor: Headroom2,
      /**
       * Start listening to scrolling
       * @public
       */
      init: function() {
        if (Headroom2.cutsTheMustard && !this.initialised) {
          this.addClass("initial");
          this.initialised = true;
          setTimeout(
            function(self2) {
              self2.scrollTracker = trackScroll(
                self2.scroller,
                { offset: self2.offset, tolerance: self2.tolerance },
                self2.update.bind(self2)
              );
            },
            100,
            this
          );
        }
        return this;
      },
      /**
       * Destroy the widget, clearing up after itself
       * @public
       */
      destroy: function() {
        this.initialised = false;
        Object.keys(this.classes).forEach(this.removeClass, this);
        this.scrollTracker.destroy();
      },
      /**
       * Unpin the element
       * @public
       */
      unpin: function() {
        if (this.hasClass("pinned") || !this.hasClass("unpinned")) {
          this.addClass("unpinned");
          this.removeClass("pinned");
          if (this.onUnpin) {
            this.onUnpin.call(this);
          }
        }
      },
      /**
       * Pin the element
       * @public
       */
      pin: function() {
        if (this.hasClass("unpinned")) {
          this.addClass("pinned");
          this.removeClass("unpinned");
          if (this.onPin) {
            this.onPin.call(this);
          }
        }
      },
      /**
       * Freezes the current state of the widget
       * @public
       */
      freeze: function() {
        this.frozen = true;
        this.addClass("frozen");
      },
      /**
       * Re-enables the default behaviour of the widget
       * @public
       */
      unfreeze: function() {
        this.frozen = false;
        this.removeClass("frozen");
      },
      top: function() {
        if (!this.hasClass("top")) {
          this.addClass("top");
          this.removeClass("notTop");
          if (this.onTop) {
            this.onTop.call(this);
          }
        }
      },
      notTop: function() {
        if (!this.hasClass("notTop")) {
          this.addClass("notTop");
          this.removeClass("top");
          if (this.onNotTop) {
            this.onNotTop.call(this);
          }
        }
      },
      bottom: function() {
        if (!this.hasClass("bottom")) {
          this.addClass("bottom");
          this.removeClass("notBottom");
          if (this.onBottom) {
            this.onBottom.call(this);
          }
        }
      },
      notBottom: function() {
        if (!this.hasClass("notBottom")) {
          this.addClass("notBottom");
          this.removeClass("bottom");
          if (this.onNotBottom) {
            this.onNotBottom.call(this);
          }
        }
      },
      shouldUnpin: function(details) {
        var scrollingDown = details.direction === "down";
        return scrollingDown && !details.top && details.toleranceExceeded;
      },
      shouldPin: function(details) {
        var scrollingUp = details.direction === "up";
        return scrollingUp && details.toleranceExceeded || details.top;
      },
      addClass: function(className) {
        this.elem.classList.add.apply(
          this.elem.classList,
          this.classes[className].split(" ")
        );
      },
      removeClass: function(className) {
        this.elem.classList.remove.apply(
          this.elem.classList,
          this.classes[className].split(" ")
        );
      },
      hasClass: function(className) {
        return this.classes[className].split(" ").every(function(cls) {
          return this.classList.contains(cls);
        }, this.elem);
      },
      update: function(details) {
        if (details.isOutOfBounds) {
          return;
        }
        if (this.frozen === true) {
          return;
        }
        if (details.top) {
          this.top();
        } else {
          this.notTop();
        }
        if (details.bottom) {
          this.bottom();
        } else {
          this.notBottom();
        }
        if (this.shouldUnpin(details)) {
          this.unpin();
        } else if (this.shouldPin(details)) {
          this.pin();
        }
      }
    };
    Headroom2.options = {
      tolerance: {
        up: 0,
        down: 0
      },
      offset: 0,
      scroller: isBrowser() ? window : null,
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
    };
    Headroom2.cutsTheMustard = isSupported();
    return Headroom2;
  });
})(headroom);
var headroomExports = headroom.exports;
const Headroom = /* @__PURE__ */ getDefaultExportFromCjs(headroomExports);
document.addEventListener("DOMContentLoaded", () => {
  var headerEl = document.querySelector(".site-header");
  var headroom2 = new Headroom(headerEl);
  headroom2.init();
  const animatedBlocks = document.querySelectorAll(
    ".info-block, .process-grid .card"
  );
  const observer = new IntersectionObserver(
    (entries, obs) => {
      entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("in-view");
          obs.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.15 }
  );
  animatedBlocks.forEach((block) => observer.observe(block));
  const emailLinks = document.querySelectorAll(".email-protected");
  emailLinks.forEach((link) => {
    var _a;
    const email = (_a = link.parentElement.getAttribute("href")) == null ? void 0 : _a.replace("mailto:", "");
    if (!email)
      return;
    link.parentElement.setAttribute("href", "mailto:" + atob(email));
    link.textContent = atob(email);
  });
});
