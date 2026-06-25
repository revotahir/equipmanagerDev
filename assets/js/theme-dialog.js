(function (window, document) {
  'use strict';

  if (window.AppDialog) {
    return;
  }

  var state = {
    container: null,
    titleEl: null,
    messageEl: null,
    inputWrapEl: null,
    inputEl: null,
    cancelBtn: null,
    okBtn: null,
    resolve: null,
    active: false
  };

  function escapeHtml(value) {
    return String(value == null ? '' : value)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/\"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  function ensureStyles() {
    if (document.getElementById('equipmanager-dialog-theme')) {
      return;
    }

    var style = document.createElement('style');
    style.id = 'equipmanager-dialog-theme';
    style.textContent = '' +
      '.app-dialog-backdrop{' +
      'position:fixed;inset:0;background:rgba(15,47,44,.42);display:none;align-items:center;justify-content:center;z-index:20000;padding:16px;' +
      '}' +
      '.app-dialog-backdrop.show{display:flex;}' +
      '.app-dialog{' +
      'width:100%;max-width:460px;background:#fff;border-radius:12px;border:1px solid #e5e7eb;box-shadow:0 16px 38px rgba(15,47,44,.28);overflow:hidden;font-family:Manrope,-apple-system,BlinkMacSystemFont,Segoe UI,sans-serif;' +
      '}' +
      '.app-dialog-header{padding:16px 18px;border-bottom:1px solid #eef1f4;background:#f9fbfb;}' +
      '.app-dialog-title{margin:0;font-size:17px;font-weight:800;color:#0f2f2c;}' +
      '.app-dialog-body{padding:16px 18px 8px 18px;color:#374151;font-size:14px;line-height:1.5;}' +
      '.app-dialog-input-wrap{padding:0 18px 8px 18px;display:none;}' +
      '.app-dialog-input{width:100%;border:1px solid #d1d5db;border-radius:8px;padding:10px 12px;font-size:14px;outline:none;}' +
      '.app-dialog-input:focus{border-color:#2A7A66;box-shadow:0 0 0 3px rgba(42,122,102,.16);}' +
      '.app-dialog-actions{display:flex;gap:10px;justify-content:flex-end;padding:14px 18px 16px 18px;border-top:1px solid #eef1f4;background:#fff;}' +
      '.app-dialog-btn{border:none;border-radius:8px;padding:9px 16px;font-size:13px;font-weight:700;cursor:pointer;}' +
      '.app-dialog-btn-cancel{background:#eef2f7;color:#334155;}' +
      '.app-dialog-btn-cancel:hover{background:#e5eaf1;}' +
      '.app-dialog-btn-ok{background:#13372E;color:#fff;}' +
      '.app-dialog-btn-ok:hover{background:#2A7A66;}' +
      '@media (max-width:576px){.app-dialog{max-width:96vw;}}';

    document.head.appendChild(style);
  }

  function ensureDialog() {
    if (state.container) {
      return;
    }

    ensureStyles();

    var backdrop = document.createElement('div');
    backdrop.className = 'app-dialog-backdrop';
    backdrop.innerHTML = '' +
      '<div class="app-dialog" role="dialog" aria-modal="true" aria-live="polite">' +
      '<div class="app-dialog-header"><h3 class="app-dialog-title">Confirm Action</h3></div>' +
      '<div class="app-dialog-body"></div>' +
      '<div class="app-dialog-input-wrap"><input class="app-dialog-input" type="text" /></div>' +
      '<div class="app-dialog-actions">' +
      '<button type="button" class="app-dialog-btn app-dialog-btn-cancel">Cancel</button>' +
      '<button type="button" class="app-dialog-btn app-dialog-btn-ok">OK</button>' +
      '</div>' +
      '</div>';

    document.body.appendChild(backdrop);

    state.container = backdrop;
    state.titleEl = backdrop.querySelector('.app-dialog-title');
    state.messageEl = backdrop.querySelector('.app-dialog-body');
    state.inputWrapEl = backdrop.querySelector('.app-dialog-input-wrap');
    state.inputEl = backdrop.querySelector('.app-dialog-input');
    state.cancelBtn = backdrop.querySelector('.app-dialog-btn-cancel');
    state.okBtn = backdrop.querySelector('.app-dialog-btn-ok');

    state.cancelBtn.addEventListener('click', function () {
      finish(false);
    });

    state.okBtn.addEventListener('click', function () {
      if (state.active && state.container.getAttribute('data-kind') === 'prompt') {
        finish({ ok: true, value: state.inputEl.value });
        return;
      }
      finish(true);
    });

    backdrop.addEventListener('click', function (e) {
      if (e.target === backdrop) {
        finish(false);
      }
    });

    document.addEventListener('keydown', function (e) {
      if (!state.active) {
        return;
      }

      if (e.key === 'Escape') {
        e.preventDefault();
        finish(false);
      }

      if (e.key === 'Enter') {
        if (state.container.getAttribute('data-kind') === 'prompt' && document.activeElement === state.inputEl) {
          e.preventDefault();
          finish({ ok: true, value: state.inputEl.value });
        } else if (document.activeElement === state.okBtn || document.activeElement === state.cancelBtn) {
          e.preventDefault();
          state.okBtn.click();
        }
      }
    });
  }

  function finish(result) {
    if (!state.active) {
      return;
    }

    state.active = false;
    state.container.classList.remove('show');

    var resolver = state.resolve;
    state.resolve = null;

    if (typeof resolver === 'function') {
      resolver(result);
    }
  }

  function open(kind, message, options) {
    ensureDialog();

    var opts = options || {};
    var title = opts.title || (kind === 'alert' ? 'Notice' : 'Confirm Action');
    var okText = opts.okText || (kind === 'alert' ? 'OK' : 'Yes');
    var cancelText = opts.cancelText || 'Cancel';

    state.container.setAttribute('data-kind', kind);
    state.titleEl.textContent = title;
    state.messageEl.innerHTML = escapeHtml(message).replace(/\n/g, '<br>');
    state.okBtn.textContent = okText;
    state.cancelBtn.textContent = cancelText;

    if (kind === 'alert') {
      state.cancelBtn.style.display = 'none';
      state.okBtn.focus();
      state.inputWrapEl.style.display = 'none';
    } else if (kind === 'prompt') {
      state.cancelBtn.style.display = 'inline-block';
      state.inputWrapEl.style.display = 'block';
      state.inputEl.value = opts.defaultValue || '';
      state.inputEl.placeholder = opts.placeholder || '';
      setTimeout(function () { state.inputEl.focus(); }, 10);
    } else {
      state.cancelBtn.style.display = 'inline-block';
      state.inputWrapEl.style.display = 'none';
      state.okBtn.focus();
    }

    state.container.classList.add('show');
    state.active = true;

    return new Promise(function (resolve) {
      state.resolve = resolve;
    });
  }

  function runElementDefaultAction(element) {
    if (!element) {
      return;
    }

    var href = element.getAttribute('href');
    if (href && href.indexOf('javascript:') === 0) {
      var jsCode = href.substring('javascript:'.length);
      if (jsCode) {
        try {
          (new Function(jsCode)).call(window);
        } catch (err) {
          if (window.console) {
            console.error('AppDialog javascript: href execution failed', err);
          }
        }
      }
      return;
    }

    if (element.tagName === 'A' && href && href !== '#') {
      window.location.href = href;
      return;
    }

    var formId = element.getAttribute('form');
    var form = formId ? document.getElementById(formId) : element.closest('form');
    var type = (element.getAttribute('type') || '').toLowerCase();

    if ((element.tagName === 'BUTTON' || element.tagName === 'INPUT') && (type === 'submit' || (type === '' && element.tagName === 'BUTTON')) && form) {
      form.submit();
    }
  }

  window.AppDialog = {
    confirm: function (message, options) {
      return open('confirm', message, options).then(function (result) {
        return !!result;
      });
    },
    alert: function (message, options) {
      return open('alert', message, options).then(function () {
        return true;
      });
    },
    prompt: function (message, defaultValue, options) {
      var opts = options || {};
      opts.defaultValue = defaultValue || '';
      return open('prompt', message, opts).then(function (result) {
        if (!result || result.ok !== true) {
          return null;
        }
        return result.value;
      });
    },
    confirmAction: function (event, element, message, options) {
      if (event && typeof event.preventDefault === 'function') {
        event.preventDefault();
        event.stopPropagation();
      }

      window.AppDialog.confirm(message, options).then(function (confirmed) {
        if (!confirmed) {
          return;
        }
        runElementDefaultAction(element);
      });

      return false;
    },
    runConfirmed: function (event, callback, message, options) {
      if (event && typeof event.preventDefault === 'function') {
        event.preventDefault();
        event.stopPropagation();
      }

      window.AppDialog.confirm(message, options).then(function (confirmed) {
        if (confirmed && typeof callback === 'function') {
          callback();
        }
      });

      return false;
    }
  };
})(window, document);
