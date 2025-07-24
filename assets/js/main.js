/**
* Template Name: Strategy
* Template URL: https://bootstrapmade.com/strategy-bootstrap-agency-template/
* Updated: Jun 06 2025 with Bootstrap v5.3.6
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/

(function() {
  "use strict";

  /**
   * Apply .scrolled class to the body as the page is scrolled down
   */
  function toggleScrolled() {
    const selectBody = document.querySelector('body');
    const selectHeader = document.querySelector('#header');
    if (!selectHeader.classList.contains('scroll-up-sticky') && !selectHeader.classList.contains('sticky-top') && !selectHeader.classList.contains('fixed-top')) return;
    window.scrollY > 100 ? selectBody.classList.add('scrolled') : selectBody.classList.remove('scrolled');
  }

  document.addEventListener('scroll', toggleScrolled);
  window.addEventListener('load', toggleScrolled);

  /**
   * Mobile nav toggle
   */
  const mobileNavToggleBtn = document.querySelector('.mobile-nav-toggle');

  function mobileNavToogle() {
    document.querySelector('body').classList.toggle('mobile-nav-active');
    mobileNavToggleBtn.classList.toggle('bi-list');
    mobileNavToggleBtn.classList.toggle('bi-x');
  }
  if (mobileNavToggleBtn) {
    mobileNavToggleBtn.addEventListener('click', mobileNavToogle);
  }

  /**
   * Hide mobile nav on same-page/hash links
   */
  document.querySelectorAll('#navmenu a').forEach(navmenu => {
    navmenu.addEventListener('click', () => {
      if (document.querySelector('.mobile-nav-active')) {
        mobileNavToogle();
      }
    });

  });

  /**
   * Toggle mobile nav dropdowns
   */
  document.querySelectorAll('.navmenu .toggle-dropdown').forEach(navmenu => {
    navmenu.addEventListener('click', function(e) {
      e.preventDefault();
      this.parentNode.classList.toggle('active');
      this.parentNode.nextElementSibling.classList.toggle('dropdown-active');
      e.stopImmediatePropagation();
    });
  });

  /**
   * Preloader
   */
  const preloader = document.querySelector('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove();
    });
  }

  /**
   * Scroll top button
   */
  let scrollTop = document.querySelector('.scroll-top');

  function toggleScrollTop() {
    if (scrollTop) {
      window.scrollY > 100 ? scrollTop.classList.add('active') : scrollTop.classList.remove('active');
    }
  }
  scrollTop.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  window.addEventListener('load', toggleScrollTop);
  document.addEventListener('scroll', toggleScrollTop);

  /**
   * Animation on scroll function and init
   */
  function aosInit() {
    AOS.init({
      duration: 600,
      easing: 'ease-in-out',
      once: true,
      mirror: false
    });
  }
  window.addEventListener('load', aosInit);

  /**
   * Init swiper sliders
   */
  function initSwiper() {
    document.querySelectorAll(".init-swiper").forEach(function(swiperElement) {
      let config = JSON.parse(
        swiperElement.querySelector(".swiper-config").innerHTML.trim()
      );

      if (swiperElement.classList.contains("swiper-tab")) {
        initSwiperWithCustomPagination(swiperElement, config);
      } else {
        new Swiper(swiperElement, config);
      }
    });
  }

  window.addEventListener("load", initSwiper);

  /**
   * Initiate glightbox
   */
  const glightbox = GLightbox({
    selector: '.glightbox'
  });

  /**
   * Init isotope layout and filters
   */
  document.querySelectorAll('.isotope-layout').forEach(function(isotopeItem) {
    let layout = isotopeItem.getAttribute('data-layout') ?? 'masonry';
    let filter = isotopeItem.getAttribute('data-default-filter') ?? '*';
    let sort = isotopeItem.getAttribute('data-sort') ?? 'original-order';

    let initIsotope;
    imagesLoaded(isotopeItem.querySelector('.isotope-container'), function() {
      initIsotope = new Isotope(isotopeItem.querySelector('.isotope-container'), {
        itemSelector: '.isotope-item',
        layoutMode: layout,
        filter: filter,
        sortBy: sort
      });
    });

    isotopeItem.querySelectorAll('.isotope-filters li').forEach(function(filters) {
      filters.addEventListener('click', function() {
        isotopeItem.querySelector('.isotope-filters .filter-active').classList.remove('filter-active');
        this.classList.add('filter-active');
        initIsotope.arrange({
          filter: this.getAttribute('data-filter')
        });
        if (typeof aosInit === 'function') {
          aosInit();
        }
      }, false);
    });

  });

  /**
   * Frequently Asked Questions Toggle
   */
  document.querySelectorAll('.faq-item h3, .faq-item .faq-toggle, .faq-item .faq-header').forEach((faqItem) => {
    faqItem.addEventListener('click', () => {
      faqItem.parentNode.classList.toggle('faq-active');
    });
  });

/**
 * Contact Form Handler - Versión para múltiples formularios
 */
function initContactForms() {
  // Buscar TODOS los formularios posibles
  const contactForms = document.querySelectorAll('form[action*="contact"], .contact-form, #contact-form, form[data-contact]');
  
  // Si no encuentra formularios específicos, buscar todos los formularios
  let allForms = Array.from(contactForms);
  
  // Como fallback, incluir todos los formularios si no encontró específicos
  if (allForms.length === 0) {
    allForms = Array.from(document.querySelectorAll('form'));
  }
  
  console.log(`Se encontraron ${allForms.length} formulario(s) para inicializar`);
  
  // Inicializar cada formulario encontrado
  allForms.forEach((contactForm, index) => {
    if (!contactForm) return; // Verificar que el formulario existe
    
    console.log(`Inicializando formulario ${index + 1}:`, contactForm);
    
    // Agregar un identificador único si no lo tiene
    if (!contactForm.id) {
      contactForm.id = `contact-form-${index + 1}`;
    }
    
    contactForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      console.log(`Formulario ${this.id} enviado`);
      
      // Obtener elementos del formulario ESPECÍFICO
      const submitBtn = this.querySelector('button[type="submit"], input[type="submit"], .btn');
      
      // Remover mensajes anteriores SOLO de este formulario
      const formContainer = this.closest('.contact-section, .form-container') || this.parentElement;
      if (formContainer) {
        formContainer.querySelectorAll('.alert-message, .error-message, .success-message').forEach(el => el.remove());
      }
      
      // Deshabilitar botón mientras se envía
      let originalBtnText = 'Enviar Mensaje';
      if (submitBtn) {
        originalBtnText = submitBtn.textContent || submitBtn.value || 'Enviar Mensaje';
        submitBtn.disabled = true;
        if (submitBtn.textContent !== undefined) {
          submitBtn.textContent = 'Enviando...';
        } else {
          submitBtn.value = 'Enviando...';
        }
      }
      
      // Crear FormData
      const formData = new FormData(this);
      
      // Debug: mostrar datos del formulario
      console.log(`Datos del formulario ${this.id}:`);
      for (let [key, value] of formData.entries()) {
        console.log(key, value);
      }
      
      // Determinar la ruta del archivo PHP basada en el formulario
      let actionUrl = 'forms/contact.php';
      
      // Si el formulario tiene un action específico, usarlo
      if (this.getAttribute('action')) {
        actionUrl = this.getAttribute('action');
      }
      
      // Si el formulario tiene un data-action específico, usarlo
      if (this.getAttribute('data-action')) {
        actionUrl = this.getAttribute('data-action');
      }
      
      console.log(`Enviando a: ${actionUrl}`);
      
      // Enviar formulario
      fetch(actionUrl, {
        method: 'POST',
        body: formData
      })
      .then(response => {
        console.log(`Status (${this.id}):`, response.status);
        console.log(`Content-Type (${this.id}):`, response.headers.get('content-type'));
        
        return response.text();
      })
      .then(responseText => {
        console.log(`Respuesta completa (${this.id}):`, responseText);
        
        try {
          // Intentar parsear como JSON
          const data = JSON.parse(responseText);
          console.log(`Datos parseados (${this.id}):`, data);
          
          if (data.sent === true) {
            // ÉXITO - Mostrar mensaje de éxito
            showMessage('success', data.message || 'Mensaje enviado correctamente.', this);
            
            // LIMPIAR EL FORMULARIO
            this.reset();
            
            // Remover clases de validación
            this.querySelectorAll('input, textarea, select').forEach(field => {
              if (field && field.classList) {
                field.classList.remove('is-invalid', 'is-valid', 'error');
                field.style.borderColor = '';
              }
            });
            
            console.log(`Formulario ${this.id} limpiado exitosamente`);
            
          } else {
            // ERROR del servidor
            showMessage('error', data.message || 'Error al enviar el mensaje.', this);
          }
          
        } catch (parseError) {
          console.error(`Error al parsear JSON (${this.id}):`, parseError);
          console.error(`Respuesta recibida (${this.id}):`, responseText);
          
          // Si no es JSON válido, mostrar la respuesta tal como viene
          showMessage('error', 'Error en el servidor: ' + responseText, this);
        }
      })
      .catch(error => {
        console.error(`Error de conexión (${this.id}):`, error);
        showMessage('error', 'Error de conexión. Verifica tu conexión a internet.', this);
      })
      .finally(() => {
        // Rehabilitar botón
        if (submitBtn) {
          submitBtn.disabled = false;
          if (submitBtn.textContent !== undefined) {
            submitBtn.textContent = originalBtnText;
          } else {
            submitBtn.value = originalBtnText;
          }
        }
      });
    });
    
    console.log(`Event listener agregado al formulario ${contactForm.id}`);
  });
  
  if (allForms.length === 0) {
    console.log('No se encontró ningún formulario de contacto');
  }
}

/**
 * Función para mostrar mensajes - Versión mejorada para múltiples formularios
 */
function showMessage(type, message, formElement) {
  console.log(`Mostrando mensaje: ${type} - ${message}`);
  
  // Verificar que formElement existe
  if (!formElement) {
    console.error('No se proporcionó elemento de formulario para mostrar el mensaje');
    return;
  }
  
  // Buscar el contenedor del formulario
  let container = formElement.closest('.contact-section, .form-container, .container') || formElement.parentElement;
  
  // Si no encuentra un contenedor específico, usar el formulario mismo
  if (!container) {
    container = formElement;
  }
  
  // Remover mensajes anteriores del contenedor
  container.querySelectorAll('.alert-message, .error-message, .success-message').forEach(el => {
    if (el && el.remove) {
      el.remove();
    }
  });
  
  // Crear el elemento del mensaje
  const messageDiv = document.createElement('div');
  messageDiv.className = `alert-message ${type === 'success' ? 'success-message' : 'error-message'}`;
  
  // Estilos para el mensaje
  messageDiv.style.cssText = `
    padding: 15px 20px;
    margin: 15px 0;
    border-radius: 5px;
    font-size: 14px;
    font-weight: 500;
    position: relative;
    z-index: 1000;
    ${type === 'success' ? 
      'background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;' : 
      'background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;'
    }
  `;
  
  messageDiv.textContent = message;
  
  // Insertar el mensaje después del formulario
  if (container === formElement) {
    formElement.parentNode.insertBefore(messageDiv, formElement.nextSibling);
  } else {
    container.appendChild(messageDiv);
  }
  
  console.log('Mensaje mostrado exitosamente');
  
  // Auto-remover el mensaje después de 5 segundos
  setTimeout(() => {
    if (messageDiv && messageDiv.parentNode) {
      messageDiv.remove();
    }
  }, 5000);
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
  initContactForms();
});

// También inicializar si el DOM ya está listo
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initContactForms);
} else {
  initContactForms();
}
  
  /**
   * Función para mostrar mensajes
   */
  function showMessage(type, message) {
    console.log(`Mostrando mensaje: ${type} - ${message}`);
    
    // Remover mensajes anteriores
    document.querySelectorAll('.alert-message, .error-message, .success-message').forEach(el => el.remove());
    
    // Crear elemento de mensaje
    const messageElement = document.createElement('div');
    messageElement.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-message`;
    messageElement.style.cssText = `
      padding: 15px 20px;
      margin: 15px 0;
      border-radius: 8px;
      border: 1px solid;
      font-size: 14px;
      font-weight: 500;
      position: relative;
      z-index: 1000;
      ${type === 'success' 
        ? 'background-color: #d4edda; border-color: #c3e6cb; color: #155724;' 
        : 'background-color: #f8d7da; border-color: #f5c6cb; color: #721c24;'
      }
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    `;
    
    // Agregar ícono
    const icon = type === 'success' ? '✓' : '⚠️';
    messageElement.innerHTML = `<strong>${icon}</strong> ${message}`;
    
    // Insertar mensaje
    const form = document.querySelector('form') || document.body;
    const container = form.parentNode || form;
    
    if (form.tagName === 'FORM') {
      // Insertar antes del formulario
      container.insertBefore(messageElement, form);
    } else {
      // Insertar al principio del contenedor
      container.insertBefore(messageElement, container.firstChild);
    }
    
    // Scroll hacia el mensaje
    messageElement.scrollIntoView({ 
      behavior: 'smooth', 
      block: 'nearest',
      inline: 'nearest'
    });
    
    // Remover mensaje después de 7 segundos
    setTimeout(() => {
      if (messageElement.parentNode) {
        messageElement.style.opacity = '0';
        messageElement.style.transform = 'translateY(-10px)';
        messageElement.style.transition = 'all 0.3s ease';
        
        setTimeout(() => {
          messageElement.remove();
        }, 300);
      }
    }, 7000);
    
    console.log('Mensaje mostrado exitosamente');
  }
  
  /**
   * Validación en tiempo real (opcional)
   */
  function initFormValidation() {
    const inputs = document.querySelectorAll('.contact-form input, .contact-form textarea, #contact-form input, #contact-form textarea');
    
    inputs.forEach(input => {
      input.addEventListener('blur', function() {
        validateField(this);
      });
      
      input.addEventListener('input', function() {
        if (this.classList.contains('is-invalid')) {
          validateField(this);
        }
      });
    });
  }
  
  /**
   * Validar campo individual
   */
  function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = '';
    
    // Validación de campo requerido
    if (field.hasAttribute('required') && !value) {
      isValid = false;
      errorMessage = 'Este campo es obligatorio.';
    }
    
    // Validación de email
    if (field.type === 'email' && value) {
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(value)) {
        isValid = false;
        errorMessage = 'Ingresa un email válido.';
      }
    }
    
    // Aplicar clases de validación
    if (isValid) {
      field.classList.remove('is-invalid');
      field.classList.add('is-valid');
    } else {
      field.classList.remove('is-valid');
      field.classList.add('is-invalid');
    }
    
    // Mostrar/ocultar mensaje de error
    let feedbackElement = field.parentNode.querySelector('.invalid-feedback');
    if (!isValid && errorMessage) {
      if (!feedbackElement) {
        feedbackElement = document.createElement('div');
        feedbackElement.className = 'invalid-feedback';
        feedbackElement.style.display = 'block';
        field.parentNode.appendChild(feedbackElement);
      }
      feedbackElement.textContent = errorMessage;
    } else if (feedbackElement) {
      feedbackElement.remove();
    }
    
    return isValid;
  }

  /**
   * Correct scrolling position upon page load for URLs containing hash links.
   */
  window.addEventListener('load', function(e) {
    if (window.location.hash) {
      if (document.querySelector(window.location.hash)) {
        setTimeout(() => {
          let section = document.querySelector(window.location.hash);
          let scrollMarginTop = getComputedStyle(section).scrollMarginTop;
          window.scrollTo({
            top: section.offsetTop - parseInt(scrollMarginTop),
            behavior: 'smooth'
          });
        }, 100);
      }
    }
  });

  /**
   * Navmenu Scrollspy
   */
  let navmenulinks = document.querySelectorAll('.navmenu a');

  function navmenuScrollspy() {
    navmenulinks.forEach(navmenulink => {
      if (!navmenulink.hash) return;
      let section = document.querySelector(navmenulink.hash);
      if (!section) return;
      let position = window.scrollY + 200;
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        document.querySelectorAll('.navmenu a.active').forEach(link => link.classList.remove('active'));
        navmenulink.classList.add('active');
      } else {
        navmenulink.classList.remove('active');
      }
    })
  }
  window.addEventListener('load', navmenuScrollspy);
  document.addEventListener('scroll', navmenuScrollspy);

  /**
   * Inicializar funciones cuando el DOM esté listo
   */
  document.addEventListener('DOMContentLoaded', function() {
    initContactForm();
    initFormValidation();
  });

})();