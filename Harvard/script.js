const menuBox = document.getElementById('menuBox');
  const menuOverlay = document.getElementById('menuOverlay');
  const closeBtn = document.getElementById('closeBtn');
  const menuLinks = document.querySelectorAll('.menu-link');
  const sections = document.querySelectorAll('.menu-section');

  // Toggle menu
  menuBox.addEventListener('click', () => {
    menuOverlay.classList.add('active');
  });

  closeBtn.addEventListener('click', () => {
    menuOverlay.classList.remove('active');
  });

  // Submenu switching
  menuLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      e.preventDefault();

      // Remove previous active
      menuLinks.forEach(l => l.classList.remove('active'));
      sections.forEach(s => s.classList.remove('active'));

      // Add new active
      const sectionId = link.getAttribute('data-section');
      document.getElementById(sectionId).classList.add('active');
      link.classList.add('active');
    });
  });