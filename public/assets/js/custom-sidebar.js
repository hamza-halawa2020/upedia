document.addEventListener('DOMContentLoaded', function () {
  const sidebar = document.getElementById('app-sidebar');
  if (!sidebar) return;

  // 1) Dropdown toggle (fallback)
  // Keeps old classes: open + dropdown-open and submenu class: sidebar-submenu
  sidebar.addEventListener('click', function (e) {
    const toggleLink = e.target.closest('a[data-sidebar-toggle="dropdown"]');
    if (!toggleLink) return;

    e.preventDefault();

    const li = toggleLink.closest('li.dropdown');
    if (!li) return;

    const submenu = li.querySelector('.sidebar-submenu');
    if (!submenu) return;

    const isOpen = li.classList.toggle('open');
    li.classList.toggle('dropdown-open', isOpen);

    submenu.style.display = isOpen ? 'block' : 'none';
    toggleLink.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  });

  // 2) Mobile close button
  const closeBtn = sidebar.querySelector('.sidebar-close-btn');
  if (closeBtn) {
    closeBtn.addEventListener('click', function () {
      sidebar.classList.remove('open');
    });
  }
});