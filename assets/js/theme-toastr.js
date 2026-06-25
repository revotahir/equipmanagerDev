(function (window, document) {
  'use strict';

  if (window.AppToast) {
    return;
  }

  var state = {
    baseUrl: null,
    cssLoaded: false,
    jsLoaded: false,
    loading: false,
    configured: false,
    queue: []
  };

  function detectBaseUrl() {
    if (state.baseUrl) {
      return state.baseUrl;
    }

    var scriptUrl = '';
    var scripts = document.getElementsByTagName('script');
    for (var i = 0; i < scripts.length; i++) {
      if (scripts[i].src && scripts[i].src.indexOf('/assets/js/theme-toastr.js') !== -1) {
        scriptUrl = scripts[i].src;
        break;
      }
    }

    if (scriptUrl) {
      state.baseUrl = scriptUrl.replace(/\/assets\/js\/theme-toastr\.js.*$/, '/');
      return state.baseUrl;
    }

    state.baseUrl = window.location.origin + '/';
    return state.baseUrl;
  }

  function addThemeCss() {
    if (document.getElementById('equipmanager-toast-theme')) {
      return;
    }

    var style = document.createElement('style');
    style.id = 'equipmanager-toast-theme';
    style.textContent = '' +
      '#toast-container > div {' +
      'font-family: Manrope, -apple-system, BlinkMacSystemFont, Segoe UI, sans-serif;' +
      'box-shadow: 0 8px 22px rgba(15,47,44,0.18);' +
      'border-radius: 10px;' +
      'opacity: 1 !important;' +
      '}' +
      '#toast-container > .toast-success { background-color: #13372E; }' +
      '#toast-container > .toast-info { background-color: #2A7A66; }' +
      '#toast-container > .toast-warning { background-color: #8B6A1F; }' +
      '#toast-container > .toast-error { background-color: #8A2D3B; }';

    document.head.appendChild(style);
  }

  function loadCss() {
    if (state.cssLoaded || document.getElementById('equipmanager-toastr-css')) {
      state.cssLoaded = true;
      return;
    }

    var link = document.createElement('link');
    link.id = 'equipmanager-toastr-css';
    link.rel = 'stylesheet';
    link.href = detectBaseUrl() + 'assets/toastr/toastr.min.css';
    link.onload = function () {
      state.cssLoaded = true;
      addThemeCss();
    };
    link.onerror = function () {
      state.cssLoaded = false;
    };

    document.head.appendChild(link);
  }

  function waitForJQuery(done) {
    var attempts = 0;
    var maxAttempts = 60;
    var timer = window.setInterval(function () {
      attempts++;
      if (window.jQuery) {
        window.clearInterval(timer);
        done(true);
        return;
      }

      if (attempts >= maxAttempts) {
        window.clearInterval(timer);
        done(false);
      }
    }, 100);
  }

  function flushQueue(ok) {
    var queued = state.queue.slice();
    state.queue = [];
    state.loading = false;

    for (var i = 0; i < queued.length; i++) {
      queued[i](ok);
    }
  }

  function configureToastr() {
    if (!window.toastr || state.configured) {
      return;
    }

    window.toastr.options = {
      closeButton: true,
      progressBar: true,
      positionClass: 'toast-top-right',
      showDuration: 250,
      hideDuration: 250,
      timeOut: 5000,
      extendedTimeOut: 1000,
      showEasing: 'swing',
      hideEasing: 'linear',
      showMethod: 'fadeIn',
      hideMethod: 'fadeOut'
    };

    addThemeCss();
    state.configured = true;
  }

  function ensureToastr(callback) {
    if (window.toastr && window.jQuery) {
      configureToastr();
      callback(true);
      return;
    }

    state.queue.push(callback);
    if (state.loading) {
      return;
    }

    state.loading = true;
    loadCss();

    waitForJQuery(function (hasJQuery) {
      if (!hasJQuery) {
        flushQueue(false);
        return;
      }

      if (window.toastr) {
        configureToastr();
        flushQueue(true);
        return;
      }

      var existing = document.getElementById('equipmanager-toastr-js');
      if (existing) {
        existing.addEventListener('load', function () {
          configureToastr();
          flushQueue(!!window.toastr);
        });
        existing.addEventListener('error', function () {
          flushQueue(false);
        });
        return;
      }

      var script = document.createElement('script');
      script.id = 'equipmanager-toastr-js';
      script.src = detectBaseUrl() + 'assets/toastr/toastr.min.js';
      script.onload = function () {
        state.jsLoaded = true;
        configureToastr();
        flushQueue(!!window.toastr);
      };
      script.onerror = function () {
        state.jsLoaded = false;
        flushQueue(false);
      };

      document.head.appendChild(script);
    });
  }

  function emit(type, message, title) {
    var msg = (message == null ? '' : String(message)).trim();
    if (!msg) {
      return;
    }

    ensureToastr(function (ready) {
      if (ready && window.toastr && typeof window.toastr[type] === 'function') {
        if (title) {
          window.toastr[type](msg, title);
        } else {
          window.toastr[type](msg);
        }
        return;
      }

      if (window.console) {
        var level = type === 'error' ? 'error' : (type === 'warning' ? 'warn' : 'log');
        window.console[level]('[AppToast ' + type + '] ' + msg);
      }
    });
  }

  window.AppToast = {
    show: function (type, message, title) {
      emit(type || 'info', message, title);
    },
    success: function (message, title) {
      emit('success', message, title || 'Success');
    },
    error: function (message, title) {
      emit('error', message, title || 'Error');
    },
    warning: function (message, title) {
      emit('warning', message, title || 'Warning');
    },
    info: function (message, title) {
      emit('info', message, title || 'Info');
    }
  };
})(window, document);
