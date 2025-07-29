document.addEventListener('DOMContentLoaded', () => {
  console.log("External dashboard JS loaded!");

  const sidebar = document.getElementById('sidebar');
  const main = document.getElementById('mainContent');
  const brandText = document.getElementById('brandText');
  const menuIcon = document.getElementById('menuIcon');
  const brandLogo = document.querySelector('.brand-logo');
  const menuToggle = document.querySelector('.menu-toggle');

  // Load collapsed state on page load
  const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
  if (isCollapsed) {
      sidebar.classList.add('collapsed');
      main.classList.add('hover-fix');
      brandText?.classList.add('hidden-brand');
      menuIcon?.classList.add('small-icon');
      menuToggle?.classList.add('shrink-toggle');
      if (brandLogo) {
          brandLogo.style.height = '30px';
          brandLogo.style.width = '30px';
      }
  }

  // Toggle sidebar function
  window.toggleSidebar = function () {
      sidebar.classList.toggle('collapsed');
      main.classList.toggle('expanded');

      const isNowCollapsed = sidebar.classList.contains('collapsed');
      localStorage.setItem('sidebar-collapsed', isNowCollapsed);

      if (isNowCollapsed) {
          main.classList.add('hover-fix');
          brandText?.classList.add('hidden-brand');
          menuIcon?.classList.add('small-icon');
          menuToggle?.classList.add('shrink-toggle');
          document.getElementById('brandLetterD')?.classList.add('d-none');
          if (brandLogo) {
              brandLogo.style.height = '30px';
              brandLogo.style.width = '30px';
          }
      } else {
          main.classList.remove('hover-fix');
          brandText?.classList.remove('hidden-brand');
          menuIcon?.classList.remove('small-icon');
          menuToggle?.classList.remove('shrink-toggle');
          document.getElementById('brandLetterD')?.classList.remove('d-none');
          if (brandLogo) {
              brandLogo.style.height = '45px';
              brandLogo.style.width = '45px';
          }
      }

      // Animate toggle
      menuToggle?.classList.add('toggle-animate');
      setTimeout(() => menuToggle?.classList.remove('toggle-animate'), 300);
  };

  // Logout modal trigger
  const logoutTrigger = document.getElementById('logoutTrigger');
  if (logoutTrigger) {
    logoutTrigger.addEventListener('click', function () {
      const modal = new bootstrap.Modal(document.getElementById('logoutConfirmModal'));
      modal.show();
    });
  }

  
});

 // Replace login page in browser history with current page (dashboard), so back won't go to login
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
