const toggleButton = document.getElementsByClassName('header-toggle-button')[0]
const navbarLinks = document.getElementsByClassName('header-navbar-links')[0]

toggleButton.addEventListener('click', () => {
  navbarLinks.classList.toggle('active')
})

