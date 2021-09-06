/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./.dev/assets/shared/js/frontend/frontend.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./.dev/assets/shared/js/frontend/components/primary-menu.js":
/*!*******************************************************************!*\
  !*** ./.dev/assets/shared/js/frontend/components/primary-menu.js ***!
  \*******************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _vendor_responsive_nav__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../vendor/responsive-nav */ "./.dev/assets/shared/js/frontend/vendor/responsive-nav.js");
/* harmony import */ var _vendor_responsive_nav__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_vendor_responsive_nav__WEBPACK_IMPORTED_MODULE_0__);
/* global TenUp */

/**
 * Hook up navigation.
 */

var init = function init() {
  if (TenUp) {
    TenUp.navigation({
      target: '#header__navigation',
      toggle: '#nav-toggle',
      // eslint-disable-next-line
      sub_menu_open: 'click'
    });
  }

  document.addEventListener('keydown', lockMenuFocus);
};
/**
 * Lock tabbing to the main navigation only.
 */


function lockMenuFocus(evt) {
  var e = event || evt; // for cross-browser compatibility

  var charCode = e.which || e.keyCode;

  if (charCode !== 9 || !jQuery('body').hasClass('menu-is-open')) {
    return;
  }

  var $element = jQuery(':focus'),
      mainMenuLength = jQuery('ul.primary-menu').children().length,
      currentIndex = jQuery($element).closest('li').index(),
      isShiftTab = event.shiftKey && event.keyCode == 9;

  if ($element.closest('ul').hasClass('sub-menu')) {
    return;
  }

  currentIndex = isShiftTab ? currentIndex - 1 : currentIndex + 1;

  if ($element.attr('id') === 'nav-toggle') {
    if (isShiftTab) {
      return;
    }

    setTimeout(function () {
      jQuery('ul.primary-menu li:first-child a')[0].focus();
    }, 10);
  } // Menu link


  if ($element.parents('ul.primary-menu').length > 0) {
    if (currentIndex < 0 && isShiftTab || currentIndex === mainMenuLength) {
      setTimeout(function () {
        jQuery('#nav-toggle').focus();
      }, 10);
    }
  }
}

;
/* harmony default export */ __webpack_exports__["default"] = (init);

/***/ }),

/***/ "./.dev/assets/shared/js/frontend/components/search-toggle.js":
/*!********************************************************************!*\
  !*** ./.dev/assets/shared/js/frontend/components/search-toggle.js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
var searchToggle = function searchToggle() {
  var searchToggle = document.getElementById('header__search-toggle');

  if (!searchToggle) {
    return;
  }

  var performToggle = function performToggle(element) {
    var toggle = element;
    var target = document.querySelector(toggle.dataset.toggleTarget);

    if (target.classList.contains('show-modal')) {
      // Hide the modal.
      target.classList.remove('active');
      setTimeout(function () {
        target.classList.remove('show-modal');
        toggle.focus();
      }, 250);
    } else {
      // Show the modal.
      target.classList.add('show-modal');
      setTimeout(function () {
        target.classList.add('active');

        if (toggle.dataset.setFocus) {
          var focusElement = document.querySelector(toggle.dataset.setFocus);

          if (focusElement) {
            var searchTerm = focusElement.value;
            focusElement.value = '';
            focusElement.focus();
            focusElement.value = searchTerm;
          }
        }
      }, 10);
    }
  };

  document.querySelectorAll('*[data-toggle-target]').forEach(function (element) {
    element.addEventListener('click', function (event) {
      event.preventDefault();
      performToggle(element);
    });
  }); // Close modal on escape key press.

  document.addEventListener('keyup', function (event) {
    if (event.keyCode === 27) {
      event.preventDefault();
      document.querySelectorAll('.search-modal.active').forEach(function (element) {
        performToggle(document.querySelector('*[data-toggle-target="' + element.dataset.modalTargetString + '"]'));
      });
    }
  }); // Close modal on outside click.

  document.addEventListener('click', function (event) {
    var target = event.target;
    var modal = document.querySelector('.search-modal.active');

    if (target === modal) {
      performToggle(document.querySelector('*[data-toggle-target="' + modal.dataset.modalTargetString + '"]'));
    }
  });
  document.addEventListener('keydown', lockSearchFocus);
};
/**
 * Lock tabbing to the search form only.
 */


function lockSearchFocus(evt) {
  var e = event || evt; // for cross-browser compatibility

  var charCode = e.which || e.keyCode;

  if (charCode !== 9 || !jQuery('div.search-modal').hasClass('active')) {
    return;
  }

  var $element = jQuery(':focus'),
      isShiftTab = event.shiftKey && event.keyCode == 9;

  if ($element.hasClass('search-form__input') && isShiftTab) {
    setTimeout(function () {
      jQuery('.search-input__button').focus();
    }, 10);
  }

  if ($element.hasClass('search-input__button') && !isShiftTab) {
    setTimeout(function () {
      jQuery('input.search-form__input').focus();
    }, 10);
  }
}

;
/* harmony default export */ __webpack_exports__["default"] = (searchToggle);

/***/ }),

/***/ "./.dev/assets/shared/js/frontend/components/woo-menu-cart.js":
/*!********************************************************************!*\
  !*** ./.dev/assets/shared/js/frontend/components/woo-menu-cart.js ***!
  \********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
var menuObject = document.getElementById('header__cart-toggle');
var siteOverlay = document.getElementById('site-overlay');
var sideNav = document.getElementById('site-nav--cart');
var sideNavClose = document.getElementById('site-close-handle');

var wooMenuCart = function wooMenuCart() {
  if (null === menuObject || null === siteOverlay || null === sideNavClose) {
    return;
  }

  document.body.classList.add('has-woo-cart-slideout');
  menuObject.addEventListener('click', function (event) {
    event.preventDefault();
    toggleSideNavVisibility();
  });
  siteOverlay.addEventListener('click', toggleSideNavVisibility);
  sideNavClose.addEventListener('click', toggleSideNavVisibility);
};

var toggleSideNavVisibility = function toggleSideNavVisibility(event) {
  sideNav.classList.toggle('active');
  siteOverlay.classList.toggle('active');
  document.body.classList.toggle('sidebar-move');
};

/* harmony default export */ __webpack_exports__["default"] = (wooMenuCart);

/***/ }),

/***/ "./.dev/assets/shared/js/frontend/frontend.js":
/*!****************************************************!*\
  !*** ./.dev/assets/shared/js/frontend/frontend.js ***!
  \****************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var css_vars_ponyfill__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! css-vars-ponyfill */ "./node_modules/css-vars-ponyfill/dist/css-vars-ponyfill.esm.js");
/* harmony import */ var _components_primary_menu_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./components/primary-menu.js */ "./.dev/assets/shared/js/frontend/components/primary-menu.js");
/* harmony import */ var _components_search_toggle_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/search-toggle.js */ "./.dev/assets/shared/js/frontend/components/search-toggle.js");
/* harmony import */ var _components_woo_menu_cart_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/woo-menu-cart.js */ "./.dev/assets/shared/js/frontend/components/woo-menu-cart.js");
/* harmony import */ var lodash_debounce__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! lodash/debounce */ "./node_modules/lodash/debounce.js");
/* harmony import */ var lodash_debounce__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(lodash_debounce__WEBPACK_IMPORTED_MODULE_4__);




 // we need an alias for debounce otherwise it conflicts with customizer

Object(_components_primary_menu_js__WEBPACK_IMPORTED_MODULE_1__["default"])();
Object(_components_search_toggle_js__WEBPACK_IMPORTED_MODULE_2__["default"])();
Object(_components_woo_menu_cart_js__WEBPACK_IMPORTED_MODULE_3__["default"])();
Object(css_vars_ponyfill__WEBPACK_IMPORTED_MODULE_0__["default"])();
document.addEventListener('DOMContentLoaded', function () {
  var hasSelectiveRefresh = 'undefined' !== typeof wp && wp.customize && wp.customize.selectiveRefresh && wp.customize.navMenusPreview.NavMenuInstancePartial; // partial-content-rendered might render multiple times for some reason, let's make sure to debouce this.

  var init = lodash_debounce__WEBPACK_IMPORTED_MODULE_4___default()(function () {
    // we need to remove this before calling primary menu again.
    document.body.classList.remove('has-offscreen-nav');
    Object(_components_primary_menu_js__WEBPACK_IMPORTED_MODULE_1__["default"])();
    Object(_components_search_toggle_js__WEBPACK_IMPORTED_MODULE_2__["default"])();
  }, 1000);

  if (hasSelectiveRefresh) {
    wp.customize.selectiveRefresh.bind('partial-content-rendered', function (placement) {
      var changedHeaderVariation = placement && 'null' !== placement.container[0].parentNode && 'header_variation' === placement.partial.id;

      if (changedHeaderVariation) {
        init();
      }
    });
  }
});

/***/ }),

/***/ "./.dev/assets/shared/js/frontend/vendor/responsive-nav.js":
/*!*****************************************************************!*\
  !*** ./.dev/assets/shared/js/frontend/vendor/responsive-nav.js ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/********************************

	Name: WordPress Accessible Responsive Navigation Menu
	Usage:

	TenUp.build_menu({

		'target'		:	'#primary-nav',      // the selector of the nav menu <ul>
		'toggle'		:	'#js-menu-toggle',   // the ID of the link you're using to open/close the small screen menu
		'sub_menu_open'	:	'hover'              // "click" is the other option

	}, function() {

		console.log('Amazing callback function!');

	});

********************************/

/* eslint-disable */
(function () {
  'use strict'; // Define global TenUp object if it doesn't exist

  if ('object' !== _typeof(window.TenUp)) {
    window.TenUp = {};
  }
  /*
  	Cache and define some variables
  */
  // init function


  TenUp.navigation = function (options, callback) {
    var defaults = {
      'target': '#primary-nav',
      'toggle': '#js-menu-toggle',
      'sub_menu_open': 'hover'
    };
    var opt; // Map all default settings to user defined options if they exist

    for (opt = 0; opt < defaults.length; opt = opt + 1) {
      if (typeof options[opt] === 'undefined') {
        options[opt] = defaults[opt];
      }
    }

    var menu = document.querySelector(options.target); // Bail out if there's no menu

    if (!menu) {
      return;
    }

    var menu_id = menu.getAttribute('id');
    var menu_toggle = document.querySelector(options.toggle);
    var aria_controls = menu_toggle.getAttribute('aria-controls');
    var sub_menu_acion = options.sub_menu_open;
    var current_menu_item = menu.querySelector('.current-menu-item');
    var menu_items_with_children = menu.querySelectorAll('.menu-item-has-children');
    var menu_items_with_children_count = menu_items_with_children.length;
    var currentTarget;
    var target;
    var i; // Listener for the menu open/close action

    function listener_menu(e) {
      // Stop links from firing
      e.preventDefault();

      if (document.body.classList.contains('menu-is-open')) {
        // Close the menu
        menu.setAttribute('aria-hidden', 'true');
        menu_toggle.setAttribute('aria-expanded', 'false'); // Bubble to the document

        document.body.classList.remove('menu-is-open');
      } else {
        // Open the menu
        menu.setAttribute('aria-hidden', 'false');
        menu_toggle.setAttribute('aria-expanded', 'true'); // Set focus to the first link

        menu.querySelectorAll('a')[0].focus(); // Bubble to the document

        document.body.classList.add('menu-is-open');
      }
    }

    ; // listener_menu()
    // Listener for submenu on click

    function listener_submenu_click(e) {
      currentTarget = e.currentTarget;
      target = e.target;

      if (target.tagName === 'svg' || target.tagName === 'path') {
        target = currentTarget.closest('.menu-item > a');
      }

      if (target.getAttribute('aria-haspopup')) {
        // Stop links from firing
        e.preventDefault(); // Stop events from bubbling up to parent elements

        e.stopPropagation();
        var parent_menu = target.parentNode;
        var sub_menu = parent_menu.querySelector('.sub-menu');
        var all_open_menus = menu.querySelectorAll('.child-has-focus');
        var all_open_menus_count = all_open_menus.length;
        var all_open_menu_triggers = menu.querySelectorAll('.child-has-focus > a.submenu-is-open');
        var all_open_menu_triggers_count = all_open_menu_triggers.length;
        var t;

        if (get_screen_size('has-full-nav')) {
          if (all_open_menu_triggers_count > 0) {
            // Make sure only 1 menu item can be opened at a time
            for (t = 0; t < all_open_menu_triggers_count; t = t + 1) {
              // Check if the open menu is top-level, if so, close it
              if (parent_menu.parentNode === menu) {
                menu_sub_close(all_open_menu_triggers[t]);
              }
            } // for

          } // if

        } // if


        if ((e.target.nodeName === 'A' || target.tagName === 'A') && target.classList.contains('submenu-is-open')) {
          // The menu is already open, so this should be a close action
          menu_sub_close(target);
        } else {
          menu_sub_close_all(); // The menu is closed, so this click should open it

          menu_sub_open(target); // Reset the focus

          sub_menu.querySelectorAll('a')[0].focus();
        }
      }
    }

    ; // listener_submenu_click()
    // When "hover", this is how focus should act

    function listener_submenu_focus(e) {
      var currentTarget = e.currentTarget;
      var target = e.target;
      var parent_menu = target.parentNode;
      var sub_menu = parent_menu.querySelector('.sub-menu');
      var all_open_menu_triggers = menu.querySelectorAll('.child-has-focus > a.submenu-is-open');
      var all_open_menu_triggers_count = all_open_menu_triggers.length;
      var t;

      if (get_screen_size('has-full-nav')) {
        if (all_open_menu_triggers_count > 0) {
          // Make sure only 1 menu item can be opened at a time
          for (t = 0; t < all_open_menu_triggers_count; t = t + 1) {
            // Check if the open menu is top-level, if so, close it
            if (parent_menu.parentNode === menu) {
              menu_sub_close(all_open_menu_triggers[t]);
            }
          }
        }
      }

      menu_sub_open(target);
    }

    ; // Listener for the window resize

    var listener_window = debounce(function (e) {
      if (get_screen_size('has-offscreen-nav')) {
        menu_create();
      } else {
        menu_destroy();
      }
    }, 100); // listener_window()
    // Close the menu if you click somewhere else

    function listener_close_open_menus(e) {
      var open_menus = menu.querySelectorAll('.submenu-is-open');
      var open_menus_count = open_menus.length;
      var opn; // if the event is keyup and it was the ESC key

      if (e.type === 'keyup' && e.keyCode == 27) {
        // We were getting some errors, so let's add in a checkpoint
        if (open_menus_count) {
          // Loop through all the open menus and close them
          for (opn = 0; opn < open_menus.length; opn = opn + 1) {
            menu_sub_close(open_menus[opn]);
          } // for
          // Return focus to the first open menu


          if (sub_menu_acion === 'click') {
            open_menus[0].focus();
          }
        } // if
        // If the event was a mouseup

      } else if (e.type === 'mouseup') {
        if (!menu.contains(e.target) && menu.querySelector('.submenu-is-open')) {
          // We were getting some error, so let's add in a second checkpoint
          if (open_menus_count) {
            for (opn = 0; opn < open_menus.length; opn = opn + 1) {
              menu_sub_close(open_menus[opn]);
            } // for

          }
        } // if

      }
    }

    ; // listener_close_open_menus()

    function menu_sub_close(open_item) {
      open_item.classList.remove('submenu-is-open');
      open_item.parentNode.classList.remove('child-has-focus');

      if (open_item.parentNode.querySelector('.sub-menu')) {
        open_item.parentNode.querySelector('.sub-menu').setAttribute('aria-hidden', 'true');
      }
    }

    ; // menu_sub_close()

    function menu_sub_close_all() {
      var open_menus = menu.querySelectorAll('.submenu-is-open');
      var open_menus_count = open_menus.length;
      var opn; // We were getting some errors, so let's add in a checkpoint

      if (open_menus_count) {
        // Loop through all the open menus and close them
        for (opn = 0; opn < open_menus.length; opn = opn + 1) {
          menu_sub_close(open_menus[opn]);
        } // for

      } // if

    }

    ; // menu_sub_close()

    function menu_sub_open(closed_item) {
      closed_item.classList.add('submenu-is-open');
      closed_item.parentNode.classList.add('child-has-focus');

      if (closed_item.parentNode.querySelector('.sub-menu')) {
        closed_item.parentNode.querySelector('.sub-menu').setAttribute('aria-hidden', 'false');
      }
    }

    ; // menu_sub_open()
    // Method to create the small screen menu

    function menu_create() {
      if (!document.body.classList.contains('has-offscreen-nav')) {
        if (!document.body.classList.contains('menu-is-open')) {
          menu.setAttribute('aria-hidden', 'true');
          menu_toggle.setAttribute('aria-expanded', 'false');
        } else {
          menu.setAttribute('aria-hidden', 'false');
          menu_toggle.setAttribute('aria-expanded', 'true');
        } // Loop through all submenus and bind events when needed


        for (i = 0; i < menu_items_with_children_count; i = i + 1) {
          if (sub_menu_acion !== 'click') {
            menu_items_with_children[i].addEventListener('click', listener_submenu_click);
            menu_items_with_children[i].removeEventListener('focusin', listener_submenu_focus);
            menu.classList.add('uses-click');
          }
        } // for
        // Bind the event


        menu_toggle.addEventListener('click', listener_menu); // Add the body class to prevent this from running again

        document.body.classList.add('has-offscreen-nav');
        document.body.classList.remove('has-full-nav');
      }
    }

    ; // menu_create()
    // Method to destroy the small screen menu

    function menu_destroy() {
      var tmp_open;
      var tmp_open_count;
      var t;

      if (!document.body.classList.contains('has-full-nav')) {
        // Remove aria-hidden, because we don't need it.
        menu.removeAttribute('aria-hidden'); // Loop through all submenus and bind events when needed

        for (i = 0; i < menu_items_with_children_count; i = i + 1) {
          if (sub_menu_acion !== 'click') {
            menu_items_with_children[i].removeEventListener('click', listener_submenu_click);
            menu_items_with_children[i].addEventListener('focusin', listener_submenu_focus);
            menu.classList.remove('uses-click');
          }
        } // If we're not using click, the open menus need to be reset


        if (sub_menu_acion !== 'click') {
          tmp_open = document.querySelectorAll('.child-has-focus');
          tmp_open_count = tmp_open.length;

          for (t = 0; t < tmp_open_count; t = t + 1) {
            tmp_open[t].classList.remove('child-has-focus');
            tmp_open[t].querySelector('.submenu-is-open').classList.remove('submenu-is-open');
            tmp_open[t].querySelector('.sub-menu').setAttribute('aria-hidden', 'true');
          }
        } // Unbind the event


        menu_toggle.removeEventListener('click', listener_menu); // Add the body class to prevent this from running again

        document.body.classList.add('has-full-nav');
        document.body.classList.remove('has-offscreen-nav');
      }
    }

    ; // Check init menu state

    if (get_screen_size('has-offscreen-nav')) {
      menu_create();
    } // If aria-controls isn't set, set it


    if (!aria_controls) {
      menu_toggle.setAttribute('aria-controls', menu_id);
    }

    if (current_menu_item) {
      current_menu_item.querySelector('a').setAttribute('aria-current', 'page');
    }
    /*
    	Events
    */
    // Debounced resize event to create and destroy the small screen menu options


    window.addEventListener('resize', listener_window); // Close the submenus by clicking off of them or hitting ESC

    document.addEventListener('mouseup', listener_close_open_menus);
    document.addEventListener('keyup', listener_close_open_menus);
    /*
    	Hiding and showing submenus (click, focus, hover)
    */
    // Loop through all items with sub menus and bind focus to them for tabbing

    for (i = 0; i < menu_items_with_children_count; i = i + 1) {
      // Let a screen reader know this menu has a submenu by hooking into the first link
      menu_items_with_children[i].querySelector('a').setAttribute('aria-haspopup', 'true'); // Hide and label each sub menu

      menu_items_with_children[i].querySelector('.sub-menu').setAttribute('aria-hidden', 'true');
      menu_items_with_children[i].querySelector('.sub-menu').setAttribute('aria-label', 'Submenu'); // If the screen is small or the action is set to click

      if (get_screen_size('has-offscreen-nav') || sub_menu_acion === 'click') {
        menu_items_with_children[i].addEventListener('click', listener_submenu_click);
        var svgElements = menu_items_with_children[i].querySelectorAll('svg');

        for (var z = 0; z < svgElements.length; z = z + 1) {
          svgElements[z].addEventListener('click', listener_submenu_click);
        }

        menu.classList.add('uses-click');
      } else if (sub_menu_acion !== 'click') {
        if (get_screen_size('has-full-nav')) {
          menu_items_with_children[i].addEventListener('focusin', listener_submenu_focus);
        } // if

      } // if

    } // for
    // Execute the callback function


    if (typeof callback === 'function') {
      callback.call();
    }
  }; // build_menu()

  /*
  	Helper functions
  */
  // Get screen size from getComputedStyle (so we don't have to define each breakpoint twice) -- Values are set in CSS --


  function get_screen_size(sizeString) {
    var size = window.getComputedStyle(document.body, ':before').getPropertyValue('content');

    if (size && size.indexOf(sizeString) !== -1) {
      return true;
    }
  }

  ; // Debounce

  function debounce(func, wait, immediate) {
    var timeout;
    return function () {
      var context = this,
          args = arguments;

      var later = function later() {
        timeout = null;
        if (!immediate) func.apply(context, args);
      };

      var callNow = immediate && !timeout;
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
      if (callNow) func.apply(context, args);
    };
  }

  ;
})();

/***/ }),

/***/ "./node_modules/css-vars-ponyfill/dist/css-vars-ponyfill.esm.js":
/*!**********************************************************************!*\
  !*** ./node_modules/css-vars-ponyfill/dist/css-vars-ponyfill.esm.js ***!
  \**********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/*!
 * css-vars-ponyfill
 * v2.3.1
 * https://jhildenbiddle.github.io/css-vars-ponyfill/
 * (c) 2018-2020 John Hildenbiddle <http://hildenbiddle.com>
 * MIT license
 */
function _extends() {
    _extends = Object.assign || function(target) {
        for (var i = 1; i < arguments.length; i++) {
            var source = arguments[i];
            for (var key in source) {
                if (Object.prototype.hasOwnProperty.call(source, key)) {
                    target[key] = source[key];
                }
            }
        }
        return target;
    };
    return _extends.apply(this, arguments);
}

function _toConsumableArray(arr) {
    return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread();
}

function _arrayWithoutHoles(arr) {
    if (Array.isArray(arr)) return _arrayLikeToArray(arr);
}

function _iterableToArray(iter) {
    if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter);
}

function _unsupportedIterableToArray(o, minLen) {
    if (!o) return;
    if (typeof o === "string") return _arrayLikeToArray(o, minLen);
    var n = Object.prototype.toString.call(o).slice(8, -1);
    if (n === "Object" && o.constructor) n = o.constructor.name;
    if (n === "Map" || n === "Set") return Array.from(o);
    if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
}

function _arrayLikeToArray(arr, len) {
    if (len == null || len > arr.length) len = arr.length;
    for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i];
    return arr2;
}

function _nonIterableSpread() {
    throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}

/*!
 * get-css-data
 * v1.8.0
 * https://github.com/jhildenbiddle/get-css-data
 * (c) 2018-2020 John Hildenbiddle <http://hildenbiddle.com>
 * MIT license
 */ function getUrls(urls) {
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
    var settings = {
        mimeType: options.mimeType || null,
        onBeforeSend: options.onBeforeSend || Function.prototype,
        onSuccess: options.onSuccess || Function.prototype,
        onError: options.onError || Function.prototype,
        onComplete: options.onComplete || Function.prototype
    };
    var urlArray = Array.isArray(urls) ? urls : [ urls ];
    var urlQueue = Array.apply(null, Array(urlArray.length)).map((function(x) {
        return null;
    }));
    function isValidCss() {
        var cssText = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";
        var isHTML = cssText.trim().charAt(0) === "<";
        return !isHTML;
    }
    function onError(xhr, urlIndex) {
        settings.onError(xhr, urlArray[urlIndex], urlIndex);
    }
    function onSuccess(responseText, urlIndex) {
        var returnVal = settings.onSuccess(responseText, urlArray[urlIndex], urlIndex);
        responseText = returnVal === false ? "" : returnVal || responseText;
        urlQueue[urlIndex] = responseText;
        if (urlQueue.indexOf(null) === -1) {
            settings.onComplete(urlQueue);
        }
    }
    var parser = document.createElement("a");
    urlArray.forEach((function(url, i) {
        parser.setAttribute("href", url);
        parser.href = String(parser.href);
        var isIElte9 = Boolean(document.all && !window.atob);
        var isIElte9CORS = isIElte9 && parser.host.split(":")[0] !== location.host.split(":")[0];
        if (isIElte9CORS) {
            var isSameProtocol = parser.protocol === location.protocol;
            if (isSameProtocol) {
                var xdr = new XDomainRequest;
                xdr.open("GET", url);
                xdr.timeout = 0;
                xdr.onprogress = Function.prototype;
                xdr.ontimeout = Function.prototype;
                xdr.onload = function() {
                    if (isValidCss(xdr.responseText)) {
                        onSuccess(xdr.responseText, i);
                    } else {
                        onError(xdr, i);
                    }
                };
                xdr.onerror = function(err) {
                    onError(xdr, i);
                };
                setTimeout((function() {
                    xdr.send();
                }), 0);
            } else {
                console.warn("Internet Explorer 9 Cross-Origin (CORS) requests must use the same protocol (".concat(url, ")"));
                onError(null, i);
            }
        } else {
            var xhr = new XMLHttpRequest;
            xhr.open("GET", url);
            if (settings.mimeType && xhr.overrideMimeType) {
                xhr.overrideMimeType(settings.mimeType);
            }
            settings.onBeforeSend(xhr, url, i);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200 && isValidCss(xhr.responseText)) {
                        onSuccess(xhr.responseText, i);
                    } else {
                        onError(xhr, i);
                    }
                }
            };
            xhr.send();
        }
    }));
}

/**
 * Gets CSS data from <style> and <link> nodes (including @imports), then
 * returns data in order processed by DOM. Allows specifying nodes to
 * include/exclude and filtering CSS data using RegEx.
 *
 * @preserve
 * @param {object}   [options] The options object
 * @param {object}   [options.rootElement=document] Root element to traverse for
 *                   <link> and <style> nodes.
 * @param {string}   [options.include] CSS selector matching <link> and <style>
 *                   nodes to include
 * @param {string}   [options.exclude] CSS selector matching <link> and <style>
 *                   nodes to exclude
 * @param {object}   [options.filter] Regular expression used to filter node CSS
 *                   data. Each block of CSS data is tested against the filter,
 *                   and only matching data is included.
 * @param {boolean}  [options.skipDisabled=true] Determines if disabled
 *                   stylesheets will be skipped while collecting CSS data.
 * @param {boolean}  [options.useCSSOM=false] Determines if CSS data will be
 *                   collected from a stylesheet's runtime values instead of its
 *                   text content. This is required to get accurate CSS data
 *                   when a stylesheet has been modified using the deleteRule()
 *                   or insertRule() methods because these modifications will
 *                   not be reflected in the stylesheet's text content.
 * @param {function} [options.onBeforeSend] Callback before XHR is sent. Passes
 *                   1) the XHR object, 2) source node reference, and 3) the
 *                   source URL as arguments.
 * @param {function} [options.onSuccess] Callback on each CSS node read. Passes
 *                   1) CSS text, 2) source node reference, and 3) the source
 *                   URL as arguments.
 * @param {function} [options.onError] Callback on each error. Passes 1) the XHR
 *                   object for inspection, 2) soure node reference, and 3) the
 *                   source URL that failed (either a <link> href or an @import)
 *                   as arguments
 * @param {function} [options.onComplete] Callback after all nodes have been
 *                   processed. Passes 1) concatenated CSS text, 2) an array of
 *                   CSS text in DOM order, and 3) an array of nodes in DOM
 *                   order as arguments.
 *
 * @example
 *
 *   getCssData({
 *     rootElement : document,
 *     include     : 'style,link[rel="stylesheet"]',
 *     exclude     : '[href="skip.css"]',
 *     filter      : /red/,
 *     skipDisabled: true,
 *     useCSSOM    : false,
 *     onBeforeSend(xhr, node, url) {
 *       // ...
 *     }
 *     onSuccess(cssText, node, url) {
 *       // ...
 *     }
 *     onError(xhr, node, url) {
 *       // ...
 *     },
 *     onComplete(cssText, cssArray, nodeArray) {
 *       // ...
 *     }
 *   });
 */ function getCssData(options) {
    var regex = {
        cssComments: /\/\*[\s\S]+?\*\//g,
        cssImports: /(?:@import\s*)(?:url\(\s*)?(?:['"])([^'"]*)(?:['"])(?:\s*\))?(?:[^;]*;)/g
    };
    var settings = {
        rootElement: options.rootElement || document,
        include: options.include || 'style,link[rel="stylesheet"]',
        exclude: options.exclude || null,
        filter: options.filter || null,
        skipDisabled: options.skipDisabled !== false,
        useCSSOM: options.useCSSOM || false,
        onBeforeSend: options.onBeforeSend || Function.prototype,
        onSuccess: options.onSuccess || Function.prototype,
        onError: options.onError || Function.prototype,
        onComplete: options.onComplete || Function.prototype
    };
    var sourceNodes = Array.apply(null, settings.rootElement.querySelectorAll(settings.include)).filter((function(node) {
        return !matchesSelector(node, settings.exclude);
    }));
    var cssArray = Array.apply(null, Array(sourceNodes.length)).map((function(x) {
        return null;
    }));
    function handleComplete() {
        var isComplete = cssArray.indexOf(null) === -1;
        if (isComplete) {
            var cssText = cssArray.join("");
            settings.onComplete(cssText, cssArray, sourceNodes);
        }
    }
    function handleSuccess(cssText, cssIndex, node, sourceUrl) {
        var returnVal = settings.onSuccess(cssText, node, sourceUrl);
        cssText = returnVal !== undefined && Boolean(returnVal) === false ? "" : returnVal || cssText;
        resolveImports(cssText, node, sourceUrl, (function(resolvedCssText, errorData) {
            if (cssArray[cssIndex] === null) {
                errorData.forEach((function(data) {
                    return settings.onError(data.xhr, node, data.url);
                }));
                if (!settings.filter || settings.filter.test(resolvedCssText)) {
                    cssArray[cssIndex] = resolvedCssText;
                } else {
                    cssArray[cssIndex] = "";
                }
                handleComplete();
            }
        }));
    }
    function parseImportData(cssText, baseUrl) {
        var ignoreRules = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : [];
        var importData = {};
        importData.rules = (cssText.replace(regex.cssComments, "").match(regex.cssImports) || []).filter((function(rule) {
            return ignoreRules.indexOf(rule) === -1;
        }));
        importData.urls = importData.rules.map((function(rule) {
            return rule.replace(regex.cssImports, "$1");
        }));
        importData.absoluteUrls = importData.urls.map((function(url) {
            return getFullUrl(url, baseUrl);
        }));
        importData.absoluteRules = importData.rules.map((function(rule, i) {
            var oldUrl = importData.urls[i];
            var newUrl = getFullUrl(importData.absoluteUrls[i], baseUrl);
            return rule.replace(oldUrl, newUrl);
        }));
        return importData;
    }
    function resolveImports(cssText, node, baseUrl, callbackFn) {
        var __errorData = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : [];
        var __errorRules = arguments.length > 5 && arguments[5] !== undefined ? arguments[5] : [];
        var importData = parseImportData(cssText, baseUrl, __errorRules);
        if (importData.rules.length) {
            getUrls(importData.absoluteUrls, {
                onBeforeSend: function onBeforeSend(xhr, url, urlIndex) {
                    settings.onBeforeSend(xhr, node, url);
                },
                onSuccess: function onSuccess(cssText, url, urlIndex) {
                    var returnVal = settings.onSuccess(cssText, node, url);
                    cssText = returnVal === false ? "" : returnVal || cssText;
                    var responseImportData = parseImportData(cssText, url, __errorRules);
                    responseImportData.rules.forEach((function(rule, i) {
                        cssText = cssText.replace(rule, responseImportData.absoluteRules[i]);
                    }));
                    return cssText;
                },
                onError: function onError(xhr, url, urlIndex) {
                    __errorData.push({
                        xhr: xhr,
                        url: url
                    });
                    __errorRules.push(importData.rules[urlIndex]);
                    resolveImports(cssText, node, baseUrl, callbackFn, __errorData, __errorRules);
                },
                onComplete: function onComplete(responseArray) {
                    responseArray.forEach((function(importText, i) {
                        cssText = cssText.replace(importData.rules[i], importText);
                    }));
                    resolveImports(cssText, node, baseUrl, callbackFn, __errorData, __errorRules);
                }
            });
        } else {
            callbackFn(cssText, __errorData);
        }
    }
    if (sourceNodes.length) {
        sourceNodes.forEach((function(node, i) {
            var linkHref = node.getAttribute("href");
            var linkRel = node.getAttribute("rel");
            var isLink = node.nodeName === "LINK" && linkHref && linkRel && linkRel.toLowerCase().indexOf("stylesheet") !== -1;
            var isSkip = settings.skipDisabled === false ? false : node.disabled;
            var isStyle = node.nodeName === "STYLE";
            if (isLink && !isSkip) {
                getUrls(linkHref, {
                    mimeType: "text/css",
                    onBeforeSend: function onBeforeSend(xhr, url, urlIndex) {
                        settings.onBeforeSend(xhr, node, url);
                    },
                    onSuccess: function onSuccess(cssText, url, urlIndex) {
                        var sourceUrl = getFullUrl(linkHref);
                        handleSuccess(cssText, i, node, sourceUrl);
                    },
                    onError: function onError(xhr, url, urlIndex) {
                        cssArray[i] = "";
                        settings.onError(xhr, node, url);
                        handleComplete();
                    }
                });
            } else if (isStyle && !isSkip) {
                var cssText = node.textContent;
                if (settings.useCSSOM) {
                    cssText = Array.apply(null, node.sheet.cssRules).map((function(rule) {
                        return rule.cssText;
                    })).join("");
                }
                handleSuccess(cssText, i, node, location.href);
            } else {
                cssArray[i] = "";
                handleComplete();
            }
        }));
    } else {
        settings.onComplete("", []);
    }
}

function getFullUrl(url, base) {
    var d = document.implementation.createHTMLDocument("");
    var b = d.createElement("base");
    var a = d.createElement("a");
    d.head.appendChild(b);
    d.body.appendChild(a);
    b.href = base || document.baseURI || (document.querySelector("base") || {}).href || location.href;
    a.href = url;
    return a.href;
}

function matchesSelector(elm, selector) {
    var matches = elm.matches || elm.matchesSelector || elm.webkitMatchesSelector || elm.mozMatchesSelector || elm.msMatchesSelector || elm.oMatchesSelector;
    return matches.call(elm, selector);
}

var balancedMatch = balanced;

function balanced(a, b, str) {
    if (a instanceof RegExp) a = maybeMatch(a, str);
    if (b instanceof RegExp) b = maybeMatch(b, str);
    var r = range(a, b, str);
    return r && {
        start: r[0],
        end: r[1],
        pre: str.slice(0, r[0]),
        body: str.slice(r[0] + a.length, r[1]),
        post: str.slice(r[1] + b.length)
    };
}

function maybeMatch(reg, str) {
    var m = str.match(reg);
    return m ? m[0] : null;
}

balanced.range = range;

function range(a, b, str) {
    var begs, beg, left, right, result;
    var ai = str.indexOf(a);
    var bi = str.indexOf(b, ai + 1);
    var i = ai;
    if (ai >= 0 && bi > 0) {
        begs = [];
        left = str.length;
        while (i >= 0 && !result) {
            if (i == ai) {
                begs.push(i);
                ai = str.indexOf(a, i + 1);
            } else if (begs.length == 1) {
                result = [ begs.pop(), bi ];
            } else {
                beg = begs.pop();
                if (beg < left) {
                    left = beg;
                    right = bi;
                }
                bi = str.indexOf(b, i + 1);
            }
            i = ai < bi && ai >= 0 ? ai : bi;
        }
        if (begs.length) {
            result = [ left, right ];
        }
    }
    return result;
}

function parseCss(css) {
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
    var defaults = {
        preserveStatic: true,
        removeComments: false
    };
    var settings = _extends({}, defaults, options);
    var errors = [];
    function error(msg) {
        throw new Error("CSS parse error: ".concat(msg));
    }
    function match(re) {
        var m = re.exec(css);
        if (m) {
            css = css.slice(m[0].length);
            return m;
        }
    }
    function open() {
        return match(/^{\s*/);
    }
    function close() {
        return match(/^}/);
    }
    function whitespace() {
        match(/^\s*/);
    }
    function comment() {
        whitespace();
        if (css[0] !== "/" || css[1] !== "*") {
            return;
        }
        var i = 2;
        while (css[i] && (css[i] !== "*" || css[i + 1] !== "/")) {
            i++;
        }
        if (!css[i]) {
            return error("end of comment is missing");
        }
        var str = css.slice(2, i);
        css = css.slice(i + 2);
        return {
            type: "comment",
            comment: str
        };
    }
    function comments() {
        var cmnts = [];
        var c;
        while (c = comment()) {
            cmnts.push(c);
        }
        return settings.removeComments ? [] : cmnts;
    }
    function selector() {
        whitespace();
        while (css[0] === "}") {
            error("extra closing bracket");
        }
        var m = match(/^(("(?:\\"|[^"])*"|'(?:\\'|[^'])*'|[^{])+)/);
        if (m) {
            return m[0].trim().replace(/\/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*\/+/g, "").replace(/"(?:\\"|[^"])*"|'(?:\\'|[^'])*'/g, (function(m) {
                return m.replace(/,/g, "‌");
            })).split(/\s*(?![^(]*\)),\s*/).map((function(s) {
                return s.replace(/\u200C/g, ",");
            }));
        }
    }
    function declaration() {
        if (css[0] === "@") {
            return at_rule();
        }
        match(/^([;\s]*)+/);
        var comment_regexp = /\/\*[^*]*\*+([^/*][^*]*\*+)*\//g;
        var prop = match(/^(\*?[-#/*\\\w]+(\[[0-9a-z_-]+\])?)\s*/);
        if (!prop) {
            return;
        }
        prop = prop[0].trim();
        if (!match(/^:\s*/)) {
            return error("property missing ':'");
        }
        var val = match(/^((?:\/\*.*?\*\/|'(?:\\'|.)*?'|"(?:\\"|.)*?"|\((\s*'(?:\\'|.)*?'|"(?:\\"|.)*?"|[^)]*?)\s*\)|[^};])+)/);
        var ret = {
            type: "declaration",
            property: prop.replace(comment_regexp, ""),
            value: val ? val[0].replace(comment_regexp, "").trim() : ""
        };
        match(/^[;\s]*/);
        return ret;
    }
    function declarations() {
        if (!open()) {
            return error("missing '{'");
        }
        var d;
        var decls = comments();
        while (d = declaration()) {
            decls.push(d);
            decls = decls.concat(comments());
        }
        if (!close()) {
            return error("missing '}'");
        }
        return decls;
    }
    function keyframe() {
        whitespace();
        var vals = [];
        var m;
        while (m = match(/^((\d+\.\d+|\.\d+|\d+)%?|[a-z]+)\s*/)) {
            vals.push(m[1]);
            match(/^,\s*/);
        }
        if (vals.length) {
            return {
                type: "keyframe",
                values: vals,
                declarations: declarations()
            };
        }
    }
    function at_keyframes() {
        var m = match(/^@([-\w]+)?keyframes\s*/);
        if (!m) {
            return;
        }
        var vendor = m[1];
        m = match(/^([-\w]+)\s*/);
        if (!m) {
            return error("@keyframes missing name");
        }
        var name = m[1];
        if (!open()) {
            return error("@keyframes missing '{'");
        }
        var frame;
        var frames = comments();
        while (frame = keyframe()) {
            frames.push(frame);
            frames = frames.concat(comments());
        }
        if (!close()) {
            return error("@keyframes missing '}'");
        }
        return {
            type: "keyframes",
            name: name,
            vendor: vendor,
            keyframes: frames
        };
    }
    function at_page() {
        var m = match(/^@page */);
        if (m) {
            var sel = selector() || [];
            return {
                type: "page",
                selectors: sel,
                declarations: declarations()
            };
        }
    }
    function at_page_margin_box() {
        var m = match(/@(top|bottom|left|right)-(left|center|right|top|middle|bottom)-?(corner)?\s*/);
        if (m) {
            var name = "".concat(m[1], "-").concat(m[2]) + (m[3] ? "-".concat(m[3]) : "");
            return {
                type: "page-margin-box",
                name: name,
                declarations: declarations()
            };
        }
    }
    function at_fontface() {
        var m = match(/^@font-face\s*/);
        if (m) {
            return {
                type: "font-face",
                declarations: declarations()
            };
        }
    }
    function at_supports() {
        var m = match(/^@supports *([^{]+)/);
        if (m) {
            return {
                type: "supports",
                supports: m[1].trim(),
                rules: rules()
            };
        }
    }
    function at_host() {
        var m = match(/^@host\s*/);
        if (m) {
            return {
                type: "host",
                rules: rules()
            };
        }
    }
    function at_media() {
        var m = match(/^@media([^{]+)*/);
        if (m) {
            return {
                type: "media",
                media: (m[1] || "").trim(),
                rules: rules()
            };
        }
    }
    function at_custom_m() {
        var m = match(/^@custom-media\s+(--[^\s]+)\s*([^{;]+);/);
        if (m) {
            return {
                type: "custom-media",
                name: m[1].trim(),
                media: m[2].trim()
            };
        }
    }
    function at_document() {
        var m = match(/^@([-\w]+)?document *([^{]+)/);
        if (m) {
            return {
                type: "document",
                document: m[2].trim(),
                vendor: m[1] ? m[1].trim() : null,
                rules: rules()
            };
        }
    }
    function at_x() {
        var m = match(/^@(import|charset|namespace)\s*([^;]+);/);
        if (m) {
            return {
                type: m[1],
                name: m[2].trim()
            };
        }
    }
    function at_rule() {
        whitespace();
        if (css[0] === "@") {
            var ret = at_x() || at_fontface() || at_media() || at_keyframes() || at_supports() || at_document() || at_custom_m() || at_host() || at_page() || at_page_margin_box();
            if (ret && !settings.preserveStatic) {
                var hasVarFunc = false;
                if (ret.declarations) {
                    hasVarFunc = ret.declarations.some((function(decl) {
                        return /var\(/.test(decl.value);
                    }));
                } else {
                    var arr = ret.keyframes || ret.rules || [];
                    hasVarFunc = arr.some((function(obj) {
                        return (obj.declarations || []).some((function(decl) {
                            return /var\(/.test(decl.value);
                        }));
                    }));
                }
                return hasVarFunc ? ret : {};
            }
            return ret;
        }
    }
    function rule() {
        if (!settings.preserveStatic) {
            var balancedMatch$1 = balancedMatch("{", "}", css);
            if (balancedMatch$1) {
                var hasVarDecl = /:(?:root|host)(?![.:#(])/.test(balancedMatch$1.pre) && /--\S*\s*:/.test(balancedMatch$1.body);
                var hasVarFunc = /var\(/.test(balancedMatch$1.body);
                if (!hasVarDecl && !hasVarFunc) {
                    css = css.slice(balancedMatch$1.end + 1);
                    return {};
                }
            }
        }
        var sel = selector() || [];
        var decls = settings.preserveStatic ? declarations() : declarations().filter((function(decl) {
            var hasVarDecl = sel.some((function(s) {
                return /:(?:root|host)(?![.:#(])/.test(s);
            })) && /^--\S/.test(decl.property);
            var hasVarFunc = /var\(/.test(decl.value);
            return hasVarDecl || hasVarFunc;
        }));
        if (!sel.length) {
            error("selector missing");
        }
        return {
            type: "rule",
            selectors: sel,
            declarations: decls
        };
    }
    function rules(core) {
        if (!core && !open()) {
            return error("missing '{'");
        }
        var node;
        var rules = comments();
        while (css.length && (core || css[0] !== "}") && (node = at_rule() || rule())) {
            if (node.type) {
                rules.push(node);
            }
            rules = rules.concat(comments());
        }
        if (!core && !close()) {
            return error("missing '}'");
        }
        return rules;
    }
    return {
        type: "stylesheet",
        stylesheet: {
            rules: rules(true),
            errors: errors
        }
    };
}

function parseVars(cssData) {
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
    var defaults = {
        parseHost: false,
        store: {},
        onWarning: function onWarning() {}
    };
    var settings = _extends({}, defaults, options);
    var reVarDeclSelectors = new RegExp(":".concat(settings.parseHost ? "host" : "root", "$"));
    if (typeof cssData === "string") {
        cssData = parseCss(cssData, settings);
    }
    cssData.stylesheet.rules.forEach((function(rule) {
        if (rule.type !== "rule" || !rule.selectors.some((function(s) {
            return reVarDeclSelectors.test(s);
        }))) {
            return;
        }
        rule.declarations.forEach((function(decl, i) {
            var prop = decl.property;
            var value = decl.value;
            if (prop && prop.indexOf("--") === 0) {
                settings.store[prop] = value;
            }
        }));
    }));
    return settings.store;
}

function stringifyCss(tree) {
    var delim = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "";
    var cb = arguments.length > 2 ? arguments[2] : undefined;
    var renderMethods = {
        charset: function charset(node) {
            return "@charset " + node.name + ";";
        },
        comment: function comment(node) {
            return node.comment.indexOf("__CSSVARSPONYFILL") === 0 ? "/*" + node.comment + "*/" : "";
        },
        "custom-media": function customMedia(node) {
            return "@custom-media " + node.name + " " + node.media + ";";
        },
        declaration: function declaration(node) {
            return node.property + ":" + node.value + ";";
        },
        document: function document(node) {
            return "@" + (node.vendor || "") + "document " + node.document + "{" + visit(node.rules) + "}";
        },
        "font-face": function fontFace(node) {
            return "@font-face" + "{" + visit(node.declarations) + "}";
        },
        host: function host(node) {
            return "@host" + "{" + visit(node.rules) + "}";
        },
        import: function _import(node) {
            return "@import " + node.name + ";";
        },
        keyframe: function keyframe(node) {
            return node.values.join(",") + "{" + visit(node.declarations) + "}";
        },
        keyframes: function keyframes(node) {
            return "@" + (node.vendor || "") + "keyframes " + node.name + "{" + visit(node.keyframes) + "}";
        },
        media: function media(node) {
            return "@media " + node.media + "{" + visit(node.rules) + "}";
        },
        namespace: function namespace(node) {
            return "@namespace " + node.name + ";";
        },
        page: function page(node) {
            return "@page " + (node.selectors.length ? node.selectors.join(", ") : "") + "{" + visit(node.declarations) + "}";
        },
        "page-margin-box": function pageMarginBox(node) {
            return "@" + node.name + "{" + visit(node.declarations) + "}";
        },
        rule: function rule(node) {
            var decls = node.declarations;
            if (decls.length) {
                return node.selectors.join(",") + "{" + visit(decls) + "}";
            }
        },
        supports: function supports(node) {
            return "@supports " + node.supports + "{" + visit(node.rules) + "}";
        }
    };
    function visit(nodes) {
        var buf = "";
        for (var i = 0; i < nodes.length; i++) {
            var n = nodes[i];
            if (cb) {
                cb(n);
            }
            var txt = renderMethods[n.type](n);
            if (txt) {
                buf += txt;
                if (txt.length && n.selectors) {
                    buf += delim;
                }
            }
        }
        return buf;
    }
    return visit(tree.stylesheet.rules);
}

function walkCss(node, fn) {
    node.rules.forEach((function(rule) {
        if (rule.rules) {
            walkCss(rule, fn);
            return;
        }
        if (rule.keyframes) {
            rule.keyframes.forEach((function(keyframe) {
                if (keyframe.type === "keyframe") {
                    fn(keyframe.declarations, rule);
                }
            }));
            return;
        }
        if (!rule.declarations) {
            return;
        }
        fn(rule.declarations, node);
    }));
}

var VAR_PROP_IDENTIFIER = "--";

var VAR_FUNC_IDENTIFIER = "var";

function transformCss(cssData) {
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
    var defaults = {
        preserveStatic: true,
        preserveVars: false,
        variables: {},
        onWarning: function onWarning() {}
    };
    var settings = _extends({}, defaults, options);
    if (typeof cssData === "string") {
        cssData = parseCss(cssData, settings);
    }
    walkCss(cssData.stylesheet, (function(declarations, node) {
        for (var i = 0; i < declarations.length; i++) {
            var decl = declarations[i];
            var type = decl.type;
            var prop = decl.property;
            var value = decl.value;
            if (type !== "declaration") {
                continue;
            }
            if (!settings.preserveVars && prop && prop.indexOf(VAR_PROP_IDENTIFIER) === 0) {
                declarations.splice(i, 1);
                i--;
                continue;
            }
            if (value.indexOf(VAR_FUNC_IDENTIFIER + "(") !== -1) {
                var resolvedValue = resolveValue(value, settings);
                if (resolvedValue !== decl.value) {
                    resolvedValue = fixNestedCalc(resolvedValue);
                    if (!settings.preserveVars) {
                        decl.value = resolvedValue;
                    } else {
                        declarations.splice(i, 0, {
                            type: type,
                            property: prop,
                            value: resolvedValue
                        });
                        i++;
                    }
                }
            }
        }
    }));
    return stringifyCss(cssData);
}

function fixNestedCalc(value) {
    var reCalcVal = /calc\(([^)]+)\)/g;
    (value.match(reCalcVal) || []).forEach((function(match) {
        var newVal = "calc".concat(match.split("calc").join(""));
        value = value.replace(match, newVal);
    }));
    return value;
}

function resolveValue(value) {
    var settings = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
    var __recursiveFallback = arguments.length > 2 ? arguments[2] : undefined;
    if (value.indexOf("var(") === -1) {
        return value;
    }
    var valueData = balancedMatch("(", ")", value);
    function resolveFunc(value) {
        var name = value.split(",")[0].replace(/[\s\n\t]/g, "");
        var fallback = (value.match(/(?:\s*,\s*){1}(.*)?/) || [])[1];
        var match = Object.prototype.hasOwnProperty.call(settings.variables, name) ? String(settings.variables[name]) : undefined;
        var replacement = match || (fallback ? String(fallback) : undefined);
        var unresolvedFallback = __recursiveFallback || value;
        if (!match) {
            settings.onWarning('variable "'.concat(name, '" is undefined'));
        }
        if (replacement && replacement !== "undefined" && replacement.length > 0) {
            return resolveValue(replacement, settings, unresolvedFallback);
        } else {
            return "var(".concat(unresolvedFallback, ")");
        }
    }
    if (!valueData) {
        if (value.indexOf("var(") !== -1) {
            settings.onWarning('missing closing ")" in the value "'.concat(value, '"'));
        }
        return value;
    } else if (valueData.pre.slice(-3) === "var") {
        var isEmptyVarFunc = valueData.body.trim().length === 0;
        if (isEmptyVarFunc) {
            settings.onWarning("var() must contain a non-whitespace string");
            return value;
        } else {
            return valueData.pre.slice(0, -3) + resolveFunc(valueData.body) + resolveValue(valueData.post, settings);
        }
    } else {
        return valueData.pre + "(".concat(resolveValue(valueData.body, settings), ")") + resolveValue(valueData.post, settings);
    }
}

var isBrowser = typeof window !== "undefined";

var isNativeSupport = isBrowser && window.CSS && window.CSS.supports && window.CSS.supports("(--a: 0)");

var counters = {
    group: 0,
    job: 0
};

var defaults = {
    rootElement: isBrowser ? document : null,
    shadowDOM: false,
    include: "style,link[rel=stylesheet]",
    exclude: "",
    variables: {},
    onlyLegacy: true,
    preserveStatic: true,
    preserveVars: false,
    silent: false,
    updateDOM: true,
    updateURLs: true,
    watch: null,
    onBeforeSend: function onBeforeSend() {},
    onError: function onError() {},
    onWarning: function onWarning() {},
    onSuccess: function onSuccess() {},
    onComplete: function onComplete() {},
    onFinally: function onFinally() {}
};

var regex = {
    cssComments: /\/\*[\s\S]+?\*\//g,
    cssKeyframes: /@(?:-\w*-)?keyframes/,
    cssMediaQueries: /@media[^{]+\{([\s\S]+?})\s*}/g,
    cssUrls: /url\((?!['"]?(?:data|http|\/\/):)['"]?([^'")]*)['"]?\)/g,
    cssVarDeclRules: /(?::(?:root|host)(?![.:#(])[\s,]*[^{]*{\s*[^}]*})/g,
    cssVarDecls: /(?:[\s;]*)(-{2}\w[\w-]*)(?:\s*:\s*)([^;]*);/g,
    cssVarFunc: /var\(\s*--[\w-]/,
    cssVars: /(?:(?::(?:root|host)(?![.:#(])[\s,]*[^{]*{\s*[^;]*;*\s*)|(?:var\(\s*))(--[^:)]+)(?:\s*[:)])/
};

var variableStore = {
    dom: {},
    job: {},
    user: {}
};

var cssVarsIsRunning = false;

var cssVarsObserver = null;

var cssVarsSrcNodeCount = 0;

var debounceTimer = null;

var isShadowDOMReady = false;

/**
 * Fetches, parses, and transforms CSS custom properties from specified
 * <style> and <link> elements into static values, then appends a new <style>
 * element with static values to the DOM to provide CSS custom property
 * compatibility for legacy browsers. Also provides a single interface for
 * live updates of runtime values in both modern and legacy browsers.
 *
 * @preserve
 * @param {object}   [options] Options object
 * @param {object}   [options.rootElement=document] Root element to traverse for
 *                   <link> and <style> nodes
 * @param {boolean}  [options.shadowDOM=false] Determines if shadow DOM <link>
 *                   and <style> nodes will be processed.
 * @param {string}   [options.include="style,link[rel=stylesheet]"] CSS selector
 *                   matching <link re="stylesheet"> and <style> nodes to
 *                   process
 * @param {string}   [options.exclude] CSS selector matching <link
 *                   rel="stylehseet"> and <style> nodes to exclude from those
 *                   matches by options.include
 * @param {object}   [options.variables] A map of custom property name/value
 *                   pairs. Property names can omit or include the leading
 *                   double-hyphen (—), and values specified will override
 *                   previous values
 * @param {boolean}  [options.onlyLegacy=true] Determines if the ponyfill will
 *                   only generate legacy-compatible CSS in browsers that lack
 *                   native support (i.e., legacy browsers)
 * @param {boolean}  [options.preserveStatic=true] Determines if CSS
 *                   declarations that do not reference a custom property will
 *                   be preserved in the transformed CSS
 * @param {boolean}  [options.preserveVars=false] Determines if CSS custom
 *                   property declarations will be preserved in the transformed
 *                   CSS
 * @param {boolean}  [options.silent=false] Determines if warning and error
 *                   messages will be displayed on the console
 * @param {boolean}  [options.updateDOM=true] Determines if the ponyfill will
 *                   update the DOM after processing CSS custom properties
 * @param {boolean}  [options.updateURLs=true] Determines if the ponyfill will
 *                   convert relative url() paths to absolute urls
 * @param {boolean}  [options.watch=false] Determines if a MutationObserver will
 *                   be created that will execute the ponyfill when a <link> or
 *                   <style> DOM mutation is observed
 * @param {function} [options.onBeforeSend] Callback before XHR is sent. Passes
 *                   1) the XHR object, 2) source node reference, and 3) the
 *                   source URL as arguments
 * @param {function} [options.onError] Callback after a CSS parsing error has
 *                   occurred or an XHR request has failed. Passes 1) an error
 *                   message, and 2) source node reference, 3) xhr, and 4 url as
 *                   arguments.
 * @param {function} [options.onWarning] Callback after each CSS parsing warning
 *                   has occurred. Passes 1) a warning message as an argument.
 * @param {function} [options.onSuccess] Callback after CSS data has been
 *                   collected from each node and before CSS custom properties
 *                   have been transformed. Allows modifying the CSS data before
 *                   it is transformed by returning any string value (or false
 *                   to skip). Passes 1) CSS text, 2) source node reference, and
 *                   3) the source URL as arguments.
 * @param {function} [options.onComplete] Callback after all CSS has been
 *                   processed, legacy-compatible CSS has been generated, and
 *                   (optionally) the DOM has been updated. Passes 1) a CSS
 *                   string with CSS variable values resolved, 2) an array of
 *                   output <style> node references that have been appended to
 *                   the DOM, 3) an object containing all custom properies names
 *                   and values, and 4) the ponyfill execution time in
 *                   milliseconds.
 * @param {function} [options.onFinally] Callback in modern and legacy browsers
 *                   after the ponyfill has finished all tasks. Passes 1) a
 *                   boolean indicating if the last ponyfill call resulted in a
 *                   style change, 2) a boolean indicating if the current
 *                   browser provides native support for CSS custom properties,
 *                   and 3) the ponyfill execution time in milliseconds.
 * @example
 *
 *   cssVars({
 *     rootElement   : document,
 *     shadowDOM     : false,
 *     include       : 'style,link[rel="stylesheet"]',
 *     exclude       : '',
 *     variables     : {},
 *     onlyLegacy    : true,
 *     preserveStatic: true,
 *     preserveVars  : false,
 *     silent        : false,
 *     updateDOM     : true,
 *     updateURLs    : true,
 *     watch         : false,
 *     onBeforeSend(xhr, node, url) {},
 *     onError(message, node, xhr, url) {},
 *     onWarning(message) {},
 *     onSuccess(cssText, node, url) {},
 *     onComplete(cssText, styleNode, cssVariables, benchmark) {},
 *     onFinally(hasChanged, hasNativeSupport, benchmark)
 *   });
 */ function cssVars() {
    var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
    var msgPrefix = "cssVars(): ";
    var settings = _extends({}, defaults, options);
    function handleError(message, sourceNode, xhr, url) {
        if (!settings.silent && window.console) {
            console.error("".concat(msgPrefix).concat(message, "\n"), sourceNode);
        }
        settings.onError(message, sourceNode, xhr, url);
    }
    function handleWarning(message) {
        if (!settings.silent && window.console) {
            console.warn("".concat(msgPrefix).concat(message));
        }
        settings.onWarning(message);
    }
    function handleFinally(hasChanged) {
        settings.onFinally(Boolean(hasChanged), isNativeSupport, getTimeStamp() - settings.__benchmark);
    }
    if (!isBrowser) {
        return;
    }
    if (settings.watch) {
        settings.watch = defaults.watch;
        addMutationObserver(settings);
        cssVars(settings);
        return;
    } else if (settings.watch === false && cssVarsObserver) {
        cssVarsObserver.disconnect();
        cssVarsObserver = null;
    }
    if (!settings.__benchmark) {
        if (cssVarsIsRunning === settings.rootElement) {
            cssVarsDebounced(options);
            return;
        }
        settings.__benchmark = getTimeStamp();
        settings.exclude = [ cssVarsObserver ? '[data-cssvars]:not([data-cssvars=""])' : '[data-cssvars="out"]', settings.exclude ].filter((function(selector) {
            return selector;
        })).join(",");
        settings.variables = fixVarNames(settings.variables);
        if (!cssVarsObserver) {
            var outNodes = Array.apply(null, settings.rootElement.querySelectorAll('[data-cssvars="out"]'));
            outNodes.forEach((function(outNode) {
                var dataGroup = outNode.getAttribute("data-cssvars-group");
                var srcNode = dataGroup ? settings.rootElement.querySelector('[data-cssvars="src"][data-cssvars-group="'.concat(dataGroup, '"]')) : null;
                if (!srcNode) {
                    outNode.parentNode.removeChild(outNode);
                }
            }));
            if (cssVarsSrcNodeCount) {
                var srcNodes = settings.rootElement.querySelectorAll('[data-cssvars]:not([data-cssvars="out"])');
                if (srcNodes.length < cssVarsSrcNodeCount) {
                    cssVarsSrcNodeCount = srcNodes.length;
                    variableStore.dom = {};
                }
            }
        }
    }
    if (document.readyState !== "loading") {
        if (isNativeSupport && settings.onlyLegacy) {
            var hasVarChange = false;
            if (settings.updateDOM) {
                var targetElm = settings.rootElement.host || (settings.rootElement === document ? document.documentElement : settings.rootElement);
                Object.keys(settings.variables).forEach((function(key) {
                    var varValue = settings.variables[key];
                    hasVarChange = hasVarChange || varValue !== getComputedStyle(targetElm).getPropertyValue(key);
                    targetElm.style.setProperty(key, varValue);
                }));
            }
            handleFinally(hasVarChange);
        } else if (!isShadowDOMReady && (settings.shadowDOM || settings.rootElement.shadowRoot || settings.rootElement.host)) {
            getCssData({
                rootElement: defaults.rootElement,
                include: defaults.include,
                exclude: settings.exclude,
                skipDisabled: false,
                onSuccess: function onSuccess(cssText, node, url) {
                    cssText = cssText.replace(regex.cssComments, "").replace(regex.cssMediaQueries, "");
                    cssText = (cssText.match(regex.cssVarDeclRules) || []).join("");
                    return cssText || false;
                },
                onComplete: function onComplete(cssText, cssArray, nodeArray) {
                    parseVars(cssText, {
                        store: variableStore.dom,
                        onWarning: handleWarning
                    });
                    isShadowDOMReady = true;
                    cssVars(settings);
                }
            });
        } else {
            cssVarsIsRunning = settings.rootElement;
            getCssData({
                rootElement: settings.rootElement,
                include: settings.include,
                exclude: settings.exclude,
                skipDisabled: false,
                onBeforeSend: settings.onBeforeSend,
                onError: function onError(xhr, node, url) {
                    var responseUrl = xhr.responseURL || getFullUrl$1(url, location.href);
                    var statusText = xhr.statusText ? "(".concat(xhr.statusText, ")") : "Unspecified Error" + (xhr.status === 0 ? " (possibly CORS related)" : "");
                    var errorMsg = "CSS XHR Error: ".concat(responseUrl, " ").concat(xhr.status, " ").concat(statusText);
                    handleError(errorMsg, node, xhr, responseUrl);
                },
                onSuccess: function onSuccess(cssText, node, url) {
                    var returnVal = settings.onSuccess(cssText, node, url);
                    cssText = returnVal !== undefined && Boolean(returnVal) === false ? "" : returnVal || cssText;
                    if (settings.updateURLs) {
                        cssText = fixRelativeCssUrls(cssText, url);
                    }
                    return cssText;
                },
                onComplete: function onComplete(cssText, cssArray) {
                    var nodeArray = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : [];
                    var currentVars = _extends({}, variableStore.dom, variableStore.user);
                    var hasVarChange = false;
                    variableStore.job = {};
                    nodeArray.forEach((function(node, i) {
                        var nodeCSS = cssArray[i];
                        if (regex.cssVars.test(nodeCSS)) {
                            try {
                                var cssTree = parseCss(nodeCSS, {
                                    preserveStatic: settings.preserveStatic,
                                    removeComments: true
                                });
                                parseVars(cssTree, {
                                    parseHost: Boolean(settings.rootElement.host),
                                    store: variableStore.dom,
                                    onWarning: handleWarning
                                });
                                node.__cssVars = {
                                    tree: cssTree
                                };
                            } catch (err) {
                                handleError(err.message, node);
                            }
                        }
                    }));
                    _extends(variableStore.job, variableStore.dom);
                    if (settings.updateDOM) {
                        _extends(variableStore.user, settings.variables);
                        _extends(variableStore.job, variableStore.user);
                    } else {
                        _extends(variableStore.job, variableStore.user, settings.variables);
                        _extends(currentVars, settings.variables);
                    }
                    hasVarChange = counters.job > 0 && Boolean(Object.keys(variableStore.job).length > Object.keys(currentVars).length || Boolean(Object.keys(currentVars).length && Object.keys(variableStore.job).some((function(key) {
                        return variableStore.job[key] !== currentVars[key];
                    }))));
                    if (hasVarChange) {
                        resetCssNodes(settings.rootElement);
                        cssVars(settings);
                    } else {
                        var outCssArray = [];
                        var outNodeArray = [];
                        var hasKeyframesWithVars = false;
                        if (settings.updateDOM) {
                            counters.job++;
                        }
                        nodeArray.forEach((function(node, i) {
                            var isSkip = !node.__cssVars;
                            if (node.__cssVars) {
                                try {
                                    transformCss(node.__cssVars.tree, _extends({}, settings, {
                                        variables: variableStore.job,
                                        onWarning: handleWarning
                                    }));
                                    var outCss = stringifyCss(node.__cssVars.tree);
                                    if (settings.updateDOM) {
                                        var nodeCSS = cssArray[i];
                                        var hasCSSVarFunc = regex.cssVarFunc.test(nodeCSS);
                                        if (!node.getAttribute("data-cssvars")) {
                                            node.setAttribute("data-cssvars", "src");
                                        }
                                        if (outCss.length && hasCSSVarFunc) {
                                            var dataGroup = node.getAttribute("data-cssvars-group") || ++counters.group;
                                            var outCssNoSpaces = outCss.replace(/\s/g, "");
                                            var outNode = settings.rootElement.querySelector('[data-cssvars="out"][data-cssvars-group="'.concat(dataGroup, '"]')) || document.createElement("style");
                                            hasKeyframesWithVars = hasKeyframesWithVars || regex.cssKeyframes.test(outCss);
                                            if (settings.preserveStatic) {
                                                node.sheet.disabled = true;
                                            }
                                            if (!outNode.hasAttribute("data-cssvars")) {
                                                outNode.setAttribute("data-cssvars", "out");
                                            }
                                            if (outCssNoSpaces === node.textContent.replace(/\s/g, "")) {
                                                isSkip = true;
                                                if (outNode && outNode.parentNode) {
                                                    node.removeAttribute("data-cssvars-group");
                                                    outNode.parentNode.removeChild(outNode);
                                                }
                                            } else if (outCssNoSpaces !== outNode.textContent.replace(/\s/g, "")) {
                                                [ node, outNode ].forEach((function(n) {
                                                    n.setAttribute("data-cssvars-job", counters.job);
                                                    n.setAttribute("data-cssvars-group", dataGroup);
                                                }));
                                                outNode.textContent = outCss;
                                                outCssArray.push(outCss);
                                                outNodeArray.push(outNode);
                                                if (!outNode.parentNode) {
                                                    node.parentNode.insertBefore(outNode, node.nextSibling);
                                                }
                                            }
                                        }
                                    } else {
                                        if (node.textContent.replace(/\s/g, "") !== outCss) {
                                            outCssArray.push(outCss);
                                        }
                                    }
                                } catch (err) {
                                    handleError(err.message, node);
                                }
                            }
                            if (isSkip) {
                                node.setAttribute("data-cssvars", "skip");
                            }
                            if (!node.hasAttribute("data-cssvars-job")) {
                                node.setAttribute("data-cssvars-job", counters.job);
                            }
                        }));
                        cssVarsSrcNodeCount = settings.rootElement.querySelectorAll('[data-cssvars]:not([data-cssvars="out"])').length;
                        if (settings.shadowDOM) {
                            var elms = [ settings.rootElement ].concat(_toConsumableArray(settings.rootElement.querySelectorAll("*")));
                            for (var i = 0, elm; elm = elms[i]; ++i) {
                                if (elm.shadowRoot && elm.shadowRoot.querySelector("style")) {
                                    var shadowSettings = _extends({}, settings, {
                                        rootElement: elm.shadowRoot
                                    });
                                    cssVars(shadowSettings);
                                }
                            }
                        }
                        if (settings.updateDOM && hasKeyframesWithVars) {
                            fixKeyframes(settings.rootElement);
                        }
                        cssVarsIsRunning = false;
                        settings.onComplete(outCssArray.join(""), outNodeArray, JSON.parse(JSON.stringify(variableStore.job)), getTimeStamp() - settings.__benchmark);
                        handleFinally(outNodeArray.length);
                    }
                }
            });
        }
    } else {
        document.addEventListener("DOMContentLoaded", (function init(evt) {
            cssVars(options);
            document.removeEventListener("DOMContentLoaded", init);
        }));
    }
}

cssVars.reset = function() {
    counters.job = 0;
    counters.group = 0;
    cssVarsIsRunning = false;
    if (cssVarsObserver) {
        cssVarsObserver.disconnect();
        cssVarsObserver = null;
    }
    cssVarsSrcNodeCount = 0;
    debounceTimer = null;
    isShadowDOMReady = false;
    for (var prop in variableStore) {
        variableStore[prop] = {};
    }
};

function addMutationObserver(settings) {
    function isDisabled(node) {
        var isDisabledAttr = node.hasAttribute("disabled");
        var isDisabledSheet = (node.sheet || {}).disabled;
        return isDisabledAttr || isDisabledSheet;
    }
    function isLink(node) {
        var isStylesheet = node.tagName === "LINK" && (node.getAttribute("rel") || "").indexOf("stylesheet") !== -1;
        return isStylesheet && !isDisabled(node);
    }
    function isStyle(node) {
        return node.tagName === "STYLE" && !isDisabled(node);
    }
    function isValidAddMutation(mutationNodes) {
        return Array.apply(null, mutationNodes).some((function(node) {
            var isElm = node.nodeType === 1;
            var hasAttr = isElm && node.hasAttribute("data-cssvars");
            var isStyleWithVars = isStyle(node) && regex.cssVars.test(node.textContent);
            var isValid = !hasAttr && (isLink(node) || isStyleWithVars);
            return isValid;
        }));
    }
    function isValidRemoveMutation(mutationNodes) {
        return Array.apply(null, mutationNodes).some((function(node) {
            var isElm = node.nodeType === 1;
            var isOutNode = isElm && node.getAttribute("data-cssvars") === "out";
            var isSrcNode = isElm && node.getAttribute("data-cssvars") === "src";
            var isValid = isSrcNode;
            if (isSrcNode || isOutNode) {
                var dataGroup = node.getAttribute("data-cssvars-group");
                var orphanNode = settings.rootElement.querySelector('[data-cssvars-group="'.concat(dataGroup, '"]'));
                if (isSrcNode) {
                    resetCssNodes(settings.rootElement);
                    variableStore.dom = {};
                }
                if (orphanNode) {
                    orphanNode.parentNode.removeChild(orphanNode);
                }
            }
            return isValid;
        }));
    }
    if (!window.MutationObserver) {
        return;
    }
    if (cssVarsObserver) {
        cssVarsObserver.disconnect();
        cssVarsObserver = null;
    }
    cssVarsObserver = new MutationObserver((function(mutations) {
        var hasValidMutation = mutations.some((function(mutation) {
            var isValid = false;
            if (mutation.type === "attributes") {
                isValid = isLink(mutation.target);
            } else if (mutation.type === "childList") {
                isValid = isValidAddMutation(mutation.addedNodes) || isValidRemoveMutation(mutation.removedNodes);
            }
            return isValid;
        }));
        if (hasValidMutation) {
            cssVars(settings);
        }
    }));
    cssVarsObserver.observe(document.documentElement, {
        attributes: true,
        attributeFilter: [ "disabled", "href" ],
        childList: true,
        subtree: true
    });
}

function cssVarsDebounced(settings) {
    var delay = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 100;
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout((function() {
        settings.__benchmark = null;
        cssVars(settings);
    }), delay);
}

function fixKeyframes(rootElement) {
    var animationNameProp = [ "animation-name", "-moz-animation-name", "-webkit-animation-name" ].filter((function(prop) {
        return getComputedStyle(document.body)[prop];
    }))[0];
    if (animationNameProp) {
        var allNodes = rootElement.getElementsByTagName("*");
        var keyframeNodes = [];
        var nameMarker = "__CSSVARSPONYFILL-KEYFRAMES__";
        for (var i = 0, len = allNodes.length; i < len; i++) {
            var node = allNodes[i];
            var animationName = getComputedStyle(node)[animationNameProp];
            if (animationName !== "none") {
                node.style[animationNameProp] += nameMarker;
                keyframeNodes.push(node);
            }
        }
        void document.body.offsetHeight;
        for (var _i = 0, _len = keyframeNodes.length; _i < _len; _i++) {
            var nodeStyle = keyframeNodes[_i].style;
            nodeStyle[animationNameProp] = nodeStyle[animationNameProp].replace(nameMarker, "");
        }
    }
}

function fixRelativeCssUrls(cssText, baseUrl) {
    var cssUrls = cssText.replace(regex.cssComments, "").match(regex.cssUrls) || [];
    cssUrls.forEach((function(cssUrl) {
        var oldUrl = cssUrl.replace(regex.cssUrls, "$1");
        var newUrl = getFullUrl$1(oldUrl, baseUrl);
        cssText = cssText.replace(cssUrl, cssUrl.replace(oldUrl, newUrl));
    }));
    return cssText;
}

function fixVarNames() {
    var varObj = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
    var reLeadingHyphens = /^-{2}/;
    return Object.keys(varObj).reduce((function(obj, value) {
        var key = reLeadingHyphens.test(value) ? value : "--".concat(value.replace(/^-+/, ""));
        obj[key] = varObj[value];
        return obj;
    }), {});
}

function getFullUrl$1(url) {
    var base = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : location.href;
    var d = document.implementation.createHTMLDocument("");
    var b = d.createElement("base");
    var a = d.createElement("a");
    d.head.appendChild(b);
    d.body.appendChild(a);
    b.href = base;
    a.href = url;
    return a.href;
}

function getTimeStamp() {
    return isBrowser && (window.performance || {}).now ? window.performance.now() : (new Date).getTime();
}

function resetCssNodes(rootElement) {
    var resetNodes = Array.apply(null, rootElement.querySelectorAll('[data-cssvars="skip"],[data-cssvars="src"]'));
    resetNodes.forEach((function(node) {
        return node.setAttribute("data-cssvars", "");
    }));
}

/* harmony default export */ __webpack_exports__["default"] = (cssVars);
//# sourceMappingURL=css-vars-ponyfill.esm.js.map


/***/ }),

/***/ "./node_modules/lodash/_Symbol.js":
/*!****************************************!*\
  !*** ./node_modules/lodash/_Symbol.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var root = __webpack_require__(/*! ./_root */ "./node_modules/lodash/_root.js");

/** Built-in value references. */
var Symbol = root.Symbol;

module.exports = Symbol;


/***/ }),

/***/ "./node_modules/lodash/_baseGetTag.js":
/*!********************************************!*\
  !*** ./node_modules/lodash/_baseGetTag.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var Symbol = __webpack_require__(/*! ./_Symbol */ "./node_modules/lodash/_Symbol.js"),
    getRawTag = __webpack_require__(/*! ./_getRawTag */ "./node_modules/lodash/_getRawTag.js"),
    objectToString = __webpack_require__(/*! ./_objectToString */ "./node_modules/lodash/_objectToString.js");

/** `Object#toString` result references. */
var nullTag = '[object Null]',
    undefinedTag = '[object Undefined]';

/** Built-in value references. */
var symToStringTag = Symbol ? Symbol.toStringTag : undefined;

/**
 * The base implementation of `getTag` without fallbacks for buggy environments.
 *
 * @private
 * @param {*} value The value to query.
 * @returns {string} Returns the `toStringTag`.
 */
function baseGetTag(value) {
  if (value == null) {
    return value === undefined ? undefinedTag : nullTag;
  }
  return (symToStringTag && symToStringTag in Object(value))
    ? getRawTag(value)
    : objectToString(value);
}

module.exports = baseGetTag;


/***/ }),

/***/ "./node_modules/lodash/_freeGlobal.js":
/*!********************************************!*\
  !*** ./node_modules/lodash/_freeGlobal.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {/** Detect free variable `global` from Node.js. */
var freeGlobal = typeof global == 'object' && global && global.Object === Object && global;

module.exports = freeGlobal;

/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../webpack/buildin/global.js */ "./node_modules/webpack/buildin/global.js")))

/***/ }),

/***/ "./node_modules/lodash/_getRawTag.js":
/*!*******************************************!*\
  !*** ./node_modules/lodash/_getRawTag.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var Symbol = __webpack_require__(/*! ./_Symbol */ "./node_modules/lodash/_Symbol.js");

/** Used for built-in method references. */
var objectProto = Object.prototype;

/** Used to check objects for own properties. */
var hasOwnProperty = objectProto.hasOwnProperty;

/**
 * Used to resolve the
 * [`toStringTag`](http://ecma-international.org/ecma-262/7.0/#sec-object.prototype.tostring)
 * of values.
 */
var nativeObjectToString = objectProto.toString;

/** Built-in value references. */
var symToStringTag = Symbol ? Symbol.toStringTag : undefined;

/**
 * A specialized version of `baseGetTag` which ignores `Symbol.toStringTag` values.
 *
 * @private
 * @param {*} value The value to query.
 * @returns {string} Returns the raw `toStringTag`.
 */
function getRawTag(value) {
  var isOwn = hasOwnProperty.call(value, symToStringTag),
      tag = value[symToStringTag];

  try {
    value[symToStringTag] = undefined;
    var unmasked = true;
  } catch (e) {}

  var result = nativeObjectToString.call(value);
  if (unmasked) {
    if (isOwn) {
      value[symToStringTag] = tag;
    } else {
      delete value[symToStringTag];
    }
  }
  return result;
}

module.exports = getRawTag;


/***/ }),

/***/ "./node_modules/lodash/_objectToString.js":
/*!************************************************!*\
  !*** ./node_modules/lodash/_objectToString.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/** Used for built-in method references. */
var objectProto = Object.prototype;

/**
 * Used to resolve the
 * [`toStringTag`](http://ecma-international.org/ecma-262/7.0/#sec-object.prototype.tostring)
 * of values.
 */
var nativeObjectToString = objectProto.toString;

/**
 * Converts `value` to a string using `Object.prototype.toString`.
 *
 * @private
 * @param {*} value The value to convert.
 * @returns {string} Returns the converted string.
 */
function objectToString(value) {
  return nativeObjectToString.call(value);
}

module.exports = objectToString;


/***/ }),

/***/ "./node_modules/lodash/_root.js":
/*!**************************************!*\
  !*** ./node_modules/lodash/_root.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var freeGlobal = __webpack_require__(/*! ./_freeGlobal */ "./node_modules/lodash/_freeGlobal.js");

/** Detect free variable `self`. */
var freeSelf = typeof self == 'object' && self && self.Object === Object && self;

/** Used as a reference to the global object. */
var root = freeGlobal || freeSelf || Function('return this')();

module.exports = root;


/***/ }),

/***/ "./node_modules/lodash/debounce.js":
/*!*****************************************!*\
  !*** ./node_modules/lodash/debounce.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(/*! ./isObject */ "./node_modules/lodash/isObject.js"),
    now = __webpack_require__(/*! ./now */ "./node_modules/lodash/now.js"),
    toNumber = __webpack_require__(/*! ./toNumber */ "./node_modules/lodash/toNumber.js");

/** Error message constants. */
var FUNC_ERROR_TEXT = 'Expected a function';

/* Built-in method references for those with the same name as other `lodash` methods. */
var nativeMax = Math.max,
    nativeMin = Math.min;

/**
 * Creates a debounced function that delays invoking `func` until after `wait`
 * milliseconds have elapsed since the last time the debounced function was
 * invoked. The debounced function comes with a `cancel` method to cancel
 * delayed `func` invocations and a `flush` method to immediately invoke them.
 * Provide `options` to indicate whether `func` should be invoked on the
 * leading and/or trailing edge of the `wait` timeout. The `func` is invoked
 * with the last arguments provided to the debounced function. Subsequent
 * calls to the debounced function return the result of the last `func`
 * invocation.
 *
 * **Note:** If `leading` and `trailing` options are `true`, `func` is
 * invoked on the trailing edge of the timeout only if the debounced function
 * is invoked more than once during the `wait` timeout.
 *
 * If `wait` is `0` and `leading` is `false`, `func` invocation is deferred
 * until to the next tick, similar to `setTimeout` with a timeout of `0`.
 *
 * See [David Corbacho's article](https://css-tricks.com/debouncing-throttling-explained-examples/)
 * for details over the differences between `_.debounce` and `_.throttle`.
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Function
 * @param {Function} func The function to debounce.
 * @param {number} [wait=0] The number of milliseconds to delay.
 * @param {Object} [options={}] The options object.
 * @param {boolean} [options.leading=false]
 *  Specify invoking on the leading edge of the timeout.
 * @param {number} [options.maxWait]
 *  The maximum time `func` is allowed to be delayed before it's invoked.
 * @param {boolean} [options.trailing=true]
 *  Specify invoking on the trailing edge of the timeout.
 * @returns {Function} Returns the new debounced function.
 * @example
 *
 * // Avoid costly calculations while the window size is in flux.
 * jQuery(window).on('resize', _.debounce(calculateLayout, 150));
 *
 * // Invoke `sendMail` when clicked, debouncing subsequent calls.
 * jQuery(element).on('click', _.debounce(sendMail, 300, {
 *   'leading': true,
 *   'trailing': false
 * }));
 *
 * // Ensure `batchLog` is invoked once after 1 second of debounced calls.
 * var debounced = _.debounce(batchLog, 250, { 'maxWait': 1000 });
 * var source = new EventSource('/stream');
 * jQuery(source).on('message', debounced);
 *
 * // Cancel the trailing debounced invocation.
 * jQuery(window).on('popstate', debounced.cancel);
 */
function debounce(func, wait, options) {
  var lastArgs,
      lastThis,
      maxWait,
      result,
      timerId,
      lastCallTime,
      lastInvokeTime = 0,
      leading = false,
      maxing = false,
      trailing = true;

  if (typeof func != 'function') {
    throw new TypeError(FUNC_ERROR_TEXT);
  }
  wait = toNumber(wait) || 0;
  if (isObject(options)) {
    leading = !!options.leading;
    maxing = 'maxWait' in options;
    maxWait = maxing ? nativeMax(toNumber(options.maxWait) || 0, wait) : maxWait;
    trailing = 'trailing' in options ? !!options.trailing : trailing;
  }

  function invokeFunc(time) {
    var args = lastArgs,
        thisArg = lastThis;

    lastArgs = lastThis = undefined;
    lastInvokeTime = time;
    result = func.apply(thisArg, args);
    return result;
  }

  function leadingEdge(time) {
    // Reset any `maxWait` timer.
    lastInvokeTime = time;
    // Start the timer for the trailing edge.
    timerId = setTimeout(timerExpired, wait);
    // Invoke the leading edge.
    return leading ? invokeFunc(time) : result;
  }

  function remainingWait(time) {
    var timeSinceLastCall = time - lastCallTime,
        timeSinceLastInvoke = time - lastInvokeTime,
        timeWaiting = wait - timeSinceLastCall;

    return maxing
      ? nativeMin(timeWaiting, maxWait - timeSinceLastInvoke)
      : timeWaiting;
  }

  function shouldInvoke(time) {
    var timeSinceLastCall = time - lastCallTime,
        timeSinceLastInvoke = time - lastInvokeTime;

    // Either this is the first call, activity has stopped and we're at the
    // trailing edge, the system time has gone backwards and we're treating
    // it as the trailing edge, or we've hit the `maxWait` limit.
    return (lastCallTime === undefined || (timeSinceLastCall >= wait) ||
      (timeSinceLastCall < 0) || (maxing && timeSinceLastInvoke >= maxWait));
  }

  function timerExpired() {
    var time = now();
    if (shouldInvoke(time)) {
      return trailingEdge(time);
    }
    // Restart the timer.
    timerId = setTimeout(timerExpired, remainingWait(time));
  }

  function trailingEdge(time) {
    timerId = undefined;

    // Only invoke if we have `lastArgs` which means `func` has been
    // debounced at least once.
    if (trailing && lastArgs) {
      return invokeFunc(time);
    }
    lastArgs = lastThis = undefined;
    return result;
  }

  function cancel() {
    if (timerId !== undefined) {
      clearTimeout(timerId);
    }
    lastInvokeTime = 0;
    lastArgs = lastCallTime = lastThis = timerId = undefined;
  }

  function flush() {
    return timerId === undefined ? result : trailingEdge(now());
  }

  function debounced() {
    var time = now(),
        isInvoking = shouldInvoke(time);

    lastArgs = arguments;
    lastThis = this;
    lastCallTime = time;

    if (isInvoking) {
      if (timerId === undefined) {
        return leadingEdge(lastCallTime);
      }
      if (maxing) {
        // Handle invocations in a tight loop.
        clearTimeout(timerId);
        timerId = setTimeout(timerExpired, wait);
        return invokeFunc(lastCallTime);
      }
    }
    if (timerId === undefined) {
      timerId = setTimeout(timerExpired, wait);
    }
    return result;
  }
  debounced.cancel = cancel;
  debounced.flush = flush;
  return debounced;
}

module.exports = debounce;


/***/ }),

/***/ "./node_modules/lodash/isObject.js":
/*!*****************************************!*\
  !*** ./node_modules/lodash/isObject.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * Checks if `value` is the
 * [language type](http://www.ecma-international.org/ecma-262/7.0/#sec-ecmascript-language-types)
 * of `Object`. (e.g. arrays, functions, objects, regexes, `new Number(0)`, and `new String('')`)
 *
 * @static
 * @memberOf _
 * @since 0.1.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is an object, else `false`.
 * @example
 *
 * _.isObject({});
 * // => true
 *
 * _.isObject([1, 2, 3]);
 * // => true
 *
 * _.isObject(_.noop);
 * // => true
 *
 * _.isObject(null);
 * // => false
 */
function isObject(value) {
  var type = typeof value;
  return value != null && (type == 'object' || type == 'function');
}

module.exports = isObject;


/***/ }),

/***/ "./node_modules/lodash/isObjectLike.js":
/*!*********************************************!*\
  !*** ./node_modules/lodash/isObjectLike.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * Checks if `value` is object-like. A value is object-like if it's not `null`
 * and has a `typeof` result of "object".
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is object-like, else `false`.
 * @example
 *
 * _.isObjectLike({});
 * // => true
 *
 * _.isObjectLike([1, 2, 3]);
 * // => true
 *
 * _.isObjectLike(_.noop);
 * // => false
 *
 * _.isObjectLike(null);
 * // => false
 */
function isObjectLike(value) {
  return value != null && typeof value == 'object';
}

module.exports = isObjectLike;


/***/ }),

/***/ "./node_modules/lodash/isSymbol.js":
/*!*****************************************!*\
  !*** ./node_modules/lodash/isSymbol.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var baseGetTag = __webpack_require__(/*! ./_baseGetTag */ "./node_modules/lodash/_baseGetTag.js"),
    isObjectLike = __webpack_require__(/*! ./isObjectLike */ "./node_modules/lodash/isObjectLike.js");

/** `Object#toString` result references. */
var symbolTag = '[object Symbol]';

/**
 * Checks if `value` is classified as a `Symbol` primitive or object.
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to check.
 * @returns {boolean} Returns `true` if `value` is a symbol, else `false`.
 * @example
 *
 * _.isSymbol(Symbol.iterator);
 * // => true
 *
 * _.isSymbol('abc');
 * // => false
 */
function isSymbol(value) {
  return typeof value == 'symbol' ||
    (isObjectLike(value) && baseGetTag(value) == symbolTag);
}

module.exports = isSymbol;


/***/ }),

/***/ "./node_modules/lodash/now.js":
/*!************************************!*\
  !*** ./node_modules/lodash/now.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var root = __webpack_require__(/*! ./_root */ "./node_modules/lodash/_root.js");

/**
 * Gets the timestamp of the number of milliseconds that have elapsed since
 * the Unix epoch (1 January 1970 00:00:00 UTC).
 *
 * @static
 * @memberOf _
 * @since 2.4.0
 * @category Date
 * @returns {number} Returns the timestamp.
 * @example
 *
 * _.defer(function(stamp) {
 *   console.log(_.now() - stamp);
 * }, _.now());
 * // => Logs the number of milliseconds it took for the deferred invocation.
 */
var now = function() {
  return root.Date.now();
};

module.exports = now;


/***/ }),

/***/ "./node_modules/lodash/toNumber.js":
/*!*****************************************!*\
  !*** ./node_modules/lodash/toNumber.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(/*! ./isObject */ "./node_modules/lodash/isObject.js"),
    isSymbol = __webpack_require__(/*! ./isSymbol */ "./node_modules/lodash/isSymbol.js");

/** Used as references for various `Number` constants. */
var NAN = 0 / 0;

/** Used to match leading and trailing whitespace. */
var reTrim = /^\s+|\s+$/g;

/** Used to detect bad signed hexadecimal string values. */
var reIsBadHex = /^[-+]0x[0-9a-f]+$/i;

/** Used to detect binary string values. */
var reIsBinary = /^0b[01]+$/i;

/** Used to detect octal string values. */
var reIsOctal = /^0o[0-7]+$/i;

/** Built-in method references without a dependency on `root`. */
var freeParseInt = parseInt;

/**
 * Converts `value` to a number.
 *
 * @static
 * @memberOf _
 * @since 4.0.0
 * @category Lang
 * @param {*} value The value to process.
 * @returns {number} Returns the number.
 * @example
 *
 * _.toNumber(3.2);
 * // => 3.2
 *
 * _.toNumber(Number.MIN_VALUE);
 * // => 5e-324
 *
 * _.toNumber(Infinity);
 * // => Infinity
 *
 * _.toNumber('3.2');
 * // => 3.2
 */
function toNumber(value) {
  if (typeof value == 'number') {
    return value;
  }
  if (isSymbol(value)) {
    return NAN;
  }
  if (isObject(value)) {
    var other = typeof value.valueOf == 'function' ? value.valueOf() : value;
    value = isObject(other) ? (other + '') : other;
  }
  if (typeof value != 'string') {
    return value === 0 ? value : +value;
  }
  value = value.replace(reTrim, '');
  var isBinary = reIsBinary.test(value);
  return (isBinary || reIsOctal.test(value))
    ? freeParseInt(value.slice(2), isBinary ? 2 : 8)
    : (reIsBadHex.test(value) ? NAN : +value);
}

module.exports = toNumber;


/***/ }),

/***/ "./node_modules/webpack/buildin/global.js":
/*!***********************************!*\
  !*** (webpack)/buildin/global.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

var g;

// This works in non-strict mode
g = (function() {
	return this;
})();

try {
	// This works if eval is allowed (see CSP)
	g = g || new Function("return this")();
} catch (e) {
	// This works if the window reference is available
	if (typeof window === "object") g = window;
}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

module.exports = g;


/***/ })

/******/ });
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoianMvZnJvbnRlbmQuanMiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vd2VicGFjay9ib290c3RyYXAiLCJ3ZWJwYWNrOi8vLy4vLmRldi9hc3NldHMvc2hhcmVkL2pzL2Zyb250ZW5kL2NvbXBvbmVudHMvcHJpbWFyeS1tZW51LmpzIiwid2VicGFjazovLy8uLy5kZXYvYXNzZXRzL3NoYXJlZC9qcy9mcm9udGVuZC9jb21wb25lbnRzL3NlYXJjaC10b2dnbGUuanMiLCJ3ZWJwYWNrOi8vLy4vLmRldi9hc3NldHMvc2hhcmVkL2pzL2Zyb250ZW5kL2NvbXBvbmVudHMvd29vLW1lbnUtY2FydC5qcyIsIndlYnBhY2s6Ly8vLi8uZGV2L2Fzc2V0cy9zaGFyZWQvanMvZnJvbnRlbmQvZnJvbnRlbmQuanMiLCJ3ZWJwYWNrOi8vLy4vLmRldi9hc3NldHMvc2hhcmVkL2pzL2Zyb250ZW5kL3ZlbmRvci9yZXNwb25zaXZlLW5hdi5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY3NzLXZhcnMtcG9ueWZpbGwvZGlzdC9jc3MtdmFycy1wb255ZmlsbC5lc20uanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2xvZGFzaC9fU3ltYm9sLmpzIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9sb2Rhc2gvX2Jhc2VHZXRUYWcuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2xvZGFzaC9fZnJlZUdsb2JhbC5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvbG9kYXNoL19nZXRSYXdUYWcuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2xvZGFzaC9fb2JqZWN0VG9TdHJpbmcuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2xvZGFzaC9fcm9vdC5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvbG9kYXNoL2RlYm91bmNlLmpzIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9sb2Rhc2gvaXNPYmplY3QuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2xvZGFzaC9pc09iamVjdExpa2UuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2xvZGFzaC9pc1N5bWJvbC5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvbG9kYXNoL25vdy5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvbG9kYXNoL3RvTnVtYmVyLmpzIiwid2VicGFjazovLy8od2VicGFjaykvYnVpbGRpbi9nbG9iYWwuanMiXSwic291cmNlc0NvbnRlbnQiOlsiIFx0Ly8gVGhlIG1vZHVsZSBjYWNoZVxuIFx0dmFyIGluc3RhbGxlZE1vZHVsZXMgPSB7fTtcblxuIFx0Ly8gVGhlIHJlcXVpcmUgZnVuY3Rpb25cbiBcdGZ1bmN0aW9uIF9fd2VicGFja19yZXF1aXJlX18obW9kdWxlSWQpIHtcblxuIFx0XHQvLyBDaGVjayBpZiBtb2R1bGUgaXMgaW4gY2FjaGVcbiBcdFx0aWYoaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0pIHtcbiBcdFx0XHRyZXR1cm4gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0uZXhwb3J0cztcbiBcdFx0fVxuIFx0XHQvLyBDcmVhdGUgYSBuZXcgbW9kdWxlIChhbmQgcHV0IGl0IGludG8gdGhlIGNhY2hlKVxuIFx0XHR2YXIgbW9kdWxlID0gaW5zdGFsbGVkTW9kdWxlc1ttb2R1bGVJZF0gPSB7XG4gXHRcdFx0aTogbW9kdWxlSWQsXG4gXHRcdFx0bDogZmFsc2UsXG4gXHRcdFx0ZXhwb3J0czoge31cbiBcdFx0fTtcblxuIFx0XHQvLyBFeGVjdXRlIHRoZSBtb2R1bGUgZnVuY3Rpb25cbiBcdFx0bW9kdWxlc1ttb2R1bGVJZF0uY2FsbChtb2R1bGUuZXhwb3J0cywgbW9kdWxlLCBtb2R1bGUuZXhwb3J0cywgX193ZWJwYWNrX3JlcXVpcmVfXyk7XG5cbiBcdFx0Ly8gRmxhZyB0aGUgbW9kdWxlIGFzIGxvYWRlZFxuIFx0XHRtb2R1bGUubCA9IHRydWU7XG5cbiBcdFx0Ly8gUmV0dXJuIHRoZSBleHBvcnRzIG9mIHRoZSBtb2R1bGVcbiBcdFx0cmV0dXJuIG1vZHVsZS5leHBvcnRzO1xuIFx0fVxuXG5cbiBcdC8vIGV4cG9zZSB0aGUgbW9kdWxlcyBvYmplY3QgKF9fd2VicGFja19tb2R1bGVzX18pXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLm0gPSBtb2R1bGVzO1xuXG4gXHQvLyBleHBvc2UgdGhlIG1vZHVsZSBjYWNoZVxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5jID0gaW5zdGFsbGVkTW9kdWxlcztcblxuIFx0Ly8gZGVmaW5lIGdldHRlciBmdW5jdGlvbiBmb3IgaGFybW9ueSBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLmQgPSBmdW5jdGlvbihleHBvcnRzLCBuYW1lLCBnZXR0ZXIpIHtcbiBcdFx0aWYoIV9fd2VicGFja19yZXF1aXJlX18ubyhleHBvcnRzLCBuYW1lKSkge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBuYW1lLCB7IGVudW1lcmFibGU6IHRydWUsIGdldDogZ2V0dGVyIH0pO1xuIFx0XHR9XG4gXHR9O1xuXG4gXHQvLyBkZWZpbmUgX19lc01vZHVsZSBvbiBleHBvcnRzXG4gXHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIgPSBmdW5jdGlvbihleHBvcnRzKSB7XG4gXHRcdGlmKHR5cGVvZiBTeW1ib2wgIT09ICd1bmRlZmluZWQnICYmIFN5bWJvbC50b1N0cmluZ1RhZykge1xuIFx0XHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCBTeW1ib2wudG9TdHJpbmdUYWcsIHsgdmFsdWU6ICdNb2R1bGUnIH0pO1xuIFx0XHR9XG4gXHRcdE9iamVjdC5kZWZpbmVQcm9wZXJ0eShleHBvcnRzLCAnX19lc01vZHVsZScsIHsgdmFsdWU6IHRydWUgfSk7XG4gXHR9O1xuXG4gXHQvLyBjcmVhdGUgYSBmYWtlIG5hbWVzcGFjZSBvYmplY3RcbiBcdC8vIG1vZGUgJiAxOiB2YWx1ZSBpcyBhIG1vZHVsZSBpZCwgcmVxdWlyZSBpdFxuIFx0Ly8gbW9kZSAmIDI6IG1lcmdlIGFsbCBwcm9wZXJ0aWVzIG9mIHZhbHVlIGludG8gdGhlIG5zXG4gXHQvLyBtb2RlICYgNDogcmV0dXJuIHZhbHVlIHdoZW4gYWxyZWFkeSBucyBvYmplY3RcbiBcdC8vIG1vZGUgJiA4fDE6IGJlaGF2ZSBsaWtlIHJlcXVpcmVcbiBcdF9fd2VicGFja19yZXF1aXJlX18udCA9IGZ1bmN0aW9uKHZhbHVlLCBtb2RlKSB7XG4gXHRcdGlmKG1vZGUgJiAxKSB2YWx1ZSA9IF9fd2VicGFja19yZXF1aXJlX18odmFsdWUpO1xuIFx0XHRpZihtb2RlICYgOCkgcmV0dXJuIHZhbHVlO1xuIFx0XHRpZigobW9kZSAmIDQpICYmIHR5cGVvZiB2YWx1ZSA9PT0gJ29iamVjdCcgJiYgdmFsdWUgJiYgdmFsdWUuX19lc01vZHVsZSkgcmV0dXJuIHZhbHVlO1xuIFx0XHR2YXIgbnMgPSBPYmplY3QuY3JlYXRlKG51bGwpO1xuIFx0XHRfX3dlYnBhY2tfcmVxdWlyZV9fLnIobnMpO1xuIFx0XHRPYmplY3QuZGVmaW5lUHJvcGVydHkobnMsICdkZWZhdWx0JywgeyBlbnVtZXJhYmxlOiB0cnVlLCB2YWx1ZTogdmFsdWUgfSk7XG4gXHRcdGlmKG1vZGUgJiAyICYmIHR5cGVvZiB2YWx1ZSAhPSAnc3RyaW5nJykgZm9yKHZhciBrZXkgaW4gdmFsdWUpIF9fd2VicGFja19yZXF1aXJlX18uZChucywga2V5LCBmdW5jdGlvbihrZXkpIHsgcmV0dXJuIHZhbHVlW2tleV07IH0uYmluZChudWxsLCBrZXkpKTtcbiBcdFx0cmV0dXJuIG5zO1xuIFx0fTtcblxuIFx0Ly8gZ2V0RGVmYXVsdEV4cG9ydCBmdW5jdGlvbiBmb3IgY29tcGF0aWJpbGl0eSB3aXRoIG5vbi1oYXJtb255IG1vZHVsZXNcbiBcdF9fd2VicGFja19yZXF1aXJlX18ubiA9IGZ1bmN0aW9uKG1vZHVsZSkge1xuIFx0XHR2YXIgZ2V0dGVyID0gbW9kdWxlICYmIG1vZHVsZS5fX2VzTW9kdWxlID9cbiBcdFx0XHRmdW5jdGlvbiBnZXREZWZhdWx0KCkgeyByZXR1cm4gbW9kdWxlWydkZWZhdWx0J107IH0gOlxuIFx0XHRcdGZ1bmN0aW9uIGdldE1vZHVsZUV4cG9ydHMoKSB7IHJldHVybiBtb2R1bGU7IH07XG4gXHRcdF9fd2VicGFja19yZXF1aXJlX18uZChnZXR0ZXIsICdhJywgZ2V0dGVyKTtcbiBcdFx0cmV0dXJuIGdldHRlcjtcbiBcdH07XG5cbiBcdC8vIE9iamVjdC5wcm90b3R5cGUuaGFzT3duUHJvcGVydHkuY2FsbFxuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5vID0gZnVuY3Rpb24ob2JqZWN0LCBwcm9wZXJ0eSkgeyByZXR1cm4gT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKG9iamVjdCwgcHJvcGVydHkpOyB9O1xuXG4gXHQvLyBfX3dlYnBhY2tfcHVibGljX3BhdGhfX1xuIFx0X193ZWJwYWNrX3JlcXVpcmVfXy5wID0gXCJcIjtcblxuXG4gXHQvLyBMb2FkIGVudHJ5IG1vZHVsZSBhbmQgcmV0dXJuIGV4cG9ydHNcbiBcdHJldHVybiBfX3dlYnBhY2tfcmVxdWlyZV9fKF9fd2VicGFja19yZXF1aXJlX18ucyA9IFwiLi8uZGV2L2Fzc2V0cy9zaGFyZWQvanMvZnJvbnRlbmQvZnJvbnRlbmQuanNcIik7XG4iLCIvKiBnbG9iYWwgVGVuVXAgKi9cbmltcG9ydCAnLi4vdmVuZG9yL3Jlc3BvbnNpdmUtbmF2JztcblxuLyoqXG4gKiBIb29rIHVwIG5hdmlnYXRpb24uXG4gKi9cbmNvbnN0IGluaXQgPSAoKSA9PiB7XG5cdGlmICggVGVuVXAgKSB7XG5cdFx0VGVuVXAubmF2aWdhdGlvbigge1xuXHRcdFx0dGFyZ2V0OiAnI2hlYWRlcl9fbmF2aWdhdGlvbicsXG5cdFx0XHR0b2dnbGU6ICcjbmF2LXRvZ2dsZScsXG5cdFx0XHQvLyBlc2xpbnQtZGlzYWJsZS1uZXh0LWxpbmVcblx0XHRcdHN1Yl9tZW51X29wZW46ICdjbGljaydcblx0XHR9ICk7XG5cdH1cblxuXHRkb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCAna2V5ZG93bicsIGxvY2tNZW51Rm9jdXMgKTtcbn07XG5cbi8qKlxuICogTG9jayB0YWJiaW5nIHRvIHRoZSBtYWluIG5hdmlnYXRpb24gb25seS5cbiAqL1xuZnVuY3Rpb24gbG9ja01lbnVGb2N1cyggZXZ0ICkge1xuXHR2YXIgZSA9IGV2ZW50IHx8IGV2dDsgLy8gZm9yIGNyb3NzLWJyb3dzZXIgY29tcGF0aWJpbGl0eVxuXHR2YXIgY2hhckNvZGUgPSBlLndoaWNoIHx8IGUua2V5Q29kZTtcblxuXHRpZiAoIGNoYXJDb2RlICE9PSA5IHx8ICEgalF1ZXJ5KCAnYm9keScgKS5oYXNDbGFzcyggJ21lbnUtaXMtb3BlbicgKSApIHtcblx0XHRyZXR1cm47XG5cdH1cblxuXHR2YXIgJGVsZW1lbnQgICAgICAgPSBqUXVlcnkoICc6Zm9jdXMnICksXG5cdCAgICBtYWluTWVudUxlbmd0aCA9IGpRdWVyeSggJ3VsLnByaW1hcnktbWVudScgKS5jaGlsZHJlbigpLmxlbmd0aCxcblx0ICAgIGN1cnJlbnRJbmRleCAgID0galF1ZXJ5KCAkZWxlbWVudCApLmNsb3Nlc3QoICdsaScgKS5pbmRleCgpLFxuXHQgICAgaXNTaGlmdFRhYiAgICAgPSAoIGV2ZW50LnNoaWZ0S2V5ICYmIGV2ZW50LmtleUNvZGUgPT0gOSApO1xuXG5cdGlmICggJGVsZW1lbnQuY2xvc2VzdCggJ3VsJyApLmhhc0NsYXNzKCAnc3ViLW1lbnUnICkgKSB7XG5cdFx0cmV0dXJuO1xuXHR9XG5cblx0Y3VycmVudEluZGV4ID0gaXNTaGlmdFRhYiA/IGN1cnJlbnRJbmRleCAtIDEgOiBjdXJyZW50SW5kZXggKyAxO1xuXG5cdGlmICggJGVsZW1lbnQuYXR0ciggJ2lkJyApID09PSAnbmF2LXRvZ2dsZScgKSB7XG5cdFx0aWYgKCBpc1NoaWZ0VGFiICkge1xuXHRcdFx0cmV0dXJuO1xuXHRcdH1cblx0XHRzZXRUaW1lb3V0KCBmdW5jdGlvbigpIHtcblx0XHRcdGpRdWVyeSggJ3VsLnByaW1hcnktbWVudSBsaTpmaXJzdC1jaGlsZCBhJyApWzBdLmZvY3VzKCk7XG5cdFx0fSwgMTAgKTtcblx0fVxuXG5cdC8vIE1lbnUgbGlua1xuXHRpZiAoICRlbGVtZW50LnBhcmVudHMoICd1bC5wcmltYXJ5LW1lbnUnICkubGVuZ3RoID4gMCApIHtcblx0XHRpZiAoICggY3VycmVudEluZGV4IDwgMCAmJiBpc1NoaWZ0VGFiICkgfHwgKCBjdXJyZW50SW5kZXggPT09IG1haW5NZW51TGVuZ3RoICkgKSB7XG5cdFx0XHRzZXRUaW1lb3V0KCBmdW5jdGlvbigpIHtcblx0XHRcdFx0alF1ZXJ5KCAnI25hdi10b2dnbGUnICkuZm9jdXMoKTtcblx0XHRcdH0sIDEwICk7XG5cdFx0fVxuXHR9XG59O1xuXG5leHBvcnQgZGVmYXVsdCBpbml0O1xuIiwiY29uc3Qgc2VhcmNoVG9nZ2xlID0gKCkgPT4ge1xuXHRjb25zdCBzZWFyY2hUb2dnbGUgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCggJ2hlYWRlcl9fc2VhcmNoLXRvZ2dsZScgKTtcblxuXHRpZiAoICEgc2VhcmNoVG9nZ2xlICkge1xuXHRcdHJldHVybjtcblx0fVxuXG5cdGNvbnN0IHBlcmZvcm1Ub2dnbGUgPSAoIGVsZW1lbnQgKSA9PiB7XG5cdFx0Y29uc3QgdG9nZ2xlID0gZWxlbWVudDtcblx0XHRjb25zdCB0YXJnZXQgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCB0b2dnbGUuZGF0YXNldC50b2dnbGVUYXJnZXQgKTtcblxuXHRcdGlmICggdGFyZ2V0LmNsYXNzTGlzdC5jb250YWlucyggJ3Nob3ctbW9kYWwnICkgKSB7XG5cdFx0XHQvLyBIaWRlIHRoZSBtb2RhbC5cblx0XHRcdHRhcmdldC5jbGFzc0xpc3QucmVtb3ZlKCAnYWN0aXZlJyApO1xuXG5cdFx0XHRzZXRUaW1lb3V0KCAoKSA9PiB7XG5cdFx0XHRcdHRhcmdldC5jbGFzc0xpc3QucmVtb3ZlKCAnc2hvdy1tb2RhbCcgKTtcblx0XHRcdFx0dG9nZ2xlLmZvY3VzKCk7XG5cdFx0XHR9LCAyNTAgKTtcblx0XHR9IGVsc2Uge1xuXHRcdFx0Ly8gU2hvdyB0aGUgbW9kYWwuXG5cdFx0XHR0YXJnZXQuY2xhc3NMaXN0LmFkZCggJ3Nob3ctbW9kYWwnICk7XG5cblx0XHRcdHNldFRpbWVvdXQoICgpID0+IHtcblx0XHRcdFx0dGFyZ2V0LmNsYXNzTGlzdC5hZGQoICdhY3RpdmUnICk7XG5cblx0XHRcdFx0aWYgKCB0b2dnbGUuZGF0YXNldC5zZXRGb2N1cyApIHtcblx0XHRcdFx0XHRjb25zdCBmb2N1c0VsZW1lbnQgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCB0b2dnbGUuZGF0YXNldC5zZXRGb2N1cyApO1xuXG5cdFx0XHRcdFx0aWYgKCBmb2N1c0VsZW1lbnQgKSB7XG5cdFx0XHRcdFx0XHR2YXIgc2VhcmNoVGVybSA9IGZvY3VzRWxlbWVudC52YWx1ZTtcblx0XHRcdFx0XHRcdGZvY3VzRWxlbWVudC52YWx1ZSA9ICcnO1xuXHRcdFx0XHRcdFx0Zm9jdXNFbGVtZW50LmZvY3VzKCk7XG5cdFx0XHRcdFx0XHRmb2N1c0VsZW1lbnQudmFsdWUgPSBzZWFyY2hUZXJtO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXHRcdFx0fSwgMTAgKTtcblx0XHR9XG5cdH07XG5cblx0ZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCggJypbZGF0YS10b2dnbGUtdGFyZ2V0XScgKS5mb3JFYWNoKCBlbGVtZW50ID0+IHtcblx0XHRlbGVtZW50LmFkZEV2ZW50TGlzdGVuZXIoICdjbGljaycsIGV2ZW50ID0+IHtcblx0XHRcdGV2ZW50LnByZXZlbnREZWZhdWx0KCk7XG5cdFx0XHRwZXJmb3JtVG9nZ2xlKCBlbGVtZW50ICk7XG5cdFx0fSApO1xuXHR9ICk7XG5cblx0Ly8gQ2xvc2UgbW9kYWwgb24gZXNjYXBlIGtleSBwcmVzcy5cblx0ZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lciggJ2tleXVwJywgZXZlbnQgPT4ge1xuXHRcdGlmICggZXZlbnQua2V5Q29kZSA9PT0gMjcgKSB7XG5cdFx0XHRldmVudC5wcmV2ZW50RGVmYXVsdCgpO1xuXHRcdFx0ZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCggJy5zZWFyY2gtbW9kYWwuYWN0aXZlJyApLmZvckVhY2goIGVsZW1lbnQgPT4ge1xuXHRcdFx0XHRwZXJmb3JtVG9nZ2xlKFxuXHRcdFx0XHRcdGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoICcqW2RhdGEtdG9nZ2xlLXRhcmdldD1cIicgKyBlbGVtZW50LmRhdGFzZXQubW9kYWxUYXJnZXRTdHJpbmcgKyAnXCJdJyApXG5cdFx0XHRcdCk7XG5cdFx0XHR9ICk7XG5cdFx0fVxuXHR9ICk7XG5cblx0Ly8gQ2xvc2UgbW9kYWwgb24gb3V0c2lkZSBjbGljay5cblx0ZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lciggJ2NsaWNrJywgZXZlbnQgPT4ge1xuXHRcdGNvbnN0IHRhcmdldCA9IGV2ZW50LnRhcmdldDtcblx0XHRjb25zdCBtb2RhbCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoICcuc2VhcmNoLW1vZGFsLmFjdGl2ZScgKTtcblxuXHRcdGlmICggdGFyZ2V0ID09PSBtb2RhbCApIHtcblx0XHRcdHBlcmZvcm1Ub2dnbGUoXG5cdFx0XHRcdGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoICcqW2RhdGEtdG9nZ2xlLXRhcmdldD1cIicgKyBtb2RhbC5kYXRhc2V0Lm1vZGFsVGFyZ2V0U3RyaW5nICsgJ1wiXScgKVxuXHRcdFx0KTtcblx0XHR9XG5cdH0gKTtcblxuXHRkb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCAna2V5ZG93bicsIGxvY2tTZWFyY2hGb2N1cyApO1xufTtcblxuLyoqXG4gKiBMb2NrIHRhYmJpbmcgdG8gdGhlIHNlYXJjaCBmb3JtIG9ubHkuXG4gKi9cbmZ1bmN0aW9uIGxvY2tTZWFyY2hGb2N1cyggZXZ0ICkge1xuXHR2YXIgZSA9IGV2ZW50IHx8IGV2dDsgLy8gZm9yIGNyb3NzLWJyb3dzZXIgY29tcGF0aWJpbGl0eVxuXHR2YXIgY2hhckNvZGUgPSBlLndoaWNoIHx8IGUua2V5Q29kZTtcblxuXHRpZiAoIGNoYXJDb2RlICE9PSA5IHx8ICEgalF1ZXJ5KCAnZGl2LnNlYXJjaC1tb2RhbCcgKS5oYXNDbGFzcyggJ2FjdGl2ZScgKSApIHtcblx0XHRyZXR1cm47XG5cdH1cblxuXHR2YXIgJGVsZW1lbnQgICAgICAgPSBqUXVlcnkoICc6Zm9jdXMnICksXG5cdCAgICBpc1NoaWZ0VGFiICAgICA9ICggZXZlbnQuc2hpZnRLZXkgJiYgZXZlbnQua2V5Q29kZSA9PSA5ICk7XG5cblx0aWYgKCAkZWxlbWVudC5oYXNDbGFzcyggJ3NlYXJjaC1mb3JtX19pbnB1dCcgKSAmJiBpc1NoaWZ0VGFiICkge1xuXHRcdHNldFRpbWVvdXQoIGZ1bmN0aW9uKCkge1xuXHRcdFx0alF1ZXJ5KCAnLnNlYXJjaC1pbnB1dF9fYnV0dG9uJyApLmZvY3VzKCk7XG5cdFx0fSwgMTAgKTtcblx0fVxuXG5cdGlmICggJGVsZW1lbnQuaGFzQ2xhc3MoICdzZWFyY2gtaW5wdXRfX2J1dHRvbicgKSAmJiAhIGlzU2hpZnRUYWIgKSB7XG5cdFx0c2V0VGltZW91dCggZnVuY3Rpb24oKSB7XG5cdFx0XHRqUXVlcnkoICdpbnB1dC5zZWFyY2gtZm9ybV9faW5wdXQnICkuZm9jdXMoKTtcblx0XHR9LCAxMCApO1xuXHR9XG59O1xuXG5cbmV4cG9ydCBkZWZhdWx0IHNlYXJjaFRvZ2dsZTtcbiIsImxldCBtZW51T2JqZWN0ICAgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCggJ2hlYWRlcl9fY2FydC10b2dnbGUnICk7XG5sZXQgc2l0ZU92ZXJsYXkgID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoICdzaXRlLW92ZXJsYXknICk7XG5sZXQgc2lkZU5hdiAgICAgID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoICdzaXRlLW5hdi0tY2FydCcgKTtcbmxldCBzaWRlTmF2Q2xvc2UgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCggJ3NpdGUtY2xvc2UtaGFuZGxlJyApO1xuXG5jb25zdCB3b29NZW51Q2FydCA9ICgpID0+IHtcblx0aWYgKFxuXHRcdG51bGwgPT09IG1lbnVPYmplY3QgfHxcblx0XHRudWxsID09PSBzaXRlT3ZlcmxheSB8fFxuXHRcdG51bGwgPT09IHNpZGVOYXZDbG9zZVxuXHQpIHtcblx0XHRyZXR1cm47XG5cdH1cblxuXHRkb2N1bWVudC5ib2R5LmNsYXNzTGlzdC5hZGQoICdoYXMtd29vLWNhcnQtc2xpZGVvdXQnICk7XG5cblx0bWVudU9iamVjdC5hZGRFdmVudExpc3RlbmVyKCAnY2xpY2snLCAgZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdGV2ZW50LnByZXZlbnREZWZhdWx0KCk7XG5cdFx0dG9nZ2xlU2lkZU5hdlZpc2liaWxpdHkoKTtcblx0fSApO1xuXG5cdHNpdGVPdmVybGF5LmFkZEV2ZW50TGlzdGVuZXIoICdjbGljaycsIHRvZ2dsZVNpZGVOYXZWaXNpYmlsaXR5ICk7XG5cdHNpZGVOYXZDbG9zZS5hZGRFdmVudExpc3RlbmVyKCAnY2xpY2snLCB0b2dnbGVTaWRlTmF2VmlzaWJpbGl0eSApO1xufTtcblxuY29uc3QgdG9nZ2xlU2lkZU5hdlZpc2liaWxpdHkgPSAoIGV2ZW50ICkgPT4ge1xuXHRzaWRlTmF2LmNsYXNzTGlzdC50b2dnbGUoICdhY3RpdmUnICk7XG5cdHNpdGVPdmVybGF5LmNsYXNzTGlzdC50b2dnbGUoICdhY3RpdmUnICk7XG5cdGRvY3VtZW50LmJvZHkuY2xhc3NMaXN0LnRvZ2dsZSggJ3NpZGViYXItbW92ZScgKTtcbn07XG5cbmV4cG9ydCBkZWZhdWx0IHdvb01lbnVDYXJ0O1xuIiwiaW1wb3J0IGNzc1ZhcnMgZnJvbSAnY3NzLXZhcnMtcG9ueWZpbGwnO1xuaW1wb3J0IHByaW1hcnlNZW51IGZyb20gJy4vY29tcG9uZW50cy9wcmltYXJ5LW1lbnUuanMnO1xuaW1wb3J0IHNlYXJjaFRvZ2dsZSBmcm9tICcuL2NvbXBvbmVudHMvc2VhcmNoLXRvZ2dsZS5qcyc7XG5pbXBvcnQgd29vTWVudUNhcnQgZnJvbSAnLi9jb21wb25lbnRzL3dvby1tZW51LWNhcnQuanMnO1xuaW1wb3J0IF9kZWJvdWNlIGZyb20gJ2xvZGFzaC9kZWJvdW5jZSc7IC8vIHdlIG5lZWQgYW4gYWxpYXMgZm9yIGRlYm91bmNlIG90aGVyd2lzZSBpdCBjb25mbGljdHMgd2l0aCBjdXN0b21pemVyXG5cbnByaW1hcnlNZW51KCk7XG5zZWFyY2hUb2dnbGUoKTtcbndvb01lbnVDYXJ0KCk7XG5jc3NWYXJzKCk7XG5cbmRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoICdET01Db250ZW50TG9hZGVkJywgZnVuY3Rpb24oKSB7XG5cdGNvbnN0IGhhc1NlbGVjdGl2ZVJlZnJlc2ggPSAoXG5cdFx0J3VuZGVmaW5lZCcgIT09IHR5cGVvZiB3cCAmJlxuXHRcdHdwLmN1c3RvbWl6ZSAmJlxuXHRcdHdwLmN1c3RvbWl6ZS5zZWxlY3RpdmVSZWZyZXNoICYmXG5cdFx0d3AuY3VzdG9taXplLm5hdk1lbnVzUHJldmlldy5OYXZNZW51SW5zdGFuY2VQYXJ0aWFsXG5cdCk7XG5cblx0Ly8gcGFydGlhbC1jb250ZW50LXJlbmRlcmVkIG1pZ2h0IHJlbmRlciBtdWx0aXBsZSB0aW1lcyBmb3Igc29tZSByZWFzb24sIGxldCdzIG1ha2Ugc3VyZSB0byBkZWJvdWNlIHRoaXMuXG5cdGNvbnN0IGluaXQgPSBfZGVib3VjZSggKCkgPT4ge1xuXHRcdC8vIHdlIG5lZWQgdG8gcmVtb3ZlIHRoaXMgYmVmb3JlIGNhbGxpbmcgcHJpbWFyeSBtZW51IGFnYWluLlxuXHRcdGRvY3VtZW50LmJvZHkuY2xhc3NMaXN0LnJlbW92ZSggJ2hhcy1vZmZzY3JlZW4tbmF2JyApO1xuXG5cdFx0cHJpbWFyeU1lbnUoKTtcblx0XHRzZWFyY2hUb2dnbGUoKTtcblx0fSwgMTAwMCApO1xuXG5cdGlmICggaGFzU2VsZWN0aXZlUmVmcmVzaCApIHtcblx0XHR3cC5jdXN0b21pemUuc2VsZWN0aXZlUmVmcmVzaC5iaW5kKCAncGFydGlhbC1jb250ZW50LXJlbmRlcmVkJywgZnVuY3Rpb24gKCBwbGFjZW1lbnQgKSB7XG5cdFx0XHRjb25zdCBjaGFuZ2VkSGVhZGVyVmFyaWF0aW9uID0gKFxuXHRcdFx0XHRwbGFjZW1lbnQgJiZcblx0XHRcdFx0J251bGwnICE9PSBwbGFjZW1lbnQuY29udGFpbmVyWzBdLnBhcmVudE5vZGUgJiZcblx0XHRcdFx0J2hlYWRlcl92YXJpYXRpb24nID09PSBwbGFjZW1lbnQucGFydGlhbC5pZFxuXHRcdFx0KTtcblxuXHRcdFx0aWYgKCBjaGFuZ2VkSGVhZGVyVmFyaWF0aW9uICkge1xuXHRcdFx0XHRpbml0KCk7XG5cdFx0XHR9XG5cdFx0fSApO1xuXHR9XG59ICk7XG4iLCIvKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKipcblxuXHROYW1lOiBXb3JkUHJlc3MgQWNjZXNzaWJsZSBSZXNwb25zaXZlIE5hdmlnYXRpb24gTWVudVxuXHRVc2FnZTpcblxuXHRUZW5VcC5idWlsZF9tZW51KHtcblxuXHRcdCd0YXJnZXQnXHRcdDpcdCcjcHJpbWFyeS1uYXYnLCAgICAgIC8vIHRoZSBzZWxlY3RvciBvZiB0aGUgbmF2IG1lbnUgPHVsPlxuXHRcdCd0b2dnbGUnXHRcdDpcdCcjanMtbWVudS10b2dnbGUnLCAgIC8vIHRoZSBJRCBvZiB0aGUgbGluayB5b3UncmUgdXNpbmcgdG8gb3Blbi9jbG9zZSB0aGUgc21hbGwgc2NyZWVuIG1lbnVcblx0XHQnc3ViX21lbnVfb3BlbidcdDpcdCdob3ZlcicgICAgICAgICAgICAgIC8vIFwiY2xpY2tcIiBpcyB0aGUgb3RoZXIgb3B0aW9uXG5cblx0fSwgZnVuY3Rpb24oKSB7XG5cblx0XHRjb25zb2xlLmxvZygnQW1hemluZyBjYWxsYmFjayBmdW5jdGlvbiEnKTtcblxuXHR9KTtcblxuKioqKioqKioqKioqKioqKioqKioqKioqKioqKioqKiovXG4vKiBlc2xpbnQtZGlzYWJsZSAqL1xuKCBmdW5jdGlvbigpIHtcblxuXHQndXNlIHN0cmljdCc7XG5cblx0Ly8gRGVmaW5lIGdsb2JhbCBUZW5VcCBvYmplY3QgaWYgaXQgZG9lc24ndCBleGlzdFxuXHRpZiAoICdvYmplY3QnICE9PSB0eXBlb2Ygd2luZG93LlRlblVwICkge1xuXHRcdHdpbmRvdy5UZW5VcCA9IHt9O1xuXHR9XG5cblx0Lypcblx0XHRDYWNoZSBhbmQgZGVmaW5lIHNvbWUgdmFyaWFibGVzXG5cdCovXG5cblx0Ly8gaW5pdCBmdW5jdGlvblxuXHRUZW5VcC5uYXZpZ2F0aW9uID0gZnVuY3Rpb24oIG9wdGlvbnMsIGNhbGxiYWNrICkge1xuXG5cdFx0dmFyIGRlZmF1bHRzID0ge1xuXHRcdFx0J3RhcmdldCdcdFx0Olx0JyNwcmltYXJ5LW5hdicsXG5cdFx0XHQndG9nZ2xlJ1x0XHQ6XHQnI2pzLW1lbnUtdG9nZ2xlJyxcblx0XHRcdCdzdWJfbWVudV9vcGVuJ1x0Olx0J2hvdmVyJ1xuXHRcdH07XG5cdFx0dmFyIG9wdDtcblxuXHRcdC8vIE1hcCBhbGwgZGVmYXVsdCBzZXR0aW5ncyB0byB1c2VyIGRlZmluZWQgb3B0aW9ucyBpZiB0aGV5IGV4aXN0XG5cdFx0Zm9yICggb3B0ID0gMDsgb3B0IDwgZGVmYXVsdHMubGVuZ3RoOyBvcHQgPSBvcHQgKyAxICkge1xuXG5cdFx0XHRpZiggdHlwZW9mIG9wdGlvbnNbb3B0XSA9PT0gJ3VuZGVmaW5lZCcgKSB7XG5cdFx0XHRcdG9wdGlvbnNbb3B0XSA9IGRlZmF1bHRzW29wdF07XG5cdFx0XHR9XG5cblx0XHR9XG5cblx0XHR2YXIgbWVudSA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoIG9wdGlvbnMudGFyZ2V0ICk7XG5cblx0XHQvLyBCYWlsIG91dCBpZiB0aGVyZSdzIG5vIG1lbnVcblx0XHRpZiAoICEgbWVudSApIHsgcmV0dXJuOyB9XG5cblx0XHR2YXIgbWVudV9pZCA9IG1lbnUuZ2V0QXR0cmlidXRlKCAnaWQnICk7XG5cdFx0dmFyIG1lbnVfdG9nZ2xlID0gZG9jdW1lbnQucXVlcnlTZWxlY3Rvciggb3B0aW9ucy50b2dnbGUgKTtcblx0XHR2YXIgYXJpYV9jb250cm9scyA9IG1lbnVfdG9nZ2xlLmdldEF0dHJpYnV0ZSggJ2FyaWEtY29udHJvbHMnICk7XG5cdFx0dmFyIHN1Yl9tZW51X2FjaW9uID0gb3B0aW9ucy5zdWJfbWVudV9vcGVuO1xuXHRcdHZhciBjdXJyZW50X21lbnVfaXRlbSA9IG1lbnUucXVlcnlTZWxlY3RvciggJy5jdXJyZW50LW1lbnUtaXRlbScgKTtcblx0XHR2YXIgbWVudV9pdGVtc193aXRoX2NoaWxkcmVuID0gbWVudS5xdWVyeVNlbGVjdG9yQWxsKCAnLm1lbnUtaXRlbS1oYXMtY2hpbGRyZW4nICk7XG5cdFx0dmFyIG1lbnVfaXRlbXNfd2l0aF9jaGlsZHJlbl9jb3VudCA9IG1lbnVfaXRlbXNfd2l0aF9jaGlsZHJlbi5sZW5ndGg7XG5cdFx0dmFyIGN1cnJlbnRUYXJnZXQ7XG5cdFx0dmFyIHRhcmdldDtcblx0XHR2YXIgaTtcblxuXHRcdC8vIExpc3RlbmVyIGZvciB0aGUgbWVudSBvcGVuL2Nsb3NlIGFjdGlvblxuXHRcdGZ1bmN0aW9uIGxpc3RlbmVyX21lbnUoIGUgKSB7XG5cblx0XHRcdC8vIFN0b3AgbGlua3MgZnJvbSBmaXJpbmdcblx0XHRcdGUucHJldmVudERlZmF1bHQoKTtcblxuXHRcdFx0aWYgKCBkb2N1bWVudC5ib2R5LmNsYXNzTGlzdC5jb250YWlucyggJ21lbnUtaXMtb3BlbicgKSApIHtcblx0XHRcdFx0Ly8gQ2xvc2UgdGhlIG1lbnVcblx0XHRcdFx0bWVudS5zZXRBdHRyaWJ1dGUoICdhcmlhLWhpZGRlbicsICd0cnVlJyApO1xuXHRcdFx0XHRtZW51X3RvZ2dsZS5zZXRBdHRyaWJ1dGUoICdhcmlhLWV4cGFuZGVkJywgJ2ZhbHNlJyApO1xuXG5cdFx0XHRcdC8vIEJ1YmJsZSB0byB0aGUgZG9jdW1lbnRcblx0XHRcdFx0ZG9jdW1lbnQuYm9keS5jbGFzc0xpc3QucmVtb3ZlKCAnbWVudS1pcy1vcGVuJyApO1xuXHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0Ly8gT3BlbiB0aGUgbWVudVxuXHRcdFx0XHRtZW51LnNldEF0dHJpYnV0ZSggJ2FyaWEtaGlkZGVuJywgJ2ZhbHNlJyApO1xuXHRcdFx0XHRtZW51X3RvZ2dsZS5zZXRBdHRyaWJ1dGUoICdhcmlhLWV4cGFuZGVkJywgJ3RydWUnICk7XG5cblx0XHRcdFx0Ly8gU2V0IGZvY3VzIHRvIHRoZSBmaXJzdCBsaW5rXG5cdFx0XHRcdG1lbnUucXVlcnlTZWxlY3RvckFsbCggJ2EnIClbMF0uZm9jdXMoKTtcblxuXHRcdFx0XHQvLyBCdWJibGUgdG8gdGhlIGRvY3VtZW50XG5cdFx0XHRcdGRvY3VtZW50LmJvZHkuY2xhc3NMaXN0LmFkZCggJ21lbnUtaXMtb3BlbicgKTtcblx0XHRcdH1cblxuXHRcdH07IC8vIGxpc3RlbmVyX21lbnUoKVxuXG5cdFx0Ly8gTGlzdGVuZXIgZm9yIHN1Ym1lbnUgb24gY2xpY2tcblx0XHRmdW5jdGlvbiBsaXN0ZW5lcl9zdWJtZW51X2NsaWNrKCBlICkge1xuXG5cdFx0XHRjdXJyZW50VGFyZ2V0ID0gZS5jdXJyZW50VGFyZ2V0O1xuXHRcdFx0dGFyZ2V0ID0gZS50YXJnZXQ7XG5cblx0XHRcdGlmICggdGFyZ2V0LnRhZ05hbWUgPT09ICdzdmcnIHx8IHRhcmdldC50YWdOYW1lID09PSAncGF0aCcgKSB7XG5cdFx0XHRcdHRhcmdldCA9IGN1cnJlbnRUYXJnZXQuY2xvc2VzdCggJy5tZW51LWl0ZW0gPiBhJyApO1xuXHRcdFx0fVxuXG5cdFx0XHRpZiAoIHRhcmdldC5nZXRBdHRyaWJ1dGUoICdhcmlhLWhhc3BvcHVwJyApICkge1xuXHRcdFx0XHQvLyBTdG9wIGxpbmtzIGZyb20gZmlyaW5nXG5cdFx0XHRcdGUucHJldmVudERlZmF1bHQoKTtcblxuXHRcdFx0XHQvLyBTdG9wIGV2ZW50cyBmcm9tIGJ1YmJsaW5nIHVwIHRvIHBhcmVudCBlbGVtZW50c1xuXHRcdFx0XHRlLnN0b3BQcm9wYWdhdGlvbigpO1xuXG5cdFx0XHRcdHZhciBwYXJlbnRfbWVudSA9IHRhcmdldC5wYXJlbnROb2RlO1xuXHRcdFx0XHR2YXIgc3ViX21lbnUgPSBwYXJlbnRfbWVudS5xdWVyeVNlbGVjdG9yKCAnLnN1Yi1tZW51JyApO1xuXHRcdFx0XHR2YXIgYWxsX29wZW5fbWVudXMgPSBtZW51LnF1ZXJ5U2VsZWN0b3JBbGwoICcuY2hpbGQtaGFzLWZvY3VzJyApO1xuXHRcdFx0XHR2YXIgYWxsX29wZW5fbWVudXNfY291bnQgPSBhbGxfb3Blbl9tZW51cy5sZW5ndGg7XG5cdFx0XHRcdHZhciBhbGxfb3Blbl9tZW51X3RyaWdnZXJzID0gbWVudS5xdWVyeVNlbGVjdG9yQWxsKCAnLmNoaWxkLWhhcy1mb2N1cyA+IGEuc3VibWVudS1pcy1vcGVuJyApO1xuXHRcdFx0XHR2YXIgYWxsX29wZW5fbWVudV90cmlnZ2Vyc19jb3VudCA9IGFsbF9vcGVuX21lbnVfdHJpZ2dlcnMubGVuZ3RoO1xuXHRcdFx0XHR2YXIgdDtcblxuXHRcdFx0XHRpZiAoIGdldF9zY3JlZW5fc2l6ZSggJ2hhcy1mdWxsLW5hdicgKSApIHtcblx0XHRcdFx0XHRpZiAoIGFsbF9vcGVuX21lbnVfdHJpZ2dlcnNfY291bnQgPiAwICkge1xuXHRcdFx0XHRcdFx0Ly8gTWFrZSBzdXJlIG9ubHkgMSBtZW51IGl0ZW0gY2FuIGJlIG9wZW5lZCBhdCBhIHRpbWVcblx0XHRcdFx0XHRcdGZvciAoIHQgPSAwOyB0IDwgYWxsX29wZW5fbWVudV90cmlnZ2Vyc19jb3VudDsgdCA9IHQgKyAxICkge1xuXG5cdFx0XHRcdFx0XHRcdC8vIENoZWNrIGlmIHRoZSBvcGVuIG1lbnUgaXMgdG9wLWxldmVsLCBpZiBzbywgY2xvc2UgaXRcblx0XHRcdFx0XHRcdFx0aWYgKCBwYXJlbnRfbWVudS5wYXJlbnROb2RlID09PSBtZW51ICkge1xuXHRcdFx0XHRcdFx0XHRcdG1lbnVfc3ViX2Nsb3NlKCBhbGxfb3Blbl9tZW51X3RyaWdnZXJzW3RdICk7XG5cdFx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHRcdH0gLy8gZm9yXG5cdFx0XHRcdFx0fSAvLyBpZlxuXHRcdFx0XHR9IC8vIGlmXG5cblx0XHRcdFx0aWYgKCAoIGUudGFyZ2V0Lm5vZGVOYW1lID09PSAnQScgfHwgdGFyZ2V0LnRhZ05hbWUgPT09ICdBJyApICYmIHRhcmdldC5jbGFzc0xpc3QuY29udGFpbnMoICdzdWJtZW51LWlzLW9wZW4nICkgKSB7XG5cdFx0XHRcdFx0Ly8gVGhlIG1lbnUgaXMgYWxyZWFkeSBvcGVuLCBzbyB0aGlzIHNob3VsZCBiZSBhIGNsb3NlIGFjdGlvblxuXHRcdFx0XHRcdG1lbnVfc3ViX2Nsb3NlKCB0YXJnZXQgKTtcblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHRtZW51X3N1Yl9jbG9zZV9hbGwoKTtcblx0XHRcdFx0XHQvLyBUaGUgbWVudSBpcyBjbG9zZWQsIHNvIHRoaXMgY2xpY2sgc2hvdWxkIG9wZW4gaXRcblx0XHRcdFx0XHRtZW51X3N1Yl9vcGVuKCB0YXJnZXQgKTtcblxuXHRcdFx0XHRcdC8vIFJlc2V0IHRoZSBmb2N1c1xuXHRcdFx0XHRcdHN1Yl9tZW51LnF1ZXJ5U2VsZWN0b3JBbGwoJ2EnKVswXS5mb2N1cygpO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fTsgLy8gbGlzdGVuZXJfc3VibWVudV9jbGljaygpXG5cblx0XHQvLyBXaGVuIFwiaG92ZXJcIiwgdGhpcyBpcyBob3cgZm9jdXMgc2hvdWxkIGFjdFxuXHRcdGZ1bmN0aW9uIGxpc3RlbmVyX3N1Ym1lbnVfZm9jdXMoIGUgKSB7XG5cblx0XHRcdHZhciBjdXJyZW50VGFyZ2V0ID0gZS5jdXJyZW50VGFyZ2V0O1xuXHRcdFx0dmFyIHRhcmdldCA9IGUudGFyZ2V0O1xuXHRcdFx0dmFyIHBhcmVudF9tZW51ID0gdGFyZ2V0LnBhcmVudE5vZGU7XG5cdFx0XHR2YXIgc3ViX21lbnUgPSBwYXJlbnRfbWVudS5xdWVyeVNlbGVjdG9yKCAnLnN1Yi1tZW51JyApO1xuXHRcdFx0dmFyIGFsbF9vcGVuX21lbnVfdHJpZ2dlcnMgPSBtZW51LnF1ZXJ5U2VsZWN0b3JBbGwoICcuY2hpbGQtaGFzLWZvY3VzID4gYS5zdWJtZW51LWlzLW9wZW4nICk7XG5cdFx0XHR2YXIgYWxsX29wZW5fbWVudV90cmlnZ2Vyc19jb3VudCA9IGFsbF9vcGVuX21lbnVfdHJpZ2dlcnMubGVuZ3RoO1xuXHRcdFx0dmFyIHQ7XG5cblx0XHRcdGlmICggZ2V0X3NjcmVlbl9zaXplKCAnaGFzLWZ1bGwtbmF2JyApICkge1xuXHRcdFx0XHRpZiAoIGFsbF9vcGVuX21lbnVfdHJpZ2dlcnNfY291bnQgPiAwICkge1xuXHRcdFx0XHRcdC8vIE1ha2Ugc3VyZSBvbmx5IDEgbWVudSBpdGVtIGNhbiBiZSBvcGVuZWQgYXQgYSB0aW1lXG5cdFx0XHRcdFx0Zm9yICggdCA9IDA7IHQgPCBhbGxfb3Blbl9tZW51X3RyaWdnZXJzX2NvdW50OyB0ID0gdCArIDEgKSB7XG5cdFx0XHRcdFx0XHQvLyBDaGVjayBpZiB0aGUgb3BlbiBtZW51IGlzIHRvcC1sZXZlbCwgaWYgc28sIGNsb3NlIGl0XG5cdFx0XHRcdFx0XHRpZiAoIHBhcmVudF9tZW51LnBhcmVudE5vZGUgPT09IG1lbnUgKSB7XG5cdFx0XHRcdFx0XHRcdG1lbnVfc3ViX2Nsb3NlKCBhbGxfb3Blbl9tZW51X3RyaWdnZXJzW3RdICk7XG5cdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0XHRtZW51X3N1Yl9vcGVuKCB0YXJnZXQgKTtcblx0XHR9O1xuXG5cdFx0Ly8gTGlzdGVuZXIgZm9yIHRoZSB3aW5kb3cgcmVzaXplXG5cdFx0dmFyIGxpc3RlbmVyX3dpbmRvdyA9IGRlYm91bmNlKCBmdW5jdGlvbiggZSApIHtcblx0XHRcdGlmKCBnZXRfc2NyZWVuX3NpemUoICdoYXMtb2Zmc2NyZWVuLW5hdicgKSApIHtcblx0XHRcdFx0bWVudV9jcmVhdGUoKTtcblx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdG1lbnVfZGVzdHJveSgpO1xuXHRcdFx0fVxuXHRcdH0sIDEwMCApOyAvLyBsaXN0ZW5lcl93aW5kb3coKVxuXG5cdFx0Ly8gQ2xvc2UgdGhlIG1lbnUgaWYgeW91IGNsaWNrIHNvbWV3aGVyZSBlbHNlXG5cdFx0ZnVuY3Rpb24gbGlzdGVuZXJfY2xvc2Vfb3Blbl9tZW51cyggZSApIHtcblxuXHRcdFx0dmFyIG9wZW5fbWVudXMgPSBtZW51LnF1ZXJ5U2VsZWN0b3JBbGwoJy5zdWJtZW51LWlzLW9wZW4nKTtcblx0XHRcdHZhciBvcGVuX21lbnVzX2NvdW50ID0gb3Blbl9tZW51cy5sZW5ndGg7XG5cdFx0XHR2YXIgb3BuO1xuXG5cdFx0XHQvLyBpZiB0aGUgZXZlbnQgaXMga2V5dXAgYW5kIGl0IHdhcyB0aGUgRVNDIGtleVxuXHRcdFx0aWYgKCBlLnR5cGUgPT09ICdrZXl1cCcgJiYgZS5rZXlDb2RlID09IDI3ICkge1xuXG5cdFx0XHRcdC8vIFdlIHdlcmUgZ2V0dGluZyBzb21lIGVycm9ycywgc28gbGV0J3MgYWRkIGluIGEgY2hlY2twb2ludFxuXHRcdFx0XHRpZiAoIG9wZW5fbWVudXNfY291bnQgKSB7XG5cblx0XHRcdFx0XHQvLyBMb29wIHRocm91Z2ggYWxsIHRoZSBvcGVuIG1lbnVzIGFuZCBjbG9zZSB0aGVtXG5cdFx0XHRcdFx0Zm9yICggb3BuID0gMDsgb3BuIDwgb3Blbl9tZW51cy5sZW5ndGg7IG9wbiA9IG9wbiArIDEgKSB7XG5cblx0XHRcdFx0XHRcdG1lbnVfc3ViX2Nsb3NlKCBvcGVuX21lbnVzW29wbl0gKTtcblxuXHRcdFx0XHRcdH0gLy8gZm9yXG5cblx0XHRcdFx0XHQvLyBSZXR1cm4gZm9jdXMgdG8gdGhlIGZpcnN0IG9wZW4gbWVudVxuXHRcdFx0XHRcdGlmICggc3ViX21lbnVfYWNpb24gPT09ICdjbGljaycgKSB7XG5cdFx0XHRcdFx0XHRvcGVuX21lbnVzWzBdLmZvY3VzKCk7XG5cdFx0XHRcdFx0fVxuXG5cdFx0XHRcdH0gLy8gaWZcblxuXHRcdFx0Ly8gSWYgdGhlIGV2ZW50IHdhcyBhIG1vdXNldXBcblx0XHRcdH0gZWxzZSBpZiAoIGUudHlwZSA9PT0gJ21vdXNldXAnICkge1xuXG5cdFx0XHRcdGlmICggISBtZW51LmNvbnRhaW5zKCBlLnRhcmdldCApICYmIG1lbnUucXVlcnlTZWxlY3RvciggJy5zdWJtZW51LWlzLW9wZW4nICkgKSB7XG5cdFx0XHRcdFx0Ly8gV2Ugd2VyZSBnZXR0aW5nIHNvbWUgZXJyb3IsIHNvIGxldCdzIGFkZCBpbiBhIHNlY29uZCBjaGVja3BvaW50XG5cdFx0XHRcdFx0aWYgKCBvcGVuX21lbnVzX2NvdW50ICkge1xuXHRcdFx0XHRcdFx0Zm9yKCBvcG4gPSAwOyBvcG4gPCBvcGVuX21lbnVzLmxlbmd0aDsgb3BuID0gb3BuICsgMSApIHtcblx0XHRcdFx0XHRcdFx0bWVudV9zdWJfY2xvc2UoIG9wZW5fbWVudXNbb3BuXSApO1xuXHRcdFx0XHRcdFx0fSAvLyBmb3Jcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH0gLy8gaWZcblx0XHRcdH1cblx0XHR9OyAvLyBsaXN0ZW5lcl9jbG9zZV9vcGVuX21lbnVzKClcblxuXHRcdGZ1bmN0aW9uIG1lbnVfc3ViX2Nsb3NlKCBvcGVuX2l0ZW0gKSB7XG5cdFx0XHRvcGVuX2l0ZW0uY2xhc3NMaXN0LnJlbW92ZSgnc3VibWVudS1pcy1vcGVuJyk7XG5cdFx0XHRvcGVuX2l0ZW0ucGFyZW50Tm9kZS5jbGFzc0xpc3QucmVtb3ZlKCdjaGlsZC1oYXMtZm9jdXMnKTtcblxuXHRcdFx0aWYgKCBvcGVuX2l0ZW0ucGFyZW50Tm9kZS5xdWVyeVNlbGVjdG9yKCAnLnN1Yi1tZW51JyApICkge1xuXHRcdFx0XHRvcGVuX2l0ZW0ucGFyZW50Tm9kZS5xdWVyeVNlbGVjdG9yKCAnLnN1Yi1tZW51JyApLnNldEF0dHJpYnV0ZSggJ2FyaWEtaGlkZGVuJywgJ3RydWUnICk7XG5cdFx0XHR9XG5cdFx0fTsgLy8gbWVudV9zdWJfY2xvc2UoKVxuXG5cdFx0ZnVuY3Rpb24gbWVudV9zdWJfY2xvc2VfYWxsKCkge1xuXHRcdFx0dmFyIG9wZW5fbWVudXMgPSBtZW51LnF1ZXJ5U2VsZWN0b3JBbGwoICcuc3VibWVudS1pcy1vcGVuJyApO1xuXHRcdFx0dmFyIG9wZW5fbWVudXNfY291bnQgPSBvcGVuX21lbnVzLmxlbmd0aDtcblx0XHRcdHZhciBvcG47XG5cdFx0XHQvLyBXZSB3ZXJlIGdldHRpbmcgc29tZSBlcnJvcnMsIHNvIGxldCdzIGFkZCBpbiBhIGNoZWNrcG9pbnRcblx0XHRcdGlmICggb3Blbl9tZW51c19jb3VudCApIHtcblx0XHRcdFx0Ly8gTG9vcCB0aHJvdWdoIGFsbCB0aGUgb3BlbiBtZW51cyBhbmQgY2xvc2UgdGhlbVxuXHRcdFx0XHRmb3IgKCBvcG4gPSAwOyBvcG4gPCBvcGVuX21lbnVzLmxlbmd0aDsgb3BuID0gb3BuICsgMSApIHtcblx0XHRcdFx0XHRtZW51X3N1Yl9jbG9zZSggb3Blbl9tZW51c1tvcG5dICk7XG5cdFx0XHRcdH0gLy8gZm9yXG5cdFx0XHR9IC8vIGlmXG5cdFx0fTsgLy8gbWVudV9zdWJfY2xvc2UoKVxuXG5cdFx0ZnVuY3Rpb24gbWVudV9zdWJfb3BlbiggY2xvc2VkX2l0ZW0gKSB7XG5cdFx0XHRjbG9zZWRfaXRlbS5jbGFzc0xpc3QuYWRkKCAnc3VibWVudS1pcy1vcGVuJyApO1xuXHRcdFx0Y2xvc2VkX2l0ZW0ucGFyZW50Tm9kZS5jbGFzc0xpc3QuYWRkKCAnY2hpbGQtaGFzLWZvY3VzJyApO1xuXG5cdFx0XHRpZiAoIGNsb3NlZF9pdGVtLnBhcmVudE5vZGUucXVlcnlTZWxlY3RvciggJy5zdWItbWVudScgKSApIHtcblx0XHRcdFx0Y2xvc2VkX2l0ZW0ucGFyZW50Tm9kZS5xdWVyeVNlbGVjdG9yKCAnLnN1Yi1tZW51JyApLnNldEF0dHJpYnV0ZSggJ2FyaWEtaGlkZGVuJywgJ2ZhbHNlJyApO1xuXHRcdFx0fVxuXHRcdH07IC8vIG1lbnVfc3ViX29wZW4oKVxuXG5cdFx0Ly8gTWV0aG9kIHRvIGNyZWF0ZSB0aGUgc21hbGwgc2NyZWVuIG1lbnVcblx0XHRmdW5jdGlvbiBtZW51X2NyZWF0ZSgpIHtcblxuXHRcdFx0aWYgKCAhIGRvY3VtZW50LmJvZHkuY2xhc3NMaXN0LmNvbnRhaW5zKCAnaGFzLW9mZnNjcmVlbi1uYXYnICkgKSB7XG5cblx0XHRcdFx0aWYgKCAhIGRvY3VtZW50LmJvZHkuY2xhc3NMaXN0LmNvbnRhaW5zKCAnbWVudS1pcy1vcGVuJyApICkge1xuXHRcdFx0XHRcdG1lbnUuc2V0QXR0cmlidXRlKCAnYXJpYS1oaWRkZW4nLCAndHJ1ZScgKTtcblx0XHRcdFx0XHRtZW51X3RvZ2dsZS5zZXRBdHRyaWJ1dGUoICdhcmlhLWV4cGFuZGVkJywgJ2ZhbHNlJyApO1xuXHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdG1lbnUuc2V0QXR0cmlidXRlKCAnYXJpYS1oaWRkZW4nLCAnZmFsc2UnICk7XG5cdFx0XHRcdFx0bWVudV90b2dnbGUuc2V0QXR0cmlidXRlKCAnYXJpYS1leHBhbmRlZCcsICd0cnVlJyApO1xuXHRcdFx0XHR9XG5cblx0XHRcdFx0Ly8gTG9vcCB0aHJvdWdoIGFsbCBzdWJtZW51cyBhbmQgYmluZCBldmVudHMgd2hlbiBuZWVkZWRcblx0XHRcdFx0Zm9yICggaSA9IDA7IGkgPCBtZW51X2l0ZW1zX3dpdGhfY2hpbGRyZW5fY291bnQ7IGkgPSBpICsgMSApIHtcblx0XHRcdFx0XHRpZiAoIHN1Yl9tZW51X2FjaW9uICE9PSAnY2xpY2snICkge1xuXHRcdFx0XHRcdFx0bWVudV9pdGVtc193aXRoX2NoaWxkcmVuW2ldLmFkZEV2ZW50TGlzdGVuZXIoICdjbGljaycsIGxpc3RlbmVyX3N1Ym1lbnVfY2xpY2sgKTtcblx0XHRcdFx0XHRcdG1lbnVfaXRlbXNfd2l0aF9jaGlsZHJlbltpXS5yZW1vdmVFdmVudExpc3RlbmVyKCAnZm9jdXNpbicsIGxpc3RlbmVyX3N1Ym1lbnVfZm9jdXMgKTtcblx0XHRcdFx0XHRcdG1lbnUuY2xhc3NMaXN0LmFkZCggJ3VzZXMtY2xpY2snICk7XG5cdFx0XHRcdFx0fVxuXHRcdFx0XHR9IC8vIGZvclxuXG5cdFx0XHRcdC8vIEJpbmQgdGhlIGV2ZW50XG5cdFx0XHRcdG1lbnVfdG9nZ2xlLmFkZEV2ZW50TGlzdGVuZXIoICdjbGljaycsIGxpc3RlbmVyX21lbnUgKTtcblxuXHRcdFx0XHQvLyBBZGQgdGhlIGJvZHkgY2xhc3MgdG8gcHJldmVudCB0aGlzIGZyb20gcnVubmluZyBhZ2FpblxuXHRcdFx0XHRkb2N1bWVudC5ib2R5LmNsYXNzTGlzdC5hZGQoICdoYXMtb2Zmc2NyZWVuLW5hdicgKTtcblx0XHRcdFx0ZG9jdW1lbnQuYm9keS5jbGFzc0xpc3QucmVtb3ZlKCAnaGFzLWZ1bGwtbmF2JyApO1xuXHRcdFx0fVxuXHRcdH07IC8vIG1lbnVfY3JlYXRlKClcblxuXHRcdC8vIE1ldGhvZCB0byBkZXN0cm95IHRoZSBzbWFsbCBzY3JlZW4gbWVudVxuXHRcdGZ1bmN0aW9uIG1lbnVfZGVzdHJveSgpIHtcblxuXHRcdFx0dmFyIHRtcF9vcGVuXG5cdFx0XHR2YXIgdG1wX29wZW5fY291bnRcblx0XHRcdHZhciB0O1xuXG5cdFx0XHRpZiAoICEgZG9jdW1lbnQuYm9keS5jbGFzc0xpc3QuY29udGFpbnMoICdoYXMtZnVsbC1uYXYnICkgKSB7XG5cdFx0XHRcdC8vIFJlbW92ZSBhcmlhLWhpZGRlbiwgYmVjYXVzZSB3ZSBkb24ndCBuZWVkIGl0LlxuXHRcdFx0XHRtZW51LnJlbW92ZUF0dHJpYnV0ZSggJ2FyaWEtaGlkZGVuJyApO1xuXG5cdFx0XHRcdC8vIExvb3AgdGhyb3VnaCBhbGwgc3VibWVudXMgYW5kIGJpbmQgZXZlbnRzIHdoZW4gbmVlZGVkXG5cdFx0XHRcdGZvciAoIGkgPSAwOyBpIDwgbWVudV9pdGVtc193aXRoX2NoaWxkcmVuX2NvdW50OyBpID0gaSArIDEgKSB7XG5cdFx0XHRcdFx0aWYgKCBzdWJfbWVudV9hY2lvbiAhPT0gJ2NsaWNrJyApIHtcblx0XHRcdFx0XHRcdG1lbnVfaXRlbXNfd2l0aF9jaGlsZHJlbltpXS5yZW1vdmVFdmVudExpc3RlbmVyKCAnY2xpY2snLCBsaXN0ZW5lcl9zdWJtZW51X2NsaWNrICk7XG5cdFx0XHRcdFx0XHRtZW51X2l0ZW1zX3dpdGhfY2hpbGRyZW5baV0uYWRkRXZlbnRMaXN0ZW5lciggJ2ZvY3VzaW4nLCBsaXN0ZW5lcl9zdWJtZW51X2ZvY3VzICk7XG5cdFx0XHRcdFx0XHRtZW51LmNsYXNzTGlzdC5yZW1vdmUoJ3VzZXMtY2xpY2snKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblxuXHRcdFx0XHQvLyBJZiB3ZSdyZSBub3QgdXNpbmcgY2xpY2ssIHRoZSBvcGVuIG1lbnVzIG5lZWQgdG8gYmUgcmVzZXRcblx0XHRcdFx0aWYgKCBzdWJfbWVudV9hY2lvbiAhPT0gJ2NsaWNrJyApIHtcblx0XHRcdFx0XHR0bXBfb3BlbiA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5jaGlsZC1oYXMtZm9jdXMnKTtcblx0XHRcdFx0XHR0bXBfb3Blbl9jb3VudCA9IHRtcF9vcGVuLmxlbmd0aDtcblxuXHRcdFx0XHRcdGZvciAoIHQgPSAwOyB0IDwgdG1wX29wZW5fY291bnQ7IHQgPSB0ICsgMSApIHtcblx0XHRcdFx0XHRcdHRtcF9vcGVuW3RdLmNsYXNzTGlzdC5yZW1vdmUoICdjaGlsZC1oYXMtZm9jdXMnICk7XG5cdFx0XHRcdFx0XHR0bXBfb3Blblt0XS5xdWVyeVNlbGVjdG9yKCAnLnN1Ym1lbnUtaXMtb3BlbicgKS5jbGFzc0xpc3QucmVtb3ZlKCAnc3VibWVudS1pcy1vcGVuJyApO1xuXHRcdFx0XHRcdFx0dG1wX29wZW5bdF0ucXVlcnlTZWxlY3RvciggJy5zdWItbWVudScgKS5zZXRBdHRyaWJ1dGUoICdhcmlhLWhpZGRlbicsICd0cnVlJyApO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fVxuXG5cdFx0XHRcdC8vIFVuYmluZCB0aGUgZXZlbnRcblx0XHRcdFx0bWVudV90b2dnbGUucmVtb3ZlRXZlbnRMaXN0ZW5lciggJ2NsaWNrJywgbGlzdGVuZXJfbWVudSApO1xuXG5cdFx0XHRcdC8vIEFkZCB0aGUgYm9keSBjbGFzcyB0byBwcmV2ZW50IHRoaXMgZnJvbSBydW5uaW5nIGFnYWluXG5cdFx0XHRcdGRvY3VtZW50LmJvZHkuY2xhc3NMaXN0LmFkZCggJ2hhcy1mdWxsLW5hdicgKTtcblx0XHRcdFx0ZG9jdW1lbnQuYm9keS5jbGFzc0xpc3QucmVtb3ZlKCAnaGFzLW9mZnNjcmVlbi1uYXYnICk7XG5cdFx0XHR9XG5cdFx0fTtcblxuXHRcdC8vIENoZWNrIGluaXQgbWVudSBzdGF0ZVxuXHRcdGlmICggZ2V0X3NjcmVlbl9zaXplKCAnaGFzLW9mZnNjcmVlbi1uYXYnICkgKSB7XG5cdFx0XHRtZW51X2NyZWF0ZSgpO1xuXHRcdH1cblxuXHRcdC8vIElmIGFyaWEtY29udHJvbHMgaXNuJ3Qgc2V0LCBzZXQgaXRcblx0XHRpZiAoICEgYXJpYV9jb250cm9scyApIHtcblx0XHRcdG1lbnVfdG9nZ2xlLnNldEF0dHJpYnV0ZSggJ2FyaWEtY29udHJvbHMnLCBtZW51X2lkICk7XG5cdFx0fVxuXG5cdFx0aWYgKCBjdXJyZW50X21lbnVfaXRlbSApIHtcblx0XHRcdGN1cnJlbnRfbWVudV9pdGVtLnF1ZXJ5U2VsZWN0b3IoICdhJyApLnNldEF0dHJpYnV0ZSggJ2FyaWEtY3VycmVudCcsICdwYWdlJyApO1xuXHRcdH1cblxuXHRcdC8qXG5cdFx0XHRFdmVudHNcblx0XHQqL1xuXG5cdFx0Ly8gRGVib3VuY2VkIHJlc2l6ZSBldmVudCB0byBjcmVhdGUgYW5kIGRlc3Ryb3kgdGhlIHNtYWxsIHNjcmVlbiBtZW51IG9wdGlvbnNcblx0XHR3aW5kb3cuYWRkRXZlbnRMaXN0ZW5lciggJ3Jlc2l6ZScsIGxpc3RlbmVyX3dpbmRvdyApO1xuXG5cdFx0Ly8gQ2xvc2UgdGhlIHN1Ym1lbnVzIGJ5IGNsaWNraW5nIG9mZiBvZiB0aGVtIG9yIGhpdHRpbmcgRVNDXG5cdFx0ZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lciggJ21vdXNldXAnLCBsaXN0ZW5lcl9jbG9zZV9vcGVuX21lbnVzICk7XG5cdFx0ZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lciggJ2tleXVwJywgbGlzdGVuZXJfY2xvc2Vfb3Blbl9tZW51cyApO1xuXG5cdFx0Lypcblx0XHRcdEhpZGluZyBhbmQgc2hvd2luZyBzdWJtZW51cyAoY2xpY2ssIGZvY3VzLCBob3Zlcilcblx0XHQqL1xuXG5cdFx0Ly8gTG9vcCB0aHJvdWdoIGFsbCBpdGVtcyB3aXRoIHN1YiBtZW51cyBhbmQgYmluZCBmb2N1cyB0byB0aGVtIGZvciB0YWJiaW5nXG5cdFx0Zm9yICggaSA9IDA7IGkgPCBtZW51X2l0ZW1zX3dpdGhfY2hpbGRyZW5fY291bnQ7IGkgPSBpICsgMSApIHtcblxuXHRcdFx0Ly8gTGV0IGEgc2NyZWVuIHJlYWRlciBrbm93IHRoaXMgbWVudSBoYXMgYSBzdWJtZW51IGJ5IGhvb2tpbmcgaW50byB0aGUgZmlyc3QgbGlua1xuXHRcdFx0bWVudV9pdGVtc193aXRoX2NoaWxkcmVuW2ldLnF1ZXJ5U2VsZWN0b3IoICdhJyApLnNldEF0dHJpYnV0ZSggJ2FyaWEtaGFzcG9wdXAnLCAndHJ1ZScgKTtcblxuXHRcdFx0Ly8gSGlkZSBhbmQgbGFiZWwgZWFjaCBzdWIgbWVudVxuXHRcdFx0bWVudV9pdGVtc193aXRoX2NoaWxkcmVuW2ldLnF1ZXJ5U2VsZWN0b3IoICcuc3ViLW1lbnUnICkuc2V0QXR0cmlidXRlKCAnYXJpYS1oaWRkZW4nLCAndHJ1ZScgKTtcblx0XHRcdG1lbnVfaXRlbXNfd2l0aF9jaGlsZHJlbltpXS5xdWVyeVNlbGVjdG9yKCAnLnN1Yi1tZW51JyApLnNldEF0dHJpYnV0ZSggJ2FyaWEtbGFiZWwnLCAnU3VibWVudScgKTtcblxuXHRcdFx0Ly8gSWYgdGhlIHNjcmVlbiBpcyBzbWFsbCBvciB0aGUgYWN0aW9uIGlzIHNldCB0byBjbGlja1xuXHRcdFx0aWYgKCBnZXRfc2NyZWVuX3NpemUoICdoYXMtb2Zmc2NyZWVuLW5hdicgKSB8fCBzdWJfbWVudV9hY2lvbiA9PT0gJ2NsaWNrJyApIHtcblx0XHRcdFx0bWVudV9pdGVtc193aXRoX2NoaWxkcmVuW2ldLmFkZEV2ZW50TGlzdGVuZXIoICdjbGljaycsIGxpc3RlbmVyX3N1Ym1lbnVfY2xpY2sgKTtcblxuXHRcdFx0XHR2YXIgc3ZnRWxlbWVudHMgPSBtZW51X2l0ZW1zX3dpdGhfY2hpbGRyZW5baV0ucXVlcnlTZWxlY3RvckFsbCggJ3N2ZycgKTtcblxuXHRcdFx0XHRmb3IgKCB2YXIgeiA9IDA7IHogPCBzdmdFbGVtZW50cy5sZW5ndGg7IHogPSB6ICsgMSApIHtcblxuXHRcdFx0XHRcdHN2Z0VsZW1lbnRzW3pdLmFkZEV2ZW50TGlzdGVuZXIoICdjbGljaycsIGxpc3RlbmVyX3N1Ym1lbnVfY2xpY2sgKTtcblxuXHRcdFx0XHR9XG5cblx0XHRcdFx0bWVudS5jbGFzc0xpc3QuYWRkKCAndXNlcy1jbGljaycgKTtcblx0XHRcdH0gZWxzZSBpZiAoIHN1Yl9tZW51X2FjaW9uICE9PSAnY2xpY2snICkge1xuXHRcdFx0XHRpZiAoIGdldF9zY3JlZW5fc2l6ZSggJ2hhcy1mdWxsLW5hdicgKSApIHtcblx0XHRcdFx0XHRtZW51X2l0ZW1zX3dpdGhfY2hpbGRyZW5baV0uYWRkRXZlbnRMaXN0ZW5lciggJ2ZvY3VzaW4nLCBsaXN0ZW5lcl9zdWJtZW51X2ZvY3VzICk7XG5cdFx0XHRcdH0gLy8gaWZcblx0XHRcdH0gLy8gaWZcblx0XHR9IC8vIGZvclxuXG5cdFx0Ly8gRXhlY3V0ZSB0aGUgY2FsbGJhY2sgZnVuY3Rpb25cblx0XHRpZiAoIHR5cGVvZiBjYWxsYmFjayA9PT0gJ2Z1bmN0aW9uJyApIHtcblx0XHRcdGNhbGxiYWNrLmNhbGwoKTtcblx0XHR9XG5cdH07IC8vIGJ1aWxkX21lbnUoKVxuXG5cdC8qXG5cdFx0SGVscGVyIGZ1bmN0aW9uc1xuXHQqL1xuXG5cdC8vIEdldCBzY3JlZW4gc2l6ZSBmcm9tIGdldENvbXB1dGVkU3R5bGUgKHNvIHdlIGRvbid0IGhhdmUgdG8gZGVmaW5lIGVhY2ggYnJlYWtwb2ludCB0d2ljZSkgLS0gVmFsdWVzIGFyZSBzZXQgaW4gQ1NTIC0tXG5cdGZ1bmN0aW9uIGdldF9zY3JlZW5fc2l6ZSggc2l6ZVN0cmluZyApIHtcblx0XHR2YXIgc2l6ZSA9IHdpbmRvdy5nZXRDb21wdXRlZFN0eWxlKCBkb2N1bWVudC5ib2R5LCc6YmVmb3JlJyApLmdldFByb3BlcnR5VmFsdWUoICdjb250ZW50JyApO1xuXG5cdFx0aWYgKCBzaXplICYmIHNpemUuaW5kZXhPZiggc2l6ZVN0cmluZyApICE9PSAtMSApIHtcblx0XHRcdHJldHVybiB0cnVlO1xuXHRcdH1cblx0fTtcblxuXHQvLyBEZWJvdW5jZVxuXHRmdW5jdGlvbiBkZWJvdW5jZSggZnVuYywgd2FpdCwgaW1tZWRpYXRlICkge1xuXHRcdHZhciB0aW1lb3V0O1xuXG5cdFx0cmV0dXJuIGZ1bmN0aW9uKCkge1xuXHRcdFx0dmFyIGNvbnRleHQgPSB0aGlzLCBhcmdzID0gYXJndW1lbnRzO1xuXG5cdFx0XHR2YXIgbGF0ZXIgPSBmdW5jdGlvbigpIHtcblx0XHRcdFx0dGltZW91dCA9IG51bGw7XG5cdFx0XHRcdGlmICggISBpbW1lZGlhdGUgKSBmdW5jLmFwcGx5KCBjb250ZXh0LCBhcmdzICk7XG5cdFx0XHR9O1xuXG5cdFx0XHR2YXIgY2FsbE5vdyA9IGltbWVkaWF0ZSAmJiAhdGltZW91dDtcblxuXHRcdFx0Y2xlYXJUaW1lb3V0KCB0aW1lb3V0ICk7XG5cdFx0XHR0aW1lb3V0ID0gc2V0VGltZW91dCggbGF0ZXIsIHdhaXQgKTtcblx0XHRcdGlmICggY2FsbE5vdyApIGZ1bmMuYXBwbHkoIGNvbnRleHQsIGFyZ3MgKTtcblx0XHR9O1xuXHR9O1xuXG59ICkoKTtcbiIsIi8qIVxuICogY3NzLXZhcnMtcG9ueWZpbGxcbiAqIHYyLjMuMVxuICogaHR0cHM6Ly9qaGlsZGVuYmlkZGxlLmdpdGh1Yi5pby9jc3MtdmFycy1wb255ZmlsbC9cbiAqIChjKSAyMDE4LTIwMjAgSm9obiBIaWxkZW5iaWRkbGUgPGh0dHA6Ly9oaWxkZW5iaWRkbGUuY29tPlxuICogTUlUIGxpY2Vuc2VcbiAqL1xuZnVuY3Rpb24gX2V4dGVuZHMoKSB7XG4gICAgX2V4dGVuZHMgPSBPYmplY3QuYXNzaWduIHx8IGZ1bmN0aW9uKHRhcmdldCkge1xuICAgICAgICBmb3IgKHZhciBpID0gMTsgaSA8IGFyZ3VtZW50cy5sZW5ndGg7IGkrKykge1xuICAgICAgICAgICAgdmFyIHNvdXJjZSA9IGFyZ3VtZW50c1tpXTtcbiAgICAgICAgICAgIGZvciAodmFyIGtleSBpbiBzb3VyY2UpIHtcbiAgICAgICAgICAgICAgICBpZiAoT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKHNvdXJjZSwga2V5KSkge1xuICAgICAgICAgICAgICAgICAgICB0YXJnZXRba2V5XSA9IHNvdXJjZVtrZXldO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgICAgICByZXR1cm4gdGFyZ2V0O1xuICAgIH07XG4gICAgcmV0dXJuIF9leHRlbmRzLmFwcGx5KHRoaXMsIGFyZ3VtZW50cyk7XG59XG5cbmZ1bmN0aW9uIF90b0NvbnN1bWFibGVBcnJheShhcnIpIHtcbiAgICByZXR1cm4gX2FycmF5V2l0aG91dEhvbGVzKGFycikgfHwgX2l0ZXJhYmxlVG9BcnJheShhcnIpIHx8IF91bnN1cHBvcnRlZEl0ZXJhYmxlVG9BcnJheShhcnIpIHx8IF9ub25JdGVyYWJsZVNwcmVhZCgpO1xufVxuXG5mdW5jdGlvbiBfYXJyYXlXaXRob3V0SG9sZXMoYXJyKSB7XG4gICAgaWYgKEFycmF5LmlzQXJyYXkoYXJyKSkgcmV0dXJuIF9hcnJheUxpa2VUb0FycmF5KGFycik7XG59XG5cbmZ1bmN0aW9uIF9pdGVyYWJsZVRvQXJyYXkoaXRlcikge1xuICAgIGlmICh0eXBlb2YgU3ltYm9sICE9PSBcInVuZGVmaW5lZFwiICYmIFN5bWJvbC5pdGVyYXRvciBpbiBPYmplY3QoaXRlcikpIHJldHVybiBBcnJheS5mcm9tKGl0ZXIpO1xufVxuXG5mdW5jdGlvbiBfdW5zdXBwb3J0ZWRJdGVyYWJsZVRvQXJyYXkobywgbWluTGVuKSB7XG4gICAgaWYgKCFvKSByZXR1cm47XG4gICAgaWYgKHR5cGVvZiBvID09PSBcInN0cmluZ1wiKSByZXR1cm4gX2FycmF5TGlrZVRvQXJyYXkobywgbWluTGVuKTtcbiAgICB2YXIgbiA9IE9iamVjdC5wcm90b3R5cGUudG9TdHJpbmcuY2FsbChvKS5zbGljZSg4LCAtMSk7XG4gICAgaWYgKG4gPT09IFwiT2JqZWN0XCIgJiYgby5jb25zdHJ1Y3RvcikgbiA9IG8uY29uc3RydWN0b3IubmFtZTtcbiAgICBpZiAobiA9PT0gXCJNYXBcIiB8fCBuID09PSBcIlNldFwiKSByZXR1cm4gQXJyYXkuZnJvbShvKTtcbiAgICBpZiAobiA9PT0gXCJBcmd1bWVudHNcIiB8fCAvXig/OlVpfEkpbnQoPzo4fDE2fDMyKSg/OkNsYW1wZWQpP0FycmF5JC8udGVzdChuKSkgcmV0dXJuIF9hcnJheUxpa2VUb0FycmF5KG8sIG1pbkxlbik7XG59XG5cbmZ1bmN0aW9uIF9hcnJheUxpa2VUb0FycmF5KGFyciwgbGVuKSB7XG4gICAgaWYgKGxlbiA9PSBudWxsIHx8IGxlbiA+IGFyci5sZW5ndGgpIGxlbiA9IGFyci5sZW5ndGg7XG4gICAgZm9yICh2YXIgaSA9IDAsIGFycjIgPSBuZXcgQXJyYXkobGVuKTsgaSA8IGxlbjsgaSsrKSBhcnIyW2ldID0gYXJyW2ldO1xuICAgIHJldHVybiBhcnIyO1xufVxuXG5mdW5jdGlvbiBfbm9uSXRlcmFibGVTcHJlYWQoKSB7XG4gICAgdGhyb3cgbmV3IFR5cGVFcnJvcihcIkludmFsaWQgYXR0ZW1wdCB0byBzcHJlYWQgbm9uLWl0ZXJhYmxlIGluc3RhbmNlLlxcbkluIG9yZGVyIHRvIGJlIGl0ZXJhYmxlLCBub24tYXJyYXkgb2JqZWN0cyBtdXN0IGhhdmUgYSBbU3ltYm9sLml0ZXJhdG9yXSgpIG1ldGhvZC5cIik7XG59XG5cbi8qIVxuICogZ2V0LWNzcy1kYXRhXG4gKiB2MS44LjBcbiAqIGh0dHBzOi8vZ2l0aHViLmNvbS9qaGlsZGVuYmlkZGxlL2dldC1jc3MtZGF0YVxuICogKGMpIDIwMTgtMjAyMCBKb2huIEhpbGRlbmJpZGRsZSA8aHR0cDovL2hpbGRlbmJpZGRsZS5jb20+XG4gKiBNSVQgbGljZW5zZVxuICovIGZ1bmN0aW9uIGdldFVybHModXJscykge1xuICAgIHZhciBvcHRpb25zID0gYXJndW1lbnRzLmxlbmd0aCA+IDEgJiYgYXJndW1lbnRzWzFdICE9PSB1bmRlZmluZWQgPyBhcmd1bWVudHNbMV0gOiB7fTtcbiAgICB2YXIgc2V0dGluZ3MgPSB7XG4gICAgICAgIG1pbWVUeXBlOiBvcHRpb25zLm1pbWVUeXBlIHx8IG51bGwsXG4gICAgICAgIG9uQmVmb3JlU2VuZDogb3B0aW9ucy5vbkJlZm9yZVNlbmQgfHwgRnVuY3Rpb24ucHJvdG90eXBlLFxuICAgICAgICBvblN1Y2Nlc3M6IG9wdGlvbnMub25TdWNjZXNzIHx8IEZ1bmN0aW9uLnByb3RvdHlwZSxcbiAgICAgICAgb25FcnJvcjogb3B0aW9ucy5vbkVycm9yIHx8IEZ1bmN0aW9uLnByb3RvdHlwZSxcbiAgICAgICAgb25Db21wbGV0ZTogb3B0aW9ucy5vbkNvbXBsZXRlIHx8IEZ1bmN0aW9uLnByb3RvdHlwZVxuICAgIH07XG4gICAgdmFyIHVybEFycmF5ID0gQXJyYXkuaXNBcnJheSh1cmxzKSA/IHVybHMgOiBbIHVybHMgXTtcbiAgICB2YXIgdXJsUXVldWUgPSBBcnJheS5hcHBseShudWxsLCBBcnJheSh1cmxBcnJheS5sZW5ndGgpKS5tYXAoKGZ1bmN0aW9uKHgpIHtcbiAgICAgICAgcmV0dXJuIG51bGw7XG4gICAgfSkpO1xuICAgIGZ1bmN0aW9uIGlzVmFsaWRDc3MoKSB7XG4gICAgICAgIHZhciBjc3NUZXh0ID0gYXJndW1lbnRzLmxlbmd0aCA+IDAgJiYgYXJndW1lbnRzWzBdICE9PSB1bmRlZmluZWQgPyBhcmd1bWVudHNbMF0gOiBcIlwiO1xuICAgICAgICB2YXIgaXNIVE1MID0gY3NzVGV4dC50cmltKCkuY2hhckF0KDApID09PSBcIjxcIjtcbiAgICAgICAgcmV0dXJuICFpc0hUTUw7XG4gICAgfVxuICAgIGZ1bmN0aW9uIG9uRXJyb3IoeGhyLCB1cmxJbmRleCkge1xuICAgICAgICBzZXR0aW5ncy5vbkVycm9yKHhociwgdXJsQXJyYXlbdXJsSW5kZXhdLCB1cmxJbmRleCk7XG4gICAgfVxuICAgIGZ1bmN0aW9uIG9uU3VjY2VzcyhyZXNwb25zZVRleHQsIHVybEluZGV4KSB7XG4gICAgICAgIHZhciByZXR1cm5WYWwgPSBzZXR0aW5ncy5vblN1Y2Nlc3MocmVzcG9uc2VUZXh0LCB1cmxBcnJheVt1cmxJbmRleF0sIHVybEluZGV4KTtcbiAgICAgICAgcmVzcG9uc2VUZXh0ID0gcmV0dXJuVmFsID09PSBmYWxzZSA/IFwiXCIgOiByZXR1cm5WYWwgfHwgcmVzcG9uc2VUZXh0O1xuICAgICAgICB1cmxRdWV1ZVt1cmxJbmRleF0gPSByZXNwb25zZVRleHQ7XG4gICAgICAgIGlmICh1cmxRdWV1ZS5pbmRleE9mKG51bGwpID09PSAtMSkge1xuICAgICAgICAgICAgc2V0dGluZ3Mub25Db21wbGV0ZSh1cmxRdWV1ZSk7XG4gICAgICAgIH1cbiAgICB9XG4gICAgdmFyIHBhcnNlciA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoXCJhXCIpO1xuICAgIHVybEFycmF5LmZvckVhY2goKGZ1bmN0aW9uKHVybCwgaSkge1xuICAgICAgICBwYXJzZXIuc2V0QXR0cmlidXRlKFwiaHJlZlwiLCB1cmwpO1xuICAgICAgICBwYXJzZXIuaHJlZiA9IFN0cmluZyhwYXJzZXIuaHJlZik7XG4gICAgICAgIHZhciBpc0lFbHRlOSA9IEJvb2xlYW4oZG9jdW1lbnQuYWxsICYmICF3aW5kb3cuYXRvYik7XG4gICAgICAgIHZhciBpc0lFbHRlOUNPUlMgPSBpc0lFbHRlOSAmJiBwYXJzZXIuaG9zdC5zcGxpdChcIjpcIilbMF0gIT09IGxvY2F0aW9uLmhvc3Quc3BsaXQoXCI6XCIpWzBdO1xuICAgICAgICBpZiAoaXNJRWx0ZTlDT1JTKSB7XG4gICAgICAgICAgICB2YXIgaXNTYW1lUHJvdG9jb2wgPSBwYXJzZXIucHJvdG9jb2wgPT09IGxvY2F0aW9uLnByb3RvY29sO1xuICAgICAgICAgICAgaWYgKGlzU2FtZVByb3RvY29sKSB7XG4gICAgICAgICAgICAgICAgdmFyIHhkciA9IG5ldyBYRG9tYWluUmVxdWVzdDtcbiAgICAgICAgICAgICAgICB4ZHIub3BlbihcIkdFVFwiLCB1cmwpO1xuICAgICAgICAgICAgICAgIHhkci50aW1lb3V0ID0gMDtcbiAgICAgICAgICAgICAgICB4ZHIub25wcm9ncmVzcyA9IEZ1bmN0aW9uLnByb3RvdHlwZTtcbiAgICAgICAgICAgICAgICB4ZHIub250aW1lb3V0ID0gRnVuY3Rpb24ucHJvdG90eXBlO1xuICAgICAgICAgICAgICAgIHhkci5vbmxvYWQgPSBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICAgICAgaWYgKGlzVmFsaWRDc3MoeGRyLnJlc3BvbnNlVGV4dCkpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIG9uU3VjY2Vzcyh4ZHIucmVzcG9uc2VUZXh0LCBpKTtcbiAgICAgICAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIG9uRXJyb3IoeGRyLCBpKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH07XG4gICAgICAgICAgICAgICAgeGRyLm9uZXJyb3IgPSBmdW5jdGlvbihlcnIpIHtcbiAgICAgICAgICAgICAgICAgICAgb25FcnJvcih4ZHIsIGkpO1xuICAgICAgICAgICAgICAgIH07XG4gICAgICAgICAgICAgICAgc2V0VGltZW91dCgoZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAgIHhkci5zZW5kKCk7XG4gICAgICAgICAgICAgICAgfSksIDApO1xuICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICBjb25zb2xlLndhcm4oXCJJbnRlcm5ldCBFeHBsb3JlciA5IENyb3NzLU9yaWdpbiAoQ09SUykgcmVxdWVzdHMgbXVzdCB1c2UgdGhlIHNhbWUgcHJvdG9jb2wgKFwiLmNvbmNhdCh1cmwsIFwiKVwiKSk7XG4gICAgICAgICAgICAgICAgb25FcnJvcihudWxsLCBpKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIHZhciB4aHIgPSBuZXcgWE1MSHR0cFJlcXVlc3Q7XG4gICAgICAgICAgICB4aHIub3BlbihcIkdFVFwiLCB1cmwpO1xuICAgICAgICAgICAgaWYgKHNldHRpbmdzLm1pbWVUeXBlICYmIHhoci5vdmVycmlkZU1pbWVUeXBlKSB7XG4gICAgICAgICAgICAgICAgeGhyLm92ZXJyaWRlTWltZVR5cGUoc2V0dGluZ3MubWltZVR5cGUpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgc2V0dGluZ3Mub25CZWZvcmVTZW5kKHhociwgdXJsLCBpKTtcbiAgICAgICAgICAgIHhoci5vbnJlYWR5c3RhdGVjaGFuZ2UgPSBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICBpZiAoeGhyLnJlYWR5U3RhdGUgPT09IDQpIHtcbiAgICAgICAgICAgICAgICAgICAgaWYgKHhoci5zdGF0dXMgPT09IDIwMCAmJiBpc1ZhbGlkQ3NzKHhoci5yZXNwb25zZVRleHQpKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICBvblN1Y2Nlc3MoeGhyLnJlc3BvbnNlVGV4dCwgaSk7XG4gICAgICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICAgICAgICBvbkVycm9yKHhociwgaSk7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9O1xuICAgICAgICAgICAgeGhyLnNlbmQoKTtcbiAgICAgICAgfVxuICAgIH0pKTtcbn1cblxuLyoqXG4gKiBHZXRzIENTUyBkYXRhIGZyb20gPHN0eWxlPiBhbmQgPGxpbms+IG5vZGVzIChpbmNsdWRpbmcgQGltcG9ydHMpLCB0aGVuXG4gKiByZXR1cm5zIGRhdGEgaW4gb3JkZXIgcHJvY2Vzc2VkIGJ5IERPTS4gQWxsb3dzIHNwZWNpZnlpbmcgbm9kZXMgdG9cbiAqIGluY2x1ZGUvZXhjbHVkZSBhbmQgZmlsdGVyaW5nIENTUyBkYXRhIHVzaW5nIFJlZ0V4LlxuICpcbiAqIEBwcmVzZXJ2ZVxuICogQHBhcmFtIHtvYmplY3R9ICAgW29wdGlvbnNdIFRoZSBvcHRpb25zIG9iamVjdFxuICogQHBhcmFtIHtvYmplY3R9ICAgW29wdGlvbnMucm9vdEVsZW1lbnQ9ZG9jdW1lbnRdIFJvb3QgZWxlbWVudCB0byB0cmF2ZXJzZSBmb3JcbiAqICAgICAgICAgICAgICAgICAgIDxsaW5rPiBhbmQgPHN0eWxlPiBub2Rlcy5cbiAqIEBwYXJhbSB7c3RyaW5nfSAgIFtvcHRpb25zLmluY2x1ZGVdIENTUyBzZWxlY3RvciBtYXRjaGluZyA8bGluaz4gYW5kIDxzdHlsZT5cbiAqICAgICAgICAgICAgICAgICAgIG5vZGVzIHRvIGluY2x1ZGVcbiAqIEBwYXJhbSB7c3RyaW5nfSAgIFtvcHRpb25zLmV4Y2x1ZGVdIENTUyBzZWxlY3RvciBtYXRjaGluZyA8bGluaz4gYW5kIDxzdHlsZT5cbiAqICAgICAgICAgICAgICAgICAgIG5vZGVzIHRvIGV4Y2x1ZGVcbiAqIEBwYXJhbSB7b2JqZWN0fSAgIFtvcHRpb25zLmZpbHRlcl0gUmVndWxhciBleHByZXNzaW9uIHVzZWQgdG8gZmlsdGVyIG5vZGUgQ1NTXG4gKiAgICAgICAgICAgICAgICAgICBkYXRhLiBFYWNoIGJsb2NrIG9mIENTUyBkYXRhIGlzIHRlc3RlZCBhZ2FpbnN0IHRoZSBmaWx0ZXIsXG4gKiAgICAgICAgICAgICAgICAgICBhbmQgb25seSBtYXRjaGluZyBkYXRhIGlzIGluY2x1ZGVkLlxuICogQHBhcmFtIHtib29sZWFufSAgW29wdGlvbnMuc2tpcERpc2FibGVkPXRydWVdIERldGVybWluZXMgaWYgZGlzYWJsZWRcbiAqICAgICAgICAgICAgICAgICAgIHN0eWxlc2hlZXRzIHdpbGwgYmUgc2tpcHBlZCB3aGlsZSBjb2xsZWN0aW5nIENTUyBkYXRhLlxuICogQHBhcmFtIHtib29sZWFufSAgW29wdGlvbnMudXNlQ1NTT009ZmFsc2VdIERldGVybWluZXMgaWYgQ1NTIGRhdGEgd2lsbCBiZVxuICogICAgICAgICAgICAgICAgICAgY29sbGVjdGVkIGZyb20gYSBzdHlsZXNoZWV0J3MgcnVudGltZSB2YWx1ZXMgaW5zdGVhZCBvZiBpdHNcbiAqICAgICAgICAgICAgICAgICAgIHRleHQgY29udGVudC4gVGhpcyBpcyByZXF1aXJlZCB0byBnZXQgYWNjdXJhdGUgQ1NTIGRhdGFcbiAqICAgICAgICAgICAgICAgICAgIHdoZW4gYSBzdHlsZXNoZWV0IGhhcyBiZWVuIG1vZGlmaWVkIHVzaW5nIHRoZSBkZWxldGVSdWxlKClcbiAqICAgICAgICAgICAgICAgICAgIG9yIGluc2VydFJ1bGUoKSBtZXRob2RzIGJlY2F1c2UgdGhlc2UgbW9kaWZpY2F0aW9ucyB3aWxsXG4gKiAgICAgICAgICAgICAgICAgICBub3QgYmUgcmVmbGVjdGVkIGluIHRoZSBzdHlsZXNoZWV0J3MgdGV4dCBjb250ZW50LlxuICogQHBhcmFtIHtmdW5jdGlvbn0gW29wdGlvbnMub25CZWZvcmVTZW5kXSBDYWxsYmFjayBiZWZvcmUgWEhSIGlzIHNlbnQuIFBhc3Nlc1xuICogICAgICAgICAgICAgICAgICAgMSkgdGhlIFhIUiBvYmplY3QsIDIpIHNvdXJjZSBub2RlIHJlZmVyZW5jZSwgYW5kIDMpIHRoZVxuICogICAgICAgICAgICAgICAgICAgc291cmNlIFVSTCBhcyBhcmd1bWVudHMuXG4gKiBAcGFyYW0ge2Z1bmN0aW9ufSBbb3B0aW9ucy5vblN1Y2Nlc3NdIENhbGxiYWNrIG9uIGVhY2ggQ1NTIG5vZGUgcmVhZC4gUGFzc2VzXG4gKiAgICAgICAgICAgICAgICAgICAxKSBDU1MgdGV4dCwgMikgc291cmNlIG5vZGUgcmVmZXJlbmNlLCBhbmQgMykgdGhlIHNvdXJjZVxuICogICAgICAgICAgICAgICAgICAgVVJMIGFzIGFyZ3VtZW50cy5cbiAqIEBwYXJhbSB7ZnVuY3Rpb259IFtvcHRpb25zLm9uRXJyb3JdIENhbGxiYWNrIG9uIGVhY2ggZXJyb3IuIFBhc3NlcyAxKSB0aGUgWEhSXG4gKiAgICAgICAgICAgICAgICAgICBvYmplY3QgZm9yIGluc3BlY3Rpb24sIDIpIHNvdXJlIG5vZGUgcmVmZXJlbmNlLCBhbmQgMykgdGhlXG4gKiAgICAgICAgICAgICAgICAgICBzb3VyY2UgVVJMIHRoYXQgZmFpbGVkIChlaXRoZXIgYSA8bGluaz4gaHJlZiBvciBhbiBAaW1wb3J0KVxuICogICAgICAgICAgICAgICAgICAgYXMgYXJndW1lbnRzXG4gKiBAcGFyYW0ge2Z1bmN0aW9ufSBbb3B0aW9ucy5vbkNvbXBsZXRlXSBDYWxsYmFjayBhZnRlciBhbGwgbm9kZXMgaGF2ZSBiZWVuXG4gKiAgICAgICAgICAgICAgICAgICBwcm9jZXNzZWQuIFBhc3NlcyAxKSBjb25jYXRlbmF0ZWQgQ1NTIHRleHQsIDIpIGFuIGFycmF5IG9mXG4gKiAgICAgICAgICAgICAgICAgICBDU1MgdGV4dCBpbiBET00gb3JkZXIsIGFuZCAzKSBhbiBhcnJheSBvZiBub2RlcyBpbiBET01cbiAqICAgICAgICAgICAgICAgICAgIG9yZGVyIGFzIGFyZ3VtZW50cy5cbiAqXG4gKiBAZXhhbXBsZVxuICpcbiAqICAgZ2V0Q3NzRGF0YSh7XG4gKiAgICAgcm9vdEVsZW1lbnQgOiBkb2N1bWVudCxcbiAqICAgICBpbmNsdWRlICAgICA6ICdzdHlsZSxsaW5rW3JlbD1cInN0eWxlc2hlZXRcIl0nLFxuICogICAgIGV4Y2x1ZGUgICAgIDogJ1tocmVmPVwic2tpcC5jc3NcIl0nLFxuICogICAgIGZpbHRlciAgICAgIDogL3JlZC8sXG4gKiAgICAgc2tpcERpc2FibGVkOiB0cnVlLFxuICogICAgIHVzZUNTU09NICAgIDogZmFsc2UsXG4gKiAgICAgb25CZWZvcmVTZW5kKHhociwgbm9kZSwgdXJsKSB7XG4gKiAgICAgICAvLyAuLi5cbiAqICAgICB9XG4gKiAgICAgb25TdWNjZXNzKGNzc1RleHQsIG5vZGUsIHVybCkge1xuICogICAgICAgLy8gLi4uXG4gKiAgICAgfVxuICogICAgIG9uRXJyb3IoeGhyLCBub2RlLCB1cmwpIHtcbiAqICAgICAgIC8vIC4uLlxuICogICAgIH0sXG4gKiAgICAgb25Db21wbGV0ZShjc3NUZXh0LCBjc3NBcnJheSwgbm9kZUFycmF5KSB7XG4gKiAgICAgICAvLyAuLi5cbiAqICAgICB9XG4gKiAgIH0pO1xuICovIGZ1bmN0aW9uIGdldENzc0RhdGEob3B0aW9ucykge1xuICAgIHZhciByZWdleCA9IHtcbiAgICAgICAgY3NzQ29tbWVudHM6IC9cXC9cXCpbXFxzXFxTXSs/XFwqXFwvL2csXG4gICAgICAgIGNzc0ltcG9ydHM6IC8oPzpAaW1wb3J0XFxzKikoPzp1cmxcXChcXHMqKT8oPzpbJ1wiXSkoW14nXCJdKikoPzpbJ1wiXSkoPzpcXHMqXFwpKT8oPzpbXjtdKjspL2dcbiAgICB9O1xuICAgIHZhciBzZXR0aW5ncyA9IHtcbiAgICAgICAgcm9vdEVsZW1lbnQ6IG9wdGlvbnMucm9vdEVsZW1lbnQgfHwgZG9jdW1lbnQsXG4gICAgICAgIGluY2x1ZGU6IG9wdGlvbnMuaW5jbHVkZSB8fCAnc3R5bGUsbGlua1tyZWw9XCJzdHlsZXNoZWV0XCJdJyxcbiAgICAgICAgZXhjbHVkZTogb3B0aW9ucy5leGNsdWRlIHx8IG51bGwsXG4gICAgICAgIGZpbHRlcjogb3B0aW9ucy5maWx0ZXIgfHwgbnVsbCxcbiAgICAgICAgc2tpcERpc2FibGVkOiBvcHRpb25zLnNraXBEaXNhYmxlZCAhPT0gZmFsc2UsXG4gICAgICAgIHVzZUNTU09NOiBvcHRpb25zLnVzZUNTU09NIHx8IGZhbHNlLFxuICAgICAgICBvbkJlZm9yZVNlbmQ6IG9wdGlvbnMub25CZWZvcmVTZW5kIHx8IEZ1bmN0aW9uLnByb3RvdHlwZSxcbiAgICAgICAgb25TdWNjZXNzOiBvcHRpb25zLm9uU3VjY2VzcyB8fCBGdW5jdGlvbi5wcm90b3R5cGUsXG4gICAgICAgIG9uRXJyb3I6IG9wdGlvbnMub25FcnJvciB8fCBGdW5jdGlvbi5wcm90b3R5cGUsXG4gICAgICAgIG9uQ29tcGxldGU6IG9wdGlvbnMub25Db21wbGV0ZSB8fCBGdW5jdGlvbi5wcm90b3R5cGVcbiAgICB9O1xuICAgIHZhciBzb3VyY2VOb2RlcyA9IEFycmF5LmFwcGx5KG51bGwsIHNldHRpbmdzLnJvb3RFbGVtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoc2V0dGluZ3MuaW5jbHVkZSkpLmZpbHRlcigoZnVuY3Rpb24obm9kZSkge1xuICAgICAgICByZXR1cm4gIW1hdGNoZXNTZWxlY3Rvcihub2RlLCBzZXR0aW5ncy5leGNsdWRlKTtcbiAgICB9KSk7XG4gICAgdmFyIGNzc0FycmF5ID0gQXJyYXkuYXBwbHkobnVsbCwgQXJyYXkoc291cmNlTm9kZXMubGVuZ3RoKSkubWFwKChmdW5jdGlvbih4KSB7XG4gICAgICAgIHJldHVybiBudWxsO1xuICAgIH0pKTtcbiAgICBmdW5jdGlvbiBoYW5kbGVDb21wbGV0ZSgpIHtcbiAgICAgICAgdmFyIGlzQ29tcGxldGUgPSBjc3NBcnJheS5pbmRleE9mKG51bGwpID09PSAtMTtcbiAgICAgICAgaWYgKGlzQ29tcGxldGUpIHtcbiAgICAgICAgICAgIHZhciBjc3NUZXh0ID0gY3NzQXJyYXkuam9pbihcIlwiKTtcbiAgICAgICAgICAgIHNldHRpbmdzLm9uQ29tcGxldGUoY3NzVGV4dCwgY3NzQXJyYXksIHNvdXJjZU5vZGVzKTtcbiAgICAgICAgfVxuICAgIH1cbiAgICBmdW5jdGlvbiBoYW5kbGVTdWNjZXNzKGNzc1RleHQsIGNzc0luZGV4LCBub2RlLCBzb3VyY2VVcmwpIHtcbiAgICAgICAgdmFyIHJldHVyblZhbCA9IHNldHRpbmdzLm9uU3VjY2Vzcyhjc3NUZXh0LCBub2RlLCBzb3VyY2VVcmwpO1xuICAgICAgICBjc3NUZXh0ID0gcmV0dXJuVmFsICE9PSB1bmRlZmluZWQgJiYgQm9vbGVhbihyZXR1cm5WYWwpID09PSBmYWxzZSA/IFwiXCIgOiByZXR1cm5WYWwgfHwgY3NzVGV4dDtcbiAgICAgICAgcmVzb2x2ZUltcG9ydHMoY3NzVGV4dCwgbm9kZSwgc291cmNlVXJsLCAoZnVuY3Rpb24ocmVzb2x2ZWRDc3NUZXh0LCBlcnJvckRhdGEpIHtcbiAgICAgICAgICAgIGlmIChjc3NBcnJheVtjc3NJbmRleF0gPT09IG51bGwpIHtcbiAgICAgICAgICAgICAgICBlcnJvckRhdGEuZm9yRWFjaCgoZnVuY3Rpb24oZGF0YSkge1xuICAgICAgICAgICAgICAgICAgICByZXR1cm4gc2V0dGluZ3Mub25FcnJvcihkYXRhLnhociwgbm9kZSwgZGF0YS51cmwpO1xuICAgICAgICAgICAgICAgIH0pKTtcbiAgICAgICAgICAgICAgICBpZiAoIXNldHRpbmdzLmZpbHRlciB8fCBzZXR0aW5ncy5maWx0ZXIudGVzdChyZXNvbHZlZENzc1RleHQpKSB7XG4gICAgICAgICAgICAgICAgICAgIGNzc0FycmF5W2Nzc0luZGV4XSA9IHJlc29sdmVkQ3NzVGV4dDtcbiAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICBjc3NBcnJheVtjc3NJbmRleF0gPSBcIlwiO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICBoYW5kbGVDb21wbGV0ZSgpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KSk7XG4gICAgfVxuICAgIGZ1bmN0aW9uIHBhcnNlSW1wb3J0RGF0YShjc3NUZXh0LCBiYXNlVXJsKSB7XG4gICAgICAgIHZhciBpZ25vcmVSdWxlcyA9IGFyZ3VtZW50cy5sZW5ndGggPiAyICYmIGFyZ3VtZW50c1syXSAhPT0gdW5kZWZpbmVkID8gYXJndW1lbnRzWzJdIDogW107XG4gICAgICAgIHZhciBpbXBvcnREYXRhID0ge307XG4gICAgICAgIGltcG9ydERhdGEucnVsZXMgPSAoY3NzVGV4dC5yZXBsYWNlKHJlZ2V4LmNzc0NvbW1lbnRzLCBcIlwiKS5tYXRjaChyZWdleC5jc3NJbXBvcnRzKSB8fCBbXSkuZmlsdGVyKChmdW5jdGlvbihydWxlKSB7XG4gICAgICAgICAgICByZXR1cm4gaWdub3JlUnVsZXMuaW5kZXhPZihydWxlKSA9PT0gLTE7XG4gICAgICAgIH0pKTtcbiAgICAgICAgaW1wb3J0RGF0YS51cmxzID0gaW1wb3J0RGF0YS5ydWxlcy5tYXAoKGZ1bmN0aW9uKHJ1bGUpIHtcbiAgICAgICAgICAgIHJldHVybiBydWxlLnJlcGxhY2UocmVnZXguY3NzSW1wb3J0cywgXCIkMVwiKTtcbiAgICAgICAgfSkpO1xuICAgICAgICBpbXBvcnREYXRhLmFic29sdXRlVXJscyA9IGltcG9ydERhdGEudXJscy5tYXAoKGZ1bmN0aW9uKHVybCkge1xuICAgICAgICAgICAgcmV0dXJuIGdldEZ1bGxVcmwodXJsLCBiYXNlVXJsKTtcbiAgICAgICAgfSkpO1xuICAgICAgICBpbXBvcnREYXRhLmFic29sdXRlUnVsZXMgPSBpbXBvcnREYXRhLnJ1bGVzLm1hcCgoZnVuY3Rpb24ocnVsZSwgaSkge1xuICAgICAgICAgICAgdmFyIG9sZFVybCA9IGltcG9ydERhdGEudXJsc1tpXTtcbiAgICAgICAgICAgIHZhciBuZXdVcmwgPSBnZXRGdWxsVXJsKGltcG9ydERhdGEuYWJzb2x1dGVVcmxzW2ldLCBiYXNlVXJsKTtcbiAgICAgICAgICAgIHJldHVybiBydWxlLnJlcGxhY2Uob2xkVXJsLCBuZXdVcmwpO1xuICAgICAgICB9KSk7XG4gICAgICAgIHJldHVybiBpbXBvcnREYXRhO1xuICAgIH1cbiAgICBmdW5jdGlvbiByZXNvbHZlSW1wb3J0cyhjc3NUZXh0LCBub2RlLCBiYXNlVXJsLCBjYWxsYmFja0ZuKSB7XG4gICAgICAgIHZhciBfX2Vycm9yRGF0YSA9IGFyZ3VtZW50cy5sZW5ndGggPiA0ICYmIGFyZ3VtZW50c1s0XSAhPT0gdW5kZWZpbmVkID8gYXJndW1lbnRzWzRdIDogW107XG4gICAgICAgIHZhciBfX2Vycm9yUnVsZXMgPSBhcmd1bWVudHMubGVuZ3RoID4gNSAmJiBhcmd1bWVudHNbNV0gIT09IHVuZGVmaW5lZCA/IGFyZ3VtZW50c1s1XSA6IFtdO1xuICAgICAgICB2YXIgaW1wb3J0RGF0YSA9IHBhcnNlSW1wb3J0RGF0YShjc3NUZXh0LCBiYXNlVXJsLCBfX2Vycm9yUnVsZXMpO1xuICAgICAgICBpZiAoaW1wb3J0RGF0YS5ydWxlcy5sZW5ndGgpIHtcbiAgICAgICAgICAgIGdldFVybHMoaW1wb3J0RGF0YS5hYnNvbHV0ZVVybHMsIHtcbiAgICAgICAgICAgICAgICBvbkJlZm9yZVNlbmQ6IGZ1bmN0aW9uIG9uQmVmb3JlU2VuZCh4aHIsIHVybCwgdXJsSW5kZXgpIHtcbiAgICAgICAgICAgICAgICAgICAgc2V0dGluZ3Mub25CZWZvcmVTZW5kKHhociwgbm9kZSwgdXJsKTtcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIG9uU3VjY2VzczogZnVuY3Rpb24gb25TdWNjZXNzKGNzc1RleHQsIHVybCwgdXJsSW5kZXgpIHtcbiAgICAgICAgICAgICAgICAgICAgdmFyIHJldHVyblZhbCA9IHNldHRpbmdzLm9uU3VjY2Vzcyhjc3NUZXh0LCBub2RlLCB1cmwpO1xuICAgICAgICAgICAgICAgICAgICBjc3NUZXh0ID0gcmV0dXJuVmFsID09PSBmYWxzZSA/IFwiXCIgOiByZXR1cm5WYWwgfHwgY3NzVGV4dDtcbiAgICAgICAgICAgICAgICAgICAgdmFyIHJlc3BvbnNlSW1wb3J0RGF0YSA9IHBhcnNlSW1wb3J0RGF0YShjc3NUZXh0LCB1cmwsIF9fZXJyb3JSdWxlcyk7XG4gICAgICAgICAgICAgICAgICAgIHJlc3BvbnNlSW1wb3J0RGF0YS5ydWxlcy5mb3JFYWNoKChmdW5jdGlvbihydWxlLCBpKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICBjc3NUZXh0ID0gY3NzVGV4dC5yZXBsYWNlKHJ1bGUsIHJlc3BvbnNlSW1wb3J0RGF0YS5hYnNvbHV0ZVJ1bGVzW2ldKTtcbiAgICAgICAgICAgICAgICAgICAgfSkpO1xuICAgICAgICAgICAgICAgICAgICByZXR1cm4gY3NzVGV4dDtcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIG9uRXJyb3I6IGZ1bmN0aW9uIG9uRXJyb3IoeGhyLCB1cmwsIHVybEluZGV4KSB7XG4gICAgICAgICAgICAgICAgICAgIF9fZXJyb3JEYXRhLnB1c2goe1xuICAgICAgICAgICAgICAgICAgICAgICAgeGhyOiB4aHIsXG4gICAgICAgICAgICAgICAgICAgICAgICB1cmw6IHVybFxuICAgICAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICAgICAgICAgX19lcnJvclJ1bGVzLnB1c2goaW1wb3J0RGF0YS5ydWxlc1t1cmxJbmRleF0pO1xuICAgICAgICAgICAgICAgICAgICByZXNvbHZlSW1wb3J0cyhjc3NUZXh0LCBub2RlLCBiYXNlVXJsLCBjYWxsYmFja0ZuLCBfX2Vycm9yRGF0YSwgX19lcnJvclJ1bGVzKTtcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIG9uQ29tcGxldGU6IGZ1bmN0aW9uIG9uQ29tcGxldGUocmVzcG9uc2VBcnJheSkge1xuICAgICAgICAgICAgICAgICAgICByZXNwb25zZUFycmF5LmZvckVhY2goKGZ1bmN0aW9uKGltcG9ydFRleHQsIGkpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGNzc1RleHQgPSBjc3NUZXh0LnJlcGxhY2UoaW1wb3J0RGF0YS5ydWxlc1tpXSwgaW1wb3J0VGV4dCk7XG4gICAgICAgICAgICAgICAgICAgIH0pKTtcbiAgICAgICAgICAgICAgICAgICAgcmVzb2x2ZUltcG9ydHMoY3NzVGV4dCwgbm9kZSwgYmFzZVVybCwgY2FsbGJhY2tGbiwgX19lcnJvckRhdGEsIF9fZXJyb3JSdWxlcyk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICBjYWxsYmFja0ZuKGNzc1RleHQsIF9fZXJyb3JEYXRhKTtcbiAgICAgICAgfVxuICAgIH1cbiAgICBpZiAoc291cmNlTm9kZXMubGVuZ3RoKSB7XG4gICAgICAgIHNvdXJjZU5vZGVzLmZvckVhY2goKGZ1bmN0aW9uKG5vZGUsIGkpIHtcbiAgICAgICAgICAgIHZhciBsaW5rSHJlZiA9IG5vZGUuZ2V0QXR0cmlidXRlKFwiaHJlZlwiKTtcbiAgICAgICAgICAgIHZhciBsaW5rUmVsID0gbm9kZS5nZXRBdHRyaWJ1dGUoXCJyZWxcIik7XG4gICAgICAgICAgICB2YXIgaXNMaW5rID0gbm9kZS5ub2RlTmFtZSA9PT0gXCJMSU5LXCIgJiYgbGlua0hyZWYgJiYgbGlua1JlbCAmJiBsaW5rUmVsLnRvTG93ZXJDYXNlKCkuaW5kZXhPZihcInN0eWxlc2hlZXRcIikgIT09IC0xO1xuICAgICAgICAgICAgdmFyIGlzU2tpcCA9IHNldHRpbmdzLnNraXBEaXNhYmxlZCA9PT0gZmFsc2UgPyBmYWxzZSA6IG5vZGUuZGlzYWJsZWQ7XG4gICAgICAgICAgICB2YXIgaXNTdHlsZSA9IG5vZGUubm9kZU5hbWUgPT09IFwiU1RZTEVcIjtcbiAgICAgICAgICAgIGlmIChpc0xpbmsgJiYgIWlzU2tpcCkge1xuICAgICAgICAgICAgICAgIGdldFVybHMobGlua0hyZWYsIHtcbiAgICAgICAgICAgICAgICAgICAgbWltZVR5cGU6IFwidGV4dC9jc3NcIixcbiAgICAgICAgICAgICAgICAgICAgb25CZWZvcmVTZW5kOiBmdW5jdGlvbiBvbkJlZm9yZVNlbmQoeGhyLCB1cmwsIHVybEluZGV4KSB7XG4gICAgICAgICAgICAgICAgICAgICAgICBzZXR0aW5ncy5vbkJlZm9yZVNlbmQoeGhyLCBub2RlLCB1cmwpO1xuICAgICAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgICAgICBvblN1Y2Nlc3M6IGZ1bmN0aW9uIG9uU3VjY2Vzcyhjc3NUZXh0LCB1cmwsIHVybEluZGV4KSB7XG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgc291cmNlVXJsID0gZ2V0RnVsbFVybChsaW5rSHJlZik7XG4gICAgICAgICAgICAgICAgICAgICAgICBoYW5kbGVTdWNjZXNzKGNzc1RleHQsIGksIG5vZGUsIHNvdXJjZVVybCk7XG4gICAgICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgICAgIG9uRXJyb3I6IGZ1bmN0aW9uIG9uRXJyb3IoeGhyLCB1cmwsIHVybEluZGV4KSB7XG4gICAgICAgICAgICAgICAgICAgICAgICBjc3NBcnJheVtpXSA9IFwiXCI7XG4gICAgICAgICAgICAgICAgICAgICAgICBzZXR0aW5ncy5vbkVycm9yKHhociwgbm9kZSwgdXJsKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIGhhbmRsZUNvbXBsZXRlKCk7XG4gICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgIH0gZWxzZSBpZiAoaXNTdHlsZSAmJiAhaXNTa2lwKSB7XG4gICAgICAgICAgICAgICAgdmFyIGNzc1RleHQgPSBub2RlLnRleHRDb250ZW50O1xuICAgICAgICAgICAgICAgIGlmIChzZXR0aW5ncy51c2VDU1NPTSkge1xuICAgICAgICAgICAgICAgICAgICBjc3NUZXh0ID0gQXJyYXkuYXBwbHkobnVsbCwgbm9kZS5zaGVldC5jc3NSdWxlcykubWFwKChmdW5jdGlvbihydWxlKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gcnVsZS5jc3NUZXh0O1xuICAgICAgICAgICAgICAgICAgICB9KSkuam9pbihcIlwiKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgaGFuZGxlU3VjY2Vzcyhjc3NUZXh0LCBpLCBub2RlLCBsb2NhdGlvbi5ocmVmKTtcbiAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgY3NzQXJyYXlbaV0gPSBcIlwiO1xuICAgICAgICAgICAgICAgIGhhbmRsZUNvbXBsZXRlKCk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH0pKTtcbiAgICB9IGVsc2Uge1xuICAgICAgICBzZXR0aW5ncy5vbkNvbXBsZXRlKFwiXCIsIFtdKTtcbiAgICB9XG59XG5cbmZ1bmN0aW9uIGdldEZ1bGxVcmwodXJsLCBiYXNlKSB7XG4gICAgdmFyIGQgPSBkb2N1bWVudC5pbXBsZW1lbnRhdGlvbi5jcmVhdGVIVE1MRG9jdW1lbnQoXCJcIik7XG4gICAgdmFyIGIgPSBkLmNyZWF0ZUVsZW1lbnQoXCJiYXNlXCIpO1xuICAgIHZhciBhID0gZC5jcmVhdGVFbGVtZW50KFwiYVwiKTtcbiAgICBkLmhlYWQuYXBwZW5kQ2hpbGQoYik7XG4gICAgZC5ib2R5LmFwcGVuZENoaWxkKGEpO1xuICAgIGIuaHJlZiA9IGJhc2UgfHwgZG9jdW1lbnQuYmFzZVVSSSB8fCAoZG9jdW1lbnQucXVlcnlTZWxlY3RvcihcImJhc2VcIikgfHwge30pLmhyZWYgfHwgbG9jYXRpb24uaHJlZjtcbiAgICBhLmhyZWYgPSB1cmw7XG4gICAgcmV0dXJuIGEuaHJlZjtcbn1cblxuZnVuY3Rpb24gbWF0Y2hlc1NlbGVjdG9yKGVsbSwgc2VsZWN0b3IpIHtcbiAgICB2YXIgbWF0Y2hlcyA9IGVsbS5tYXRjaGVzIHx8IGVsbS5tYXRjaGVzU2VsZWN0b3IgfHwgZWxtLndlYmtpdE1hdGNoZXNTZWxlY3RvciB8fCBlbG0ubW96TWF0Y2hlc1NlbGVjdG9yIHx8IGVsbS5tc01hdGNoZXNTZWxlY3RvciB8fCBlbG0ub01hdGNoZXNTZWxlY3RvcjtcbiAgICByZXR1cm4gbWF0Y2hlcy5jYWxsKGVsbSwgc2VsZWN0b3IpO1xufVxuXG52YXIgYmFsYW5jZWRNYXRjaCA9IGJhbGFuY2VkO1xuXG5mdW5jdGlvbiBiYWxhbmNlZChhLCBiLCBzdHIpIHtcbiAgICBpZiAoYSBpbnN0YW5jZW9mIFJlZ0V4cCkgYSA9IG1heWJlTWF0Y2goYSwgc3RyKTtcbiAgICBpZiAoYiBpbnN0YW5jZW9mIFJlZ0V4cCkgYiA9IG1heWJlTWF0Y2goYiwgc3RyKTtcbiAgICB2YXIgciA9IHJhbmdlKGEsIGIsIHN0cik7XG4gICAgcmV0dXJuIHIgJiYge1xuICAgICAgICBzdGFydDogclswXSxcbiAgICAgICAgZW5kOiByWzFdLFxuICAgICAgICBwcmU6IHN0ci5zbGljZSgwLCByWzBdKSxcbiAgICAgICAgYm9keTogc3RyLnNsaWNlKHJbMF0gKyBhLmxlbmd0aCwgclsxXSksXG4gICAgICAgIHBvc3Q6IHN0ci5zbGljZShyWzFdICsgYi5sZW5ndGgpXG4gICAgfTtcbn1cblxuZnVuY3Rpb24gbWF5YmVNYXRjaChyZWcsIHN0cikge1xuICAgIHZhciBtID0gc3RyLm1hdGNoKHJlZyk7XG4gICAgcmV0dXJuIG0gPyBtWzBdIDogbnVsbDtcbn1cblxuYmFsYW5jZWQucmFuZ2UgPSByYW5nZTtcblxuZnVuY3Rpb24gcmFuZ2UoYSwgYiwgc3RyKSB7XG4gICAgdmFyIGJlZ3MsIGJlZywgbGVmdCwgcmlnaHQsIHJlc3VsdDtcbiAgICB2YXIgYWkgPSBzdHIuaW5kZXhPZihhKTtcbiAgICB2YXIgYmkgPSBzdHIuaW5kZXhPZihiLCBhaSArIDEpO1xuICAgIHZhciBpID0gYWk7XG4gICAgaWYgKGFpID49IDAgJiYgYmkgPiAwKSB7XG4gICAgICAgIGJlZ3MgPSBbXTtcbiAgICAgICAgbGVmdCA9IHN0ci5sZW5ndGg7XG4gICAgICAgIHdoaWxlIChpID49IDAgJiYgIXJlc3VsdCkge1xuICAgICAgICAgICAgaWYgKGkgPT0gYWkpIHtcbiAgICAgICAgICAgICAgICBiZWdzLnB1c2goaSk7XG4gICAgICAgICAgICAgICAgYWkgPSBzdHIuaW5kZXhPZihhLCBpICsgMSk7XG4gICAgICAgICAgICB9IGVsc2UgaWYgKGJlZ3MubGVuZ3RoID09IDEpIHtcbiAgICAgICAgICAgICAgICByZXN1bHQgPSBbIGJlZ3MucG9wKCksIGJpIF07XG4gICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgIGJlZyA9IGJlZ3MucG9wKCk7XG4gICAgICAgICAgICAgICAgaWYgKGJlZyA8IGxlZnQpIHtcbiAgICAgICAgICAgICAgICAgICAgbGVmdCA9IGJlZztcbiAgICAgICAgICAgICAgICAgICAgcmlnaHQgPSBiaTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgYmkgPSBzdHIuaW5kZXhPZihiLCBpICsgMSk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBpID0gYWkgPCBiaSAmJiBhaSA+PSAwID8gYWkgOiBiaTtcbiAgICAgICAgfVxuICAgICAgICBpZiAoYmVncy5sZW5ndGgpIHtcbiAgICAgICAgICAgIHJlc3VsdCA9IFsgbGVmdCwgcmlnaHQgXTtcbiAgICAgICAgfVxuICAgIH1cbiAgICByZXR1cm4gcmVzdWx0O1xufVxuXG5mdW5jdGlvbiBwYXJzZUNzcyhjc3MpIHtcbiAgICB2YXIgb3B0aW9ucyA9IGFyZ3VtZW50cy5sZW5ndGggPiAxICYmIGFyZ3VtZW50c1sxXSAhPT0gdW5kZWZpbmVkID8gYXJndW1lbnRzWzFdIDoge307XG4gICAgdmFyIGRlZmF1bHRzID0ge1xuICAgICAgICBwcmVzZXJ2ZVN0YXRpYzogdHJ1ZSxcbiAgICAgICAgcmVtb3ZlQ29tbWVudHM6IGZhbHNlXG4gICAgfTtcbiAgICB2YXIgc2V0dGluZ3MgPSBfZXh0ZW5kcyh7fSwgZGVmYXVsdHMsIG9wdGlvbnMpO1xuICAgIHZhciBlcnJvcnMgPSBbXTtcbiAgICBmdW5jdGlvbiBlcnJvcihtc2cpIHtcbiAgICAgICAgdGhyb3cgbmV3IEVycm9yKFwiQ1NTIHBhcnNlIGVycm9yOiBcIi5jb25jYXQobXNnKSk7XG4gICAgfVxuICAgIGZ1bmN0aW9uIG1hdGNoKHJlKSB7XG4gICAgICAgIHZhciBtID0gcmUuZXhlYyhjc3MpO1xuICAgICAgICBpZiAobSkge1xuICAgICAgICAgICAgY3NzID0gY3NzLnNsaWNlKG1bMF0ubGVuZ3RoKTtcbiAgICAgICAgICAgIHJldHVybiBtO1xuICAgICAgICB9XG4gICAgfVxuICAgIGZ1bmN0aW9uIG9wZW4oKSB7XG4gICAgICAgIHJldHVybiBtYXRjaCgvXntcXHMqLyk7XG4gICAgfVxuICAgIGZ1bmN0aW9uIGNsb3NlKCkge1xuICAgICAgICByZXR1cm4gbWF0Y2goL159Lyk7XG4gICAgfVxuICAgIGZ1bmN0aW9uIHdoaXRlc3BhY2UoKSB7XG4gICAgICAgIG1hdGNoKC9eXFxzKi8pO1xuICAgIH1cbiAgICBmdW5jdGlvbiBjb21tZW50KCkge1xuICAgICAgICB3aGl0ZXNwYWNlKCk7XG4gICAgICAgIGlmIChjc3NbMF0gIT09IFwiL1wiIHx8IGNzc1sxXSAhPT0gXCIqXCIpIHtcbiAgICAgICAgICAgIHJldHVybjtcbiAgICAgICAgfVxuICAgICAgICB2YXIgaSA9IDI7XG4gICAgICAgIHdoaWxlIChjc3NbaV0gJiYgKGNzc1tpXSAhPT0gXCIqXCIgfHwgY3NzW2kgKyAxXSAhPT0gXCIvXCIpKSB7XG4gICAgICAgICAgICBpKys7XG4gICAgICAgIH1cbiAgICAgICAgaWYgKCFjc3NbaV0pIHtcbiAgICAgICAgICAgIHJldHVybiBlcnJvcihcImVuZCBvZiBjb21tZW50IGlzIG1pc3NpbmdcIik7XG4gICAgICAgIH1cbiAgICAgICAgdmFyIHN0ciA9IGNzcy5zbGljZSgyLCBpKTtcbiAgICAgICAgY3NzID0gY3NzLnNsaWNlKGkgKyAyKTtcbiAgICAgICAgcmV0dXJuIHtcbiAgICAgICAgICAgIHR5cGU6IFwiY29tbWVudFwiLFxuICAgICAgICAgICAgY29tbWVudDogc3RyXG4gICAgICAgIH07XG4gICAgfVxuICAgIGZ1bmN0aW9uIGNvbW1lbnRzKCkge1xuICAgICAgICB2YXIgY21udHMgPSBbXTtcbiAgICAgICAgdmFyIGM7XG4gICAgICAgIHdoaWxlIChjID0gY29tbWVudCgpKSB7XG4gICAgICAgICAgICBjbW50cy5wdXNoKGMpO1xuICAgICAgICB9XG4gICAgICAgIHJldHVybiBzZXR0aW5ncy5yZW1vdmVDb21tZW50cyA/IFtdIDogY21udHM7XG4gICAgfVxuICAgIGZ1bmN0aW9uIHNlbGVjdG9yKCkge1xuICAgICAgICB3aGl0ZXNwYWNlKCk7XG4gICAgICAgIHdoaWxlIChjc3NbMF0gPT09IFwifVwiKSB7XG4gICAgICAgICAgICBlcnJvcihcImV4dHJhIGNsb3NpbmcgYnJhY2tldFwiKTtcbiAgICAgICAgfVxuICAgICAgICB2YXIgbSA9IG1hdGNoKC9eKChcIig/OlxcXFxcInxbXlwiXSkqXCJ8Jyg/OlxcXFwnfFteJ10pKid8W157XSkrKS8pO1xuICAgICAgICBpZiAobSkge1xuICAgICAgICAgICAgcmV0dXJuIG1bMF0udHJpbSgpLnJlcGxhY2UoL1xcL1xcKihbXipdfFtcXHJcXG5dfChcXCorKFteKi9dfFtcXHJcXG5dKSkpKlxcKlxcLysvZywgXCJcIikucmVwbGFjZSgvXCIoPzpcXFxcXCJ8W15cIl0pKlwifCcoPzpcXFxcJ3xbXiddKSonL2csIChmdW5jdGlvbihtKSB7XG4gICAgICAgICAgICAgICAgcmV0dXJuIG0ucmVwbGFjZSgvLC9nLCBcIuKAjFwiKTtcbiAgICAgICAgICAgIH0pKS5zcGxpdCgvXFxzKig/IVteKF0qXFwpKSxcXHMqLykubWFwKChmdW5jdGlvbihzKSB7XG4gICAgICAgICAgICAgICAgcmV0dXJuIHMucmVwbGFjZSgvXFx1MjAwQy9nLCBcIixcIik7XG4gICAgICAgICAgICB9KSk7XG4gICAgICAgIH1cbiAgICB9XG4gICAgZnVuY3Rpb24gZGVjbGFyYXRpb24oKSB7XG4gICAgICAgIGlmIChjc3NbMF0gPT09IFwiQFwiKSB7XG4gICAgICAgICAgICByZXR1cm4gYXRfcnVsZSgpO1xuICAgICAgICB9XG4gICAgICAgIG1hdGNoKC9eKFs7XFxzXSopKy8pO1xuICAgICAgICB2YXIgY29tbWVudF9yZWdleHAgPSAvXFwvXFwqW14qXSpcXCorKFteLypdW14qXSpcXCorKSpcXC8vZztcbiAgICAgICAgdmFyIHByb3AgPSBtYXRjaCgvXihcXCo/Wy0jLypcXFxcXFx3XSsoXFxbWzAtOWEtel8tXStcXF0pPylcXHMqLyk7XG4gICAgICAgIGlmICghcHJvcCkge1xuICAgICAgICAgICAgcmV0dXJuO1xuICAgICAgICB9XG4gICAgICAgIHByb3AgPSBwcm9wWzBdLnRyaW0oKTtcbiAgICAgICAgaWYgKCFtYXRjaCgvXjpcXHMqLykpIHtcbiAgICAgICAgICAgIHJldHVybiBlcnJvcihcInByb3BlcnR5IG1pc3NpbmcgJzonXCIpO1xuICAgICAgICB9XG4gICAgICAgIHZhciB2YWwgPSBtYXRjaCgvXigoPzpcXC9cXCouKj9cXCpcXC98Jyg/OlxcXFwnfC4pKj8nfFwiKD86XFxcXFwifC4pKj9cInxcXCgoXFxzKicoPzpcXFxcJ3wuKSo/J3xcIig/OlxcXFxcInwuKSo/XCJ8W14pXSo/KVxccypcXCl8W159O10pKykvKTtcbiAgICAgICAgdmFyIHJldCA9IHtcbiAgICAgICAgICAgIHR5cGU6IFwiZGVjbGFyYXRpb25cIixcbiAgICAgICAgICAgIHByb3BlcnR5OiBwcm9wLnJlcGxhY2UoY29tbWVudF9yZWdleHAsIFwiXCIpLFxuICAgICAgICAgICAgdmFsdWU6IHZhbCA/IHZhbFswXS5yZXBsYWNlKGNvbW1lbnRfcmVnZXhwLCBcIlwiKS50cmltKCkgOiBcIlwiXG4gICAgICAgIH07XG4gICAgICAgIG1hdGNoKC9eWztcXHNdKi8pO1xuICAgICAgICByZXR1cm4gcmV0O1xuICAgIH1cbiAgICBmdW5jdGlvbiBkZWNsYXJhdGlvbnMoKSB7XG4gICAgICAgIGlmICghb3BlbigpKSB7XG4gICAgICAgICAgICByZXR1cm4gZXJyb3IoXCJtaXNzaW5nICd7J1wiKTtcbiAgICAgICAgfVxuICAgICAgICB2YXIgZDtcbiAgICAgICAgdmFyIGRlY2xzID0gY29tbWVudHMoKTtcbiAgICAgICAgd2hpbGUgKGQgPSBkZWNsYXJhdGlvbigpKSB7XG4gICAgICAgICAgICBkZWNscy5wdXNoKGQpO1xuICAgICAgICAgICAgZGVjbHMgPSBkZWNscy5jb25jYXQoY29tbWVudHMoKSk7XG4gICAgICAgIH1cbiAgICAgICAgaWYgKCFjbG9zZSgpKSB7XG4gICAgICAgICAgICByZXR1cm4gZXJyb3IoXCJtaXNzaW5nICd9J1wiKTtcbiAgICAgICAgfVxuICAgICAgICByZXR1cm4gZGVjbHM7XG4gICAgfVxuICAgIGZ1bmN0aW9uIGtleWZyYW1lKCkge1xuICAgICAgICB3aGl0ZXNwYWNlKCk7XG4gICAgICAgIHZhciB2YWxzID0gW107XG4gICAgICAgIHZhciBtO1xuICAgICAgICB3aGlsZSAobSA9IG1hdGNoKC9eKChcXGQrXFwuXFxkK3xcXC5cXGQrfFxcZCspJT98W2Etel0rKVxccyovKSkge1xuICAgICAgICAgICAgdmFscy5wdXNoKG1bMV0pO1xuICAgICAgICAgICAgbWF0Y2goL14sXFxzKi8pO1xuICAgICAgICB9XG4gICAgICAgIGlmICh2YWxzLmxlbmd0aCkge1xuICAgICAgICAgICAgcmV0dXJuIHtcbiAgICAgICAgICAgICAgICB0eXBlOiBcImtleWZyYW1lXCIsXG4gICAgICAgICAgICAgICAgdmFsdWVzOiB2YWxzLFxuICAgICAgICAgICAgICAgIGRlY2xhcmF0aW9uczogZGVjbGFyYXRpb25zKClcbiAgICAgICAgICAgIH07XG4gICAgICAgIH1cbiAgICB9XG4gICAgZnVuY3Rpb24gYXRfa2V5ZnJhbWVzKCkge1xuICAgICAgICB2YXIgbSA9IG1hdGNoKC9eQChbLVxcd10rKT9rZXlmcmFtZXNcXHMqLyk7XG4gICAgICAgIGlmICghbSkge1xuICAgICAgICAgICAgcmV0dXJuO1xuICAgICAgICB9XG4gICAgICAgIHZhciB2ZW5kb3IgPSBtWzFdO1xuICAgICAgICBtID0gbWF0Y2goL14oWy1cXHddKylcXHMqLyk7XG4gICAgICAgIGlmICghbSkge1xuICAgICAgICAgICAgcmV0dXJuIGVycm9yKFwiQGtleWZyYW1lcyBtaXNzaW5nIG5hbWVcIik7XG4gICAgICAgIH1cbiAgICAgICAgdmFyIG5hbWUgPSBtWzFdO1xuICAgICAgICBpZiAoIW9wZW4oKSkge1xuICAgICAgICAgICAgcmV0dXJuIGVycm9yKFwiQGtleWZyYW1lcyBtaXNzaW5nICd7J1wiKTtcbiAgICAgICAgfVxuICAgICAgICB2YXIgZnJhbWU7XG4gICAgICAgIHZhciBmcmFtZXMgPSBjb21tZW50cygpO1xuICAgICAgICB3aGlsZSAoZnJhbWUgPSBrZXlmcmFtZSgpKSB7XG4gICAgICAgICAgICBmcmFtZXMucHVzaChmcmFtZSk7XG4gICAgICAgICAgICBmcmFtZXMgPSBmcmFtZXMuY29uY2F0KGNvbW1lbnRzKCkpO1xuICAgICAgICB9XG4gICAgICAgIGlmICghY2xvc2UoKSkge1xuICAgICAgICAgICAgcmV0dXJuIGVycm9yKFwiQGtleWZyYW1lcyBtaXNzaW5nICd9J1wiKTtcbiAgICAgICAgfVxuICAgICAgICByZXR1cm4ge1xuICAgICAgICAgICAgdHlwZTogXCJrZXlmcmFtZXNcIixcbiAgICAgICAgICAgIG5hbWU6IG5hbWUsXG4gICAgICAgICAgICB2ZW5kb3I6IHZlbmRvcixcbiAgICAgICAgICAgIGtleWZyYW1lczogZnJhbWVzXG4gICAgICAgIH07XG4gICAgfVxuICAgIGZ1bmN0aW9uIGF0X3BhZ2UoKSB7XG4gICAgICAgIHZhciBtID0gbWF0Y2goL15AcGFnZSAqLyk7XG4gICAgICAgIGlmIChtKSB7XG4gICAgICAgICAgICB2YXIgc2VsID0gc2VsZWN0b3IoKSB8fCBbXTtcbiAgICAgICAgICAgIHJldHVybiB7XG4gICAgICAgICAgICAgICAgdHlwZTogXCJwYWdlXCIsXG4gICAgICAgICAgICAgICAgc2VsZWN0b3JzOiBzZWwsXG4gICAgICAgICAgICAgICAgZGVjbGFyYXRpb25zOiBkZWNsYXJhdGlvbnMoKVxuICAgICAgICAgICAgfTtcbiAgICAgICAgfVxuICAgIH1cbiAgICBmdW5jdGlvbiBhdF9wYWdlX21hcmdpbl9ib3goKSB7XG4gICAgICAgIHZhciBtID0gbWF0Y2goL0AodG9wfGJvdHRvbXxsZWZ0fHJpZ2h0KS0obGVmdHxjZW50ZXJ8cmlnaHR8dG9wfG1pZGRsZXxib3R0b20pLT8oY29ybmVyKT9cXHMqLyk7XG4gICAgICAgIGlmIChtKSB7XG4gICAgICAgICAgICB2YXIgbmFtZSA9IFwiXCIuY29uY2F0KG1bMV0sIFwiLVwiKS5jb25jYXQobVsyXSkgKyAobVszXSA/IFwiLVwiLmNvbmNhdChtWzNdKSA6IFwiXCIpO1xuICAgICAgICAgICAgcmV0dXJuIHtcbiAgICAgICAgICAgICAgICB0eXBlOiBcInBhZ2UtbWFyZ2luLWJveFwiLFxuICAgICAgICAgICAgICAgIG5hbWU6IG5hbWUsXG4gICAgICAgICAgICAgICAgZGVjbGFyYXRpb25zOiBkZWNsYXJhdGlvbnMoKVxuICAgICAgICAgICAgfTtcbiAgICAgICAgfVxuICAgIH1cbiAgICBmdW5jdGlvbiBhdF9mb250ZmFjZSgpIHtcbiAgICAgICAgdmFyIG0gPSBtYXRjaCgvXkBmb250LWZhY2VcXHMqLyk7XG4gICAgICAgIGlmIChtKSB7XG4gICAgICAgICAgICByZXR1cm4ge1xuICAgICAgICAgICAgICAgIHR5cGU6IFwiZm9udC1mYWNlXCIsXG4gICAgICAgICAgICAgICAgZGVjbGFyYXRpb25zOiBkZWNsYXJhdGlvbnMoKVxuICAgICAgICAgICAgfTtcbiAgICAgICAgfVxuICAgIH1cbiAgICBmdW5jdGlvbiBhdF9zdXBwb3J0cygpIHtcbiAgICAgICAgdmFyIG0gPSBtYXRjaCgvXkBzdXBwb3J0cyAqKFtee10rKS8pO1xuICAgICAgICBpZiAobSkge1xuICAgICAgICAgICAgcmV0dXJuIHtcbiAgICAgICAgICAgICAgICB0eXBlOiBcInN1cHBvcnRzXCIsXG4gICAgICAgICAgICAgICAgc3VwcG9ydHM6IG1bMV0udHJpbSgpLFxuICAgICAgICAgICAgICAgIHJ1bGVzOiBydWxlcygpXG4gICAgICAgICAgICB9O1xuICAgICAgICB9XG4gICAgfVxuICAgIGZ1bmN0aW9uIGF0X2hvc3QoKSB7XG4gICAgICAgIHZhciBtID0gbWF0Y2goL15AaG9zdFxccyovKTtcbiAgICAgICAgaWYgKG0pIHtcbiAgICAgICAgICAgIHJldHVybiB7XG4gICAgICAgICAgICAgICAgdHlwZTogXCJob3N0XCIsXG4gICAgICAgICAgICAgICAgcnVsZXM6IHJ1bGVzKClcbiAgICAgICAgICAgIH07XG4gICAgICAgIH1cbiAgICB9XG4gICAgZnVuY3Rpb24gYXRfbWVkaWEoKSB7XG4gICAgICAgIHZhciBtID0gbWF0Y2goL15AbWVkaWEoW157XSspKi8pO1xuICAgICAgICBpZiAobSkge1xuICAgICAgICAgICAgcmV0dXJuIHtcbiAgICAgICAgICAgICAgICB0eXBlOiBcIm1lZGlhXCIsXG4gICAgICAgICAgICAgICAgbWVkaWE6IChtWzFdIHx8IFwiXCIpLnRyaW0oKSxcbiAgICAgICAgICAgICAgICBydWxlczogcnVsZXMoKVxuICAgICAgICAgICAgfTtcbiAgICAgICAgfVxuICAgIH1cbiAgICBmdW5jdGlvbiBhdF9jdXN0b21fbSgpIHtcbiAgICAgICAgdmFyIG0gPSBtYXRjaCgvXkBjdXN0b20tbWVkaWFcXHMrKC0tW15cXHNdKylcXHMqKFteeztdKyk7Lyk7XG4gICAgICAgIGlmIChtKSB7XG4gICAgICAgICAgICByZXR1cm4ge1xuICAgICAgICAgICAgICAgIHR5cGU6IFwiY3VzdG9tLW1lZGlhXCIsXG4gICAgICAgICAgICAgICAgbmFtZTogbVsxXS50cmltKCksXG4gICAgICAgICAgICAgICAgbWVkaWE6IG1bMl0udHJpbSgpXG4gICAgICAgICAgICB9O1xuICAgICAgICB9XG4gICAgfVxuICAgIGZ1bmN0aW9uIGF0X2RvY3VtZW50KCkge1xuICAgICAgICB2YXIgbSA9IG1hdGNoKC9eQChbLVxcd10rKT9kb2N1bWVudCAqKFtee10rKS8pO1xuICAgICAgICBpZiAobSkge1xuICAgICAgICAgICAgcmV0dXJuIHtcbiAgICAgICAgICAgICAgICB0eXBlOiBcImRvY3VtZW50XCIsXG4gICAgICAgICAgICAgICAgZG9jdW1lbnQ6IG1bMl0udHJpbSgpLFxuICAgICAgICAgICAgICAgIHZlbmRvcjogbVsxXSA/IG1bMV0udHJpbSgpIDogbnVsbCxcbiAgICAgICAgICAgICAgICBydWxlczogcnVsZXMoKVxuICAgICAgICAgICAgfTtcbiAgICAgICAgfVxuICAgIH1cbiAgICBmdW5jdGlvbiBhdF94KCkge1xuICAgICAgICB2YXIgbSA9IG1hdGNoKC9eQChpbXBvcnR8Y2hhcnNldHxuYW1lc3BhY2UpXFxzKihbXjtdKyk7Lyk7XG4gICAgICAgIGlmIChtKSB7XG4gICAgICAgICAgICByZXR1cm4ge1xuICAgICAgICAgICAgICAgIHR5cGU6IG1bMV0sXG4gICAgICAgICAgICAgICAgbmFtZTogbVsyXS50cmltKClcbiAgICAgICAgICAgIH07XG4gICAgICAgIH1cbiAgICB9XG4gICAgZnVuY3Rpb24gYXRfcnVsZSgpIHtcbiAgICAgICAgd2hpdGVzcGFjZSgpO1xuICAgICAgICBpZiAoY3NzWzBdID09PSBcIkBcIikge1xuICAgICAgICAgICAgdmFyIHJldCA9IGF0X3goKSB8fCBhdF9mb250ZmFjZSgpIHx8IGF0X21lZGlhKCkgfHwgYXRfa2V5ZnJhbWVzKCkgfHwgYXRfc3VwcG9ydHMoKSB8fCBhdF9kb2N1bWVudCgpIHx8IGF0X2N1c3RvbV9tKCkgfHwgYXRfaG9zdCgpIHx8IGF0X3BhZ2UoKSB8fCBhdF9wYWdlX21hcmdpbl9ib3goKTtcbiAgICAgICAgICAgIGlmIChyZXQgJiYgIXNldHRpbmdzLnByZXNlcnZlU3RhdGljKSB7XG4gICAgICAgICAgICAgICAgdmFyIGhhc1ZhckZ1bmMgPSBmYWxzZTtcbiAgICAgICAgICAgICAgICBpZiAocmV0LmRlY2xhcmF0aW9ucykge1xuICAgICAgICAgICAgICAgICAgICBoYXNWYXJGdW5jID0gcmV0LmRlY2xhcmF0aW9ucy5zb21lKChmdW5jdGlvbihkZWNsKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gL3ZhclxcKC8udGVzdChkZWNsLnZhbHVlKTtcbiAgICAgICAgICAgICAgICAgICAgfSkpO1xuICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICAgIHZhciBhcnIgPSByZXQua2V5ZnJhbWVzIHx8IHJldC5ydWxlcyB8fCBbXTtcbiAgICAgICAgICAgICAgICAgICAgaGFzVmFyRnVuYyA9IGFyci5zb21lKChmdW5jdGlvbihvYmopIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiAob2JqLmRlY2xhcmF0aW9ucyB8fCBbXSkuc29tZSgoZnVuY3Rpb24oZGVjbCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiAvdmFyXFwoLy50ZXN0KGRlY2wudmFsdWUpO1xuICAgICAgICAgICAgICAgICAgICAgICAgfSkpO1xuICAgICAgICAgICAgICAgICAgICB9KSk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIHJldHVybiBoYXNWYXJGdW5jID8gcmV0IDoge307XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICByZXR1cm4gcmV0O1xuICAgICAgICB9XG4gICAgfVxuICAgIGZ1bmN0aW9uIHJ1bGUoKSB7XG4gICAgICAgIGlmICghc2V0dGluZ3MucHJlc2VydmVTdGF0aWMpIHtcbiAgICAgICAgICAgIHZhciBiYWxhbmNlZE1hdGNoJDEgPSBiYWxhbmNlZE1hdGNoKFwie1wiLCBcIn1cIiwgY3NzKTtcbiAgICAgICAgICAgIGlmIChiYWxhbmNlZE1hdGNoJDEpIHtcbiAgICAgICAgICAgICAgICB2YXIgaGFzVmFyRGVjbCA9IC86KD86cm9vdHxob3N0KSg/IVsuOiMoXSkvLnRlc3QoYmFsYW5jZWRNYXRjaCQxLnByZSkgJiYgLy0tXFxTKlxccyo6Ly50ZXN0KGJhbGFuY2VkTWF0Y2gkMS5ib2R5KTtcbiAgICAgICAgICAgICAgICB2YXIgaGFzVmFyRnVuYyA9IC92YXJcXCgvLnRlc3QoYmFsYW5jZWRNYXRjaCQxLmJvZHkpO1xuICAgICAgICAgICAgICAgIGlmICghaGFzVmFyRGVjbCAmJiAhaGFzVmFyRnVuYykge1xuICAgICAgICAgICAgICAgICAgICBjc3MgPSBjc3Muc2xpY2UoYmFsYW5jZWRNYXRjaCQxLmVuZCArIDEpO1xuICAgICAgICAgICAgICAgICAgICByZXR1cm4ge307XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICAgIHZhciBzZWwgPSBzZWxlY3RvcigpIHx8IFtdO1xuICAgICAgICB2YXIgZGVjbHMgPSBzZXR0aW5ncy5wcmVzZXJ2ZVN0YXRpYyA/IGRlY2xhcmF0aW9ucygpIDogZGVjbGFyYXRpb25zKCkuZmlsdGVyKChmdW5jdGlvbihkZWNsKSB7XG4gICAgICAgICAgICB2YXIgaGFzVmFyRGVjbCA9IHNlbC5zb21lKChmdW5jdGlvbihzKSB7XG4gICAgICAgICAgICAgICAgcmV0dXJuIC86KD86cm9vdHxob3N0KSg/IVsuOiMoXSkvLnRlc3Qocyk7XG4gICAgICAgICAgICB9KSkgJiYgL14tLVxcUy8udGVzdChkZWNsLnByb3BlcnR5KTtcbiAgICAgICAgICAgIHZhciBoYXNWYXJGdW5jID0gL3ZhclxcKC8udGVzdChkZWNsLnZhbHVlKTtcbiAgICAgICAgICAgIHJldHVybiBoYXNWYXJEZWNsIHx8IGhhc1ZhckZ1bmM7XG4gICAgICAgIH0pKTtcbiAgICAgICAgaWYgKCFzZWwubGVuZ3RoKSB7XG4gICAgICAgICAgICBlcnJvcihcInNlbGVjdG9yIG1pc3NpbmdcIik7XG4gICAgICAgIH1cbiAgICAgICAgcmV0dXJuIHtcbiAgICAgICAgICAgIHR5cGU6IFwicnVsZVwiLFxuICAgICAgICAgICAgc2VsZWN0b3JzOiBzZWwsXG4gICAgICAgICAgICBkZWNsYXJhdGlvbnM6IGRlY2xzXG4gICAgICAgIH07XG4gICAgfVxuICAgIGZ1bmN0aW9uIHJ1bGVzKGNvcmUpIHtcbiAgICAgICAgaWYgKCFjb3JlICYmICFvcGVuKCkpIHtcbiAgICAgICAgICAgIHJldHVybiBlcnJvcihcIm1pc3NpbmcgJ3snXCIpO1xuICAgICAgICB9XG4gICAgICAgIHZhciBub2RlO1xuICAgICAgICB2YXIgcnVsZXMgPSBjb21tZW50cygpO1xuICAgICAgICB3aGlsZSAoY3NzLmxlbmd0aCAmJiAoY29yZSB8fCBjc3NbMF0gIT09IFwifVwiKSAmJiAobm9kZSA9IGF0X3J1bGUoKSB8fCBydWxlKCkpKSB7XG4gICAgICAgICAgICBpZiAobm9kZS50eXBlKSB7XG4gICAgICAgICAgICAgICAgcnVsZXMucHVzaChub2RlKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIHJ1bGVzID0gcnVsZXMuY29uY2F0KGNvbW1lbnRzKCkpO1xuICAgICAgICB9XG4gICAgICAgIGlmICghY29yZSAmJiAhY2xvc2UoKSkge1xuICAgICAgICAgICAgcmV0dXJuIGVycm9yKFwibWlzc2luZyAnfSdcIik7XG4gICAgICAgIH1cbiAgICAgICAgcmV0dXJuIHJ1bGVzO1xuICAgIH1cbiAgICByZXR1cm4ge1xuICAgICAgICB0eXBlOiBcInN0eWxlc2hlZXRcIixcbiAgICAgICAgc3R5bGVzaGVldDoge1xuICAgICAgICAgICAgcnVsZXM6IHJ1bGVzKHRydWUpLFxuICAgICAgICAgICAgZXJyb3JzOiBlcnJvcnNcbiAgICAgICAgfVxuICAgIH07XG59XG5cbmZ1bmN0aW9uIHBhcnNlVmFycyhjc3NEYXRhKSB7XG4gICAgdmFyIG9wdGlvbnMgPSBhcmd1bWVudHMubGVuZ3RoID4gMSAmJiBhcmd1bWVudHNbMV0gIT09IHVuZGVmaW5lZCA/IGFyZ3VtZW50c1sxXSA6IHt9O1xuICAgIHZhciBkZWZhdWx0cyA9IHtcbiAgICAgICAgcGFyc2VIb3N0OiBmYWxzZSxcbiAgICAgICAgc3RvcmU6IHt9LFxuICAgICAgICBvbldhcm5pbmc6IGZ1bmN0aW9uIG9uV2FybmluZygpIHt9XG4gICAgfTtcbiAgICB2YXIgc2V0dGluZ3MgPSBfZXh0ZW5kcyh7fSwgZGVmYXVsdHMsIG9wdGlvbnMpO1xuICAgIHZhciByZVZhckRlY2xTZWxlY3RvcnMgPSBuZXcgUmVnRXhwKFwiOlwiLmNvbmNhdChzZXR0aW5ncy5wYXJzZUhvc3QgPyBcImhvc3RcIiA6IFwicm9vdFwiLCBcIiRcIikpO1xuICAgIGlmICh0eXBlb2YgY3NzRGF0YSA9PT0gXCJzdHJpbmdcIikge1xuICAgICAgICBjc3NEYXRhID0gcGFyc2VDc3MoY3NzRGF0YSwgc2V0dGluZ3MpO1xuICAgIH1cbiAgICBjc3NEYXRhLnN0eWxlc2hlZXQucnVsZXMuZm9yRWFjaCgoZnVuY3Rpb24ocnVsZSkge1xuICAgICAgICBpZiAocnVsZS50eXBlICE9PSBcInJ1bGVcIiB8fCAhcnVsZS5zZWxlY3RvcnMuc29tZSgoZnVuY3Rpb24ocykge1xuICAgICAgICAgICAgcmV0dXJuIHJlVmFyRGVjbFNlbGVjdG9ycy50ZXN0KHMpO1xuICAgICAgICB9KSkpIHtcbiAgICAgICAgICAgIHJldHVybjtcbiAgICAgICAgfVxuICAgICAgICBydWxlLmRlY2xhcmF0aW9ucy5mb3JFYWNoKChmdW5jdGlvbihkZWNsLCBpKSB7XG4gICAgICAgICAgICB2YXIgcHJvcCA9IGRlY2wucHJvcGVydHk7XG4gICAgICAgICAgICB2YXIgdmFsdWUgPSBkZWNsLnZhbHVlO1xuICAgICAgICAgICAgaWYgKHByb3AgJiYgcHJvcC5pbmRleE9mKFwiLS1cIikgPT09IDApIHtcbiAgICAgICAgICAgICAgICBzZXR0aW5ncy5zdG9yZVtwcm9wXSA9IHZhbHVlO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KSk7XG4gICAgfSkpO1xuICAgIHJldHVybiBzZXR0aW5ncy5zdG9yZTtcbn1cblxuZnVuY3Rpb24gc3RyaW5naWZ5Q3NzKHRyZWUpIHtcbiAgICB2YXIgZGVsaW0gPSBhcmd1bWVudHMubGVuZ3RoID4gMSAmJiBhcmd1bWVudHNbMV0gIT09IHVuZGVmaW5lZCA/IGFyZ3VtZW50c1sxXSA6IFwiXCI7XG4gICAgdmFyIGNiID0gYXJndW1lbnRzLmxlbmd0aCA+IDIgPyBhcmd1bWVudHNbMl0gOiB1bmRlZmluZWQ7XG4gICAgdmFyIHJlbmRlck1ldGhvZHMgPSB7XG4gICAgICAgIGNoYXJzZXQ6IGZ1bmN0aW9uIGNoYXJzZXQobm9kZSkge1xuICAgICAgICAgICAgcmV0dXJuIFwiQGNoYXJzZXQgXCIgKyBub2RlLm5hbWUgKyBcIjtcIjtcbiAgICAgICAgfSxcbiAgICAgICAgY29tbWVudDogZnVuY3Rpb24gY29tbWVudChub2RlKSB7XG4gICAgICAgICAgICByZXR1cm4gbm9kZS5jb21tZW50LmluZGV4T2YoXCJfX0NTU1ZBUlNQT05ZRklMTFwiKSA9PT0gMCA/IFwiLypcIiArIG5vZGUuY29tbWVudCArIFwiKi9cIiA6IFwiXCI7XG4gICAgICAgIH0sXG4gICAgICAgIFwiY3VzdG9tLW1lZGlhXCI6IGZ1bmN0aW9uIGN1c3RvbU1lZGlhKG5vZGUpIHtcbiAgICAgICAgICAgIHJldHVybiBcIkBjdXN0b20tbWVkaWEgXCIgKyBub2RlLm5hbWUgKyBcIiBcIiArIG5vZGUubWVkaWEgKyBcIjtcIjtcbiAgICAgICAgfSxcbiAgICAgICAgZGVjbGFyYXRpb246IGZ1bmN0aW9uIGRlY2xhcmF0aW9uKG5vZGUpIHtcbiAgICAgICAgICAgIHJldHVybiBub2RlLnByb3BlcnR5ICsgXCI6XCIgKyBub2RlLnZhbHVlICsgXCI7XCI7XG4gICAgICAgIH0sXG4gICAgICAgIGRvY3VtZW50OiBmdW5jdGlvbiBkb2N1bWVudChub2RlKSB7XG4gICAgICAgICAgICByZXR1cm4gXCJAXCIgKyAobm9kZS52ZW5kb3IgfHwgXCJcIikgKyBcImRvY3VtZW50IFwiICsgbm9kZS5kb2N1bWVudCArIFwie1wiICsgdmlzaXQobm9kZS5ydWxlcykgKyBcIn1cIjtcbiAgICAgICAgfSxcbiAgICAgICAgXCJmb250LWZhY2VcIjogZnVuY3Rpb24gZm9udEZhY2Uobm9kZSkge1xuICAgICAgICAgICAgcmV0dXJuIFwiQGZvbnQtZmFjZVwiICsgXCJ7XCIgKyB2aXNpdChub2RlLmRlY2xhcmF0aW9ucykgKyBcIn1cIjtcbiAgICAgICAgfSxcbiAgICAgICAgaG9zdDogZnVuY3Rpb24gaG9zdChub2RlKSB7XG4gICAgICAgICAgICByZXR1cm4gXCJAaG9zdFwiICsgXCJ7XCIgKyB2aXNpdChub2RlLnJ1bGVzKSArIFwifVwiO1xuICAgICAgICB9LFxuICAgICAgICBpbXBvcnQ6IGZ1bmN0aW9uIF9pbXBvcnQobm9kZSkge1xuICAgICAgICAgICAgcmV0dXJuIFwiQGltcG9ydCBcIiArIG5vZGUubmFtZSArIFwiO1wiO1xuICAgICAgICB9LFxuICAgICAgICBrZXlmcmFtZTogZnVuY3Rpb24ga2V5ZnJhbWUobm9kZSkge1xuICAgICAgICAgICAgcmV0dXJuIG5vZGUudmFsdWVzLmpvaW4oXCIsXCIpICsgXCJ7XCIgKyB2aXNpdChub2RlLmRlY2xhcmF0aW9ucykgKyBcIn1cIjtcbiAgICAgICAgfSxcbiAgICAgICAga2V5ZnJhbWVzOiBmdW5jdGlvbiBrZXlmcmFtZXMobm9kZSkge1xuICAgICAgICAgICAgcmV0dXJuIFwiQFwiICsgKG5vZGUudmVuZG9yIHx8IFwiXCIpICsgXCJrZXlmcmFtZXMgXCIgKyBub2RlLm5hbWUgKyBcIntcIiArIHZpc2l0KG5vZGUua2V5ZnJhbWVzKSArIFwifVwiO1xuICAgICAgICB9LFxuICAgICAgICBtZWRpYTogZnVuY3Rpb24gbWVkaWEobm9kZSkge1xuICAgICAgICAgICAgcmV0dXJuIFwiQG1lZGlhIFwiICsgbm9kZS5tZWRpYSArIFwie1wiICsgdmlzaXQobm9kZS5ydWxlcykgKyBcIn1cIjtcbiAgICAgICAgfSxcbiAgICAgICAgbmFtZXNwYWNlOiBmdW5jdGlvbiBuYW1lc3BhY2Uobm9kZSkge1xuICAgICAgICAgICAgcmV0dXJuIFwiQG5hbWVzcGFjZSBcIiArIG5vZGUubmFtZSArIFwiO1wiO1xuICAgICAgICB9LFxuICAgICAgICBwYWdlOiBmdW5jdGlvbiBwYWdlKG5vZGUpIHtcbiAgICAgICAgICAgIHJldHVybiBcIkBwYWdlIFwiICsgKG5vZGUuc2VsZWN0b3JzLmxlbmd0aCA/IG5vZGUuc2VsZWN0b3JzLmpvaW4oXCIsIFwiKSA6IFwiXCIpICsgXCJ7XCIgKyB2aXNpdChub2RlLmRlY2xhcmF0aW9ucykgKyBcIn1cIjtcbiAgICAgICAgfSxcbiAgICAgICAgXCJwYWdlLW1hcmdpbi1ib3hcIjogZnVuY3Rpb24gcGFnZU1hcmdpbkJveChub2RlKSB7XG4gICAgICAgICAgICByZXR1cm4gXCJAXCIgKyBub2RlLm5hbWUgKyBcIntcIiArIHZpc2l0KG5vZGUuZGVjbGFyYXRpb25zKSArIFwifVwiO1xuICAgICAgICB9LFxuICAgICAgICBydWxlOiBmdW5jdGlvbiBydWxlKG5vZGUpIHtcbiAgICAgICAgICAgIHZhciBkZWNscyA9IG5vZGUuZGVjbGFyYXRpb25zO1xuICAgICAgICAgICAgaWYgKGRlY2xzLmxlbmd0aCkge1xuICAgICAgICAgICAgICAgIHJldHVybiBub2RlLnNlbGVjdG9ycy5qb2luKFwiLFwiKSArIFwie1wiICsgdmlzaXQoZGVjbHMpICsgXCJ9XCI7XG4gICAgICAgICAgICB9XG4gICAgICAgIH0sXG4gICAgICAgIHN1cHBvcnRzOiBmdW5jdGlvbiBzdXBwb3J0cyhub2RlKSB7XG4gICAgICAgICAgICByZXR1cm4gXCJAc3VwcG9ydHMgXCIgKyBub2RlLnN1cHBvcnRzICsgXCJ7XCIgKyB2aXNpdChub2RlLnJ1bGVzKSArIFwifVwiO1xuICAgICAgICB9XG4gICAgfTtcbiAgICBmdW5jdGlvbiB2aXNpdChub2Rlcykge1xuICAgICAgICB2YXIgYnVmID0gXCJcIjtcbiAgICAgICAgZm9yICh2YXIgaSA9IDA7IGkgPCBub2Rlcy5sZW5ndGg7IGkrKykge1xuICAgICAgICAgICAgdmFyIG4gPSBub2Rlc1tpXTtcbiAgICAgICAgICAgIGlmIChjYikge1xuICAgICAgICAgICAgICAgIGNiKG4pO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgdmFyIHR4dCA9IHJlbmRlck1ldGhvZHNbbi50eXBlXShuKTtcbiAgICAgICAgICAgIGlmICh0eHQpIHtcbiAgICAgICAgICAgICAgICBidWYgKz0gdHh0O1xuICAgICAgICAgICAgICAgIGlmICh0eHQubGVuZ3RoICYmIG4uc2VsZWN0b3JzKSB7XG4gICAgICAgICAgICAgICAgICAgIGJ1ZiArPSBkZWxpbTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICAgICAgcmV0dXJuIGJ1ZjtcbiAgICB9XG4gICAgcmV0dXJuIHZpc2l0KHRyZWUuc3R5bGVzaGVldC5ydWxlcyk7XG59XG5cbmZ1bmN0aW9uIHdhbGtDc3Mobm9kZSwgZm4pIHtcbiAgICBub2RlLnJ1bGVzLmZvckVhY2goKGZ1bmN0aW9uKHJ1bGUpIHtcbiAgICAgICAgaWYgKHJ1bGUucnVsZXMpIHtcbiAgICAgICAgICAgIHdhbGtDc3MocnVsZSwgZm4pO1xuICAgICAgICAgICAgcmV0dXJuO1xuICAgICAgICB9XG4gICAgICAgIGlmIChydWxlLmtleWZyYW1lcykge1xuICAgICAgICAgICAgcnVsZS5rZXlmcmFtZXMuZm9yRWFjaCgoZnVuY3Rpb24oa2V5ZnJhbWUpIHtcbiAgICAgICAgICAgICAgICBpZiAoa2V5ZnJhbWUudHlwZSA9PT0gXCJrZXlmcmFtZVwiKSB7XG4gICAgICAgICAgICAgICAgICAgIGZuKGtleWZyYW1lLmRlY2xhcmF0aW9ucywgcnVsZSk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSkpO1xuICAgICAgICAgICAgcmV0dXJuO1xuICAgICAgICB9XG4gICAgICAgIGlmICghcnVsZS5kZWNsYXJhdGlvbnMpIHtcbiAgICAgICAgICAgIHJldHVybjtcbiAgICAgICAgfVxuICAgICAgICBmbihydWxlLmRlY2xhcmF0aW9ucywgbm9kZSk7XG4gICAgfSkpO1xufVxuXG52YXIgVkFSX1BST1BfSURFTlRJRklFUiA9IFwiLS1cIjtcblxudmFyIFZBUl9GVU5DX0lERU5USUZJRVIgPSBcInZhclwiO1xuXG5mdW5jdGlvbiB0cmFuc2Zvcm1Dc3MoY3NzRGF0YSkge1xuICAgIHZhciBvcHRpb25zID0gYXJndW1lbnRzLmxlbmd0aCA+IDEgJiYgYXJndW1lbnRzWzFdICE9PSB1bmRlZmluZWQgPyBhcmd1bWVudHNbMV0gOiB7fTtcbiAgICB2YXIgZGVmYXVsdHMgPSB7XG4gICAgICAgIHByZXNlcnZlU3RhdGljOiB0cnVlLFxuICAgICAgICBwcmVzZXJ2ZVZhcnM6IGZhbHNlLFxuICAgICAgICB2YXJpYWJsZXM6IHt9LFxuICAgICAgICBvbldhcm5pbmc6IGZ1bmN0aW9uIG9uV2FybmluZygpIHt9XG4gICAgfTtcbiAgICB2YXIgc2V0dGluZ3MgPSBfZXh0ZW5kcyh7fSwgZGVmYXVsdHMsIG9wdGlvbnMpO1xuICAgIGlmICh0eXBlb2YgY3NzRGF0YSA9PT0gXCJzdHJpbmdcIikge1xuICAgICAgICBjc3NEYXRhID0gcGFyc2VDc3MoY3NzRGF0YSwgc2V0dGluZ3MpO1xuICAgIH1cbiAgICB3YWxrQ3NzKGNzc0RhdGEuc3R5bGVzaGVldCwgKGZ1bmN0aW9uKGRlY2xhcmF0aW9ucywgbm9kZSkge1xuICAgICAgICBmb3IgKHZhciBpID0gMDsgaSA8IGRlY2xhcmF0aW9ucy5sZW5ndGg7IGkrKykge1xuICAgICAgICAgICAgdmFyIGRlY2wgPSBkZWNsYXJhdGlvbnNbaV07XG4gICAgICAgICAgICB2YXIgdHlwZSA9IGRlY2wudHlwZTtcbiAgICAgICAgICAgIHZhciBwcm9wID0gZGVjbC5wcm9wZXJ0eTtcbiAgICAgICAgICAgIHZhciB2YWx1ZSA9IGRlY2wudmFsdWU7XG4gICAgICAgICAgICBpZiAodHlwZSAhPT0gXCJkZWNsYXJhdGlvblwiKSB7XG4gICAgICAgICAgICAgICAgY29udGludWU7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBpZiAoIXNldHRpbmdzLnByZXNlcnZlVmFycyAmJiBwcm9wICYmIHByb3AuaW5kZXhPZihWQVJfUFJPUF9JREVOVElGSUVSKSA9PT0gMCkge1xuICAgICAgICAgICAgICAgIGRlY2xhcmF0aW9ucy5zcGxpY2UoaSwgMSk7XG4gICAgICAgICAgICAgICAgaS0tO1xuICAgICAgICAgICAgICAgIGNvbnRpbnVlO1xuICAgICAgICAgICAgfVxuICAgICAgICAgICAgaWYgKHZhbHVlLmluZGV4T2YoVkFSX0ZVTkNfSURFTlRJRklFUiArIFwiKFwiKSAhPT0gLTEpIHtcbiAgICAgICAgICAgICAgICB2YXIgcmVzb2x2ZWRWYWx1ZSA9IHJlc29sdmVWYWx1ZSh2YWx1ZSwgc2V0dGluZ3MpO1xuICAgICAgICAgICAgICAgIGlmIChyZXNvbHZlZFZhbHVlICE9PSBkZWNsLnZhbHVlKSB7XG4gICAgICAgICAgICAgICAgICAgIHJlc29sdmVkVmFsdWUgPSBmaXhOZXN0ZWRDYWxjKHJlc29sdmVkVmFsdWUpO1xuICAgICAgICAgICAgICAgICAgICBpZiAoIXNldHRpbmdzLnByZXNlcnZlVmFycykge1xuICAgICAgICAgICAgICAgICAgICAgICAgZGVjbC52YWx1ZSA9IHJlc29sdmVkVmFsdWU7XG4gICAgICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICAgICAgICBkZWNsYXJhdGlvbnMuc3BsaWNlKGksIDAsIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB0eXBlOiB0eXBlLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHByb3BlcnR5OiBwcm9wLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhbHVlOiByZXNvbHZlZFZhbHVlXG4gICAgICAgICAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgICAgICAgICAgICAgICAgIGkrKztcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgIH0pKTtcbiAgICByZXR1cm4gc3RyaW5naWZ5Q3NzKGNzc0RhdGEpO1xufVxuXG5mdW5jdGlvbiBmaXhOZXN0ZWRDYWxjKHZhbHVlKSB7XG4gICAgdmFyIHJlQ2FsY1ZhbCA9IC9jYWxjXFwoKFteKV0rKVxcKS9nO1xuICAgICh2YWx1ZS5tYXRjaChyZUNhbGNWYWwpIHx8IFtdKS5mb3JFYWNoKChmdW5jdGlvbihtYXRjaCkge1xuICAgICAgICB2YXIgbmV3VmFsID0gXCJjYWxjXCIuY29uY2F0KG1hdGNoLnNwbGl0KFwiY2FsY1wiKS5qb2luKFwiXCIpKTtcbiAgICAgICAgdmFsdWUgPSB2YWx1ZS5yZXBsYWNlKG1hdGNoLCBuZXdWYWwpO1xuICAgIH0pKTtcbiAgICByZXR1cm4gdmFsdWU7XG59XG5cbmZ1bmN0aW9uIHJlc29sdmVWYWx1ZSh2YWx1ZSkge1xuICAgIHZhciBzZXR0aW5ncyA9IGFyZ3VtZW50cy5sZW5ndGggPiAxICYmIGFyZ3VtZW50c1sxXSAhPT0gdW5kZWZpbmVkID8gYXJndW1lbnRzWzFdIDoge307XG4gICAgdmFyIF9fcmVjdXJzaXZlRmFsbGJhY2sgPSBhcmd1bWVudHMubGVuZ3RoID4gMiA/IGFyZ3VtZW50c1syXSA6IHVuZGVmaW5lZDtcbiAgICBpZiAodmFsdWUuaW5kZXhPZihcInZhcihcIikgPT09IC0xKSB7XG4gICAgICAgIHJldHVybiB2YWx1ZTtcbiAgICB9XG4gICAgdmFyIHZhbHVlRGF0YSA9IGJhbGFuY2VkTWF0Y2goXCIoXCIsIFwiKVwiLCB2YWx1ZSk7XG4gICAgZnVuY3Rpb24gcmVzb2x2ZUZ1bmModmFsdWUpIHtcbiAgICAgICAgdmFyIG5hbWUgPSB2YWx1ZS5zcGxpdChcIixcIilbMF0ucmVwbGFjZSgvW1xcc1xcblxcdF0vZywgXCJcIik7XG4gICAgICAgIHZhciBmYWxsYmFjayA9ICh2YWx1ZS5tYXRjaCgvKD86XFxzKixcXHMqKXsxfSguKik/LykgfHwgW10pWzFdO1xuICAgICAgICB2YXIgbWF0Y2ggPSBPYmplY3QucHJvdG90eXBlLmhhc093blByb3BlcnR5LmNhbGwoc2V0dGluZ3MudmFyaWFibGVzLCBuYW1lKSA/IFN0cmluZyhzZXR0aW5ncy52YXJpYWJsZXNbbmFtZV0pIDogdW5kZWZpbmVkO1xuICAgICAgICB2YXIgcmVwbGFjZW1lbnQgPSBtYXRjaCB8fCAoZmFsbGJhY2sgPyBTdHJpbmcoZmFsbGJhY2spIDogdW5kZWZpbmVkKTtcbiAgICAgICAgdmFyIHVucmVzb2x2ZWRGYWxsYmFjayA9IF9fcmVjdXJzaXZlRmFsbGJhY2sgfHwgdmFsdWU7XG4gICAgICAgIGlmICghbWF0Y2gpIHtcbiAgICAgICAgICAgIHNldHRpbmdzLm9uV2FybmluZygndmFyaWFibGUgXCInLmNvbmNhdChuYW1lLCAnXCIgaXMgdW5kZWZpbmVkJykpO1xuICAgICAgICB9XG4gICAgICAgIGlmIChyZXBsYWNlbWVudCAmJiByZXBsYWNlbWVudCAhPT0gXCJ1bmRlZmluZWRcIiAmJiByZXBsYWNlbWVudC5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICByZXR1cm4gcmVzb2x2ZVZhbHVlKHJlcGxhY2VtZW50LCBzZXR0aW5ncywgdW5yZXNvbHZlZEZhbGxiYWNrKTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIHJldHVybiBcInZhcihcIi5jb25jYXQodW5yZXNvbHZlZEZhbGxiYWNrLCBcIilcIik7XG4gICAgICAgIH1cbiAgICB9XG4gICAgaWYgKCF2YWx1ZURhdGEpIHtcbiAgICAgICAgaWYgKHZhbHVlLmluZGV4T2YoXCJ2YXIoXCIpICE9PSAtMSkge1xuICAgICAgICAgICAgc2V0dGluZ3Mub25XYXJuaW5nKCdtaXNzaW5nIGNsb3NpbmcgXCIpXCIgaW4gdGhlIHZhbHVlIFwiJy5jb25jYXQodmFsdWUsICdcIicpKTtcbiAgICAgICAgfVxuICAgICAgICByZXR1cm4gdmFsdWU7XG4gICAgfSBlbHNlIGlmICh2YWx1ZURhdGEucHJlLnNsaWNlKC0zKSA9PT0gXCJ2YXJcIikge1xuICAgICAgICB2YXIgaXNFbXB0eVZhckZ1bmMgPSB2YWx1ZURhdGEuYm9keS50cmltKCkubGVuZ3RoID09PSAwO1xuICAgICAgICBpZiAoaXNFbXB0eVZhckZ1bmMpIHtcbiAgICAgICAgICAgIHNldHRpbmdzLm9uV2FybmluZyhcInZhcigpIG11c3QgY29udGFpbiBhIG5vbi13aGl0ZXNwYWNlIHN0cmluZ1wiKTtcbiAgICAgICAgICAgIHJldHVybiB2YWx1ZTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIHJldHVybiB2YWx1ZURhdGEucHJlLnNsaWNlKDAsIC0zKSArIHJlc29sdmVGdW5jKHZhbHVlRGF0YS5ib2R5KSArIHJlc29sdmVWYWx1ZSh2YWx1ZURhdGEucG9zdCwgc2V0dGluZ3MpO1xuICAgICAgICB9XG4gICAgfSBlbHNlIHtcbiAgICAgICAgcmV0dXJuIHZhbHVlRGF0YS5wcmUgKyBcIihcIi5jb25jYXQocmVzb2x2ZVZhbHVlKHZhbHVlRGF0YS5ib2R5LCBzZXR0aW5ncyksIFwiKVwiKSArIHJlc29sdmVWYWx1ZSh2YWx1ZURhdGEucG9zdCwgc2V0dGluZ3MpO1xuICAgIH1cbn1cblxudmFyIGlzQnJvd3NlciA9IHR5cGVvZiB3aW5kb3cgIT09IFwidW5kZWZpbmVkXCI7XG5cbnZhciBpc05hdGl2ZVN1cHBvcnQgPSBpc0Jyb3dzZXIgJiYgd2luZG93LkNTUyAmJiB3aW5kb3cuQ1NTLnN1cHBvcnRzICYmIHdpbmRvdy5DU1Muc3VwcG9ydHMoXCIoLS1hOiAwKVwiKTtcblxudmFyIGNvdW50ZXJzID0ge1xuICAgIGdyb3VwOiAwLFxuICAgIGpvYjogMFxufTtcblxudmFyIGRlZmF1bHRzID0ge1xuICAgIHJvb3RFbGVtZW50OiBpc0Jyb3dzZXIgPyBkb2N1bWVudCA6IG51bGwsXG4gICAgc2hhZG93RE9NOiBmYWxzZSxcbiAgICBpbmNsdWRlOiBcInN0eWxlLGxpbmtbcmVsPXN0eWxlc2hlZXRdXCIsXG4gICAgZXhjbHVkZTogXCJcIixcbiAgICB2YXJpYWJsZXM6IHt9LFxuICAgIG9ubHlMZWdhY3k6IHRydWUsXG4gICAgcHJlc2VydmVTdGF0aWM6IHRydWUsXG4gICAgcHJlc2VydmVWYXJzOiBmYWxzZSxcbiAgICBzaWxlbnQ6IGZhbHNlLFxuICAgIHVwZGF0ZURPTTogdHJ1ZSxcbiAgICB1cGRhdGVVUkxzOiB0cnVlLFxuICAgIHdhdGNoOiBudWxsLFxuICAgIG9uQmVmb3JlU2VuZDogZnVuY3Rpb24gb25CZWZvcmVTZW5kKCkge30sXG4gICAgb25FcnJvcjogZnVuY3Rpb24gb25FcnJvcigpIHt9LFxuICAgIG9uV2FybmluZzogZnVuY3Rpb24gb25XYXJuaW5nKCkge30sXG4gICAgb25TdWNjZXNzOiBmdW5jdGlvbiBvblN1Y2Nlc3MoKSB7fSxcbiAgICBvbkNvbXBsZXRlOiBmdW5jdGlvbiBvbkNvbXBsZXRlKCkge30sXG4gICAgb25GaW5hbGx5OiBmdW5jdGlvbiBvbkZpbmFsbHkoKSB7fVxufTtcblxudmFyIHJlZ2V4ID0ge1xuICAgIGNzc0NvbW1lbnRzOiAvXFwvXFwqW1xcc1xcU10rP1xcKlxcLy9nLFxuICAgIGNzc0tleWZyYW1lczogL0AoPzotXFx3Ki0pP2tleWZyYW1lcy8sXG4gICAgY3NzTWVkaWFRdWVyaWVzOiAvQG1lZGlhW157XStcXHsoW1xcc1xcU10rP30pXFxzKn0vZyxcbiAgICBjc3NVcmxzOiAvdXJsXFwoKD8hWydcIl0/KD86ZGF0YXxodHRwfFxcL1xcLyk6KVsnXCJdPyhbXidcIildKilbJ1wiXT9cXCkvZyxcbiAgICBjc3NWYXJEZWNsUnVsZXM6IC8oPzo6KD86cm9vdHxob3N0KSg/IVsuOiMoXSlbXFxzLF0qW157XSp7XFxzKltefV0qfSkvZyxcbiAgICBjc3NWYXJEZWNsczogLyg/OltcXHM7XSopKC17Mn1cXHdbXFx3LV0qKSg/Olxccyo6XFxzKikoW147XSopOy9nLFxuICAgIGNzc1ZhckZ1bmM6IC92YXJcXChcXHMqLS1bXFx3LV0vLFxuICAgIGNzc1ZhcnM6IC8oPzooPzo6KD86cm9vdHxob3N0KSg/IVsuOiMoXSlbXFxzLF0qW157XSp7XFxzKlteO10qOypcXHMqKXwoPzp2YXJcXChcXHMqKSkoLS1bXjopXSspKD86XFxzKls6KV0pL1xufTtcblxudmFyIHZhcmlhYmxlU3RvcmUgPSB7XG4gICAgZG9tOiB7fSxcbiAgICBqb2I6IHt9LFxuICAgIHVzZXI6IHt9XG59O1xuXG52YXIgY3NzVmFyc0lzUnVubmluZyA9IGZhbHNlO1xuXG52YXIgY3NzVmFyc09ic2VydmVyID0gbnVsbDtcblxudmFyIGNzc1ZhcnNTcmNOb2RlQ291bnQgPSAwO1xuXG52YXIgZGVib3VuY2VUaW1lciA9IG51bGw7XG5cbnZhciBpc1NoYWRvd0RPTVJlYWR5ID0gZmFsc2U7XG5cbi8qKlxuICogRmV0Y2hlcywgcGFyc2VzLCBhbmQgdHJhbnNmb3JtcyBDU1MgY3VzdG9tIHByb3BlcnRpZXMgZnJvbSBzcGVjaWZpZWRcbiAqIDxzdHlsZT4gYW5kIDxsaW5rPiBlbGVtZW50cyBpbnRvIHN0YXRpYyB2YWx1ZXMsIHRoZW4gYXBwZW5kcyBhIG5ldyA8c3R5bGU+XG4gKiBlbGVtZW50IHdpdGggc3RhdGljIHZhbHVlcyB0byB0aGUgRE9NIHRvIHByb3ZpZGUgQ1NTIGN1c3RvbSBwcm9wZXJ0eVxuICogY29tcGF0aWJpbGl0eSBmb3IgbGVnYWN5IGJyb3dzZXJzLiBBbHNvIHByb3ZpZGVzIGEgc2luZ2xlIGludGVyZmFjZSBmb3JcbiAqIGxpdmUgdXBkYXRlcyBvZiBydW50aW1lIHZhbHVlcyBpbiBib3RoIG1vZGVybiBhbmQgbGVnYWN5IGJyb3dzZXJzLlxuICpcbiAqIEBwcmVzZXJ2ZVxuICogQHBhcmFtIHtvYmplY3R9ICAgW29wdGlvbnNdIE9wdGlvbnMgb2JqZWN0XG4gKiBAcGFyYW0ge29iamVjdH0gICBbb3B0aW9ucy5yb290RWxlbWVudD1kb2N1bWVudF0gUm9vdCBlbGVtZW50IHRvIHRyYXZlcnNlIGZvclxuICogICAgICAgICAgICAgICAgICAgPGxpbms+IGFuZCA8c3R5bGU+IG5vZGVzXG4gKiBAcGFyYW0ge2Jvb2xlYW59ICBbb3B0aW9ucy5zaGFkb3dET009ZmFsc2VdIERldGVybWluZXMgaWYgc2hhZG93IERPTSA8bGluaz5cbiAqICAgICAgICAgICAgICAgICAgIGFuZCA8c3R5bGU+IG5vZGVzIHdpbGwgYmUgcHJvY2Vzc2VkLlxuICogQHBhcmFtIHtzdHJpbmd9ICAgW29wdGlvbnMuaW5jbHVkZT1cInN0eWxlLGxpbmtbcmVsPXN0eWxlc2hlZXRdXCJdIENTUyBzZWxlY3RvclxuICogICAgICAgICAgICAgICAgICAgbWF0Y2hpbmcgPGxpbmsgcmU9XCJzdHlsZXNoZWV0XCI+IGFuZCA8c3R5bGU+IG5vZGVzIHRvXG4gKiAgICAgICAgICAgICAgICAgICBwcm9jZXNzXG4gKiBAcGFyYW0ge3N0cmluZ30gICBbb3B0aW9ucy5leGNsdWRlXSBDU1Mgc2VsZWN0b3IgbWF0Y2hpbmcgPGxpbmtcbiAqICAgICAgICAgICAgICAgICAgIHJlbD1cInN0eWxlaHNlZXRcIj4gYW5kIDxzdHlsZT4gbm9kZXMgdG8gZXhjbHVkZSBmcm9tIHRob3NlXG4gKiAgICAgICAgICAgICAgICAgICBtYXRjaGVzIGJ5IG9wdGlvbnMuaW5jbHVkZVxuICogQHBhcmFtIHtvYmplY3R9ICAgW29wdGlvbnMudmFyaWFibGVzXSBBIG1hcCBvZiBjdXN0b20gcHJvcGVydHkgbmFtZS92YWx1ZVxuICogICAgICAgICAgICAgICAgICAgcGFpcnMuIFByb3BlcnR5IG5hbWVzIGNhbiBvbWl0IG9yIGluY2x1ZGUgdGhlIGxlYWRpbmdcbiAqICAgICAgICAgICAgICAgICAgIGRvdWJsZS1oeXBoZW4gKOKAlCksIGFuZCB2YWx1ZXMgc3BlY2lmaWVkIHdpbGwgb3ZlcnJpZGVcbiAqICAgICAgICAgICAgICAgICAgIHByZXZpb3VzIHZhbHVlc1xuICogQHBhcmFtIHtib29sZWFufSAgW29wdGlvbnMub25seUxlZ2FjeT10cnVlXSBEZXRlcm1pbmVzIGlmIHRoZSBwb255ZmlsbCB3aWxsXG4gKiAgICAgICAgICAgICAgICAgICBvbmx5IGdlbmVyYXRlIGxlZ2FjeS1jb21wYXRpYmxlIENTUyBpbiBicm93c2VycyB0aGF0IGxhY2tcbiAqICAgICAgICAgICAgICAgICAgIG5hdGl2ZSBzdXBwb3J0IChpLmUuLCBsZWdhY3kgYnJvd3NlcnMpXG4gKiBAcGFyYW0ge2Jvb2xlYW59ICBbb3B0aW9ucy5wcmVzZXJ2ZVN0YXRpYz10cnVlXSBEZXRlcm1pbmVzIGlmIENTU1xuICogICAgICAgICAgICAgICAgICAgZGVjbGFyYXRpb25zIHRoYXQgZG8gbm90IHJlZmVyZW5jZSBhIGN1c3RvbSBwcm9wZXJ0eSB3aWxsXG4gKiAgICAgICAgICAgICAgICAgICBiZSBwcmVzZXJ2ZWQgaW4gdGhlIHRyYW5zZm9ybWVkIENTU1xuICogQHBhcmFtIHtib29sZWFufSAgW29wdGlvbnMucHJlc2VydmVWYXJzPWZhbHNlXSBEZXRlcm1pbmVzIGlmIENTUyBjdXN0b21cbiAqICAgICAgICAgICAgICAgICAgIHByb3BlcnR5IGRlY2xhcmF0aW9ucyB3aWxsIGJlIHByZXNlcnZlZCBpbiB0aGUgdHJhbnNmb3JtZWRcbiAqICAgICAgICAgICAgICAgICAgIENTU1xuICogQHBhcmFtIHtib29sZWFufSAgW29wdGlvbnMuc2lsZW50PWZhbHNlXSBEZXRlcm1pbmVzIGlmIHdhcm5pbmcgYW5kIGVycm9yXG4gKiAgICAgICAgICAgICAgICAgICBtZXNzYWdlcyB3aWxsIGJlIGRpc3BsYXllZCBvbiB0aGUgY29uc29sZVxuICogQHBhcmFtIHtib29sZWFufSAgW29wdGlvbnMudXBkYXRlRE9NPXRydWVdIERldGVybWluZXMgaWYgdGhlIHBvbnlmaWxsIHdpbGxcbiAqICAgICAgICAgICAgICAgICAgIHVwZGF0ZSB0aGUgRE9NIGFmdGVyIHByb2Nlc3NpbmcgQ1NTIGN1c3RvbSBwcm9wZXJ0aWVzXG4gKiBAcGFyYW0ge2Jvb2xlYW59ICBbb3B0aW9ucy51cGRhdGVVUkxzPXRydWVdIERldGVybWluZXMgaWYgdGhlIHBvbnlmaWxsIHdpbGxcbiAqICAgICAgICAgICAgICAgICAgIGNvbnZlcnQgcmVsYXRpdmUgdXJsKCkgcGF0aHMgdG8gYWJzb2x1dGUgdXJsc1xuICogQHBhcmFtIHtib29sZWFufSAgW29wdGlvbnMud2F0Y2g9ZmFsc2VdIERldGVybWluZXMgaWYgYSBNdXRhdGlvbk9ic2VydmVyIHdpbGxcbiAqICAgICAgICAgICAgICAgICAgIGJlIGNyZWF0ZWQgdGhhdCB3aWxsIGV4ZWN1dGUgdGhlIHBvbnlmaWxsIHdoZW4gYSA8bGluaz4gb3JcbiAqICAgICAgICAgICAgICAgICAgIDxzdHlsZT4gRE9NIG11dGF0aW9uIGlzIG9ic2VydmVkXG4gKiBAcGFyYW0ge2Z1bmN0aW9ufSBbb3B0aW9ucy5vbkJlZm9yZVNlbmRdIENhbGxiYWNrIGJlZm9yZSBYSFIgaXMgc2VudC4gUGFzc2VzXG4gKiAgICAgICAgICAgICAgICAgICAxKSB0aGUgWEhSIG9iamVjdCwgMikgc291cmNlIG5vZGUgcmVmZXJlbmNlLCBhbmQgMykgdGhlXG4gKiAgICAgICAgICAgICAgICAgICBzb3VyY2UgVVJMIGFzIGFyZ3VtZW50c1xuICogQHBhcmFtIHtmdW5jdGlvbn0gW29wdGlvbnMub25FcnJvcl0gQ2FsbGJhY2sgYWZ0ZXIgYSBDU1MgcGFyc2luZyBlcnJvciBoYXNcbiAqICAgICAgICAgICAgICAgICAgIG9jY3VycmVkIG9yIGFuIFhIUiByZXF1ZXN0IGhhcyBmYWlsZWQuIFBhc3NlcyAxKSBhbiBlcnJvclxuICogICAgICAgICAgICAgICAgICAgbWVzc2FnZSwgYW5kIDIpIHNvdXJjZSBub2RlIHJlZmVyZW5jZSwgMykgeGhyLCBhbmQgNCB1cmwgYXNcbiAqICAgICAgICAgICAgICAgICAgIGFyZ3VtZW50cy5cbiAqIEBwYXJhbSB7ZnVuY3Rpb259IFtvcHRpb25zLm9uV2FybmluZ10gQ2FsbGJhY2sgYWZ0ZXIgZWFjaCBDU1MgcGFyc2luZyB3YXJuaW5nXG4gKiAgICAgICAgICAgICAgICAgICBoYXMgb2NjdXJyZWQuIFBhc3NlcyAxKSBhIHdhcm5pbmcgbWVzc2FnZSBhcyBhbiBhcmd1bWVudC5cbiAqIEBwYXJhbSB7ZnVuY3Rpb259IFtvcHRpb25zLm9uU3VjY2Vzc10gQ2FsbGJhY2sgYWZ0ZXIgQ1NTIGRhdGEgaGFzIGJlZW5cbiAqICAgICAgICAgICAgICAgICAgIGNvbGxlY3RlZCBmcm9tIGVhY2ggbm9kZSBhbmQgYmVmb3JlIENTUyBjdXN0b20gcHJvcGVydGllc1xuICogICAgICAgICAgICAgICAgICAgaGF2ZSBiZWVuIHRyYW5zZm9ybWVkLiBBbGxvd3MgbW9kaWZ5aW5nIHRoZSBDU1MgZGF0YSBiZWZvcmVcbiAqICAgICAgICAgICAgICAgICAgIGl0IGlzIHRyYW5zZm9ybWVkIGJ5IHJldHVybmluZyBhbnkgc3RyaW5nIHZhbHVlIChvciBmYWxzZVxuICogICAgICAgICAgICAgICAgICAgdG8gc2tpcCkuIFBhc3NlcyAxKSBDU1MgdGV4dCwgMikgc291cmNlIG5vZGUgcmVmZXJlbmNlLCBhbmRcbiAqICAgICAgICAgICAgICAgICAgIDMpIHRoZSBzb3VyY2UgVVJMIGFzIGFyZ3VtZW50cy5cbiAqIEBwYXJhbSB7ZnVuY3Rpb259IFtvcHRpb25zLm9uQ29tcGxldGVdIENhbGxiYWNrIGFmdGVyIGFsbCBDU1MgaGFzIGJlZW5cbiAqICAgICAgICAgICAgICAgICAgIHByb2Nlc3NlZCwgbGVnYWN5LWNvbXBhdGlibGUgQ1NTIGhhcyBiZWVuIGdlbmVyYXRlZCwgYW5kXG4gKiAgICAgICAgICAgICAgICAgICAob3B0aW9uYWxseSkgdGhlIERPTSBoYXMgYmVlbiB1cGRhdGVkLiBQYXNzZXMgMSkgYSBDU1NcbiAqICAgICAgICAgICAgICAgICAgIHN0cmluZyB3aXRoIENTUyB2YXJpYWJsZSB2YWx1ZXMgcmVzb2x2ZWQsIDIpIGFuIGFycmF5IG9mXG4gKiAgICAgICAgICAgICAgICAgICBvdXRwdXQgPHN0eWxlPiBub2RlIHJlZmVyZW5jZXMgdGhhdCBoYXZlIGJlZW4gYXBwZW5kZWQgdG9cbiAqICAgICAgICAgICAgICAgICAgIHRoZSBET00sIDMpIGFuIG9iamVjdCBjb250YWluaW5nIGFsbCBjdXN0b20gcHJvcGVyaWVzIG5hbWVzXG4gKiAgICAgICAgICAgICAgICAgICBhbmQgdmFsdWVzLCBhbmQgNCkgdGhlIHBvbnlmaWxsIGV4ZWN1dGlvbiB0aW1lIGluXG4gKiAgICAgICAgICAgICAgICAgICBtaWxsaXNlY29uZHMuXG4gKiBAcGFyYW0ge2Z1bmN0aW9ufSBbb3B0aW9ucy5vbkZpbmFsbHldIENhbGxiYWNrIGluIG1vZGVybiBhbmQgbGVnYWN5IGJyb3dzZXJzXG4gKiAgICAgICAgICAgICAgICAgICBhZnRlciB0aGUgcG9ueWZpbGwgaGFzIGZpbmlzaGVkIGFsbCB0YXNrcy4gUGFzc2VzIDEpIGFcbiAqICAgICAgICAgICAgICAgICAgIGJvb2xlYW4gaW5kaWNhdGluZyBpZiB0aGUgbGFzdCBwb255ZmlsbCBjYWxsIHJlc3VsdGVkIGluIGFcbiAqICAgICAgICAgICAgICAgICAgIHN0eWxlIGNoYW5nZSwgMikgYSBib29sZWFuIGluZGljYXRpbmcgaWYgdGhlIGN1cnJlbnRcbiAqICAgICAgICAgICAgICAgICAgIGJyb3dzZXIgcHJvdmlkZXMgbmF0aXZlIHN1cHBvcnQgZm9yIENTUyBjdXN0b20gcHJvcGVydGllcyxcbiAqICAgICAgICAgICAgICAgICAgIGFuZCAzKSB0aGUgcG9ueWZpbGwgZXhlY3V0aW9uIHRpbWUgaW4gbWlsbGlzZWNvbmRzLlxuICogQGV4YW1wbGVcbiAqXG4gKiAgIGNzc1ZhcnMoe1xuICogICAgIHJvb3RFbGVtZW50ICAgOiBkb2N1bWVudCxcbiAqICAgICBzaGFkb3dET00gICAgIDogZmFsc2UsXG4gKiAgICAgaW5jbHVkZSAgICAgICA6ICdzdHlsZSxsaW5rW3JlbD1cInN0eWxlc2hlZXRcIl0nLFxuICogICAgIGV4Y2x1ZGUgICAgICAgOiAnJyxcbiAqICAgICB2YXJpYWJsZXMgICAgIDoge30sXG4gKiAgICAgb25seUxlZ2FjeSAgICA6IHRydWUsXG4gKiAgICAgcHJlc2VydmVTdGF0aWM6IHRydWUsXG4gKiAgICAgcHJlc2VydmVWYXJzICA6IGZhbHNlLFxuICogICAgIHNpbGVudCAgICAgICAgOiBmYWxzZSxcbiAqICAgICB1cGRhdGVET00gICAgIDogdHJ1ZSxcbiAqICAgICB1cGRhdGVVUkxzICAgIDogdHJ1ZSxcbiAqICAgICB3YXRjaCAgICAgICAgIDogZmFsc2UsXG4gKiAgICAgb25CZWZvcmVTZW5kKHhociwgbm9kZSwgdXJsKSB7fSxcbiAqICAgICBvbkVycm9yKG1lc3NhZ2UsIG5vZGUsIHhociwgdXJsKSB7fSxcbiAqICAgICBvbldhcm5pbmcobWVzc2FnZSkge30sXG4gKiAgICAgb25TdWNjZXNzKGNzc1RleHQsIG5vZGUsIHVybCkge30sXG4gKiAgICAgb25Db21wbGV0ZShjc3NUZXh0LCBzdHlsZU5vZGUsIGNzc1ZhcmlhYmxlcywgYmVuY2htYXJrKSB7fSxcbiAqICAgICBvbkZpbmFsbHkoaGFzQ2hhbmdlZCwgaGFzTmF0aXZlU3VwcG9ydCwgYmVuY2htYXJrKVxuICogICB9KTtcbiAqLyBmdW5jdGlvbiBjc3NWYXJzKCkge1xuICAgIHZhciBvcHRpb25zID0gYXJndW1lbnRzLmxlbmd0aCA+IDAgJiYgYXJndW1lbnRzWzBdICE9PSB1bmRlZmluZWQgPyBhcmd1bWVudHNbMF0gOiB7fTtcbiAgICB2YXIgbXNnUHJlZml4ID0gXCJjc3NWYXJzKCk6IFwiO1xuICAgIHZhciBzZXR0aW5ncyA9IF9leHRlbmRzKHt9LCBkZWZhdWx0cywgb3B0aW9ucyk7XG4gICAgZnVuY3Rpb24gaGFuZGxlRXJyb3IobWVzc2FnZSwgc291cmNlTm9kZSwgeGhyLCB1cmwpIHtcbiAgICAgICAgaWYgKCFzZXR0aW5ncy5zaWxlbnQgJiYgd2luZG93LmNvbnNvbGUpIHtcbiAgICAgICAgICAgIGNvbnNvbGUuZXJyb3IoXCJcIi5jb25jYXQobXNnUHJlZml4KS5jb25jYXQobWVzc2FnZSwgXCJcXG5cIiksIHNvdXJjZU5vZGUpO1xuICAgICAgICB9XG4gICAgICAgIHNldHRpbmdzLm9uRXJyb3IobWVzc2FnZSwgc291cmNlTm9kZSwgeGhyLCB1cmwpO1xuICAgIH1cbiAgICBmdW5jdGlvbiBoYW5kbGVXYXJuaW5nKG1lc3NhZ2UpIHtcbiAgICAgICAgaWYgKCFzZXR0aW5ncy5zaWxlbnQgJiYgd2luZG93LmNvbnNvbGUpIHtcbiAgICAgICAgICAgIGNvbnNvbGUud2FybihcIlwiLmNvbmNhdChtc2dQcmVmaXgpLmNvbmNhdChtZXNzYWdlKSk7XG4gICAgICAgIH1cbiAgICAgICAgc2V0dGluZ3Mub25XYXJuaW5nKG1lc3NhZ2UpO1xuICAgIH1cbiAgICBmdW5jdGlvbiBoYW5kbGVGaW5hbGx5KGhhc0NoYW5nZWQpIHtcbiAgICAgICAgc2V0dGluZ3Mub25GaW5hbGx5KEJvb2xlYW4oaGFzQ2hhbmdlZCksIGlzTmF0aXZlU3VwcG9ydCwgZ2V0VGltZVN0YW1wKCkgLSBzZXR0aW5ncy5fX2JlbmNobWFyayk7XG4gICAgfVxuICAgIGlmICghaXNCcm93c2VyKSB7XG4gICAgICAgIHJldHVybjtcbiAgICB9XG4gICAgaWYgKHNldHRpbmdzLndhdGNoKSB7XG4gICAgICAgIHNldHRpbmdzLndhdGNoID0gZGVmYXVsdHMud2F0Y2g7XG4gICAgICAgIGFkZE11dGF0aW9uT2JzZXJ2ZXIoc2V0dGluZ3MpO1xuICAgICAgICBjc3NWYXJzKHNldHRpbmdzKTtcbiAgICAgICAgcmV0dXJuO1xuICAgIH0gZWxzZSBpZiAoc2V0dGluZ3Mud2F0Y2ggPT09IGZhbHNlICYmIGNzc1ZhcnNPYnNlcnZlcikge1xuICAgICAgICBjc3NWYXJzT2JzZXJ2ZXIuZGlzY29ubmVjdCgpO1xuICAgICAgICBjc3NWYXJzT2JzZXJ2ZXIgPSBudWxsO1xuICAgIH1cbiAgICBpZiAoIXNldHRpbmdzLl9fYmVuY2htYXJrKSB7XG4gICAgICAgIGlmIChjc3NWYXJzSXNSdW5uaW5nID09PSBzZXR0aW5ncy5yb290RWxlbWVudCkge1xuICAgICAgICAgICAgY3NzVmFyc0RlYm91bmNlZChvcHRpb25zKTtcbiAgICAgICAgICAgIHJldHVybjtcbiAgICAgICAgfVxuICAgICAgICBzZXR0aW5ncy5fX2JlbmNobWFyayA9IGdldFRpbWVTdGFtcCgpO1xuICAgICAgICBzZXR0aW5ncy5leGNsdWRlID0gWyBjc3NWYXJzT2JzZXJ2ZXIgPyAnW2RhdGEtY3NzdmFyc106bm90KFtkYXRhLWNzc3ZhcnM9XCJcIl0pJyA6ICdbZGF0YS1jc3N2YXJzPVwib3V0XCJdJywgc2V0dGluZ3MuZXhjbHVkZSBdLmZpbHRlcigoZnVuY3Rpb24oc2VsZWN0b3IpIHtcbiAgICAgICAgICAgIHJldHVybiBzZWxlY3RvcjtcbiAgICAgICAgfSkpLmpvaW4oXCIsXCIpO1xuICAgICAgICBzZXR0aW5ncy52YXJpYWJsZXMgPSBmaXhWYXJOYW1lcyhzZXR0aW5ncy52YXJpYWJsZXMpO1xuICAgICAgICBpZiAoIWNzc1ZhcnNPYnNlcnZlcikge1xuICAgICAgICAgICAgdmFyIG91dE5vZGVzID0gQXJyYXkuYXBwbHkobnVsbCwgc2V0dGluZ3Mucm9vdEVsZW1lbnQucXVlcnlTZWxlY3RvckFsbCgnW2RhdGEtY3NzdmFycz1cIm91dFwiXScpKTtcbiAgICAgICAgICAgIG91dE5vZGVzLmZvckVhY2goKGZ1bmN0aW9uKG91dE5vZGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YUdyb3VwID0gb3V0Tm9kZS5nZXRBdHRyaWJ1dGUoXCJkYXRhLWNzc3ZhcnMtZ3JvdXBcIik7XG4gICAgICAgICAgICAgICAgdmFyIHNyY05vZGUgPSBkYXRhR3JvdXAgPyBzZXR0aW5ncy5yb290RWxlbWVudC5xdWVyeVNlbGVjdG9yKCdbZGF0YS1jc3N2YXJzPVwic3JjXCJdW2RhdGEtY3NzdmFycy1ncm91cD1cIicuY29uY2F0KGRhdGFHcm91cCwgJ1wiXScpKSA6IG51bGw7XG4gICAgICAgICAgICAgICAgaWYgKCFzcmNOb2RlKSB7XG4gICAgICAgICAgICAgICAgICAgIG91dE5vZGUucGFyZW50Tm9kZS5yZW1vdmVDaGlsZChvdXROb2RlKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KSk7XG4gICAgICAgICAgICBpZiAoY3NzVmFyc1NyY05vZGVDb3VudCkge1xuICAgICAgICAgICAgICAgIHZhciBzcmNOb2RlcyA9IHNldHRpbmdzLnJvb3RFbGVtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJ1tkYXRhLWNzc3ZhcnNdOm5vdChbZGF0YS1jc3N2YXJzPVwib3V0XCJdKScpO1xuICAgICAgICAgICAgICAgIGlmIChzcmNOb2Rlcy5sZW5ndGggPCBjc3NWYXJzU3JjTm9kZUNvdW50KSB7XG4gICAgICAgICAgICAgICAgICAgIGNzc1ZhcnNTcmNOb2RlQ291bnQgPSBzcmNOb2Rlcy5sZW5ndGg7XG4gICAgICAgICAgICAgICAgICAgIHZhcmlhYmxlU3RvcmUuZG9tID0ge307XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuICAgICAgICB9XG4gICAgfVxuICAgIGlmIChkb2N1bWVudC5yZWFkeVN0YXRlICE9PSBcImxvYWRpbmdcIikge1xuICAgICAgICBpZiAoaXNOYXRpdmVTdXBwb3J0ICYmIHNldHRpbmdzLm9ubHlMZWdhY3kpIHtcbiAgICAgICAgICAgIHZhciBoYXNWYXJDaGFuZ2UgPSBmYWxzZTtcbiAgICAgICAgICAgIGlmIChzZXR0aW5ncy51cGRhdGVET00pIHtcbiAgICAgICAgICAgICAgICB2YXIgdGFyZ2V0RWxtID0gc2V0dGluZ3Mucm9vdEVsZW1lbnQuaG9zdCB8fCAoc2V0dGluZ3Mucm9vdEVsZW1lbnQgPT09IGRvY3VtZW50ID8gZG9jdW1lbnQuZG9jdW1lbnRFbGVtZW50IDogc2V0dGluZ3Mucm9vdEVsZW1lbnQpO1xuICAgICAgICAgICAgICAgIE9iamVjdC5rZXlzKHNldHRpbmdzLnZhcmlhYmxlcykuZm9yRWFjaCgoZnVuY3Rpb24oa2V5KSB7XG4gICAgICAgICAgICAgICAgICAgIHZhciB2YXJWYWx1ZSA9IHNldHRpbmdzLnZhcmlhYmxlc1trZXldO1xuICAgICAgICAgICAgICAgICAgICBoYXNWYXJDaGFuZ2UgPSBoYXNWYXJDaGFuZ2UgfHwgdmFyVmFsdWUgIT09IGdldENvbXB1dGVkU3R5bGUodGFyZ2V0RWxtKS5nZXRQcm9wZXJ0eVZhbHVlKGtleSk7XG4gICAgICAgICAgICAgICAgICAgIHRhcmdldEVsbS5zdHlsZS5zZXRQcm9wZXJ0eShrZXksIHZhclZhbHVlKTtcbiAgICAgICAgICAgICAgICB9KSk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICBoYW5kbGVGaW5hbGx5KGhhc1ZhckNoYW5nZSk7XG4gICAgICAgIH0gZWxzZSBpZiAoIWlzU2hhZG93RE9NUmVhZHkgJiYgKHNldHRpbmdzLnNoYWRvd0RPTSB8fCBzZXR0aW5ncy5yb290RWxlbWVudC5zaGFkb3dSb290IHx8IHNldHRpbmdzLnJvb3RFbGVtZW50Lmhvc3QpKSB7XG4gICAgICAgICAgICBnZXRDc3NEYXRhKHtcbiAgICAgICAgICAgICAgICByb290RWxlbWVudDogZGVmYXVsdHMucm9vdEVsZW1lbnQsXG4gICAgICAgICAgICAgICAgaW5jbHVkZTogZGVmYXVsdHMuaW5jbHVkZSxcbiAgICAgICAgICAgICAgICBleGNsdWRlOiBzZXR0aW5ncy5leGNsdWRlLFxuICAgICAgICAgICAgICAgIHNraXBEaXNhYmxlZDogZmFsc2UsXG4gICAgICAgICAgICAgICAgb25TdWNjZXNzOiBmdW5jdGlvbiBvblN1Y2Nlc3MoY3NzVGV4dCwgbm9kZSwgdXJsKSB7XG4gICAgICAgICAgICAgICAgICAgIGNzc1RleHQgPSBjc3NUZXh0LnJlcGxhY2UocmVnZXguY3NzQ29tbWVudHMsIFwiXCIpLnJlcGxhY2UocmVnZXguY3NzTWVkaWFRdWVyaWVzLCBcIlwiKTtcbiAgICAgICAgICAgICAgICAgICAgY3NzVGV4dCA9IChjc3NUZXh0Lm1hdGNoKHJlZ2V4LmNzc1ZhckRlY2xSdWxlcykgfHwgW10pLmpvaW4oXCJcIik7XG4gICAgICAgICAgICAgICAgICAgIHJldHVybiBjc3NUZXh0IHx8IGZhbHNlO1xuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgb25Db21wbGV0ZTogZnVuY3Rpb24gb25Db21wbGV0ZShjc3NUZXh0LCBjc3NBcnJheSwgbm9kZUFycmF5KSB7XG4gICAgICAgICAgICAgICAgICAgIHBhcnNlVmFycyhjc3NUZXh0LCB7XG4gICAgICAgICAgICAgICAgICAgICAgICBzdG9yZTogdmFyaWFibGVTdG9yZS5kb20sXG4gICAgICAgICAgICAgICAgICAgICAgICBvbldhcm5pbmc6IGhhbmRsZVdhcm5pbmdcbiAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgICAgIGlzU2hhZG93RE9NUmVhZHkgPSB0cnVlO1xuICAgICAgICAgICAgICAgICAgICBjc3NWYXJzKHNldHRpbmdzKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIGNzc1ZhcnNJc1J1bm5pbmcgPSBzZXR0aW5ncy5yb290RWxlbWVudDtcbiAgICAgICAgICAgIGdldENzc0RhdGEoe1xuICAgICAgICAgICAgICAgIHJvb3RFbGVtZW50OiBzZXR0aW5ncy5yb290RWxlbWVudCxcbiAgICAgICAgICAgICAgICBpbmNsdWRlOiBzZXR0aW5ncy5pbmNsdWRlLFxuICAgICAgICAgICAgICAgIGV4Y2x1ZGU6IHNldHRpbmdzLmV4Y2x1ZGUsXG4gICAgICAgICAgICAgICAgc2tpcERpc2FibGVkOiBmYWxzZSxcbiAgICAgICAgICAgICAgICBvbkJlZm9yZVNlbmQ6IHNldHRpbmdzLm9uQmVmb3JlU2VuZCxcbiAgICAgICAgICAgICAgICBvbkVycm9yOiBmdW5jdGlvbiBvbkVycm9yKHhociwgbm9kZSwgdXJsKSB7XG4gICAgICAgICAgICAgICAgICAgIHZhciByZXNwb25zZVVybCA9IHhoci5yZXNwb25zZVVSTCB8fCBnZXRGdWxsVXJsJDEodXJsLCBsb2NhdGlvbi5ocmVmKTtcbiAgICAgICAgICAgICAgICAgICAgdmFyIHN0YXR1c1RleHQgPSB4aHIuc3RhdHVzVGV4dCA/IFwiKFwiLmNvbmNhdCh4aHIuc3RhdHVzVGV4dCwgXCIpXCIpIDogXCJVbnNwZWNpZmllZCBFcnJvclwiICsgKHhoci5zdGF0dXMgPT09IDAgPyBcIiAocG9zc2libHkgQ09SUyByZWxhdGVkKVwiIDogXCJcIik7XG4gICAgICAgICAgICAgICAgICAgIHZhciBlcnJvck1zZyA9IFwiQ1NTIFhIUiBFcnJvcjogXCIuY29uY2F0KHJlc3BvbnNlVXJsLCBcIiBcIikuY29uY2F0KHhoci5zdGF0dXMsIFwiIFwiKS5jb25jYXQoc3RhdHVzVGV4dCk7XG4gICAgICAgICAgICAgICAgICAgIGhhbmRsZUVycm9yKGVycm9yTXNnLCBub2RlLCB4aHIsIHJlc3BvbnNlVXJsKTtcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIG9uU3VjY2VzczogZnVuY3Rpb24gb25TdWNjZXNzKGNzc1RleHQsIG5vZGUsIHVybCkge1xuICAgICAgICAgICAgICAgICAgICB2YXIgcmV0dXJuVmFsID0gc2V0dGluZ3Mub25TdWNjZXNzKGNzc1RleHQsIG5vZGUsIHVybCk7XG4gICAgICAgICAgICAgICAgICAgIGNzc1RleHQgPSByZXR1cm5WYWwgIT09IHVuZGVmaW5lZCAmJiBCb29sZWFuKHJldHVyblZhbCkgPT09IGZhbHNlID8gXCJcIiA6IHJldHVyblZhbCB8fCBjc3NUZXh0O1xuICAgICAgICAgICAgICAgICAgICBpZiAoc2V0dGluZ3MudXBkYXRlVVJMcykge1xuICAgICAgICAgICAgICAgICAgICAgICAgY3NzVGV4dCA9IGZpeFJlbGF0aXZlQ3NzVXJscyhjc3NUZXh0LCB1cmwpO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIHJldHVybiBjc3NUZXh0O1xuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgb25Db21wbGV0ZTogZnVuY3Rpb24gb25Db21wbGV0ZShjc3NUZXh0LCBjc3NBcnJheSkge1xuICAgICAgICAgICAgICAgICAgICB2YXIgbm9kZUFycmF5ID0gYXJndW1lbnRzLmxlbmd0aCA+IDIgJiYgYXJndW1lbnRzWzJdICE9PSB1bmRlZmluZWQgPyBhcmd1bWVudHNbMl0gOiBbXTtcbiAgICAgICAgICAgICAgICAgICAgdmFyIGN1cnJlbnRWYXJzID0gX2V4dGVuZHMoe30sIHZhcmlhYmxlU3RvcmUuZG9tLCB2YXJpYWJsZVN0b3JlLnVzZXIpO1xuICAgICAgICAgICAgICAgICAgICB2YXIgaGFzVmFyQ2hhbmdlID0gZmFsc2U7XG4gICAgICAgICAgICAgICAgICAgIHZhcmlhYmxlU3RvcmUuam9iID0ge307XG4gICAgICAgICAgICAgICAgICAgIG5vZGVBcnJheS5mb3JFYWNoKChmdW5jdGlvbihub2RlLCBpKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgbm9kZUNTUyA9IGNzc0FycmF5W2ldO1xuICAgICAgICAgICAgICAgICAgICAgICAgaWYgKHJlZ2V4LmNzc1ZhcnMudGVzdChub2RlQ1NTKSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHRyeSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhciBjc3NUcmVlID0gcGFyc2VDc3Mobm9kZUNTUywge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgcHJlc2VydmVTdGF0aWM6IHNldHRpbmdzLnByZXNlcnZlU3RhdGljLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgcmVtb3ZlQ29tbWVudHM6IHRydWVcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHBhcnNlVmFycyhjc3NUcmVlLCB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBwYXJzZUhvc3Q6IEJvb2xlYW4oc2V0dGluZ3Mucm9vdEVsZW1lbnQuaG9zdCksXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBzdG9yZTogdmFyaWFibGVTdG9yZS5kb20sXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBvbldhcm5pbmc6IGhhbmRsZVdhcm5pbmdcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG5vZGUuX19jc3NWYXJzID0ge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdHJlZTogY3NzVHJlZVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9O1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0gY2F0Y2ggKGVycikge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBoYW5kbGVFcnJvcihlcnIubWVzc2FnZSwgbm9kZSk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICB9KSk7XG4gICAgICAgICAgICAgICAgICAgIF9leHRlbmRzKHZhcmlhYmxlU3RvcmUuam9iLCB2YXJpYWJsZVN0b3JlLmRvbSk7XG4gICAgICAgICAgICAgICAgICAgIGlmIChzZXR0aW5ncy51cGRhdGVET00pIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIF9leHRlbmRzKHZhcmlhYmxlU3RvcmUudXNlciwgc2V0dGluZ3MudmFyaWFibGVzKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIF9leHRlbmRzKHZhcmlhYmxlU3RvcmUuam9iLCB2YXJpYWJsZVN0b3JlLnVzZXIpO1xuICAgICAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICAgICAgX2V4dGVuZHModmFyaWFibGVTdG9yZS5qb2IsIHZhcmlhYmxlU3RvcmUudXNlciwgc2V0dGluZ3MudmFyaWFibGVzKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIF9leHRlbmRzKGN1cnJlbnRWYXJzLCBzZXR0aW5ncy52YXJpYWJsZXMpO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgIGhhc1ZhckNoYW5nZSA9IGNvdW50ZXJzLmpvYiA+IDAgJiYgQm9vbGVhbihPYmplY3Qua2V5cyh2YXJpYWJsZVN0b3JlLmpvYikubGVuZ3RoID4gT2JqZWN0LmtleXMoY3VycmVudFZhcnMpLmxlbmd0aCB8fCBCb29sZWFuKE9iamVjdC5rZXlzKGN1cnJlbnRWYXJzKS5sZW5ndGggJiYgT2JqZWN0LmtleXModmFyaWFibGVTdG9yZS5qb2IpLnNvbWUoKGZ1bmN0aW9uKGtleSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIHZhcmlhYmxlU3RvcmUuam9iW2tleV0gIT09IGN1cnJlbnRWYXJzW2tleV07XG4gICAgICAgICAgICAgICAgICAgIH0pKSkpO1xuICAgICAgICAgICAgICAgICAgICBpZiAoaGFzVmFyQ2hhbmdlKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICByZXNldENzc05vZGVzKHNldHRpbmdzLnJvb3RFbGVtZW50KTtcbiAgICAgICAgICAgICAgICAgICAgICAgIGNzc1ZhcnMoc2V0dGluZ3MpO1xuICAgICAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIG91dENzc0FycmF5ID0gW107XG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgb3V0Tm9kZUFycmF5ID0gW107XG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgaGFzS2V5ZnJhbWVzV2l0aFZhcnMgPSBmYWxzZTtcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmIChzZXR0aW5ncy51cGRhdGVET00pIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBjb3VudGVycy5qb2IrKztcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIG5vZGVBcnJheS5mb3JFYWNoKChmdW5jdGlvbihub2RlLCBpKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGlzU2tpcCA9ICFub2RlLl9fY3NzVmFycztcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAobm9kZS5fX2Nzc1ZhcnMpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdHJ5IHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHRyYW5zZm9ybUNzcyhub2RlLl9fY3NzVmFycy50cmVlLCBfZXh0ZW5kcyh7fSwgc2V0dGluZ3MsIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YXJpYWJsZXM6IHZhcmlhYmxlU3RvcmUuam9iLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG9uV2FybmluZzogaGFuZGxlV2FybmluZ1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSkpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFyIG91dENzcyA9IHN0cmluZ2lmeUNzcyhub2RlLl9fY3NzVmFycy50cmVlKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmIChzZXR0aW5ncy51cGRhdGVET00pIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YXIgbm9kZUNTUyA9IGNzc0FycmF5W2ldO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhciBoYXNDU1NWYXJGdW5jID0gcmVnZXguY3NzVmFyRnVuYy50ZXN0KG5vZGVDU1MpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmICghbm9kZS5nZXRBdHRyaWJ1dGUoXCJkYXRhLWNzc3ZhcnNcIikpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgbm9kZS5zZXRBdHRyaWJ1dGUoXCJkYXRhLWNzc3ZhcnNcIiwgXCJzcmNcIik7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmIChvdXRDc3MubGVuZ3RoICYmIGhhc0NTU1ZhckZ1bmMpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGRhdGFHcm91cCA9IG5vZGUuZ2V0QXR0cmlidXRlKFwiZGF0YS1jc3N2YXJzLWdyb3VwXCIpIHx8ICsrY291bnRlcnMuZ3JvdXA7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhciBvdXRDc3NOb1NwYWNlcyA9IG91dENzcy5yZXBsYWNlKC9cXHMvZywgXCJcIik7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhciBvdXROb2RlID0gc2V0dGluZ3Mucm9vdEVsZW1lbnQucXVlcnlTZWxlY3RvcignW2RhdGEtY3NzdmFycz1cIm91dFwiXVtkYXRhLWNzc3ZhcnMtZ3JvdXA9XCInLmNvbmNhdChkYXRhR3JvdXAsICdcIl0nKSkgfHwgZG9jdW1lbnQuY3JlYXRlRWxlbWVudChcInN0eWxlXCIpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBoYXNLZXlmcmFtZXNXaXRoVmFycyA9IGhhc0tleWZyYW1lc1dpdGhWYXJzIHx8IHJlZ2V4LmNzc0tleWZyYW1lcy50ZXN0KG91dENzcyk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmIChzZXR0aW5ncy5wcmVzZXJ2ZVN0YXRpYykge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgbm9kZS5zaGVldC5kaXNhYmxlZCA9IHRydWU7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKCFvdXROb2RlLmhhc0F0dHJpYnV0ZShcImRhdGEtY3NzdmFyc1wiKSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgb3V0Tm9kZS5zZXRBdHRyaWJ1dGUoXCJkYXRhLWNzc3ZhcnNcIiwgXCJvdXRcIik7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKG91dENzc05vU3BhY2VzID09PSBub2RlLnRleHRDb250ZW50LnJlcGxhY2UoL1xccy9nLCBcIlwiKSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaXNTa2lwID0gdHJ1ZTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmIChvdXROb2RlICYmIG91dE5vZGUucGFyZW50Tm9kZSkge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG5vZGUucmVtb3ZlQXR0cmlidXRlKFwiZGF0YS1jc3N2YXJzLWdyb3VwXCIpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG91dE5vZGUucGFyZW50Tm9kZS5yZW1vdmVDaGlsZChvdXROb2RlKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSBlbHNlIGlmIChvdXRDc3NOb1NwYWNlcyAhPT0gb3V0Tm9kZS50ZXh0Q29udGVudC5yZXBsYWNlKC9cXHMvZywgXCJcIikpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIFsgbm9kZSwgb3V0Tm9kZSBdLmZvckVhY2goKGZ1bmN0aW9uKG4pIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBuLnNldEF0dHJpYnV0ZShcImRhdGEtY3NzdmFycy1qb2JcIiwgY291bnRlcnMuam9iKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBuLnNldEF0dHJpYnV0ZShcImRhdGEtY3NzdmFycy1ncm91cFwiLCBkYXRhR3JvdXApO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSkpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgb3V0Tm9kZS50ZXh0Q29udGVudCA9IG91dENzcztcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG91dENzc0FycmF5LnB1c2gob3V0Q3NzKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG91dE5vZGVBcnJheS5wdXNoKG91dE5vZGUpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKCFvdXROb2RlLnBhcmVudE5vZGUpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBub2RlLnBhcmVudE5vZGUuaW5zZXJ0QmVmb3JlKG91dE5vZGUsIG5vZGUubmV4dFNpYmxpbmcpO1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAobm9kZS50ZXh0Q29udGVudC5yZXBsYWNlKC9cXHMvZywgXCJcIikgIT09IG91dENzcykge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBvdXRDc3NBcnJheS5wdXNoKG91dENzcyk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICB9IGNhdGNoIChlcnIpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGhhbmRsZUVycm9yKGVyci5tZXNzYWdlLCBub2RlKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBpZiAoaXNTa2lwKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIG5vZGUuc2V0QXR0cmlidXRlKFwiZGF0YS1jc3N2YXJzXCIsIFwic2tpcFwiKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYgKCFub2RlLmhhc0F0dHJpYnV0ZShcImRhdGEtY3NzdmFycy1qb2JcIikpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgbm9kZS5zZXRBdHRyaWJ1dGUoXCJkYXRhLWNzc3ZhcnMtam9iXCIsIGNvdW50ZXJzLmpvYik7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgfSkpO1xuICAgICAgICAgICAgICAgICAgICAgICAgY3NzVmFyc1NyY05vZGVDb3VudCA9IHNldHRpbmdzLnJvb3RFbGVtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJ1tkYXRhLWNzc3ZhcnNdOm5vdChbZGF0YS1jc3N2YXJzPVwib3V0XCJdKScpLmxlbmd0aDtcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmIChzZXR0aW5ncy5zaGFkb3dET00pIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YXIgZWxtcyA9IFsgc2V0dGluZ3Mucm9vdEVsZW1lbnQgXS5jb25jYXQoX3RvQ29uc3VtYWJsZUFycmF5KHNldHRpbmdzLnJvb3RFbGVtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoXCIqXCIpKSk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgZm9yICh2YXIgaSA9IDAsIGVsbTsgZWxtID0gZWxtc1tpXTsgKytpKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGlmIChlbG0uc2hhZG93Um9vdCAmJiBlbG0uc2hhZG93Um9vdC5xdWVyeVNlbGVjdG9yKFwic3R5bGVcIikpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHZhciBzaGFkb3dTZXR0aW5ncyA9IF9leHRlbmRzKHt9LCBzZXR0aW5ncywge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHJvb3RFbGVtZW50OiBlbG0uc2hhZG93Um9vdFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBjc3NWYXJzKHNoYWRvd1NldHRpbmdzKTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgICAgIGlmIChzZXR0aW5ncy51cGRhdGVET00gJiYgaGFzS2V5ZnJhbWVzV2l0aFZhcnMpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBmaXhLZXlmcmFtZXMoc2V0dGluZ3Mucm9vdEVsZW1lbnQpO1xuICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICAgICAgY3NzVmFyc0lzUnVubmluZyA9IGZhbHNlO1xuICAgICAgICAgICAgICAgICAgICAgICAgc2V0dGluZ3Mub25Db21wbGV0ZShvdXRDc3NBcnJheS5qb2luKFwiXCIpLCBvdXROb2RlQXJyYXksIEpTT04ucGFyc2UoSlNPTi5zdHJpbmdpZnkodmFyaWFibGVTdG9yZS5qb2IpKSwgZ2V0VGltZVN0YW1wKCkgLSBzZXR0aW5ncy5fX2JlbmNobWFyayk7XG4gICAgICAgICAgICAgICAgICAgICAgICBoYW5kbGVGaW5hbGx5KG91dE5vZGVBcnJheS5sZW5ndGgpO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSk7XG4gICAgICAgIH1cbiAgICB9IGVsc2Uge1xuICAgICAgICBkb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKFwiRE9NQ29udGVudExvYWRlZFwiLCAoZnVuY3Rpb24gaW5pdChldnQpIHtcbiAgICAgICAgICAgIGNzc1ZhcnMob3B0aW9ucyk7XG4gICAgICAgICAgICBkb2N1bWVudC5yZW1vdmVFdmVudExpc3RlbmVyKFwiRE9NQ29udGVudExvYWRlZFwiLCBpbml0KTtcbiAgICAgICAgfSkpO1xuICAgIH1cbn1cblxuY3NzVmFycy5yZXNldCA9IGZ1bmN0aW9uKCkge1xuICAgIGNvdW50ZXJzLmpvYiA9IDA7XG4gICAgY291bnRlcnMuZ3JvdXAgPSAwO1xuICAgIGNzc1ZhcnNJc1J1bm5pbmcgPSBmYWxzZTtcbiAgICBpZiAoY3NzVmFyc09ic2VydmVyKSB7XG4gICAgICAgIGNzc1ZhcnNPYnNlcnZlci5kaXNjb25uZWN0KCk7XG4gICAgICAgIGNzc1ZhcnNPYnNlcnZlciA9IG51bGw7XG4gICAgfVxuICAgIGNzc1ZhcnNTcmNOb2RlQ291bnQgPSAwO1xuICAgIGRlYm91bmNlVGltZXIgPSBudWxsO1xuICAgIGlzU2hhZG93RE9NUmVhZHkgPSBmYWxzZTtcbiAgICBmb3IgKHZhciBwcm9wIGluIHZhcmlhYmxlU3RvcmUpIHtcbiAgICAgICAgdmFyaWFibGVTdG9yZVtwcm9wXSA9IHt9O1xuICAgIH1cbn07XG5cbmZ1bmN0aW9uIGFkZE11dGF0aW9uT2JzZXJ2ZXIoc2V0dGluZ3MpIHtcbiAgICBmdW5jdGlvbiBpc0Rpc2FibGVkKG5vZGUpIHtcbiAgICAgICAgdmFyIGlzRGlzYWJsZWRBdHRyID0gbm9kZS5oYXNBdHRyaWJ1dGUoXCJkaXNhYmxlZFwiKTtcbiAgICAgICAgdmFyIGlzRGlzYWJsZWRTaGVldCA9IChub2RlLnNoZWV0IHx8IHt9KS5kaXNhYmxlZDtcbiAgICAgICAgcmV0dXJuIGlzRGlzYWJsZWRBdHRyIHx8IGlzRGlzYWJsZWRTaGVldDtcbiAgICB9XG4gICAgZnVuY3Rpb24gaXNMaW5rKG5vZGUpIHtcbiAgICAgICAgdmFyIGlzU3R5bGVzaGVldCA9IG5vZGUudGFnTmFtZSA9PT0gXCJMSU5LXCIgJiYgKG5vZGUuZ2V0QXR0cmlidXRlKFwicmVsXCIpIHx8IFwiXCIpLmluZGV4T2YoXCJzdHlsZXNoZWV0XCIpICE9PSAtMTtcbiAgICAgICAgcmV0dXJuIGlzU3R5bGVzaGVldCAmJiAhaXNEaXNhYmxlZChub2RlKTtcbiAgICB9XG4gICAgZnVuY3Rpb24gaXNTdHlsZShub2RlKSB7XG4gICAgICAgIHJldHVybiBub2RlLnRhZ05hbWUgPT09IFwiU1RZTEVcIiAmJiAhaXNEaXNhYmxlZChub2RlKTtcbiAgICB9XG4gICAgZnVuY3Rpb24gaXNWYWxpZEFkZE11dGF0aW9uKG11dGF0aW9uTm9kZXMpIHtcbiAgICAgICAgcmV0dXJuIEFycmF5LmFwcGx5KG51bGwsIG11dGF0aW9uTm9kZXMpLnNvbWUoKGZ1bmN0aW9uKG5vZGUpIHtcbiAgICAgICAgICAgIHZhciBpc0VsbSA9IG5vZGUubm9kZVR5cGUgPT09IDE7XG4gICAgICAgICAgICB2YXIgaGFzQXR0ciA9IGlzRWxtICYmIG5vZGUuaGFzQXR0cmlidXRlKFwiZGF0YS1jc3N2YXJzXCIpO1xuICAgICAgICAgICAgdmFyIGlzU3R5bGVXaXRoVmFycyA9IGlzU3R5bGUobm9kZSkgJiYgcmVnZXguY3NzVmFycy50ZXN0KG5vZGUudGV4dENvbnRlbnQpO1xuICAgICAgICAgICAgdmFyIGlzVmFsaWQgPSAhaGFzQXR0ciAmJiAoaXNMaW5rKG5vZGUpIHx8IGlzU3R5bGVXaXRoVmFycyk7XG4gICAgICAgICAgICByZXR1cm4gaXNWYWxpZDtcbiAgICAgICAgfSkpO1xuICAgIH1cbiAgICBmdW5jdGlvbiBpc1ZhbGlkUmVtb3ZlTXV0YXRpb24obXV0YXRpb25Ob2Rlcykge1xuICAgICAgICByZXR1cm4gQXJyYXkuYXBwbHkobnVsbCwgbXV0YXRpb25Ob2Rlcykuc29tZSgoZnVuY3Rpb24obm9kZSkge1xuICAgICAgICAgICAgdmFyIGlzRWxtID0gbm9kZS5ub2RlVHlwZSA9PT0gMTtcbiAgICAgICAgICAgIHZhciBpc091dE5vZGUgPSBpc0VsbSAmJiBub2RlLmdldEF0dHJpYnV0ZShcImRhdGEtY3NzdmFyc1wiKSA9PT0gXCJvdXRcIjtcbiAgICAgICAgICAgIHZhciBpc1NyY05vZGUgPSBpc0VsbSAmJiBub2RlLmdldEF0dHJpYnV0ZShcImRhdGEtY3NzdmFyc1wiKSA9PT0gXCJzcmNcIjtcbiAgICAgICAgICAgIHZhciBpc1ZhbGlkID0gaXNTcmNOb2RlO1xuICAgICAgICAgICAgaWYgKGlzU3JjTm9kZSB8fCBpc091dE5vZGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgZGF0YUdyb3VwID0gbm9kZS5nZXRBdHRyaWJ1dGUoXCJkYXRhLWNzc3ZhcnMtZ3JvdXBcIik7XG4gICAgICAgICAgICAgICAgdmFyIG9ycGhhbk5vZGUgPSBzZXR0aW5ncy5yb290RWxlbWVudC5xdWVyeVNlbGVjdG9yKCdbZGF0YS1jc3N2YXJzLWdyb3VwPVwiJy5jb25jYXQoZGF0YUdyb3VwLCAnXCJdJykpO1xuICAgICAgICAgICAgICAgIGlmIChpc1NyY05vZGUpIHtcbiAgICAgICAgICAgICAgICAgICAgcmVzZXRDc3NOb2RlcyhzZXR0aW5ncy5yb290RWxlbWVudCk7XG4gICAgICAgICAgICAgICAgICAgIHZhcmlhYmxlU3RvcmUuZG9tID0ge307XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIGlmIChvcnBoYW5Ob2RlKSB7XG4gICAgICAgICAgICAgICAgICAgIG9ycGhhbk5vZGUucGFyZW50Tm9kZS5yZW1vdmVDaGlsZChvcnBoYW5Ob2RlKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICByZXR1cm4gaXNWYWxpZDtcbiAgICAgICAgfSkpO1xuICAgIH1cbiAgICBpZiAoIXdpbmRvdy5NdXRhdGlvbk9ic2VydmVyKSB7XG4gICAgICAgIHJldHVybjtcbiAgICB9XG4gICAgaWYgKGNzc1ZhcnNPYnNlcnZlcikge1xuICAgICAgICBjc3NWYXJzT2JzZXJ2ZXIuZGlzY29ubmVjdCgpO1xuICAgICAgICBjc3NWYXJzT2JzZXJ2ZXIgPSBudWxsO1xuICAgIH1cbiAgICBjc3NWYXJzT2JzZXJ2ZXIgPSBuZXcgTXV0YXRpb25PYnNlcnZlcigoZnVuY3Rpb24obXV0YXRpb25zKSB7XG4gICAgICAgIHZhciBoYXNWYWxpZE11dGF0aW9uID0gbXV0YXRpb25zLnNvbWUoKGZ1bmN0aW9uKG11dGF0aW9uKSB7XG4gICAgICAgICAgICB2YXIgaXNWYWxpZCA9IGZhbHNlO1xuICAgICAgICAgICAgaWYgKG11dGF0aW9uLnR5cGUgPT09IFwiYXR0cmlidXRlc1wiKSB7XG4gICAgICAgICAgICAgICAgaXNWYWxpZCA9IGlzTGluayhtdXRhdGlvbi50YXJnZXQpO1xuICAgICAgICAgICAgfSBlbHNlIGlmIChtdXRhdGlvbi50eXBlID09PSBcImNoaWxkTGlzdFwiKSB7XG4gICAgICAgICAgICAgICAgaXNWYWxpZCA9IGlzVmFsaWRBZGRNdXRhdGlvbihtdXRhdGlvbi5hZGRlZE5vZGVzKSB8fCBpc1ZhbGlkUmVtb3ZlTXV0YXRpb24obXV0YXRpb24ucmVtb3ZlZE5vZGVzKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIHJldHVybiBpc1ZhbGlkO1xuICAgICAgICB9KSk7XG4gICAgICAgIGlmIChoYXNWYWxpZE11dGF0aW9uKSB7XG4gICAgICAgICAgICBjc3NWYXJzKHNldHRpbmdzKTtcbiAgICAgICAgfVxuICAgIH0pKTtcbiAgICBjc3NWYXJzT2JzZXJ2ZXIub2JzZXJ2ZShkb2N1bWVudC5kb2N1bWVudEVsZW1lbnQsIHtcbiAgICAgICAgYXR0cmlidXRlczogdHJ1ZSxcbiAgICAgICAgYXR0cmlidXRlRmlsdGVyOiBbIFwiZGlzYWJsZWRcIiwgXCJocmVmXCIgXSxcbiAgICAgICAgY2hpbGRMaXN0OiB0cnVlLFxuICAgICAgICBzdWJ0cmVlOiB0cnVlXG4gICAgfSk7XG59XG5cbmZ1bmN0aW9uIGNzc1ZhcnNEZWJvdW5jZWQoc2V0dGluZ3MpIHtcbiAgICB2YXIgZGVsYXkgPSBhcmd1bWVudHMubGVuZ3RoID4gMSAmJiBhcmd1bWVudHNbMV0gIT09IHVuZGVmaW5lZCA/IGFyZ3VtZW50c1sxXSA6IDEwMDtcbiAgICBjbGVhclRpbWVvdXQoZGVib3VuY2VUaW1lcik7XG4gICAgZGVib3VuY2VUaW1lciA9IHNldFRpbWVvdXQoKGZ1bmN0aW9uKCkge1xuICAgICAgICBzZXR0aW5ncy5fX2JlbmNobWFyayA9IG51bGw7XG4gICAgICAgIGNzc1ZhcnMoc2V0dGluZ3MpO1xuICAgIH0pLCBkZWxheSk7XG59XG5cbmZ1bmN0aW9uIGZpeEtleWZyYW1lcyhyb290RWxlbWVudCkge1xuICAgIHZhciBhbmltYXRpb25OYW1lUHJvcCA9IFsgXCJhbmltYXRpb24tbmFtZVwiLCBcIi1tb3otYW5pbWF0aW9uLW5hbWVcIiwgXCItd2Via2l0LWFuaW1hdGlvbi1uYW1lXCIgXS5maWx0ZXIoKGZ1bmN0aW9uKHByb3ApIHtcbiAgICAgICAgcmV0dXJuIGdldENvbXB1dGVkU3R5bGUoZG9jdW1lbnQuYm9keSlbcHJvcF07XG4gICAgfSkpWzBdO1xuICAgIGlmIChhbmltYXRpb25OYW1lUHJvcCkge1xuICAgICAgICB2YXIgYWxsTm9kZXMgPSByb290RWxlbWVudC5nZXRFbGVtZW50c0J5VGFnTmFtZShcIipcIik7XG4gICAgICAgIHZhciBrZXlmcmFtZU5vZGVzID0gW107XG4gICAgICAgIHZhciBuYW1lTWFya2VyID0gXCJfX0NTU1ZBUlNQT05ZRklMTC1LRVlGUkFNRVNfX1wiO1xuICAgICAgICBmb3IgKHZhciBpID0gMCwgbGVuID0gYWxsTm9kZXMubGVuZ3RoOyBpIDwgbGVuOyBpKyspIHtcbiAgICAgICAgICAgIHZhciBub2RlID0gYWxsTm9kZXNbaV07XG4gICAgICAgICAgICB2YXIgYW5pbWF0aW9uTmFtZSA9IGdldENvbXB1dGVkU3R5bGUobm9kZSlbYW5pbWF0aW9uTmFtZVByb3BdO1xuICAgICAgICAgICAgaWYgKGFuaW1hdGlvbk5hbWUgIT09IFwibm9uZVwiKSB7XG4gICAgICAgICAgICAgICAgbm9kZS5zdHlsZVthbmltYXRpb25OYW1lUHJvcF0gKz0gbmFtZU1hcmtlcjtcbiAgICAgICAgICAgICAgICBrZXlmcmFtZU5vZGVzLnB1c2gobm9kZSk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICAgICAgdm9pZCBkb2N1bWVudC5ib2R5Lm9mZnNldEhlaWdodDtcbiAgICAgICAgZm9yICh2YXIgX2kgPSAwLCBfbGVuID0ga2V5ZnJhbWVOb2Rlcy5sZW5ndGg7IF9pIDwgX2xlbjsgX2krKykge1xuICAgICAgICAgICAgdmFyIG5vZGVTdHlsZSA9IGtleWZyYW1lTm9kZXNbX2ldLnN0eWxlO1xuICAgICAgICAgICAgbm9kZVN0eWxlW2FuaW1hdGlvbk5hbWVQcm9wXSA9IG5vZGVTdHlsZVthbmltYXRpb25OYW1lUHJvcF0ucmVwbGFjZShuYW1lTWFya2VyLCBcIlwiKTtcbiAgICAgICAgfVxuICAgIH1cbn1cblxuZnVuY3Rpb24gZml4UmVsYXRpdmVDc3NVcmxzKGNzc1RleHQsIGJhc2VVcmwpIHtcbiAgICB2YXIgY3NzVXJscyA9IGNzc1RleHQucmVwbGFjZShyZWdleC5jc3NDb21tZW50cywgXCJcIikubWF0Y2gocmVnZXguY3NzVXJscykgfHwgW107XG4gICAgY3NzVXJscy5mb3JFYWNoKChmdW5jdGlvbihjc3NVcmwpIHtcbiAgICAgICAgdmFyIG9sZFVybCA9IGNzc1VybC5yZXBsYWNlKHJlZ2V4LmNzc1VybHMsIFwiJDFcIik7XG4gICAgICAgIHZhciBuZXdVcmwgPSBnZXRGdWxsVXJsJDEob2xkVXJsLCBiYXNlVXJsKTtcbiAgICAgICAgY3NzVGV4dCA9IGNzc1RleHQucmVwbGFjZShjc3NVcmwsIGNzc1VybC5yZXBsYWNlKG9sZFVybCwgbmV3VXJsKSk7XG4gICAgfSkpO1xuICAgIHJldHVybiBjc3NUZXh0O1xufVxuXG5mdW5jdGlvbiBmaXhWYXJOYW1lcygpIHtcbiAgICB2YXIgdmFyT2JqID0gYXJndW1lbnRzLmxlbmd0aCA+IDAgJiYgYXJndW1lbnRzWzBdICE9PSB1bmRlZmluZWQgPyBhcmd1bWVudHNbMF0gOiB7fTtcbiAgICB2YXIgcmVMZWFkaW5nSHlwaGVucyA9IC9eLXsyfS87XG4gICAgcmV0dXJuIE9iamVjdC5rZXlzKHZhck9iaikucmVkdWNlKChmdW5jdGlvbihvYmosIHZhbHVlKSB7XG4gICAgICAgIHZhciBrZXkgPSByZUxlYWRpbmdIeXBoZW5zLnRlc3QodmFsdWUpID8gdmFsdWUgOiBcIi0tXCIuY29uY2F0KHZhbHVlLnJlcGxhY2UoL14tKy8sIFwiXCIpKTtcbiAgICAgICAgb2JqW2tleV0gPSB2YXJPYmpbdmFsdWVdO1xuICAgICAgICByZXR1cm4gb2JqO1xuICAgIH0pLCB7fSk7XG59XG5cbmZ1bmN0aW9uIGdldEZ1bGxVcmwkMSh1cmwpIHtcbiAgICB2YXIgYmFzZSA9IGFyZ3VtZW50cy5sZW5ndGggPiAxICYmIGFyZ3VtZW50c1sxXSAhPT0gdW5kZWZpbmVkID8gYXJndW1lbnRzWzFdIDogbG9jYXRpb24uaHJlZjtcbiAgICB2YXIgZCA9IGRvY3VtZW50LmltcGxlbWVudGF0aW9uLmNyZWF0ZUhUTUxEb2N1bWVudChcIlwiKTtcbiAgICB2YXIgYiA9IGQuY3JlYXRlRWxlbWVudChcImJhc2VcIik7XG4gICAgdmFyIGEgPSBkLmNyZWF0ZUVsZW1lbnQoXCJhXCIpO1xuICAgIGQuaGVhZC5hcHBlbmRDaGlsZChiKTtcbiAgICBkLmJvZHkuYXBwZW5kQ2hpbGQoYSk7XG4gICAgYi5ocmVmID0gYmFzZTtcbiAgICBhLmhyZWYgPSB1cmw7XG4gICAgcmV0dXJuIGEuaHJlZjtcbn1cblxuZnVuY3Rpb24gZ2V0VGltZVN0YW1wKCkge1xuICAgIHJldHVybiBpc0Jyb3dzZXIgJiYgKHdpbmRvdy5wZXJmb3JtYW5jZSB8fCB7fSkubm93ID8gd2luZG93LnBlcmZvcm1hbmNlLm5vdygpIDogKG5ldyBEYXRlKS5nZXRUaW1lKCk7XG59XG5cbmZ1bmN0aW9uIHJlc2V0Q3NzTm9kZXMocm9vdEVsZW1lbnQpIHtcbiAgICB2YXIgcmVzZXROb2RlcyA9IEFycmF5LmFwcGx5KG51bGwsIHJvb3RFbGVtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJ1tkYXRhLWNzc3ZhcnM9XCJza2lwXCJdLFtkYXRhLWNzc3ZhcnM9XCJzcmNcIl0nKSk7XG4gICAgcmVzZXROb2Rlcy5mb3JFYWNoKChmdW5jdGlvbihub2RlKSB7XG4gICAgICAgIHJldHVybiBub2RlLnNldEF0dHJpYnV0ZShcImRhdGEtY3NzdmFyc1wiLCBcIlwiKTtcbiAgICB9KSk7XG59XG5cbmV4cG9ydCBkZWZhdWx0IGNzc1ZhcnM7XG4vLyMgc291cmNlTWFwcGluZ1VSTD1jc3MtdmFycy1wb255ZmlsbC5lc20uanMubWFwXG4iLCJ2YXIgcm9vdCA9IHJlcXVpcmUoJy4vX3Jvb3QnKTtcblxuLyoqIEJ1aWx0LWluIHZhbHVlIHJlZmVyZW5jZXMuICovXG52YXIgU3ltYm9sID0gcm9vdC5TeW1ib2w7XG5cbm1vZHVsZS5leHBvcnRzID0gU3ltYm9sO1xuIiwidmFyIFN5bWJvbCA9IHJlcXVpcmUoJy4vX1N5bWJvbCcpLFxuICAgIGdldFJhd1RhZyA9IHJlcXVpcmUoJy4vX2dldFJhd1RhZycpLFxuICAgIG9iamVjdFRvU3RyaW5nID0gcmVxdWlyZSgnLi9fb2JqZWN0VG9TdHJpbmcnKTtcblxuLyoqIGBPYmplY3QjdG9TdHJpbmdgIHJlc3VsdCByZWZlcmVuY2VzLiAqL1xudmFyIG51bGxUYWcgPSAnW29iamVjdCBOdWxsXScsXG4gICAgdW5kZWZpbmVkVGFnID0gJ1tvYmplY3QgVW5kZWZpbmVkXSc7XG5cbi8qKiBCdWlsdC1pbiB2YWx1ZSByZWZlcmVuY2VzLiAqL1xudmFyIHN5bVRvU3RyaW5nVGFnID0gU3ltYm9sID8gU3ltYm9sLnRvU3RyaW5nVGFnIDogdW5kZWZpbmVkO1xuXG4vKipcbiAqIFRoZSBiYXNlIGltcGxlbWVudGF0aW9uIG9mIGBnZXRUYWdgIHdpdGhvdXQgZmFsbGJhY2tzIGZvciBidWdneSBlbnZpcm9ubWVudHMuXG4gKlxuICogQHByaXZhdGVcbiAqIEBwYXJhbSB7Kn0gdmFsdWUgVGhlIHZhbHVlIHRvIHF1ZXJ5LlxuICogQHJldHVybnMge3N0cmluZ30gUmV0dXJucyB0aGUgYHRvU3RyaW5nVGFnYC5cbiAqL1xuZnVuY3Rpb24gYmFzZUdldFRhZyh2YWx1ZSkge1xuICBpZiAodmFsdWUgPT0gbnVsbCkge1xuICAgIHJldHVybiB2YWx1ZSA9PT0gdW5kZWZpbmVkID8gdW5kZWZpbmVkVGFnIDogbnVsbFRhZztcbiAgfVxuICByZXR1cm4gKHN5bVRvU3RyaW5nVGFnICYmIHN5bVRvU3RyaW5nVGFnIGluIE9iamVjdCh2YWx1ZSkpXG4gICAgPyBnZXRSYXdUYWcodmFsdWUpXG4gICAgOiBvYmplY3RUb1N0cmluZyh2YWx1ZSk7XG59XG5cbm1vZHVsZS5leHBvcnRzID0gYmFzZUdldFRhZztcbiIsIi8qKiBEZXRlY3QgZnJlZSB2YXJpYWJsZSBgZ2xvYmFsYCBmcm9tIE5vZGUuanMuICovXG52YXIgZnJlZUdsb2JhbCA9IHR5cGVvZiBnbG9iYWwgPT0gJ29iamVjdCcgJiYgZ2xvYmFsICYmIGdsb2JhbC5PYmplY3QgPT09IE9iamVjdCAmJiBnbG9iYWw7XG5cbm1vZHVsZS5leHBvcnRzID0gZnJlZUdsb2JhbDtcbiIsInZhciBTeW1ib2wgPSByZXF1aXJlKCcuL19TeW1ib2wnKTtcblxuLyoqIFVzZWQgZm9yIGJ1aWx0LWluIG1ldGhvZCByZWZlcmVuY2VzLiAqL1xudmFyIG9iamVjdFByb3RvID0gT2JqZWN0LnByb3RvdHlwZTtcblxuLyoqIFVzZWQgdG8gY2hlY2sgb2JqZWN0cyBmb3Igb3duIHByb3BlcnRpZXMuICovXG52YXIgaGFzT3duUHJvcGVydHkgPSBvYmplY3RQcm90by5oYXNPd25Qcm9wZXJ0eTtcblxuLyoqXG4gKiBVc2VkIHRvIHJlc29sdmUgdGhlXG4gKiBbYHRvU3RyaW5nVGFnYF0oaHR0cDovL2VjbWEtaW50ZXJuYXRpb25hbC5vcmcvZWNtYS0yNjIvNy4wLyNzZWMtb2JqZWN0LnByb3RvdHlwZS50b3N0cmluZylcbiAqIG9mIHZhbHVlcy5cbiAqL1xudmFyIG5hdGl2ZU9iamVjdFRvU3RyaW5nID0gb2JqZWN0UHJvdG8udG9TdHJpbmc7XG5cbi8qKiBCdWlsdC1pbiB2YWx1ZSByZWZlcmVuY2VzLiAqL1xudmFyIHN5bVRvU3RyaW5nVGFnID0gU3ltYm9sID8gU3ltYm9sLnRvU3RyaW5nVGFnIDogdW5kZWZpbmVkO1xuXG4vKipcbiAqIEEgc3BlY2lhbGl6ZWQgdmVyc2lvbiBvZiBgYmFzZUdldFRhZ2Agd2hpY2ggaWdub3JlcyBgU3ltYm9sLnRvU3RyaW5nVGFnYCB2YWx1ZXMuXG4gKlxuICogQHByaXZhdGVcbiAqIEBwYXJhbSB7Kn0gdmFsdWUgVGhlIHZhbHVlIHRvIHF1ZXJ5LlxuICogQHJldHVybnMge3N0cmluZ30gUmV0dXJucyB0aGUgcmF3IGB0b1N0cmluZ1RhZ2AuXG4gKi9cbmZ1bmN0aW9uIGdldFJhd1RhZyh2YWx1ZSkge1xuICB2YXIgaXNPd24gPSBoYXNPd25Qcm9wZXJ0eS5jYWxsKHZhbHVlLCBzeW1Ub1N0cmluZ1RhZyksXG4gICAgICB0YWcgPSB2YWx1ZVtzeW1Ub1N0cmluZ1RhZ107XG5cbiAgdHJ5IHtcbiAgICB2YWx1ZVtzeW1Ub1N0cmluZ1RhZ10gPSB1bmRlZmluZWQ7XG4gICAgdmFyIHVubWFza2VkID0gdHJ1ZTtcbiAgfSBjYXRjaCAoZSkge31cblxuICB2YXIgcmVzdWx0ID0gbmF0aXZlT2JqZWN0VG9TdHJpbmcuY2FsbCh2YWx1ZSk7XG4gIGlmICh1bm1hc2tlZCkge1xuICAgIGlmIChpc093bikge1xuICAgICAgdmFsdWVbc3ltVG9TdHJpbmdUYWddID0gdGFnO1xuICAgIH0gZWxzZSB7XG4gICAgICBkZWxldGUgdmFsdWVbc3ltVG9TdHJpbmdUYWddO1xuICAgIH1cbiAgfVxuICByZXR1cm4gcmVzdWx0O1xufVxuXG5tb2R1bGUuZXhwb3J0cyA9IGdldFJhd1RhZztcbiIsIi8qKiBVc2VkIGZvciBidWlsdC1pbiBtZXRob2QgcmVmZXJlbmNlcy4gKi9cbnZhciBvYmplY3RQcm90byA9IE9iamVjdC5wcm90b3R5cGU7XG5cbi8qKlxuICogVXNlZCB0byByZXNvbHZlIHRoZVxuICogW2B0b1N0cmluZ1RhZ2BdKGh0dHA6Ly9lY21hLWludGVybmF0aW9uYWwub3JnL2VjbWEtMjYyLzcuMC8jc2VjLW9iamVjdC5wcm90b3R5cGUudG9zdHJpbmcpXG4gKiBvZiB2YWx1ZXMuXG4gKi9cbnZhciBuYXRpdmVPYmplY3RUb1N0cmluZyA9IG9iamVjdFByb3RvLnRvU3RyaW5nO1xuXG4vKipcbiAqIENvbnZlcnRzIGB2YWx1ZWAgdG8gYSBzdHJpbmcgdXNpbmcgYE9iamVjdC5wcm90b3R5cGUudG9TdHJpbmdgLlxuICpcbiAqIEBwcml2YXRlXG4gKiBAcGFyYW0geyp9IHZhbHVlIFRoZSB2YWx1ZSB0byBjb252ZXJ0LlxuICogQHJldHVybnMge3N0cmluZ30gUmV0dXJucyB0aGUgY29udmVydGVkIHN0cmluZy5cbiAqL1xuZnVuY3Rpb24gb2JqZWN0VG9TdHJpbmcodmFsdWUpIHtcbiAgcmV0dXJuIG5hdGl2ZU9iamVjdFRvU3RyaW5nLmNhbGwodmFsdWUpO1xufVxuXG5tb2R1bGUuZXhwb3J0cyA9IG9iamVjdFRvU3RyaW5nO1xuIiwidmFyIGZyZWVHbG9iYWwgPSByZXF1aXJlKCcuL19mcmVlR2xvYmFsJyk7XG5cbi8qKiBEZXRlY3QgZnJlZSB2YXJpYWJsZSBgc2VsZmAuICovXG52YXIgZnJlZVNlbGYgPSB0eXBlb2Ygc2VsZiA9PSAnb2JqZWN0JyAmJiBzZWxmICYmIHNlbGYuT2JqZWN0ID09PSBPYmplY3QgJiYgc2VsZjtcblxuLyoqIFVzZWQgYXMgYSByZWZlcmVuY2UgdG8gdGhlIGdsb2JhbCBvYmplY3QuICovXG52YXIgcm9vdCA9IGZyZWVHbG9iYWwgfHwgZnJlZVNlbGYgfHwgRnVuY3Rpb24oJ3JldHVybiB0aGlzJykoKTtcblxubW9kdWxlLmV4cG9ydHMgPSByb290O1xuIiwidmFyIGlzT2JqZWN0ID0gcmVxdWlyZSgnLi9pc09iamVjdCcpLFxuICAgIG5vdyA9IHJlcXVpcmUoJy4vbm93JyksXG4gICAgdG9OdW1iZXIgPSByZXF1aXJlKCcuL3RvTnVtYmVyJyk7XG5cbi8qKiBFcnJvciBtZXNzYWdlIGNvbnN0YW50cy4gKi9cbnZhciBGVU5DX0VSUk9SX1RFWFQgPSAnRXhwZWN0ZWQgYSBmdW5jdGlvbic7XG5cbi8qIEJ1aWx0LWluIG1ldGhvZCByZWZlcmVuY2VzIGZvciB0aG9zZSB3aXRoIHRoZSBzYW1lIG5hbWUgYXMgb3RoZXIgYGxvZGFzaGAgbWV0aG9kcy4gKi9cbnZhciBuYXRpdmVNYXggPSBNYXRoLm1heCxcbiAgICBuYXRpdmVNaW4gPSBNYXRoLm1pbjtcblxuLyoqXG4gKiBDcmVhdGVzIGEgZGVib3VuY2VkIGZ1bmN0aW9uIHRoYXQgZGVsYXlzIGludm9raW5nIGBmdW5jYCB1bnRpbCBhZnRlciBgd2FpdGBcbiAqIG1pbGxpc2Vjb25kcyBoYXZlIGVsYXBzZWQgc2luY2UgdGhlIGxhc3QgdGltZSB0aGUgZGVib3VuY2VkIGZ1bmN0aW9uIHdhc1xuICogaW52b2tlZC4gVGhlIGRlYm91bmNlZCBmdW5jdGlvbiBjb21lcyB3aXRoIGEgYGNhbmNlbGAgbWV0aG9kIHRvIGNhbmNlbFxuICogZGVsYXllZCBgZnVuY2AgaW52b2NhdGlvbnMgYW5kIGEgYGZsdXNoYCBtZXRob2QgdG8gaW1tZWRpYXRlbHkgaW52b2tlIHRoZW0uXG4gKiBQcm92aWRlIGBvcHRpb25zYCB0byBpbmRpY2F0ZSB3aGV0aGVyIGBmdW5jYCBzaG91bGQgYmUgaW52b2tlZCBvbiB0aGVcbiAqIGxlYWRpbmcgYW5kL29yIHRyYWlsaW5nIGVkZ2Ugb2YgdGhlIGB3YWl0YCB0aW1lb3V0LiBUaGUgYGZ1bmNgIGlzIGludm9rZWRcbiAqIHdpdGggdGhlIGxhc3QgYXJndW1lbnRzIHByb3ZpZGVkIHRvIHRoZSBkZWJvdW5jZWQgZnVuY3Rpb24uIFN1YnNlcXVlbnRcbiAqIGNhbGxzIHRvIHRoZSBkZWJvdW5jZWQgZnVuY3Rpb24gcmV0dXJuIHRoZSByZXN1bHQgb2YgdGhlIGxhc3QgYGZ1bmNgXG4gKiBpbnZvY2F0aW9uLlxuICpcbiAqICoqTm90ZToqKiBJZiBgbGVhZGluZ2AgYW5kIGB0cmFpbGluZ2Agb3B0aW9ucyBhcmUgYHRydWVgLCBgZnVuY2AgaXNcbiAqIGludm9rZWQgb24gdGhlIHRyYWlsaW5nIGVkZ2Ugb2YgdGhlIHRpbWVvdXQgb25seSBpZiB0aGUgZGVib3VuY2VkIGZ1bmN0aW9uXG4gKiBpcyBpbnZva2VkIG1vcmUgdGhhbiBvbmNlIGR1cmluZyB0aGUgYHdhaXRgIHRpbWVvdXQuXG4gKlxuICogSWYgYHdhaXRgIGlzIGAwYCBhbmQgYGxlYWRpbmdgIGlzIGBmYWxzZWAsIGBmdW5jYCBpbnZvY2F0aW9uIGlzIGRlZmVycmVkXG4gKiB1bnRpbCB0byB0aGUgbmV4dCB0aWNrLCBzaW1pbGFyIHRvIGBzZXRUaW1lb3V0YCB3aXRoIGEgdGltZW91dCBvZiBgMGAuXG4gKlxuICogU2VlIFtEYXZpZCBDb3JiYWNobydzIGFydGljbGVdKGh0dHBzOi8vY3NzLXRyaWNrcy5jb20vZGVib3VuY2luZy10aHJvdHRsaW5nLWV4cGxhaW5lZC1leGFtcGxlcy8pXG4gKiBmb3IgZGV0YWlscyBvdmVyIHRoZSBkaWZmZXJlbmNlcyBiZXR3ZWVuIGBfLmRlYm91bmNlYCBhbmQgYF8udGhyb3R0bGVgLlxuICpcbiAqIEBzdGF0aWNcbiAqIEBtZW1iZXJPZiBfXG4gKiBAc2luY2UgMC4xLjBcbiAqIEBjYXRlZ29yeSBGdW5jdGlvblxuICogQHBhcmFtIHtGdW5jdGlvbn0gZnVuYyBUaGUgZnVuY3Rpb24gdG8gZGVib3VuY2UuXG4gKiBAcGFyYW0ge251bWJlcn0gW3dhaXQ9MF0gVGhlIG51bWJlciBvZiBtaWxsaXNlY29uZHMgdG8gZGVsYXkuXG4gKiBAcGFyYW0ge09iamVjdH0gW29wdGlvbnM9e31dIFRoZSBvcHRpb25zIG9iamVjdC5cbiAqIEBwYXJhbSB7Ym9vbGVhbn0gW29wdGlvbnMubGVhZGluZz1mYWxzZV1cbiAqICBTcGVjaWZ5IGludm9raW5nIG9uIHRoZSBsZWFkaW5nIGVkZ2Ugb2YgdGhlIHRpbWVvdXQuXG4gKiBAcGFyYW0ge251bWJlcn0gW29wdGlvbnMubWF4V2FpdF1cbiAqICBUaGUgbWF4aW11bSB0aW1lIGBmdW5jYCBpcyBhbGxvd2VkIHRvIGJlIGRlbGF5ZWQgYmVmb3JlIGl0J3MgaW52b2tlZC5cbiAqIEBwYXJhbSB7Ym9vbGVhbn0gW29wdGlvbnMudHJhaWxpbmc9dHJ1ZV1cbiAqICBTcGVjaWZ5IGludm9raW5nIG9uIHRoZSB0cmFpbGluZyBlZGdlIG9mIHRoZSB0aW1lb3V0LlxuICogQHJldHVybnMge0Z1bmN0aW9ufSBSZXR1cm5zIHRoZSBuZXcgZGVib3VuY2VkIGZ1bmN0aW9uLlxuICogQGV4YW1wbGVcbiAqXG4gKiAvLyBBdm9pZCBjb3N0bHkgY2FsY3VsYXRpb25zIHdoaWxlIHRoZSB3aW5kb3cgc2l6ZSBpcyBpbiBmbHV4LlxuICogalF1ZXJ5KHdpbmRvdykub24oJ3Jlc2l6ZScsIF8uZGVib3VuY2UoY2FsY3VsYXRlTGF5b3V0LCAxNTApKTtcbiAqXG4gKiAvLyBJbnZva2UgYHNlbmRNYWlsYCB3aGVuIGNsaWNrZWQsIGRlYm91bmNpbmcgc3Vic2VxdWVudCBjYWxscy5cbiAqIGpRdWVyeShlbGVtZW50KS5vbignY2xpY2snLCBfLmRlYm91bmNlKHNlbmRNYWlsLCAzMDAsIHtcbiAqICAgJ2xlYWRpbmcnOiB0cnVlLFxuICogICAndHJhaWxpbmcnOiBmYWxzZVxuICogfSkpO1xuICpcbiAqIC8vIEVuc3VyZSBgYmF0Y2hMb2dgIGlzIGludm9rZWQgb25jZSBhZnRlciAxIHNlY29uZCBvZiBkZWJvdW5jZWQgY2FsbHMuXG4gKiB2YXIgZGVib3VuY2VkID0gXy5kZWJvdW5jZShiYXRjaExvZywgMjUwLCB7ICdtYXhXYWl0JzogMTAwMCB9KTtcbiAqIHZhciBzb3VyY2UgPSBuZXcgRXZlbnRTb3VyY2UoJy9zdHJlYW0nKTtcbiAqIGpRdWVyeShzb3VyY2UpLm9uKCdtZXNzYWdlJywgZGVib3VuY2VkKTtcbiAqXG4gKiAvLyBDYW5jZWwgdGhlIHRyYWlsaW5nIGRlYm91bmNlZCBpbnZvY2F0aW9uLlxuICogalF1ZXJ5KHdpbmRvdykub24oJ3BvcHN0YXRlJywgZGVib3VuY2VkLmNhbmNlbCk7XG4gKi9cbmZ1bmN0aW9uIGRlYm91bmNlKGZ1bmMsIHdhaXQsIG9wdGlvbnMpIHtcbiAgdmFyIGxhc3RBcmdzLFxuICAgICAgbGFzdFRoaXMsXG4gICAgICBtYXhXYWl0LFxuICAgICAgcmVzdWx0LFxuICAgICAgdGltZXJJZCxcbiAgICAgIGxhc3RDYWxsVGltZSxcbiAgICAgIGxhc3RJbnZva2VUaW1lID0gMCxcbiAgICAgIGxlYWRpbmcgPSBmYWxzZSxcbiAgICAgIG1heGluZyA9IGZhbHNlLFxuICAgICAgdHJhaWxpbmcgPSB0cnVlO1xuXG4gIGlmICh0eXBlb2YgZnVuYyAhPSAnZnVuY3Rpb24nKSB7XG4gICAgdGhyb3cgbmV3IFR5cGVFcnJvcihGVU5DX0VSUk9SX1RFWFQpO1xuICB9XG4gIHdhaXQgPSB0b051bWJlcih3YWl0KSB8fCAwO1xuICBpZiAoaXNPYmplY3Qob3B0aW9ucykpIHtcbiAgICBsZWFkaW5nID0gISFvcHRpb25zLmxlYWRpbmc7XG4gICAgbWF4aW5nID0gJ21heFdhaXQnIGluIG9wdGlvbnM7XG4gICAgbWF4V2FpdCA9IG1heGluZyA/IG5hdGl2ZU1heCh0b051bWJlcihvcHRpb25zLm1heFdhaXQpIHx8IDAsIHdhaXQpIDogbWF4V2FpdDtcbiAgICB0cmFpbGluZyA9ICd0cmFpbGluZycgaW4gb3B0aW9ucyA/ICEhb3B0aW9ucy50cmFpbGluZyA6IHRyYWlsaW5nO1xuICB9XG5cbiAgZnVuY3Rpb24gaW52b2tlRnVuYyh0aW1lKSB7XG4gICAgdmFyIGFyZ3MgPSBsYXN0QXJncyxcbiAgICAgICAgdGhpc0FyZyA9IGxhc3RUaGlzO1xuXG4gICAgbGFzdEFyZ3MgPSBsYXN0VGhpcyA9IHVuZGVmaW5lZDtcbiAgICBsYXN0SW52b2tlVGltZSA9IHRpbWU7XG4gICAgcmVzdWx0ID0gZnVuYy5hcHBseSh0aGlzQXJnLCBhcmdzKTtcbiAgICByZXR1cm4gcmVzdWx0O1xuICB9XG5cbiAgZnVuY3Rpb24gbGVhZGluZ0VkZ2UodGltZSkge1xuICAgIC8vIFJlc2V0IGFueSBgbWF4V2FpdGAgdGltZXIuXG4gICAgbGFzdEludm9rZVRpbWUgPSB0aW1lO1xuICAgIC8vIFN0YXJ0IHRoZSB0aW1lciBmb3IgdGhlIHRyYWlsaW5nIGVkZ2UuXG4gICAgdGltZXJJZCA9IHNldFRpbWVvdXQodGltZXJFeHBpcmVkLCB3YWl0KTtcbiAgICAvLyBJbnZva2UgdGhlIGxlYWRpbmcgZWRnZS5cbiAgICByZXR1cm4gbGVhZGluZyA/IGludm9rZUZ1bmModGltZSkgOiByZXN1bHQ7XG4gIH1cblxuICBmdW5jdGlvbiByZW1haW5pbmdXYWl0KHRpbWUpIHtcbiAgICB2YXIgdGltZVNpbmNlTGFzdENhbGwgPSB0aW1lIC0gbGFzdENhbGxUaW1lLFxuICAgICAgICB0aW1lU2luY2VMYXN0SW52b2tlID0gdGltZSAtIGxhc3RJbnZva2VUaW1lLFxuICAgICAgICB0aW1lV2FpdGluZyA9IHdhaXQgLSB0aW1lU2luY2VMYXN0Q2FsbDtcblxuICAgIHJldHVybiBtYXhpbmdcbiAgICAgID8gbmF0aXZlTWluKHRpbWVXYWl0aW5nLCBtYXhXYWl0IC0gdGltZVNpbmNlTGFzdEludm9rZSlcbiAgICAgIDogdGltZVdhaXRpbmc7XG4gIH1cblxuICBmdW5jdGlvbiBzaG91bGRJbnZva2UodGltZSkge1xuICAgIHZhciB0aW1lU2luY2VMYXN0Q2FsbCA9IHRpbWUgLSBsYXN0Q2FsbFRpbWUsXG4gICAgICAgIHRpbWVTaW5jZUxhc3RJbnZva2UgPSB0aW1lIC0gbGFzdEludm9rZVRpbWU7XG5cbiAgICAvLyBFaXRoZXIgdGhpcyBpcyB0aGUgZmlyc3QgY2FsbCwgYWN0aXZpdHkgaGFzIHN0b3BwZWQgYW5kIHdlJ3JlIGF0IHRoZVxuICAgIC8vIHRyYWlsaW5nIGVkZ2UsIHRoZSBzeXN0ZW0gdGltZSBoYXMgZ29uZSBiYWNrd2FyZHMgYW5kIHdlJ3JlIHRyZWF0aW5nXG4gICAgLy8gaXQgYXMgdGhlIHRyYWlsaW5nIGVkZ2UsIG9yIHdlJ3ZlIGhpdCB0aGUgYG1heFdhaXRgIGxpbWl0LlxuICAgIHJldHVybiAobGFzdENhbGxUaW1lID09PSB1bmRlZmluZWQgfHwgKHRpbWVTaW5jZUxhc3RDYWxsID49IHdhaXQpIHx8XG4gICAgICAodGltZVNpbmNlTGFzdENhbGwgPCAwKSB8fCAobWF4aW5nICYmIHRpbWVTaW5jZUxhc3RJbnZva2UgPj0gbWF4V2FpdCkpO1xuICB9XG5cbiAgZnVuY3Rpb24gdGltZXJFeHBpcmVkKCkge1xuICAgIHZhciB0aW1lID0gbm93KCk7XG4gICAgaWYgKHNob3VsZEludm9rZSh0aW1lKSkge1xuICAgICAgcmV0dXJuIHRyYWlsaW5nRWRnZSh0aW1lKTtcbiAgICB9XG4gICAgLy8gUmVzdGFydCB0aGUgdGltZXIuXG4gICAgdGltZXJJZCA9IHNldFRpbWVvdXQodGltZXJFeHBpcmVkLCByZW1haW5pbmdXYWl0KHRpbWUpKTtcbiAgfVxuXG4gIGZ1bmN0aW9uIHRyYWlsaW5nRWRnZSh0aW1lKSB7XG4gICAgdGltZXJJZCA9IHVuZGVmaW5lZDtcblxuICAgIC8vIE9ubHkgaW52b2tlIGlmIHdlIGhhdmUgYGxhc3RBcmdzYCB3aGljaCBtZWFucyBgZnVuY2AgaGFzIGJlZW5cbiAgICAvLyBkZWJvdW5jZWQgYXQgbGVhc3Qgb25jZS5cbiAgICBpZiAodHJhaWxpbmcgJiYgbGFzdEFyZ3MpIHtcbiAgICAgIHJldHVybiBpbnZva2VGdW5jKHRpbWUpO1xuICAgIH1cbiAgICBsYXN0QXJncyA9IGxhc3RUaGlzID0gdW5kZWZpbmVkO1xuICAgIHJldHVybiByZXN1bHQ7XG4gIH1cblxuICBmdW5jdGlvbiBjYW5jZWwoKSB7XG4gICAgaWYgKHRpbWVySWQgIT09IHVuZGVmaW5lZCkge1xuICAgICAgY2xlYXJUaW1lb3V0KHRpbWVySWQpO1xuICAgIH1cbiAgICBsYXN0SW52b2tlVGltZSA9IDA7XG4gICAgbGFzdEFyZ3MgPSBsYXN0Q2FsbFRpbWUgPSBsYXN0VGhpcyA9IHRpbWVySWQgPSB1bmRlZmluZWQ7XG4gIH1cblxuICBmdW5jdGlvbiBmbHVzaCgpIHtcbiAgICByZXR1cm4gdGltZXJJZCA9PT0gdW5kZWZpbmVkID8gcmVzdWx0IDogdHJhaWxpbmdFZGdlKG5vdygpKTtcbiAgfVxuXG4gIGZ1bmN0aW9uIGRlYm91bmNlZCgpIHtcbiAgICB2YXIgdGltZSA9IG5vdygpLFxuICAgICAgICBpc0ludm9raW5nID0gc2hvdWxkSW52b2tlKHRpbWUpO1xuXG4gICAgbGFzdEFyZ3MgPSBhcmd1bWVudHM7XG4gICAgbGFzdFRoaXMgPSB0aGlzO1xuICAgIGxhc3RDYWxsVGltZSA9IHRpbWU7XG5cbiAgICBpZiAoaXNJbnZva2luZykge1xuICAgICAgaWYgKHRpbWVySWQgPT09IHVuZGVmaW5lZCkge1xuICAgICAgICByZXR1cm4gbGVhZGluZ0VkZ2UobGFzdENhbGxUaW1lKTtcbiAgICAgIH1cbiAgICAgIGlmIChtYXhpbmcpIHtcbiAgICAgICAgLy8gSGFuZGxlIGludm9jYXRpb25zIGluIGEgdGlnaHQgbG9vcC5cbiAgICAgICAgY2xlYXJUaW1lb3V0KHRpbWVySWQpO1xuICAgICAgICB0aW1lcklkID0gc2V0VGltZW91dCh0aW1lckV4cGlyZWQsIHdhaXQpO1xuICAgICAgICByZXR1cm4gaW52b2tlRnVuYyhsYXN0Q2FsbFRpbWUpO1xuICAgICAgfVxuICAgIH1cbiAgICBpZiAodGltZXJJZCA9PT0gdW5kZWZpbmVkKSB7XG4gICAgICB0aW1lcklkID0gc2V0VGltZW91dCh0aW1lckV4cGlyZWQsIHdhaXQpO1xuICAgIH1cbiAgICByZXR1cm4gcmVzdWx0O1xuICB9XG4gIGRlYm91bmNlZC5jYW5jZWwgPSBjYW5jZWw7XG4gIGRlYm91bmNlZC5mbHVzaCA9IGZsdXNoO1xuICByZXR1cm4gZGVib3VuY2VkO1xufVxuXG5tb2R1bGUuZXhwb3J0cyA9IGRlYm91bmNlO1xuIiwiLyoqXG4gKiBDaGVja3MgaWYgYHZhbHVlYCBpcyB0aGVcbiAqIFtsYW5ndWFnZSB0eXBlXShodHRwOi8vd3d3LmVjbWEtaW50ZXJuYXRpb25hbC5vcmcvZWNtYS0yNjIvNy4wLyNzZWMtZWNtYXNjcmlwdC1sYW5ndWFnZS10eXBlcylcbiAqIG9mIGBPYmplY3RgLiAoZS5nLiBhcnJheXMsIGZ1bmN0aW9ucywgb2JqZWN0cywgcmVnZXhlcywgYG5ldyBOdW1iZXIoMClgLCBhbmQgYG5ldyBTdHJpbmcoJycpYClcbiAqXG4gKiBAc3RhdGljXG4gKiBAbWVtYmVyT2YgX1xuICogQHNpbmNlIDAuMS4wXG4gKiBAY2F0ZWdvcnkgTGFuZ1xuICogQHBhcmFtIHsqfSB2YWx1ZSBUaGUgdmFsdWUgdG8gY2hlY2suXG4gKiBAcmV0dXJucyB7Ym9vbGVhbn0gUmV0dXJucyBgdHJ1ZWAgaWYgYHZhbHVlYCBpcyBhbiBvYmplY3QsIGVsc2UgYGZhbHNlYC5cbiAqIEBleGFtcGxlXG4gKlxuICogXy5pc09iamVjdCh7fSk7XG4gKiAvLyA9PiB0cnVlXG4gKlxuICogXy5pc09iamVjdChbMSwgMiwgM10pO1xuICogLy8gPT4gdHJ1ZVxuICpcbiAqIF8uaXNPYmplY3QoXy5ub29wKTtcbiAqIC8vID0+IHRydWVcbiAqXG4gKiBfLmlzT2JqZWN0KG51bGwpO1xuICogLy8gPT4gZmFsc2VcbiAqL1xuZnVuY3Rpb24gaXNPYmplY3QodmFsdWUpIHtcbiAgdmFyIHR5cGUgPSB0eXBlb2YgdmFsdWU7XG4gIHJldHVybiB2YWx1ZSAhPSBudWxsICYmICh0eXBlID09ICdvYmplY3QnIHx8IHR5cGUgPT0gJ2Z1bmN0aW9uJyk7XG59XG5cbm1vZHVsZS5leHBvcnRzID0gaXNPYmplY3Q7XG4iLCIvKipcbiAqIENoZWNrcyBpZiBgdmFsdWVgIGlzIG9iamVjdC1saWtlLiBBIHZhbHVlIGlzIG9iamVjdC1saWtlIGlmIGl0J3Mgbm90IGBudWxsYFxuICogYW5kIGhhcyBhIGB0eXBlb2ZgIHJlc3VsdCBvZiBcIm9iamVjdFwiLlxuICpcbiAqIEBzdGF0aWNcbiAqIEBtZW1iZXJPZiBfXG4gKiBAc2luY2UgNC4wLjBcbiAqIEBjYXRlZ29yeSBMYW5nXG4gKiBAcGFyYW0geyp9IHZhbHVlIFRoZSB2YWx1ZSB0byBjaGVjay5cbiAqIEByZXR1cm5zIHtib29sZWFufSBSZXR1cm5zIGB0cnVlYCBpZiBgdmFsdWVgIGlzIG9iamVjdC1saWtlLCBlbHNlIGBmYWxzZWAuXG4gKiBAZXhhbXBsZVxuICpcbiAqIF8uaXNPYmplY3RMaWtlKHt9KTtcbiAqIC8vID0+IHRydWVcbiAqXG4gKiBfLmlzT2JqZWN0TGlrZShbMSwgMiwgM10pO1xuICogLy8gPT4gdHJ1ZVxuICpcbiAqIF8uaXNPYmplY3RMaWtlKF8ubm9vcCk7XG4gKiAvLyA9PiBmYWxzZVxuICpcbiAqIF8uaXNPYmplY3RMaWtlKG51bGwpO1xuICogLy8gPT4gZmFsc2VcbiAqL1xuZnVuY3Rpb24gaXNPYmplY3RMaWtlKHZhbHVlKSB7XG4gIHJldHVybiB2YWx1ZSAhPSBudWxsICYmIHR5cGVvZiB2YWx1ZSA9PSAnb2JqZWN0Jztcbn1cblxubW9kdWxlLmV4cG9ydHMgPSBpc09iamVjdExpa2U7XG4iLCJ2YXIgYmFzZUdldFRhZyA9IHJlcXVpcmUoJy4vX2Jhc2VHZXRUYWcnKSxcbiAgICBpc09iamVjdExpa2UgPSByZXF1aXJlKCcuL2lzT2JqZWN0TGlrZScpO1xuXG4vKiogYE9iamVjdCN0b1N0cmluZ2AgcmVzdWx0IHJlZmVyZW5jZXMuICovXG52YXIgc3ltYm9sVGFnID0gJ1tvYmplY3QgU3ltYm9sXSc7XG5cbi8qKlxuICogQ2hlY2tzIGlmIGB2YWx1ZWAgaXMgY2xhc3NpZmllZCBhcyBhIGBTeW1ib2xgIHByaW1pdGl2ZSBvciBvYmplY3QuXG4gKlxuICogQHN0YXRpY1xuICogQG1lbWJlck9mIF9cbiAqIEBzaW5jZSA0LjAuMFxuICogQGNhdGVnb3J5IExhbmdcbiAqIEBwYXJhbSB7Kn0gdmFsdWUgVGhlIHZhbHVlIHRvIGNoZWNrLlxuICogQHJldHVybnMge2Jvb2xlYW59IFJldHVybnMgYHRydWVgIGlmIGB2YWx1ZWAgaXMgYSBzeW1ib2wsIGVsc2UgYGZhbHNlYC5cbiAqIEBleGFtcGxlXG4gKlxuICogXy5pc1N5bWJvbChTeW1ib2wuaXRlcmF0b3IpO1xuICogLy8gPT4gdHJ1ZVxuICpcbiAqIF8uaXNTeW1ib2woJ2FiYycpO1xuICogLy8gPT4gZmFsc2VcbiAqL1xuZnVuY3Rpb24gaXNTeW1ib2wodmFsdWUpIHtcbiAgcmV0dXJuIHR5cGVvZiB2YWx1ZSA9PSAnc3ltYm9sJyB8fFxuICAgIChpc09iamVjdExpa2UodmFsdWUpICYmIGJhc2VHZXRUYWcodmFsdWUpID09IHN5bWJvbFRhZyk7XG59XG5cbm1vZHVsZS5leHBvcnRzID0gaXNTeW1ib2w7XG4iLCJ2YXIgcm9vdCA9IHJlcXVpcmUoJy4vX3Jvb3QnKTtcblxuLyoqXG4gKiBHZXRzIHRoZSB0aW1lc3RhbXAgb2YgdGhlIG51bWJlciBvZiBtaWxsaXNlY29uZHMgdGhhdCBoYXZlIGVsYXBzZWQgc2luY2VcbiAqIHRoZSBVbml4IGVwb2NoICgxIEphbnVhcnkgMTk3MCAwMDowMDowMCBVVEMpLlxuICpcbiAqIEBzdGF0aWNcbiAqIEBtZW1iZXJPZiBfXG4gKiBAc2luY2UgMi40LjBcbiAqIEBjYXRlZ29yeSBEYXRlXG4gKiBAcmV0dXJucyB7bnVtYmVyfSBSZXR1cm5zIHRoZSB0aW1lc3RhbXAuXG4gKiBAZXhhbXBsZVxuICpcbiAqIF8uZGVmZXIoZnVuY3Rpb24oc3RhbXApIHtcbiAqICAgY29uc29sZS5sb2coXy5ub3coKSAtIHN0YW1wKTtcbiAqIH0sIF8ubm93KCkpO1xuICogLy8gPT4gTG9ncyB0aGUgbnVtYmVyIG9mIG1pbGxpc2Vjb25kcyBpdCB0b29rIGZvciB0aGUgZGVmZXJyZWQgaW52b2NhdGlvbi5cbiAqL1xudmFyIG5vdyA9IGZ1bmN0aW9uKCkge1xuICByZXR1cm4gcm9vdC5EYXRlLm5vdygpO1xufTtcblxubW9kdWxlLmV4cG9ydHMgPSBub3c7XG4iLCJ2YXIgaXNPYmplY3QgPSByZXF1aXJlKCcuL2lzT2JqZWN0JyksXG4gICAgaXNTeW1ib2wgPSByZXF1aXJlKCcuL2lzU3ltYm9sJyk7XG5cbi8qKiBVc2VkIGFzIHJlZmVyZW5jZXMgZm9yIHZhcmlvdXMgYE51bWJlcmAgY29uc3RhbnRzLiAqL1xudmFyIE5BTiA9IDAgLyAwO1xuXG4vKiogVXNlZCB0byBtYXRjaCBsZWFkaW5nIGFuZCB0cmFpbGluZyB3aGl0ZXNwYWNlLiAqL1xudmFyIHJlVHJpbSA9IC9eXFxzK3xcXHMrJC9nO1xuXG4vKiogVXNlZCB0byBkZXRlY3QgYmFkIHNpZ25lZCBoZXhhZGVjaW1hbCBzdHJpbmcgdmFsdWVzLiAqL1xudmFyIHJlSXNCYWRIZXggPSAvXlstK10weFswLTlhLWZdKyQvaTtcblxuLyoqIFVzZWQgdG8gZGV0ZWN0IGJpbmFyeSBzdHJpbmcgdmFsdWVzLiAqL1xudmFyIHJlSXNCaW5hcnkgPSAvXjBiWzAxXSskL2k7XG5cbi8qKiBVc2VkIHRvIGRldGVjdCBvY3RhbCBzdHJpbmcgdmFsdWVzLiAqL1xudmFyIHJlSXNPY3RhbCA9IC9eMG9bMC03XSskL2k7XG5cbi8qKiBCdWlsdC1pbiBtZXRob2QgcmVmZXJlbmNlcyB3aXRob3V0IGEgZGVwZW5kZW5jeSBvbiBgcm9vdGAuICovXG52YXIgZnJlZVBhcnNlSW50ID0gcGFyc2VJbnQ7XG5cbi8qKlxuICogQ29udmVydHMgYHZhbHVlYCB0byBhIG51bWJlci5cbiAqXG4gKiBAc3RhdGljXG4gKiBAbWVtYmVyT2YgX1xuICogQHNpbmNlIDQuMC4wXG4gKiBAY2F0ZWdvcnkgTGFuZ1xuICogQHBhcmFtIHsqfSB2YWx1ZSBUaGUgdmFsdWUgdG8gcHJvY2Vzcy5cbiAqIEByZXR1cm5zIHtudW1iZXJ9IFJldHVybnMgdGhlIG51bWJlci5cbiAqIEBleGFtcGxlXG4gKlxuICogXy50b051bWJlcigzLjIpO1xuICogLy8gPT4gMy4yXG4gKlxuICogXy50b051bWJlcihOdW1iZXIuTUlOX1ZBTFVFKTtcbiAqIC8vID0+IDVlLTMyNFxuICpcbiAqIF8udG9OdW1iZXIoSW5maW5pdHkpO1xuICogLy8gPT4gSW5maW5pdHlcbiAqXG4gKiBfLnRvTnVtYmVyKCczLjInKTtcbiAqIC8vID0+IDMuMlxuICovXG5mdW5jdGlvbiB0b051bWJlcih2YWx1ZSkge1xuICBpZiAodHlwZW9mIHZhbHVlID09ICdudW1iZXInKSB7XG4gICAgcmV0dXJuIHZhbHVlO1xuICB9XG4gIGlmIChpc1N5bWJvbCh2YWx1ZSkpIHtcbiAgICByZXR1cm4gTkFOO1xuICB9XG4gIGlmIChpc09iamVjdCh2YWx1ZSkpIHtcbiAgICB2YXIgb3RoZXIgPSB0eXBlb2YgdmFsdWUudmFsdWVPZiA9PSAnZnVuY3Rpb24nID8gdmFsdWUudmFsdWVPZigpIDogdmFsdWU7XG4gICAgdmFsdWUgPSBpc09iamVjdChvdGhlcikgPyAob3RoZXIgKyAnJykgOiBvdGhlcjtcbiAgfVxuICBpZiAodHlwZW9mIHZhbHVlICE9ICdzdHJpbmcnKSB7XG4gICAgcmV0dXJuIHZhbHVlID09PSAwID8gdmFsdWUgOiArdmFsdWU7XG4gIH1cbiAgdmFsdWUgPSB2YWx1ZS5yZXBsYWNlKHJlVHJpbSwgJycpO1xuICB2YXIgaXNCaW5hcnkgPSByZUlzQmluYXJ5LnRlc3QodmFsdWUpO1xuICByZXR1cm4gKGlzQmluYXJ5IHx8IHJlSXNPY3RhbC50ZXN0KHZhbHVlKSlcbiAgICA/IGZyZWVQYXJzZUludCh2YWx1ZS5zbGljZSgyKSwgaXNCaW5hcnkgPyAyIDogOClcbiAgICA6IChyZUlzQmFkSGV4LnRlc3QodmFsdWUpID8gTkFOIDogK3ZhbHVlKTtcbn1cblxubW9kdWxlLmV4cG9ydHMgPSB0b051bWJlcjtcbiIsInZhciBnO1xuXG4vLyBUaGlzIHdvcmtzIGluIG5vbi1zdHJpY3QgbW9kZVxuZyA9IChmdW5jdGlvbigpIHtcblx0cmV0dXJuIHRoaXM7XG59KSgpO1xuXG50cnkge1xuXHQvLyBUaGlzIHdvcmtzIGlmIGV2YWwgaXMgYWxsb3dlZCAoc2VlIENTUClcblx0ZyA9IGcgfHwgbmV3IEZ1bmN0aW9uKFwicmV0dXJuIHRoaXNcIikoKTtcbn0gY2F0Y2ggKGUpIHtcblx0Ly8gVGhpcyB3b3JrcyBpZiB0aGUgd2luZG93IHJlZmVyZW5jZSBpcyBhdmFpbGFibGVcblx0aWYgKHR5cGVvZiB3aW5kb3cgPT09IFwib2JqZWN0XCIpIGcgPSB3aW5kb3c7XG59XG5cbi8vIGcgY2FuIHN0aWxsIGJlIHVuZGVmaW5lZCwgYnV0IG5vdGhpbmcgdG8gZG8gYWJvdXQgaXQuLi5cbi8vIFdlIHJldHVybiB1bmRlZmluZWQsIGluc3RlYWQgb2Ygbm90aGluZyBoZXJlLCBzbyBpdCdzXG4vLyBlYXNpZXIgdG8gaGFuZGxlIHRoaXMgY2FzZS4gaWYoIWdsb2JhbCkgeyAuLi59XG5cbm1vZHVsZS5leHBvcnRzID0gZztcbiJdLCJtYXBwaW5ncyI6IjtBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Ozs7Ozs7Ozs7Ozs7QUNsRkE7QUFBQTtBQUFBO0FBQUE7QUFDQTtBQUVBOzs7O0FBR0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFKQTtBQU1BO0FBQ0E7QUFDQTtBQUNBO0FBRUE7Ozs7O0FBR0E7QUFDQTtBQUNBO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFBQTtBQUFBO0FBQUE7QUFDQTtBQUlBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFEQTtBQUVBOzs7Ozs7Ozs7Ozs7QUM1REE7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBR0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFHQTtBQUNBO0FBRUE7QUFDQTtBQUVBOzs7OztBQUdBO0FBQ0E7QUFDQTtBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQUE7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBREE7QUFHQTs7Ozs7Ozs7Ozs7O0FDdEdBO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFLQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7Ozs7Ozs7Ozs7O0FDL0JBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFPQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBS0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7Ozs7Ozs7Ozs7O0FDekNBO0FBQ0E7Ozs7Ozs7Ozs7Ozs7Ozs7OztBQWlCQTtBQUNBO0FBRUE7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUVBOzs7QUFJQTtBQUNBO0FBQ0E7QUFEQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBSEE7QUFLQTtBQUNBO0FBRUE7QUFFQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQUE7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFFQTtBQUNBO0FBRUE7QUFDQTtBQURBO0FBRUE7QUFDQTtBQUFBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQUE7QUFDQTtBQUFBO0FBQ0E7QUFDQTtBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBREE7QUFFQTtBQUNBO0FBQUE7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQUE7QUFDQTtBQUNBO0FBREE7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBRUE7QUFDQTtBQUFBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUVBO0FBQ0E7QUFFQTtBQUNBO0FBRUE7QUFFQTtBQUVBO0FBQ0E7QUFDQTtBQURBO0FBQ0E7QUFDQTtBQUVBO0FBRUE7QUFDQTtBQUFBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFBQTtBQUNBO0FBQ0E7QUFBQTtBQUNBO0FBQ0E7QUFEQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBREE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFBQTtBQUNBO0FBQUE7QUFDQTtBQURBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFEQTtBQUVBO0FBQ0E7QUFBQTtBQUVBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFEQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQURBO0FBRUE7QUFDQTtBQUFBO0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBREE7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBOzs7QUFJQTtBQUNBO0FBQ0E7QUFEQTtBQUNBO0FBRUE7QUFDQTtBQUVBOzs7QUFJQTtBQUNBO0FBQUE7QUFFQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBQ0E7QUFFQTtBQUNBO0FBRUE7QUFDQTtBQUNBO0FBRUE7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQUE7QUFDQTtBQUFBO0FBRUE7QUFDQTtBQUNBO0FBREE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7QUFJQTtBQUNBO0FBQ0E7QUFEQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBREE7QUFDQTtBQUVBO0FBQ0E7QUFFQTtBQUNBO0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQURBO0FBRUE7Ozs7Ozs7Ozs7OztBQ3RhQTtBQUFBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7Ozs7Ozs7Ozs7QUNwL0NBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7Ozs7Ozs7Ozs7O0FDTEE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Ozs7Ozs7Ozs7OztBQzNCQTtBQUNBO0FBQ0E7QUFDQTs7Ozs7Ozs7Ozs7OztBQ0hBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7Ozs7Ozs7Ozs7QUM3Q0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Ozs7Ozs7Ozs7OztBQ3JCQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Ozs7Ozs7Ozs7OztBQ1JBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Ozs7Ozs7Ozs7OztBQzlMQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7Ozs7Ozs7Ozs7O0FDOUJBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Ozs7Ozs7Ozs7OztBQzVCQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOzs7Ozs7Ozs7Ozs7QUM1QkE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7Ozs7Ozs7Ozs7O0FDdEJBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7Ozs7Ozs7Ozs7O0FDakVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Ozs7O0EiLCJzb3VyY2VSb290IjoiIn0=