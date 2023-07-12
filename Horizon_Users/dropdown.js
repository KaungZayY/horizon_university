
  const dropdown = document.querySelector('.dropdown');
  const dropdownContent = dropdown.querySelector('.dropdown-content');
  const image = dropdown.querySelector('img');

  image.addEventListener('click', () => {
    dropdownContent.classList.toggle('show');
  });

  window.addEventListener('click', (event) => {
    if (!event.target.matches('.dropdown_img')) {
      dropdownContent.classList.remove('show');
    }
  });
